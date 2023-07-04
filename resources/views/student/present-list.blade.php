@extends('base')

@section('title', 'List Student')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.notifications')
        </div>
    </div>
    <div class="card card-custom col-md-8">
        <div class="card-header">
            @role('student')
                <div class="card-toolbar">
                    <a href="{{ route('present.lock', 'in') }}" class="btn btn-sm mr-1 btn-success font-weight-bold">
                        <i class="flaticon2-send-1"></i>Clock In</a>
                    <a href="{{ route('present.lock', 'out') }}" class="btn btn-sm btn-warning font-weight-bold">
                        <i class="flaticon2-right-arrow"></i>Clock Out</a>
                </div>
            @endrole
            @hasanyrole('teacher|teacher')
                <h3 class="card-title">
                    List Presensi Siswa
                </h3>
                <div class="card-toolbar">
                    <a href="?export=true" class="btn btn-primary">Export Data</a>
                </div>
            @endhasanyrole
        </div>


        <!--begin::Form-->
        <div class="card-body">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        @hasanyrole('company|teacher')
                            <th scope="col">NISN</th>
                            <th scope="col">Nama</th>
                        @endhasanyrole
                        <th scope="col">Tanggal</th>
                        <th scope="col">Type</th>
                        <th scope="col">Jam</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            @hasanyrole('company|teacher')
                                <td>{{ $row->nisn }}</td>
                                <td>{{ $row->name }}</td>
                            @endhasanyrole
                            <td>{{ date('d F Y', strtotime($row->created_at)) }}</td>
                            <td>{{ $row->type == 'in' ? 'Clock In' : 'Clock Out' }}</td>
                            <td>{{ date('H:i:s', strtotime($row->created_at)) }}</td>
                            <td>
                                <a
                                    href="{{ route('present.detail', Illuminate\Support\Facades\Crypt::encryptString($row->id)) }}">Detail</a>
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
