@extends('base')

@section('title', 'List Student')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.notifications')
        </div>
    </div>
    <div class="card card-custom col-md-10">
        <div class="card-header">
            <h3 class="card-title">
                Data Murid

            </h3>


        </div>

        <!--begin::Form-->
        <div class="card-body">
            <div id="accordion">

                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                aria-expanded="false" aria-controls="collapseTwo">
                                Filter Data
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <form action="{{ route('student.index') }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control form-control" name="name"
                                                value="{{ request()->get('name') }}" placeholder="E.g : Muhammad Fulan" />
                                        </div>

                                        <div class="form-group">
                                            <label>Jurusan</label>
                                            <select class="form-control" id="kt_select2_1" name="jurusan">
                                                <option value="">Pilih Salah Satu</option>\
                                                @foreach ($jurusan as $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ request()->get('jurusan') == $item['id'] ? 'selected' : '' }}>
                                                        {{ $item['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>DU/DI</label>
                                            <br>
                                            <select class="form-control select2" id="kt_select2_1" name="du_di">
                                                <option value="">Pilih Salah Satu</option>\
                                                @foreach ($du_di as $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ request()->get('du_di') == $item['id'] ? 'selected' : '' }}>
                                                        {{ $item['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row float-right">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary filter">
                                                <i class="flaticon-search"></i> Cari
                                            </button>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-secondary" type="reset"
                                                href="{{ route('student.index') }}">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                                aria-expanded="false" aria-controls="collapseThree">
                                Import Data
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <form action="{{ route('student.export') }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control form-control" name="name"
                                                value="{{ request()->get('name') }}" placeholder="E.g : Muhammad Fulan" />
                                        </div>

                                        <div class="form-group">
                                            <label>Jurusan</label>
                                            <select class="form-control" id="kt_select2_1" name="jurusan">
                                                <option value="">Pilih Salah Satu</option>\
                                                @foreach ($jurusan as $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ request()->get('jurusan') == $item['id'] ? 'selected' : '' }}>
                                                        {{ $item['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>DU/DI</label>
                                            <br>
                                            <select class="form-control select2" id="kt_select2_1" name="du_di">
                                                <option value="">Pilih Salah Satu</option>\
                                                @foreach ($du_di as $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ request()->get('du_di') == $item['id'] ? 'selected' : '' }}>
                                                        {{ $item['name'] }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row float-right">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary filter">
                                                <i class="flaticon-search"></i> Cari
                                            </button>
                                            &nbsp;&nbsp;
                                            <a class="btn btn-secondary" type="reset"
                                                href="{{ route('student.index') }}">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>





        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">NISN</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">DU/DI</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $row)
                    @role('Admin')
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->student->nisn }}</td>
                            <td>
                                <span class="label label-inline label-light-primary font-weight-bold">
                                    {{ $row->student->major->name }}
                                </span>
                            </td>
                            <td>
                                @if ($row->student->student_du == null || empty($row->student->student_du->practice_place))
                                    <span class="label label-inline label-light-danger font-weight-bold">
                                        Belum Dapat Du/DI
                                    </span>
                                @else
                                    <span class="label label-inline label-light-info font-weight-bold">


                                        {{ $row->student->student_du->practice_place->name }}

                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('student.edit', $row->student->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <a type="button" class="btn btn-sm btn-danger" href="javascript:;"
                                    onclick="deleteStudent({{ $row->student->id }})">Delete</a>
                            </td>
                        </tr>
                    @endrole
                    @hasanyrole('teacher|company')
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->nisn }}</td>
                            <td>
                                <span class="label label-inline label-light-primary font-weight-bold">
                                    {{ $row->major_name }}
                                </span>
                            </td>
                            <td>
                                @if ($row->du_di == null)
                                    <span class="label label-inline label-light-danger font-weight-bold">
                                        Belum Dapat Du/DI
                                    </span>
                                @else
                                    <span class="label label-inline label-light-info font-weight-bold">
                                        {{ $row->du_di }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('student.jurnal.lists', $row->id) }}" class="btn btn-sm btn-warning">Lihat
                                    Jurnal</a>

                                <a href="{{ route('teacher.jurnal.student.list', $row->id) }}" class="btn btn-sm btn-info">
                                    @role('teacher')
                                        Assign Jurnal
                                        @endrole @role('company')
                                        Lihat Jurnal Guru
                                    @endrole
                                </a>

                                <a type="button" class="btn btn-sm btn-primary"
                                    href="{{ route('company.assessment', $row->id) }}">Beri Nilai</a>
                            </td>
                        </tr>
                    @endhasanyrole()
                @empty
                    <tr>
                        <td>Data Tidak Ditemukan</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        <div class="float-right">
            Showing {{ @$data->firstItem() }} to {{ @$data->lastItem() }} of {{ @$data->total() }} entries

            @if (@$data->previousPageUrl() == null)
                <a href="#" class="btn btn-secondary disabled">
                    << </a>
                    @else
                        <a href="{{ @$data->previousPageUrl() }}" class="btn btn-primary">
                            << </a>
            @endif

            @if (@$data->nextPageUrl() == null)
                <a href="#" class="btn btn-secondary disabled"> >> </a>
            @else
                <a href="{{ @$data->nextPageUrl() }}" class="btn btn-primary"> >></a>
            @endif
        </div>
    </div>
    <!--end::Form-->
    </div>
@endsection
@section('scripts')
    <script>
        $('.select2').select2({
            placeholder: "Select a state"
        });

        function deleteStudent(id) {
            let url = $('meta[name="url"]').attr('content') + '/student/delete/' + id;
            let csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal.fire({
                title: "Apa anda yakin?",
                text: "Setelah dihapus, murid tidak akan bisa login kembali",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#34ab13',
                confirmButtonText: "Ya Hapus saja!"
            }).then((result) => {

                if (result.value) {
                    $('#loading').show();
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            '_method': 'POST',
                            '_token': csrf_token
                        },
                        success: function(response) {
                            $('#loading').hide();
                            // console.log(response)
                            if (response == false) {
                                swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!'
                                }).then((result) => {
                                    if (result.value) {
                                        $(location).attr('href',
                                            "{{ route('student.index') }}");
                                    }
                                });
                            }
                            if (response == true) {
                                Swal.fire("Success!", "Data siswa berhasil dihapus!", "success")
                                    .then((result) => {
                                        if (result.value) {
                                            $(location).attr('href',
                                                "{{ route('student.index') }}");
                                        }
                                        $(location).attr('href', "{{ route('student.index') }}");
                                    });
                            }
                        },
                        error: function(xhr) {
                            $('#loading').hide();
                            Swal.fire("Oops....", "Something went wrong!", "error");
                        }
                    });
                }
            });
        };
    </script>
@endsection
