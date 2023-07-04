<?php

namespace App\Http\Controllers;

use App\Models\PracticePlace;
use App\Models\Student;
use App\Models\StudentAssessment;
use App\Models\StudentJurnal;
use App\Models\StudentPracticePlace;
use App\Models\StudentPresence;
use App\Models\Teacher;
use App\Models\TeacherJurnal;
use App\Models\TeacherPlace;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function loginPost(Request $request) { //Untuk proses Login ketika user klik submit
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    public function dashboard() {
        if (Auth::user()->user_type == User::STUDENT) {
            $data = Student::where('user_id', Auth::id())->with('student_du.practice_place')->first();


            if ($data->student_du == null || empty($data->student_du->practice_place)) {
                session(['du_di' => null]);
            } else {

                session(['du_di' => $data->student_du->practice_place->name]);
            }

            $data1 = StudentJurnal::whereHas('student', function($q) {
                $q->where('user_id', Auth::id());
            })->count();

            $data2 = TeacherJurnal::whereHas('student', function($q) {
                $q->where('user_id', Auth::id());
            })->count();

            $data3 = StudentPresence::whereHas('student', function($q) {
                $q->where('user_id', Auth::id());
            })->whereDate('created_at', date('Y-m-d', strtotime('today')))->get();



            $sertifikat = StudentAssessment::whereHas('student', function($q){
                $q->where('user_id', Auth::id());
            })->get();

            if(count($sertifikat) != 0) {
                foreach($sertifikat as $val) {
                    if($val['company_score'] == 0) {
                        session(["sertifikat" => false]);
                        break;
                    }
                    if($val['teacher_score'] == 0) {
                        session(["sertifikat" => false]);
                        break;
                    }

                    session(["sertifikat" => true]);

                }
            } else {
                session(["sertifikat" => false]);

            }
        } elseif(Auth::user()->user_type == User::TEACHER) {
            $data1 = Student::leftJoin('student_practice_places', 'students.id', '=', 'student_practice_places.student_id')
            // ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
            ->where('teachers.user_id', Auth::id())->count();

            $data2 = TeacherJurnal::whereHas('teacher', function($q) {
                $q->where('user_id', Auth::id());
            })->count();

            $data3 =  TeacherPlace::whereHas('teacher', function($q) {
                $q->where('user_id', Auth::id());
            })->count();
        } elseif (Auth::user()->user_type == User::COMPANY) {
            $data1 = StudentPracticePlace::whereHas('practice_place', function($q) {
                $q->where('user_id', Auth::id());
            })->count();

            $data2 = StudentJurnal::leftJoin('student_practice_places', 'student_jurnals.student_id', '=', 'student_practice_places.student_id')
            ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->where('practice_places.user_id', Auth::id())
            ->count();

            $data3 = TeacherJurnal::leftJoin('student_practice_places', 'teacher_jurnals.student_id', '=', 'student_practice_places.student_id')
            ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->where('practice_places.user_id', Auth::id())
            ->count();
        } elseif(Auth::user()->user_type == User::ADMIN) {
            $data1 = Student::count();
            $data2 = Teacher::count();
            $data3 = PracticePlace::count();
        }

        // return session()->all();
        return view('welcome', compact('data1', 'data2', 'data3'));
    }

    public function editProfile() {
        $data = Auth::user();

        return view('profile', compact('data'));
    }

    public function updateProfile(Request $request) {
        if (!empty($request->password)) {
            $update_profile = User::where('id', Auth::id())->update([
                "password" => Hash::make($request->password)
            ]);

            if(!$update_profile) {
                return redirect()->back()->withErrors(["Error Update Profile"]);
            }
        }

        return redirect()->back()->withSuccess(["Sukses Update Profile"]);
    }
}
