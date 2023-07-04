<?php

namespace App\Exports;

use App\Models\TeacherPlace;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentTeacherExport implements FromView, ShouldAutoSize, WithStyles
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
        return view('excel.teacher_student', [
            'data' => TeacherPlace::whereHas('teacher', function ($q) {
                $q->where('user_id', Auth::id());
            })->where(function ($q) {
                $q->where('practice_place_id', $this->id);
            })
                ->with(['practice_place.student.student.user' => function ($q) {
                    $q->where('name', 'LIKE', '%' . $this->name . '%');
                }])->whereHas('practice_place.student', function ($q) {
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
