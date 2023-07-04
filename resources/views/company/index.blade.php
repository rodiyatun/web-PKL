@extends('base')

@section('title', 'List Student')
@section('du_di', 'menu-item-open')
@section('list_du_di', 'menu-item-active')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.notifications')
        </div>
    </div>
    <div class="card card-custom col-md-10">
        <div class="card-header">
            <h3 class="card-title">
                Data DU/DI
            </h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">
                    {{-- <input type="text" name="name" placeholder="E.g : Muhammad Fulan" class="form-control" id=""> --}}
                    <div class="form-group row">
                        {{-- <label for="example-search-input" class="col-4 col-form-label">Search</label> --}}
                        <div class="col-12">
                            <form action="{{ route('company.index') }}" method="get">
                            <div class="input-group">
                                    <input type="text"
                                        class="form-control" name="name" value="{{ request()->get('name') }}" placeholder="Search for...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">Go!</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <div class="card-body">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama DU/DI</th>
                        <th scope="col">Owner</th>
                        <th scope="col">No HP Perusahaan</th>
                        <th scope="col">Email Perusahaan</th>
                        <th scope="col">Jumlah Siswa</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                    @role('Admin')
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row['student_count'] }}</td>
                            <td>
                                <a href="{{ route('student.assign', $row->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('company.edit', $row->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <a type="button" class="btn btn-sm btn-danger" href="javascript:;"
                                    onclick="deleteStudent({{ $row->id }})">Delete</a>
                            </td>
                        </tr>
                        @endrole
                        @role('teacher')
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $row->practice_place->name }}</td>
                            <td>{{ $row->practice_place->user->name }}</td>
                            <td>{{ $row->practice_place->phone }}</td>
                            <td>{{ $row->practice_place->email }}</td>
                            <td>{{ '-' }}</td>
                            <td>
                                <a href="{{ route('company.detail', $row->practice_place->id) }}" class="btn btn-sm btn-info">Detail</a>

                            </td>
                        </tr>
                        @endrole
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
        function deleteStudent(id) {
            let url = $('meta[name="url"]').attr('content') + '/company/delete/' + id;
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
                                            "{{ route('company.index') }}");
                                    }
                                });
                            }
                            if (response == true) {
                                Swal.fire("Success!", "Data siswa berhasil dihapus!", "success")
                                    .then((result) => {
                                        if (result.value) {
                                            $(location).attr('href',
                                                "{{ route('company.index') }}");
                                        }
                                        $(location).attr('href', "{{ route('company.index') }}");
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
