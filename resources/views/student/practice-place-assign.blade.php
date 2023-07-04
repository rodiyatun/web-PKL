@extends('base')

@section('title', 'Assign Tempat Praktek '.$practice_place->name )

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.notifications')
        </div>
    </div>
    <div class="card card-custom col-md-6">
        <div class="card-header">
            <h3 class="card-title">
                Detail Tempat Praktek
            </h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">
                    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                </div>
            </div>
        </div>
        <table class="table table-borderless">
            <tr>
                <td>
                    <strong>Tempat Praktek</strong>
                </td>
                <td>: {{ $practice_place->name }}</td>
            </tr>

            <tr>
                <td>
                    <strong>Alamat</strong>
                </td>
                <td>: {{ $practice_place->address }}</td>
            </tr>

            <tr>
                <td>
                    <strong>PIC</strong>
                </td>
                <td>: {{ $practice_place->pic }}</td>
            </tr>

            <tr>
                <td>
                    <strong>Owner</strong>
                </td>
                <td>: {{ $practice_place->user->name }}</td>
            </tr>
        </table>


    </div>
    <div class="row">
        <div class="card card-custom col-md-6 mt-10">
            <div class="card-header">
                <h3 class="card-title">
                    Daftar Guru Yang Belum Dapat Tempat PKL
                </h3>

            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <td>NIK</td>
                            <th>Nama Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teacher_list as $key => $item)
                           <tr>
                            <input type="hidden" class="id_teacher" value="{{ $item['id'] }}">

                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td><button class="btn btn-sm btn-primary assign-teacher">Tambah</button></td>
                           </tr>
                        @empty
                            <td></td>
                            <td>Data Kosong</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6 mt-10 ">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Guru {{ $practice_place->name }}</h4>
                </div>
                <div class="card-body list-teacher">

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="card card-custom col-md-6 mt-10">
            <div class="card-header">
                <h3 class="card-title">
                    Daftar Murid Yang Belum Dapat Tempat PKL
                </h3>

            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <td>NISN</td>
                            <th>Nama Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($student_list as $key => $item)
                           <tr>
                            <input type="hidden" class="id_student" value="{{ $item['id'] }}">

                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td><button class="btn btn-sm btn-warning assign-student">Tambah</button></td>
                           </tr>
                        @empty
                            <td></td>
                            <td>Data Kosong</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6 mt-10 ">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Siswa {{ $practice_place->name }}</h4>
                </div>
                <div class="card-body list-student">

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(function(){
        tampil_siswa()
        tampil_guru()
    })
    $('.assign-student').click(function(){

        var id = {{ $practice_place->id }}
        let url = $('meta[name="url"]').attr('content')+'/company/assign-save/'+id;
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        var student = $(this).parent().parent().find('.id_student').val();
        var button = $(this);

        $.post(url, {
            "_token" : csrf_token,
            "student_id" : student
        },
        function(data, status) {
            if(data == 1){
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                };

                toastr.success("Siswa berhasil diassign!");
                tampil_siswa()
                button.hide();

            } else if(data = 0) {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                    };

                    toastr.error("Gagal Tambah Siswa ke perushaan (Siswa Sudah Terdaftar di perusahaan)");

            } else {
                iziToast.error({
                    title: 'Error!',
                    message: 'Cek Koneksi anda!',
                    position: 'topRight'
                });
            }

        });

    })




    $('.assign-teacher').click(function(){

    var id = {{ $practice_place->id }}
    let url = $('meta[name="url"]').attr('content')+'/company/teacher/assign-save/'+id;
    let csrf_token = $('meta[name="csrf-token"]').attr('content');
    var teacher = $(this).parent().parent().find('.id_teacher').val();
    var button = $(this);

    $.post(url, {
        "_token" : csrf_token,
        "teacher_id" : teacher
    },
    function(data, status) {

        if(data == 1){
            toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            };

            toastr.success("Guru berhasil diassign!");
            tampil_guru()
            button.hide();

        } else if(data == 0) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                };

                toastr.error("Gagal Tambah Guru ke perushaan (Siswa Sudah Terdaftar di perusahaan)");

        }  else if(data == 2) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                };

                toastr.error("Gagal Tambah Guru ke Perusahaan(DU/DI Hanya bisa 1 Pembimbing)");

        } else {
            iziToast.error({
                title: 'Error!',
                message: 'Cek Koneksi anda!',
                position: 'topRight'
            });
        }

    });

    })

    function tampil_guru(){
        var id = {{ $practice_place->id }}

        let url = $('meta[name="url"]').attr('content')+'/company/teacher/assigned/'+id;
        let csrf_token = $('meta[name="csrf-token"]').attr('content');

        $.get(url,
        {
            _token    :   csrf_token
        },
        function(data, status){
            $(".list-teacher").html(data);
        });
    }
    function tampil_siswa(){
        var id = {{ $practice_place->id }}

        let url = $('meta[name="url"]').attr('content')+'/company/assigned/'+id;
        let csrf_token = $('meta[name="csrf-token"]').attr('content');

        $.get(url,
        {
            _token    :   csrf_token
        },
        function(data, status){
            $(".list-student").html(data);
        });
    }

    function deleteStudent(id){
            let url = $('meta[name="url"]').attr('content')+'/company/assign-delete/'+id;
            let csrf_token = $('meta[name="csrf-token"]').attr('content');
            let title = $(this).attr('seq');
            // console.log(title)
            swal.fire({
                title: "Apakah anda yakin?",
                text: "menghapus data akan membuat beberapa data hilang termasuk Jurnal Siswa!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#a83232',
                confirmButtonText: "Yes, delete it!"
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
                        success: function (response) {
                            $('#loading').hide();
                            console.log(response)
                            if (response == false) {
                                var obj = JSON.parse(response.message);

                                Swal.fire("Oops....", obj.message ?? "Something went wrong!", "error").then((result) => {

                                    });
                            }
                            if (response == true) {
                                    Swal.fire("Success!", "Data has been deleted!", "success").then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                        location.reload();
                                });
                            }
                        },
                        error: function (xhr) {
                            $('#loading').hide();

                            Swal.fire("Oops....", "Something went wrong!", "error");
                        }
                    });
                }
            });
	    };

        function deleteGuru(id){
            let url = $('meta[name="url"]').attr('content')+'/company/teacher/assign-delete/'+id;
            let csrf_token = $('meta[name="csrf-token"]').attr('content');
            let title = $(this).attr('seq');
            // console.log(title)
            swal.fire({
                title: "Apakah anda yakin?",
                text: "menghapus data akan membuat beberapa data hilang termasuk Jurnal Guru!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#a83232',
                confirmButtonText: "Yes, delete it!"
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
                        success: function (response) {
                            $('#loading').hide();
                            console.log(response)
                            if (response == false) {
                                var obj = JSON.parse(response.message);

                                Swal.fire("Oops....", obj.message ?? "Something went wrong!", "error").then((result) => {

                                    });
                            }
                            if (response == true) {
                                    Swal.fire("Success!", "Data has been deleted!", "success").then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                        location.reload();
                                });
                            }
                        },
                        error: function (xhr) {
                            $('#loading').hide();

                            Swal.fire("Oops....", "Something went wrong!", "error");
                        }
                    });
                }
            });
	    };
</script>
@endsection
