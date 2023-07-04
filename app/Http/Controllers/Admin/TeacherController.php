<?php

namespace App\Http\Controllers\Admin;

use App\Exports\JurnalStudentExport;
use App\Exports\JurnalTEacherExport;
use App\Exports\JurnalTeacherExportAll;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\StudentJurnal;
use App\Models\TeacherJurnal;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\Return_;

class TeacherController extends Controller
{
    public function index(Request $request) {
        $data = Teacher::where(function($q) use($request){
            if(!empty($request->keyword)) {
                $q->where('nik', $request->nik);
            }
        })->with('user');

        $data = $data->paginate(10);

        return view('teacher.index', compact('data'));
    }

    public function create() {
        return view('teacher.create');
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $create_user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                'user_type' => 3
            ]);

            if (!$create_user) {
                DB::rollback();
                return redirect()->back()->withErrors(["Error menyimpan data guru"]);
            }

            $create_user->assignRole('teacher');

            $create_teacher = Teacher::create([
                "user_id" => $create_user->id,
                "nik" => $request->nik,
                "date_birth" => $request->birth_date,
                "place_birth" => $request->birth_place,
                "gender" => $request->gender,
                "phone" => $request->phone
            ]);

            if(!$create_teacher) {
                DB::rollback();
                return redirect()->back()->withErrors(["Error menyimpan data guru"]);
            }
            DB::commit();
            return redirect()->back()->withSuccess(["Data Teacher Berhasil disimpan"]);


        } catch (\Exception $err) {
            return redirect()->back()->withErrors($err->getMessage());

        }
    }

    public function createTeacherJurnal($id) {
        $data = Student::leftJoin('student_practice_places', 'student_practice_places.student_id', '=', "students.id")
        ->leftJoin('teacher_places', 'student_practice_places.practice_place_id', '=', 'teacher_places.practice_place_id')
        ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
        ->leftJoin('users', 'users.id', '=', 'students.user_id')
        ->where('teachers.user_id', Auth::id())->where('student_practice_places.student_id', $id)
        ->select('students.id', 'students.nisn', 'users.name')
        ->get();


        return view('teacher.jurnal', compact('data'));
    }

    public function storeTeacherJurnal(Request $request) {
        try {
            $this->validate($request, [
                'jurnal_image' => 'file|max:7000', // max 7MB
            ]);
            $filename = null;

            if(!empty($request->jurnal_image)) {
                $path = "uploads/jurnal/teacher/";
                $name = \Str::random(7).".png";
                $filename = $path.$name;

                $upload = \Storage::putFileAs($path,$request->file('jurnal_image'), $name);
            }

            $save = TeacherJurnal::create([
                "title" => $request->title,
                "description" => $request->description,
                "student_id" => $request->student_id,
                "teacher_id" => Teacher::where('user_id', Auth::id())->first()->id,
                "image" => $filename
            ]);

            if ( !$save) {
                return redirect()->back()->withErrors(["Error menyimpan data jurnal"]);
            }

            return redirect()->back()->withSuccess(["Jurnal Berhasil disimpan"]);

        } catch (\Exception $err) {
            return redirect()->back()->withErrors($err->getMessage());

        }
    }

    public function edit($id) {
        $data = Teacher::where('id', $id)->with('user')->first();

        if(!$data) {
            abort(404);
        }

        return view('teacher.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();

        try {
            $data = Teacher::where('id', $id)->first();

            $update = $data->update([
                "nik" => $request->nik,
                "place_birth" => $request->birth_place,
                "date_birth" => $request->birth_date,
                "phone" => $request->phone,
                "gender" => $request->gender
            ]);

            if(!$update) {
                DB::rollback();
                return redirect()->back()->withErrors(["Update Data Teacher Failed"]);
            }

            $data_user = User::where('id', $data->user_id)->first();

            $update_user  = $data_user->update([
                "name" => $request->name,
                "email" => $request->email
            ]);

            if(!$update_user) {
                DB::rollback();
                return redirect()->back()->withErrors(["Update Data Teacher Failed"]);
            }

            if (!empty($request->password)) {
                $data_user->update([
                    "password" => FacadesHash::make($request->password)
                ]);
            }

            DB::commit();
            return redirect()->back()->withSuccess(["Update Data Teacher Success"]);
        } catch (\Exception $err) {
            return redirect()->back()->withErrors([$err->getMessage()]);
        }
    }

    public function jurnalList(Request $request) {
        if(empty($request->export)){
            if(Auth::user()->user_type == User::TEACHER) {
                $data = TeacherJurnal::whereHas('teacher', function($q) {
                    $q->where('user_id', Auth::id());
                })->whereHas('student', function($q) {
                    $q->where('deleted_at',null);
                });
            } elseif(Auth::user()->user_type == User::STUDENT) {
                $data = TeacherJurnal::whereHas('student', function($q) {
                    $q->where('user_id', Auth::id());
                });
            }

            $data = $data->with('student.user', 'teacher.user')->orderBy('created_at', 'desc')->paginate(10);


            return view('teacher.jurnal-list', compact('data'));
        }
        return Excel::download(new JurnalTeacherExportAll(), "teacher_jurnals_".strtotime('now').".xlsx");


    }

    public function jurnalStudentList(Request $request,$id) {

        $data_student = Student::where('id', $id)->first();

        if (!$data_student) {
            abort(404);
        }

        if(empty($request->export)) {
            if(Auth::user()->user_type == User::TEACHER) {
                $data = TeacherJurnal::whereHas('teacher', function($q) {
                    $q->where('user_id', Auth::id());
                })->where(function($q) use($id) {
                    if (!empty($id)) {
                        $q->where('student_id', $id);
                    }
                })->with('student.user')->paginate(10);;
            } elseif(Auth::user()->user_type == User::STUDENT) {
                $data = TeacherJurnal::whereHas('student', function($q) {
                    $q->where('user_id', Auth::id());
                })->where(function($q) use($id) {
                    if (!empty($id)) {
                        $q->where('student_id', $id);
                    }
                })->with('student.user')->paginate(10);;
            } elseif(Auth::user()->user_type == User::COMPANY) {
                $data = TeacherJurnal::where('teacher_jurnals.student_id', $id)
                ->leftJoin('student_practice_places', 'teacher_jurnals.student_id', '=', 'student_practice_places.student_id')
                ->leftJoin('practice_places', 'student_practice_places.practice_place_id', '=', 'practice_places.id')
                ->leftJoin('students', 'students.id','=', 'teacher_jurnals.student_id')
                ->leftJoin('users', 'students.user_id', '=', 'users.id')
                ->where('practice_places.user_id', Auth::id())
                ->select('teacher_jurnals.id', 'students.nisn', 'users.name','teacher_jurnals.title', 'teacher_jurnals.created_at')
                ->paginate(10);
            }
            return view('teacher.jurnal-list', compact('data', 'data_student'));
        }
        $data['student_id'] = $id;
        return Excel::download(new JurnalTeacherExport($data), "teacher_jurnals_".strtotime('now').".xlsx");

    }

    public function jurnalEdit($id) {

        $data = TeacherJurnal::where('id', $id)->whereHas('teacher', function($q){
            $q->where('user_id', Auth::id());
        })->first();

        $student = Student::leftJoin('student_practice_places', 'student_practice_places.student_id', '=', "students.id")
        ->leftJoin('teacher_places', 'student_practice_places.practice_place_id', '=', 'teacher_places.practice_place_id')
        ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
        ->leftJoin('users', 'users.id', '=', 'students.user_id')
        ->where('teachers.user_id', Auth::id())->where('student_practice_places.student_id', $data->student_id)
        ->select('students.id', 'students.nisn', 'users.name')
        ->get();

        return view('teacher.jurnal-edit', compact('data', 'student'));
    }

    public function jurnalUpdate(Request $request, $id) {


        $data = TeacherJurnal::where('id', $id)->whereHas('teacher', function($q) {
            $q->where('user_id', Auth::id());
        })->first();
        $filename = $data['image'];

        if(!empty($request->jurnal_image)) {
            $path = "uploads/jurnal/teacher/";
            $name = \Str::random(7).".png";
            $filename = $path.$name;

            $upload = \Storage::putFileAs($path,$request->file('jurnal_image'), $name);
        }

        $update = $data->update([
            'title' => $request->title,
            "description" => $request->description,
            "image" => $filename
        ]);

        if (!$update) {
            return redirect()->back()->withErrors(["Jurnal Gagal di update"]);
        }

        return redirect()->route('teacher.jurnal.list')->withSuccess(["Jurnal berhasil diupdate"]);
    }

    public function jurnalStudentDetail ($id) {
        if(Auth::user()->user_type == User::TEACHER) {
            $data = TeacherJurnal::where('id', $id)->whereHas('teacher', function($q){
                $q->where('user_id', Auth::id());
            })->with('student.user')->first();
        } else if(Auth::user()->user_type == User::STUDENT) {
            $data = TeacherJurnal::where('id', $id)->whereHas('student', function($q) {
                $q->where('user_id', Auth::id());
            })->with('student.user')->with('teacher.user')->first();
        } else if(Auth::user()->user_type == User::COMPANY) {
            $data = TeacherJurnal::where('teacher_jurnals.id', $id)
            ->leftJoin('students', 'students.id', '=', 'teacher_jurnals.student_id')
            ->leftJoin('student_practice_places','student_practice_places.student_id', '=', 'students.id')
            ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('users', 'users.id', '=', 'students.user_id')
            ->where('practice_places.user_id', Auth::id())
            ->select('teacher_jurnals.id', 'teacher_jurnals.title', 'teacher_jurnals.description', 'students.nisn', 'users.name', 'teacher_jurnals.created_at')
            ->first();
        }

        if (!$data) {
            abort(404);
        }

        return  view('teacher.jurnal-detail', compact('data'));
    }
}
