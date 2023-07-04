<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

use App\Models\StudentJurnal;
use App\Models\TeacherJurnal;
use App\Models\User;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Auth;
use Maatwebsite\Excel\Concerns\FromView;

class JurnalTeacherExport implements FromView, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        $this->id = $data['student_id'];
        // $this->brandOutlet = $data['brand_outlet'];


    }
    public function view(): View
    {


        if (Auth::user()->user_type == User::TEACHER) {
            return view('excel.teacher_jurnal', [
                'data' => TeacherJurnal::leftJoin('students', 'students.id', '=','teacher_jurnals.student_id')
            ->leftJoin('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('teachers', 'teachers.id', '=', 'teacher_jurnals.teacher_id')
            ->where('teachers.user_id', Auth::id())->where('teacher_jurnals.student_id', $this->id)
            ->select('teacher_jurnals.id', 'students.nisn', 'users.name','teacher_jurnals.title','teacher_jurnals.description', 'teacher_jurnals.created_at')
            ->get()
            ]);
        }
        elseif (Auth::user()->user_type == User::COMPANY) {
                return view('excel.teacher_jurnal', [
                    'data' =>  TeacherJurnal::where('teacher_jurnals.student_id', $this->id)
                    ->leftJoin('student_practice_places', 'teacher_jurnals.student_id', '=', 'student_practice_places.student_id')
                    ->leftJoin('practice_places', 'student_practice_places.practice_place_id', '=', 'practice_places.id')
                    ->leftJoin('students', 'students.id','=', 'teacher_jurnals.student_id')
                    ->leftJoin('users', 'students.user_id', '=', 'users.id')
                    ->where('practice_places.user_id', Auth::id())
                    ->select('teacher_jurnals.id', 'students.nisn', 'users.name','teacher_jurnals.title', 'teacher_jurnals.description','teacher_jurnals.created_at')->get()
                ]);
        }
    }

    public function headings(): array
    {
        return ["No", "Judul", "Deskripsi", 'Dibuat pada'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
