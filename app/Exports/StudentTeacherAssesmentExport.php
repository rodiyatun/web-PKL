<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\TeacherPlace;
use Illuminate\Support\Facades\Auth;

class StudentTeacherAssesmentExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
    {
        $this->name = $data['name'];
        // $this->brandOutlet = $data['brand_outlet'];

        $this->id = $data['id'];
    }

    public function view(): View
    {
        return view('excel.teacher_student_assement', [
            'data' => $data = TeacherPlace::whereHas('teacher', function($q) {
                $q->where('user_id', Auth::id());
            })->where(function($q) {
                $q->where('practice_place_id', $this->id);
            })
            ->with(['practice_place.student.student.user' => function($q){
                $q->where('name', 'LIKE', '%'.$this->name.'%');
            }])->with('practice_place.student.student.student_assesment')->whereHas('practice_place.student', function($q) {
                $q->where('deleted_at', null);
            })->first()
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

}
