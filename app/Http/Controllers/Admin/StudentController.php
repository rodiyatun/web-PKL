<?php

namespace App\Http\Controllers\Admin;

use App\Exports\JurnalStudentExport;
use App\Exports\PresenceStudentExport;
use App\Exports\StudentExport;
use App\Http\Controllers\Controller;
use App\Models\AssessmentAspect;
use App\Models\Major;
use App\Models\PracticePlace;
use App\Models\Student;
use App\Models\StudentAssessment;
use App\Models\StudentJurnal;
use App\Models\StudentPracticePlace;
use App\Models\StudentPresence;
use App\Models\Teacher;
use App\Models\TeacherPlace;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Str;
use Storage;
use Stevebauman\Location\Facades\Location;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(Request $request) {
        $du_di = PracticePlace::all();
        $jurusan = Major::all();
        if(Auth::user()->user_type == User::ADMIN) {
            $data = User::where(function($q) use($request) {
                if(!empty($request->name)) {//Jika ada pencarian
                    $q->where('users.name', 'LIKE', '%'.$request->name.'%'); //Pahami istilah LIKE pada SQL
                }


            })->whereHas('student', function($q) use($request){
                if(!empty($request->jurusan)) {//Jika ada pencarian
                    // $q->whereHas('student', function($query) use($request) {
                        $q->where('major_id',$request->jurusan); //Pahami istilah LIKE pada SQL
                    // });
                }
            })->whereHas('student.student_du', function($q) use($request) {
                if(!empty($request->du_di)) {//Jika ada pencarian

                    $q->where('practice_place_id', $request->du_di);
                }
            })->where('user_type', 2) //Hanya menampilkan siswa saja
            ->with(['student.major', 'student.student_du.practice_place'])->orderBy('users.name', 'asc')->paginate(10);
        } elseif (Auth::user()->user_type == User::TEACHER) {
            $data = User::where(function($q) use($request) {
                if(!empty($request->name)) {//Jika ada pencarian
                    $q->where('users.name', 'LIKE', '%'.$request->name.'%'); //Pahami istilah LIKE pada SQL
                }
            })->where('user_type', 2) //Hanya menampilkan siswa saja
            ->leftJoin('students', 'students.user_id', '=', 'users.id')
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=','students.id')
            ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
            ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('majors', 'majors.id', '=', 'students.major_id')
            ->select('students.id', 'users.name', 'students.nisn', 'majors.name as major_name', 'practice_places.name as du_di')
            ->where('teachers.user_id', Auth::id())
            // ->with(['student.major', 'student.student_du.practice_place'])

            ->orderBy('users.name', 'asc')->paginate(10);
        } else if(Auth::user()->user_type == User::COMPANY) {
            $data = User::where(function($q) use($request) {
                if(!empty($request->name)) {//Jika ada pencarian
                    $q->where('users.name', 'LIKE', '%'.$request->name.'%'); //Pahami istilah LIKE pada SQL
                }
            })->where('user_type', 2) //Hanya menampilkan siswa saja
            ->leftJoin('students', 'students.user_id', '=', 'users.id')
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=','students.id')
            ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('majors', 'majors.id', '=', 'students.major_id')
            ->where('practice_places.user_id', Auth::id())
            ->select('students.id', 'users.name', 'students.nisn', 'majors.name as major_name', 'practice_places.name as du_di')
            ->orderBy('users.name', 'asc')->paginate(10);


        }

        // return $data;


        return view('student.index', compact('data', 'du_di', 'jurusan'));
    }

    public function exportStudent(Request $request) {

        $data['name'] = $request->name;
        $data['jurusan'] = $request->jurusan;
        $data['du_di'] = $request->du_di;
        return Excel::download(new StudentExport($request), "student_".strtotime('now').".xlsx");

    }
    public function create() { //Untuk menampilkan view create student
        return view('student.create');
    }

    public function store(Request $request) {
        //Create user untuk siswa login, $request adalah inputan dari admin
        DB::beginTransaction();
        try {
            $create_user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password), //Enkripsi Password kedalam hash
                'user_type' => 2
            ]);

            if (!$create_user) {
                DB::rollback();
                return redirect()->back()->withErrors(["Error Create User #RU001"]);
            }

            //Assign Role ke Student
            $create_user->assignRole('student');

            $create_student = Student::create([
                "user_id" => $create_user->id,
                "nisn" => $request->nisn,
                "birth_date" => $request->birth_date,
                "birth_place" => $request->birth_place,
                "major_id" => $request->major_id, //Jurusan
            ]);

            if (!$create_student) {
                DB::rollback();
                return redirect()->back()->withErrors(["Error Create User #RU002"]);
            }

            DB::commit();
            return redirect()->route('student.index')->withSuccess(["Data Student Berhasil disimpan"]);;

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function edit($id) {
        $data = User::whereHas('student', function($q) use($id) {
            $q->where('id', $id);
        })->with('student')->first();

        return view('student.edit', compact('data'));

    }

    public function update(Request $request, $id){
        DB::beginTransaction();
        try {
            $data_student = Student::where('id', $id)->first();

            if (!$data_student) {
                return redirect()->back()->withErrors(['Data Not Found']);
            }

            $update_student = $data_student->update([
                "nisn" => $request->nisn,
                "birth_date" => $request->birth_date,
                "birth_place" => $request->birth_place,
                "major_id" => $request->major_id, //Jurusan
            ]);

            if (!$update_student) { //Jika Gagal Update Student
                DB::rollback();
                return redirect()->back()->withErrors(["Error Update User #RR001"]);
            }

            $data_user = User::where('id', $data_student->user_id)->first();



            $update_user = $data_user->update([
                "name" => $request->name,
                "email" => $request->email,
                //Tambahkan Field Lain ya nanti
            ]);

            if(!empty($request->password)) { //Jika Password diisi
                $data_user->update([
                    "password" => Hash::make($request->password)
                ]);
            }

            if(!$update_student) { //Jika Gagal Update Student
                DB::rollback();
                return redirect()->back()->withErrors(["Error Update User #RU002"]);
            }

            DB::commit();
            return redirect()->back()->withSuccess(["Data User Berhasil diupdate"]);




        } catch (\Exception $err) {
            DB::rollback();
            return redirect()->back()->withErrors($err->getMessage());

        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            $data  = Student::where('id', $id)->first(); //Get Data

            // $data_user = ->first();

            $delete_student = $data->delete();
            if(!$delete_student) {
                DB::rollback();
                return 0;
            }
            $delete_user = User::where('id', $data->user_id)->delete();
            if(!$delete_user) {
                DB::rollback();
                return 0;
            }
            DB::commit();
            return 1;
        } catch (\Exception $err) {
            DB::rollback();
            return 0;
        }
    }

    public function presentation() {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $type = basename(parse_url($url, PHP_URL_PATH));


        $check_data = StudentPresence::whereHas('student', function($q){
            $q->where('user_id', Auth::id());
        })->whereDate('created_at', date('Y-m-d', strtotime('now')))->where('type', $type)->first();

        if ($check_data) {
            return redirect()->route('present.index')->withErrors(['Anda Sudah melakukan Clock '.$type." Hari ini"]);
        }
        return view('student.present');
    }

    public function savePresentation(Request $request) {
        try {
            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $type = basename(parse_url($url, PHP_URL_PATH));

            if ($type != "in" && $type != "out") {
                abort(404);
            }

            if (env('APP_ENV') == "development") {
                $ip = $_SERVER['REMOTE_ADDR'];
            } else {

                $ip = "36.72.213.40"; //Sementara di Local, kamu bisa ambil IP manual dengan cara cari d Google "My IP Address"
            }

            $user_agent =  $_SERVER["HTTP_USER_AGENT"];
            $location = Location::get($ip);
            $img = $request->image;
            $folderPath = "uploads/";

            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];

            $image_base64 = base64_decode($image_parts[1]); //Gambar berupa Base64 jadi harus di decode

            $fileName = time() . '-' . Str::random(6) . '.' . '.png';

            $file = $folderPath . $fileName;
            Storage::put($file, $image_base64); //Simpan gambar hasil presensi


            $save_presence = StudentPresence::create([
                "student_id" => Student::where('user_id', Auth::id())->first()->id,
                "type" => $type,
                "image_presence" => $file,
                "longitude" => $location->longitude,
                "latitude" => $location->latitude,
                "ip_address" => $location->ip,
                "region" => $location->regionName,
                "user_agent" => $user_agent,
            ]);
            return redirect()->route('present.index')->withSuccess(["Presensi Berhasil direkam"]);
        } catch (\Exception $err) {
            return redirect()->back()->withErrors($err->getMessage());
        }
    }

    public function createStudentJurnal() {
        $check_date = StudentJurnal::whereHas('student', function($q){
            $q->where('user_id', Auth::id());
        })->whereDate('created_at', date('Y-m-d'))->first();

        if ($check_date) {
            return redirect()->route('student.jurnal.list')->withErrors(['Jurnal hanya bisa diisi sekali sehari']);
        }
        return view('student.jurnal');
    }

    public function saveStudentJurnal(Request $request) {

        $this->validate($request, [
            'jurnal_image' => 'file|max:7000', // max 7MB
        ]);
// return $request;
        try {
            $check_date = StudentJurnal::whereHas('student', function($q){
                $q->where('user_id', Auth::id());
            })->whereDate('created_at', date('Y-m-d'))->first();

            if ($check_date) {
                return redirect()->route('student.jurnal.list')->withErrors(['Jurnal hanya bisa diisi sekali sehari']);
            }
            $filename = null;

            if(!@empty($request->jurnal_image)) {
                $path = "uploads/jurnal/student/";
                $name = Str::random(7).".png";
                $filename = $path.$name;

                $upload = Storage::putFileAs($path,$request->file('jurnal_image'), $name);
            }

            $save = StudentJurnal::create([
                "title" => $request->title,
                "description" => $request->description,
                "student_id" => Student::where('user_id', Auth::id())->first()->id,
                'image' => $filename
            ]);

            if ( !$save) {
                return redirect()->back()->withErrors(["Error menyimpan data jurnal"]);
            }

            return redirect()->route('student.jurnal.list')->withSuccess(["Jurnal Berhasil disimpan"]);

        } catch (\Exception $err) {
            return redirect()->back()->withErrors($err->getMessage());

        }
    }

    public function assignPracticePlace($id) {
        $student_list_assign = StudentPracticePlace::select('id', 'student_id', 'practice_place_id')->whereHas('practice_place', function($q){
            $q->where('deleted_at', null);
        })->get()->toArray(); //TODO ambil tahun ajaran

        $practice_place = PracticePlace::find($id);

        $student_list = Student::whereNotIn('id', array_column($student_list_assign, 'student_id'))->with('user')->get(); //Data siswa yang belum diassign

        $teacher_place = TeacherPlace::select('id', 'teacher_id', 'practice_place_id')->where('practice_place_id', $id)->whereHas('practice_place', function($q) {
            $q->where('deleted_at', null);
        })->get()->toArray();

        $teacher_list = Teacher::whereNotIn('id', array_column($teacher_place, 'teacher_id'))->with('user')->get();


        // return $student_list;
        return view('student.practice-place-assign', compact('practice_place', 'student_list', 'teacher_list'));
    }

    public function postAssignPracticePlace(Request $request, $id){
        // $tahun_ajaran = session("tahun_ajaran_aktif");

        $check_data = StudentPracticePlace::where([
            "student_id" => $request->student_id,
            "practice_place_id" => $id,
            // "school_year_id" => $tahun_ajaran->id
        ])->first();

        if($check_data){
            return 0;
        }

        $create = StudentPracticePlace::create([
            "student_id" => $request->student_id,
            "practice_place_id" => $id,
            // "school_year_id" => $tahun_ajaran->id
        ]);


        return 1;
    }

    public function listStudentAssigned(Request $request,$id) {
        // if(!$request->ajax()){
        //     abort(404);
        // }
        $data = StudentPracticePlace::where('practice_place_id', $id)->with('student.user')->get();

        $data_perusahaan = '<table class="table table-sm">
        <thead>
            <tr>
                <td>No</td>
                <td>NISN</td>
                <td>Nama Siswa</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <tbody>';

        foreach($data as $key => $val){
            if(!empty($val['student'])) {

                $num = $key+1;
                $data_perusahaan .= '<tr>

                <td>'.$num.'</td>
                <td>'.$val["student"]["nisn"].'</td>
                <td>'.$val["student"]["user"]["name"].'</td>
                <td><button class="btn btn-sm btn-danger"  data-seq="1" onClick="deleteStudent('.$val['id'].')">Hapus</button></td>
                </tr>';
            }
        }
        $data_perusahaan .= '</tbody>
        </table>';

        return $data_perusahaan;
    }



    public function deleteStudentAssigned($id) {
        try {
            $data = StudentPracticePlace::where('id', $id)->delete();

            return $data;
        } catch (\Exception $th) {
            return 0;
        }
    }

    public function listPresence(Request $request){

        if(empty($request->export)) {
            if(Auth::user()->user_type == User::STUDENT) {
                $data = StudentPresence::whereHas('student', function($q){
                    $q->where('user_id', Auth::id());
                })->orderBy('created_at', 'desc')->paginate(10);
            } else if (Auth::user()->user_type == User::COMPANY){
                // return Auth::id();
                $data = StudentPresence::leftJoin('students', 'students.id', '=', 'student_presences.student_id')
                ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'student_presences.student_id')
                ->leftJoin('practice_places', 'practice_places.id','=', 'student_practice_places.practice_place_id')
                ->leftJoin('users', 'users.id', '=', 'students.user_id')
                ->where('practice_places.user_id', Auth::id())
                ->select('users.name', 'students.nisn','student_presences.id', 'student_presences.type', 'student_presences.created_at')
                ->orderBy('student_presences.created_at', 'desc')->paginate(10);
            } elseif(Auth::user()->user_type == User::TEACHER) {
                $data = StudentPresence::leftJoin('students', 'students.id', '=', 'student_presences.student_id')
                ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'student_presences.student_id')
                ->leftJoin('practice_places', 'practice_places.id','=', 'student_practice_places.practice_place_id')
                ->leftJoin('users', 'users.id', '=', 'students.user_id')
                ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'practice_places.id')
                ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
                ->where('teachers.user_id', Auth::id())
                ->select('users.name', 'students.nisn','student_presences.id', 'student_presences.type', 'student_presences.created_at')
                ->orderBy('student_presences.created_at', 'desc')->paginate(10);
            }



            return view('student.present-list', compact('data'));
        }

        return Excel::download(new PresenceStudentExport(), "student_presence_".strtotime('now').".xlsx");


    }

    public function detailPresence($id) {
        if(Auth::user()->user_type ==User::STUDENT) {

            $data = StudentPresence::where('id', Crypt::decryptString($id))->WhereHas('student', function($q) {
                $q->where('user_id', Auth::id());
            })->with('student.user')->first();
        } else if(Auth::user()->user_type == User::COMPANY) {
            $data = StudentPresence::leftJoin('students', 'students.id', '=', 'student_presences.student_id')
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'student_presences.student_id')
            ->leftJoin('practice_places', 'practice_places.id','=', 'student_practice_places.practice_place_id')
        ->leftJoin('users', 'users.id', '=', 'students.user_id')
            ->where('practice_places.user_id', Auth::id())
            ->where('student_presences.id',  Crypt::decryptString($id))
            ->select('users.name', 'students.nisn','student_presences.id', 'student_presences.type', 'student_presences.image_presence', 'student_presences.longitude', 'student_presences.latitude', 'student_presences.ip_address', 'region','user_agent', 'student_presences.created_at') //TODO ambil value longitude segala macem

            ->first();
        } else {
            $data = StudentPresence::leftJoin('students', 'students.id', '=', 'student_presences.student_id')
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'student_presences.student_id')
            ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('teachers', 'teacher_places.teacher_id', '=', 'teachers.id')
            ->leftJoin('users', 'users.id', '=', 'students.user_id')
            ->where('teachers.user_id', Auth::id())
            ->where('student_presences.id',  Crypt::decryptString($id))
            ->select('users.name', 'students.nisn','student_presences.id', 'student_presences.type', 'student_presences.image_presence', 'student_presences.longitude', 'student_presences.latitude', 'student_presences.ip_address', 'region','user_agent', 'student_presences.created_at') //TODO ambil value longitude segala macem
            ->first();
        }

        // return $data;

        return view('student.presence-detail', compact('data'));
    }

    public function listStudentJurnal() {
        if(Auth::user()->user_type == User::STUDENT) {
            $data = StudentJurnal::whereHas('student', function($q){
                $q->where('user_id', Auth::id());
            });
        }

        $data = $data->orderBy('student_jurnals.created_at', 'desc')->paginate(10);

        return view('student.jurnal-list', compact('data'));
    }


    public function detailJurnal($id) {
        if(Auth::user()->user_type == User::STUDENT) {
            $data = StudentJurnal::where('id', $id)->whereHas('student', function($q){
                $q->where('user_id', Auth::id());
            });
        } elseif(Auth::user()->user_type == User::COMPANY) {
            $data = StudentJurnal::leftJoin('students', 'students.id', '=', "student_jurnals.student_id")
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'students.id')
            ->leftJoin('practice_places', 'practice_places.id','=', 'student_practice_places.practice_place_id')
            ->leftJoin('users', 'users.id', '=', 'students.user_id')
            ->where('practice_places.user_id', Auth::id())->where('student_jurnals.id', $id)
            ->select('student_jurnals.id', 'student_jurnals.title','student_jurnals.description', 'students.nisn', 'users.name','student_jurnals.image', 'student_jurnals.created_at');

        } elseif(Auth::user()->user_type == User::TEACHER) {
            $data = StudentJurnal::leftJoin('students', 'students.id', '=', "student_jurnals.student_id")
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'students.id')
            ->leftJoin('practice_places', 'practice_places.id','=', 'student_practice_places.practice_place_id')
            ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=','student_practice_places.practice_place_id')
            ->leftJoin('teachers', 'teacher_places.teacher_id', '=', 'teachers.id')
            ->leftJoin('users', 'users.id', '=', 'students.user_id')
            ->where('teachers.user_id', Auth::id())->where('student_jurnals.id', $id)
            ->select('student_jurnals.id', 'student_jurnals.title', 'student_jurnals.description','students.nisn', 'users.name','student_jurnals.image', 'student_jurnals.created_at');
        }

        $data = $data->first();

        if (!$data) { //Jika Jurnal tidak ada maka tampilan 404 Not Found
            abort(404);
        }

        return view('student.jurnal-detail', compact('data'));
    }

    public function studentJurnalList(Request $request, $id) {
        if(empty($request->export)){
            if(Auth::user()->user_type == User::TEACHER) {
                $data = StudentJurnal::where('student_jurnals.student_id', $id)
                ->leftJoin('student_practice_places', 'student_jurnals.student_id', '=', 'student_practice_places.student_id')
                ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'student_practice_places.practice_place_id')
                ->leftJoin('teachers', 'teacher_places.teacher_id', '=', 'teachers.id')
                ->where('teachers.user_id', Auth::id())
                ->select('student_jurnals.id', 'student_jurnals.title', 'student_jurnals.created_at')->orderBy('student_jurnals.created_at', 'desc')->paginate(10);
            } elseif(Auth::user()->user_type == User::COMPANY) {
                $data = StudentJurnal::where('student_jurnals.student_id', $id)
                ->leftJoin('student_practice_places', 'student_jurnals.student_id', '=', 'student_practice_places.student_id')
                ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
                ->where('practice_places.user_id', Auth::id())
                ->select('student_jurnals.id', 'student_jurnals.title', 'student_jurnals.created_at')->orderBy('student_jurnals.created_at', 'desc')->paginate(10);
            }


            return view('student.jurnal-list', compact('data'));
        }

        $data['student_id'] = $id;

        return Excel::download(new JurnalStudentExport($data), "student_jurnal_".strtotime('now').".xlsx");



    }

    public function studentJurnalEdit($id) {
        $data = StudentJurnal::where('id', $id)
        ->whereHas('student', function($q) {
            $q->where('user_id', Auth::id());
        })->first();

        // return date('Y-m-d', strtotime('today'));

        if(date('Y-m-d', strtotime('today')) != date('Y-m-d', strtotime($data->created_at))) {
            return redirect()->back()->withErrors(['Jurnal hanya bisa di edit di hari yang sama']);
        }

        return view('student.jurnal-edit', compact('data'));
    }

    public function studentJurnalUpdate(Request $request, $id)  {
        $data = StudentJurnal::where('id', $id)
        ->whereHas('student', function($q) {
            $q->where('user_id', Auth::id());
        })->first();

        if(!$data) {
            abort(404);
        }

        $filename = $data['image'];

        if(!empty($request->jurnal_image)) {
            $path = "uploads/jurnal/teacher/";
            $name = \Str::random(7).".png";
            $filename = $path.$name;

            $upload = \Storage::putFileAs($path,$request->file('jurnal_image'), $name);
        }

        $update = $data->update([
            "title" => $request->title,
            "description" => $request->description,
            "image" => $filename
        ]);

        return redirect()->route('student.jurnal.list')->withSuccess(["Jurnal Berhasil diupdate"]);
    }

    public function showCertificate() {
        $sertifikat = StudentAssessment::whereHas('student', function($q){
            $q->where('user_id', Auth::id());
        })->get();

        if(count($sertifikat) != 0) {
            foreach($sertifikat as $val) {
                // return $val;
                if($val['company_score'] == 0) {
                    return $val;
                    return redirect()->route('dashboard')->withErrors(['Sertifikat Belum Tersedia']);
                }
                if($val['teacher_score'] == 0) {

                    return redirect()->route('dashboard')->withErrors(['Sertifikat Belum Tersedia']);

                }



            }
        } else {
            return redirect()->route('dashboard')->withErrors(['Sertifikat Belum Tersedia']);


        }


        $data = Student::where('user_id', Auth::id())->with('user', 'student_du.practice_place')->first();

        $data_nilai = AssessmentAspect::with(['assessment' => function($q) {
            $q->whereHas('student', function($query) {
                $query->where('user_id', Auth::id());
            });
        }])->get();

        // return $data_nilai;

        return view('certificate', compact('data', 'data_nilai'));
    }
    public function downloadCertificate() {
        $sertifikat = StudentAssessment::whereHas('student', function($q){
            $q->where('user_id', Auth::id());
        })->get();

        if(count($sertifikat) != 0) {
            foreach($sertifikat as $val) {
                // return $val;
                if($val['company_score'] == 0) {
                    return $val;
                    return redirect()->route('dashboard')->withErrors(['Sertifikat Belum Tersedia']);
                }
                if($val['teacher_score'] == 0) {

                    return redirect()->route('dashboard')->withErrors(['Sertifikat Belum Tersedia']);

                }



            }
        } else {
            return redirect()->route('dashboard')->withErrors(['Sertifikat Belum Tersedia']);


        }


        $nilai['data'] = Student::where('user_id', Auth::id())->with('user', 'student_du.practice_place')->first();

        $nilai['data_nilai'] = AssessmentAspect::with(['assessment' => function($q) {
            $q->whereHas('student', function($query) {
                $query->where('user_id', Auth::id());
            });
        }])->get();



        $pdf = Pdf::loadView('certificate-download', $nilai)->setPaper('4', 'landscape');
        return $pdf->stream($nilai['data']['user']['name'].'_Certificate.pdf');
    }

    public function exportStudentJurnal(Request $request) {

        $data['student_id'] = $request->student_id;
        $data['date_start'] = $request->date_start;
        $data['date_end'] = $request->date_end;
        return Excel::download(new JurnalStudentExport($data), "users.xlsx");
    }
}
