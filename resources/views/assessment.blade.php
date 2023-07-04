@extends('base')

@section('title', 'Create Teacher')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>
                Penilaian Siswa
            </h3>
            @include('layouts.notifications')
        </div>
    </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-borderless">
                    @role('teacher')
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $student['name'] }}</td>

                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>: {{ $student['nisn'] }}</td>
                    </tr>
                    @endrole
                    @role('company')
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $student['student']['user']['name'] }}</td>

                    </tr>
                    <tr>
                        <td>NISN</td>
                        <td>: {{ $student['student']['nisn'] }}</td>
                    </tr>
                    @endrole
                </table>
            </div>
        </div>

        <form action="{{ route('company.assessment.store', $student_id) }}" method="POST">
        @csrf
        @foreach ($aspect as $key => $value)
            <div class="card">
                <div class="card-header" id="heading{{ $value['id'] }}">
                    <h3> {{ $value['name'] }}</h3>
                </div>
                <div class="card-body">
                        <div class="kt_repeater_1">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-right">Penilaian:</label>
                                <div data-repeater-list="{{ Illuminate\Support\Facades\Crypt::encryptString($value['id']) }}" class="col-lg-10">
                                    @if (count($value['assessment']) == 0)
                                    <div data-repeater-item="item_{{ $key }}" class="form-group row align-items-center">
                                        <div class="col-md-3">
                                            <label>Assessment:</label>
                                            <textarea name="assessment" required id="" class="form-control" cols="30" rows="10" placeholder="E.g : Ketrampilan dalam merakit komputer cukup baik"></textarea>
                                            <div class="d-md-none mb-2"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Penilaian Perusahaan:</label>
                                            <input type="number" class="form-control" @role('teacher') disabled @endrole max="100" name="company_score" placeholder="E.g : 70">
                                            <div class="d-md-none mb-2"></div>
                                            @role('teacher')
                                            <input type="hidden" value="0" name="company_score">
                                            @endrole
                                        </div>
                                        <div class="col-md-2">
                                            <label>Penilaian Sekolah:</label>
                                            <input type="number" class="form-control" @role('company') disabled @endrole max="100"  name="teacher_score" placeholder="E.g : 70">
                                            <div class="d-md-none mb-2"></div>
                                            @role('company')
                                            <input type="hidden" value="0" name="teacher_score">
                                            @endrole
                                        </div>
                                        <div class="col-md-4">
                                            <a href="javascript:;" data-repeater-delete=""
                                                class="btn btn-sm font-weight-bolder btn-light-danger">
                                                <i class="la la-trash-o"></i>Delete</a>
                                        </div>
                                    </div>
                                    @else
                                    @foreach ($value['assessment'] as $item)

                                    <div data-repeater-item="" class="form-group row align-items-center">
                                        <input type="hidden" name="assessment_id" value="{{ Illuminate\Support\Facades\Crypt::encryptString($item['id']) }}">
                                        <div class="col-md-3">
                                            <label>Assessment:</label>
                                            <textarea name="assessment" required id="" class="form-control" cols="30" rows="10" placeholder="E.g : Ketrampilan dalam merakit komputer cukup baik">{{ $item['assessment'] }}</textarea>

                                            <div class="d-md-none mb-2"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Penilaian Perusahaan:</label>
                                            <input type="number" class="form-control"   name="company_score" @role('teacher') disabled @endrole value="{{ $item['company_score'] }}"max="100"  placeholder="E.g : 70">
                                            @role('teacher')
                                            <input type="hidden" value="{{ $item['company_score'] }}" name="company_score">
                                            @endrole
                                            <div class="d-md-none mb-2"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Penilaian Sekolah:</label>
                                            <input type="number" class="form-control"  name="teacher_score" @role('company') disabled @endrole value="{{ $item['teacher_score'] }}" max="100" placeholder="E.g : 70">
                                            @role('company')
                                            <input type="hidden" value="{{ $item['teacher_score'] }}" name="teacher_score">
                                            @endrole
                                            <div class="d-md-none mb-2"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="javascript:;" data-repeater-delete=""
                                                class="btn btn-sm font-weight-bolder btn-light-danger">
                                                <i class="la la-trash-o"></i>Delete</a>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-right"></label>
                                <div class="col-lg-4">
                                    <a href="javascript:;" data-repeater-create=""
                                        class="btn btn-sm font-weight-bolder btn-light-primary">
                                        <i class="la la-plus"></i>Add</a>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        @endforeach
        <hr>
        <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

@endsection
@section('scripts')
<script>
    var KTFormRepeater = function() {

// Private functions
var demo1 = function() {
    $('.kt_repeater_1').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function () {
            $(this).slideDown();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });
}

return {
    // public functions
    init: function() {
        demo1();
    }
};
}();

jQuery(document).ready(function() {
KTFormRepeater.init();
});
</script>
@endsection
