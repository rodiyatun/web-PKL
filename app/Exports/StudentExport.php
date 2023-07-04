<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Auth;
use DB;

class StudentExport implements FromCollection, WithStyles, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

     public function __construct($data)
     {
        $this->name = $data['name'];
        // $this->brandOutlet = $data['brand_outlet'];
        $this->jurusan = $data['jurusan'];
        $this->du_di = $data['du_di'];
     }
    public function collection()
    {
        if(Auth::user()->user_type == User::ADMIN) {
            $data = User::where(function($q)  {
                if(!empty($this->name)) {//Jika ada pencarian
                    $q->where('users.name', 'LIKE', '%'.$this->name.'%'); //Pahami istilah LIKE pada SQL
                }

                if(!empty($this->du_di)) {//Jika ada pencarian

                    $q->where('student_practice_places.practice_place_id', $this->du_di);
                }

                if(!empty($this->jurusan)) {//Jika ada pencarian

                        $q->where('students.major_id',$this->jurusan); //Pahami istilah LIKE pada SQL

                }
            })->where('user_type', 2) //Hanya menampilkan siswa saja
            ->leftJoin('students', 'students.user_id', '=', 'users.id')
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'students.id')


            ->leftJoin('majors', 'majors.id', '=', 'students.major_id')
            ->select('students.id', 'users.name', 'students.nisn','majors.name as major_name','users.email', 'students.birth_place',  DB::raw('DATE_FORMAT(students.birth_date, "%d %b %Y") as birth_date'))

            // ->with(['student.major', 'student.student_du.practice_place'])

            ->orderBy('users.name', 'asc')->get();
        } elseif (Auth::user()->user_type == User::TEACHER) {
            $data = User::where(function($q) {
                if(!empty($this->name)) {//Jika ada pencarian
                    $q->where('name', 'LIKE', '%'.$this->name.'%'); //Pahami istilah LIKE pada SQL
                }

                if(!empty($this->du_di)) {//Jika ada pencarian

                    $q->where('student_practice_places.practice_place_id', $this->du_di);
                }

                if(!empty($this->jurusan)) {//Jika ada pencarian
                    // $q->whereHas('student', function($query) use($request) {
                        $q->where('students.major_id',$this->jurusan); //Pahami istilah LIKE pada SQL
                    // });
                }
            })->where('user_type', 2) //Hanya menampilkan siswa saja
            ->leftJoin('students', 'students.user_id', '=', 'users.id')
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=','students.id')
            ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
            ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('majors', 'majors.id', '=', 'students.major_id')
            ->select('students.id', 'users.name', 'students.nisn', 'majors.name as major_name','users.email','students.birth_place', 'students.birth_date')
            ->where('teachers.user_id', Auth::id())
            // ->with(['student.major', 'student.student_du.practice_place'])

            ->orderBy('name', 'asc')->get();
        } else if(Auth::user()->user_type == User::COMPANY) {
            $data = User::where(function($q) {
                if(!empty($this->name)) {//Jika ada pencarian
                    $q->where('name', 'LIKE', '%'.$this->name.'%'); //Pahami istilah LIKE pada SQL
                }

                if(!empty($this->du_di)) {//Jika ada pencarian

                    $q->where('student_practice_places.practice_place_id', $this->du_di);
                }

                if(!empty($this->jurusan)) {//Jika ada pencarian
                    // $q->whereHas('student', function($query) use($request) {
                        $q->where('students.major_id',$this->jurusan); //Pahami istilah LIKE pada SQL
                    // });
                }
            })->where('user_type', 2) //Hanya menampilkan siswa saja
            ->leftJoin('students', 'students.user_id', '=', 'users.id')
            ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=','students.id')
            ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
            ->leftJoin('majors', 'majors.id', '=', 'students.major_id')
            ->where('practice_places.user_id', Auth::id())
            ->select('students.id', 'users.name', 'students.nisn', 'majors.name as major_name','users.email','students.birth_place',  DB::raw('DATE_FORMAT(students.birth_date, "%d-%b-%Y") as birth_date'))
            ->orderBy('name', 'asc')->get();


        }

        return $data;
    }

    public function headings(): array
    {
        return ['#',"Nama", "NISN", "Jurusan", "email", "Tempat Lahir", "Tanggal Lahir"];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
