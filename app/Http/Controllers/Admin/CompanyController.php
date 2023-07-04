<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentTeacherAssesmentExport;
use App\Exports\StudentTeacherExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Models\AssessmentAspect;
use App\Models\PracticePlace;
use App\Models\StudentAssessment;
use App\Models\StudentPracticePlace;
use App\Models\TeacherPlace;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{
    public function create() {
        return view('company.create');
    }

    public function store(CreateCompanyRequest $request) {
        try {
            DB::beginTransaction();

            $create_user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);

            if(!$create_user) {
                DB::rollback();
                return redirect()->back()->withErrors(["Error menyimpan data DU/DI"]);
            }

            $create_user->assignRole('company');

            $create_du_di = PracticePlace::create([
                "user_id" => $create_user->id,
                "name" => $request->company_name,
                "address" => $request->company_address,
                "pic" => $request->pic,
                "email" => $request->pic_email,
                "phone" => $request->pic_phone
            ]);

            if (!$create_du_di) {
                DB::rollback();
                return redirect()->back()->withErrors(["Error menyimpan data DU/DI"]);
            }
            DB::commit();
            return redirect()->back()->withSuccess(["Data DU/DI Berhasil disimpan"]);;
        } catch (\Exception $err) {
            DB::rollback();
            return redirect()->back()->withErrors($err->getMessage());

        }

    }

    public function companyAssessment($id) {
        $student = StudentPracticePlace::where('student_id', $id);

        if (Auth::user()->user_type == User::COMPANY) {
           $student= $student->whereHas('practice_place', function($q){
                $q->where('user_id', Auth::id());
            })->with('student.user')->first();
        } else {
            $student = $student->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'practice_places.id')
            ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
            ->leftJoin('students', 'student_practice_places.student_id', '=', 'students.id')
            ->leftJoin('users', 'users.id', '=', 'students.user_id')
            ->select('students.nisn', 'users.name')
            ->where('teachers.user_id', Auth::id())->first();
        }

        if (!$student) {
            abort(404);
        }
        $aspect = AssessmentAspect::where('is_active', 1)->select('id', "name")->with(['assessment' => function($q) use($id) {
            $q->where('student_id', $id);
        }])->get();

        $student_id = $id;


        return view('assessment', compact('aspect', 'student_id', 'student'));
    }

    public function storeCompanyAssessment(Request $request, $id) {
        $post = $request->except("_token");
        // return $post;

        DB::beginTransaction();
        try {
            $list_id = [];
            foreach ($post as $key => $val) {

                foreach($val as $item) {


                    if(empty($item['assessment_id'])) {
                        $save_assessment = StudentAssessment::create([
                            "assessment_aspect_id" =>  Crypt::decryptString($key),
                            "student_id" => $id,
                            "assessment" => $item['assessment'],
                            "company_score" => $item['company_score'],
                            "teacher_score" => $item['teacher_score']
                        ]);
                        array_push($list_id, $save_assessment['id']);

                    } else {
                        $assesement_id = Crypt::decryptString($item['assessment_id']);
                        $save_assessment = StudentAssessment::where('id', $assesement_id)->update([
                            "assessment_aspect_id" =>  Crypt::decryptString($key),
                            "student_id" => $id,
                            "assessment" => $item['assessment'],
                            "company_score" => $item['company_score'],
                            "teacher_score" => $item['teacher_score']
                        ]);
                        // return $list_id;
                        array_push($list_id, $assesement_id);

                    }
                    if(!$save_assessment) {
                        DB::rollback();
                        return redirect()->back()->withErrors(['Save Penilaian Error #001']);

                    }

                }

            }
            $delete_data = StudentAssessment::whereNotIn('student_assessments.id', $list_id)->where('student_assessments.student_id', $id)
            ->leftJoin('students', 'students.id', '=', 'student_assessments.student_id')
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'students.id')
            ->leftJoin('teacher_places', 'student_practice_places.practice_place_id', '=', 'teacher_places.practice_place_id')
            ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
            ->where('teachers.user_id', Auth::id())
            ->select('student_assessments.id')
            ->delete();

            DB::commit();
            return redirect()->back()->withSuccess(['Penilaian berhasil diupdate']);
        } catch (\Exception $err) {
            DB::rollback();
            return redirect()->back()->withErrors($err->getMessage());
        }
    }

    public function index(Request $request) {
        $post = $request->all();
        if(Auth::user()->user_type == User::ADMIN) {

            $data = PracticePlace::where(function($q) use($post) {
                if(!empty($post['name'])) {
                    $q->where('name', $post['name'])->orWhere('pic', $post['name']);
                }
            })->with('user')->with('student')->withCount('student')->paginate(10);
        } else {
            $data = TeacherPlace::whereHas('teacher', function($q) {
                $q->where('user_id', Auth::id());
            })->whereHas('practice_place', function($q) {
                $q->where('deleted_at', null);
            })->with(['practice_place.user'])->paginate(10);
        }



        return view('company.index', compact('data'));
    }

    public function edit($id) {
        $data = PracticePlace::where('id', $id)->with('user')->first();

        return view('company.edit', compact('data'));
    }

    public function delete($id) {
        return PracticePlace::where('id', $id)->delete();
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();
        try {
            // return  $request->company_address;
            $data = PracticePlace::where('id', $id)->first();


            $update = $data->update([
                "name" => $request->company_name,
                "address" => $request->company_address,
                "email" => $request->pic_email,
                "phone" => $request->pic_phone,
                "pic" => $request->pic
            ]);

            if(!$update) {
                DB::rollback();
                return redirect()->back()->withSuccess(["Update Data Failed"]);
            }

            $data_user = User::where('id', $data->user_id)->first();

            $update_user = $data_user->update([
                "name" => $request->name,
                "email" => $request->company_email,
            ]);


            if(!$update_user) {
                DB::rollback();
                return redirect()->back()->withErrors(["Update Data Failed"]);
            }


            //Update Password
            if(!empty($request->password)) {
                $data_user->update([
                    "password" => Hash::make($request->password)
                ]);
            }

            DB::commit();

            return redirect()->back()->withSuccess(["Update Data Success"]);



        } catch (\Exception $err) {
            DB::rollback();
            return redirect()->back()->withErrors($err->getMessage());
        }
    }

    public function listTeacherAssigned(Request $request, $id) {

        if(!$request->ajax()){
            abort(404);
        }
        $data = TeacherPlace::where('practice_place_id', $id)->with('teacher.user')->get();



        $data_perusahaan = '<table class="table table-sm">
        <thead>
            <tr>
                <td>No</td>
                <td>NIK</td>
                <td>Nama Guru</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <tbody>';

        foreach($data as $key => $val){
            $num = $key+1;


            $data_perusahaan .= '<tr>
            <td>'.$num.'</td>
            <td>'.$val["teacher"]["nik"].'</td>
            <td>'.$val["teacher"]["user"]["name"].'</td>
            <td><button class="btn btn-sm btn-danger"  data-seq="1" onClick="deleteGuru('.$val['id'].')">Hapus</button></td>
        </tr>';
        }
        $data_perusahaan .= '</tbody>
        </table>';

        return $data_perusahaan;

    }

    public function postAssignTeacher(Request $request,$id) {

        if(!$request->ajax()){
            abort(404);
        }

        $check_exist = TeacherPlace::where('practice_place_id', $id)->first();

        if($check_exist) {
            return 2;
        }
        $check_data = TeacherPlace::where([
            "teacher_id" => $request->teacher_id,
            "practice_place_id" => $id,
            // "school_year_id" => $tahun_ajaran->id
        ])->first();

        if($check_data){
            return 0;
        }

        $create = TeacherPlace::create([
            "teacher_id" => $request->teacher_id,
            "practice_place_id" => $id,
            // "school_year_id" => $tahun_ajaran->id
        ]);


        return 1;
    }

    public function deleteTeacherAssigned(Request $request,$id) {

        if(!$request->ajax()){
            abort(404);
        }
        try {
            $data = TeacherPlace::where('id', $id)->delete();

            return $data;
        } catch (\Exception $err) {
            return $err;
            return 0;
        }
    }

    public function listStudent(Request $request,$id) {
        if(!empty($request->import_data)) {
            $data['name'] = $request->name;
            $data['id'] = $id;
            // return $data;
            return Excel::download(new StudentTeacherExport($data), strtotime('now')."_students.xlsx");
        } elseif(!empty($request->import_data_nilai)) {
            $data['name'] = $request->name;
            $data['id'] = $id;




            // return $data;
            return Excel::download(new StudentTeacherAssesmentExport($data), strtotime('now')."_student_assesments.xlsx");
        } else {
            $data = TeacherPlace::whereHas('teacher', function($q) {
                $q->where('user_id', Auth::id());
            })->where(function($q) use($id) {
                $q->where('practice_place_id', $id);
            })
            ->with(['practice_place.student.student.user' => function($q) use($request) {
                $q->where('name', 'LIKE', '%'.$request->name.'%');
            }])->whereHas('practice_place.student', function($q) {
                $q->where('deleted_at', null);
            })->first();
            // return $data;
            return view('company.detail', compact('data'));
        }




    }
}
