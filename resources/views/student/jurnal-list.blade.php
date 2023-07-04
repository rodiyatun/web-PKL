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
                Data Jurnal
            </h3>
            <div class="card-toolbar">
                <a href="?export=true" class="btn btn-primary">Export Data</a>
            </div>
        </div>


        <!--begin::Form-->
        <div class="card-body">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>

                        <th scope="col">Judul</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>

                            <td>{{ $row->title }}</td>
                            <td>{{ date('d F Y', strtotime($row->created_at)) }}</td>
                            <td>
                                <a href="{{ route('student.jurnal.detail', $row->id) }}"
                                    class="btn btn-sm btn-info">Detail</a>
                                @role('student')
                                <a href="{{ route('student.jurnal.edit', $row->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                @endrole
                            </td>
                        </tr>
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
