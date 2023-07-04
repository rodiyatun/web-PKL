<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

use App\Models\StudentJurnal;
use App\Models\User;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Auth;
use Maatwebsite\Excel\Concerns\FromView;

class JurnalStudentExport implements FromView, WithHeadings, ShouldAutoSize, WithStyles
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
            return view('excel.teacher_student_jurnal', [
                'data' => StudentJurnal::where('student_jurnals.student_id', $this->id)
                    ->leftJoin('student_practice_places', 'student_jurnals.student_id', '=', 'student_practice_places.student_id')
                    ->leftJoin('teacher_places', 'teacher_places.practice_place_id', '=', 'student_practice_places.practice_place_id')
                    ->leftJoin('teachers', 'teacher_places.teacher_id', '=', 'teachers.id')
                    ->where('teachers.user_id', Auth::id())
                    ->select('student_jurnals.id', 'student_jurnals.title', 'student_jurnals.description', 'student_jurnals.created_at')->orderBy('student_jurnals.created_at', 'desc')->get()
            ]);
        }
        elseif (Auth::user()->user_type == User::COMPANY) {
                return view('excel.teacher_student_jurnal', [
                    'data' => StudentJurnal::where('student_jurnals.student_id', $this->id)
                    ->leftJoin('student_practice_places', 'student_jurnals.student_id', '=', 'student_practice_places.student_id')
                    ->leftJoin('practice_places', 'practice_places.id', '=', 'student_practice_places.practice_place_id')
                    ->where('practice_places.user_id', Auth::id())
                    ->select('student_jurnals.id', 'student_jurnals.title', 'student_jurnals.description', 'student_jurnals.created_at')->orderBy('student_jurnals.created_at', 'desc')->get()
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
