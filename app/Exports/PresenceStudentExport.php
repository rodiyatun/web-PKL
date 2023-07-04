<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

use App\Models\StudentPresence;
use App\Models\User;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Auth;
use Maatwebsite\Excel\Concerns\FromView;

class PresenceStudentExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {

                if (Auth::user()->user_type == User::COMPANY) {
            return view('excel.presence_student', [
                'data' => StudentPresence::leftJoin('students', 'students.id', '=', 'student_presences.student_id')
                ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'student_presences.student_id')
                ->leftJoin('practice_places', 'practice_places.id','=', 'student_practice_places.practice_place_id')
                ->leftJoin('users', 'users.id', '=', 'students.user_id')
                ->where('practice_places.user_id', Auth::id())
                ->select('users.name', 'students.nisn','student_presences.id', 'student_presences.type', 'student_presences.created_at')
                ->orderBy('student_presences.created_at', 'desc')->get()
            ]);
        }
        elseif (Auth::user()->user_type == User::TEACHER) {
                return view('excel.presence_student', [
                    'data' => StudentPresence::leftJoin('students', 'students.id', '=', 'student_presences.student_id')
                    ->leftJoin('student_practice_places', 'student_practice_places.student_id', '=', 'student_presences.student_id')
                    ->leftJoin('practice_places', 'practice_places.id','=', 'student_practice_places.practice_place_id')
                    ->leftJoin('users', 'users.id', '=', 'students.user_id')
                    ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'practice_places.id')
                    ->leftJoin('teachers', 'teachers.id', '=', 'teacher_places.teacher_id')
                    ->where('teachers.user_id', Auth::id())
                    ->select('users.name', 'students.nisn','student_presences.id', 'student_presences.type', 'student_presences.created_at')
                    ->orderBy('student_presences.created_at', 'desc')->get()
                ]);
        }
    }



    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
