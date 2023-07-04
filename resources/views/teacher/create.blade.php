@extends('base')

@section('title', 'Create Teacher')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.notifications')
        </div>
    </div>
    <div class="card card-custom col-md-8">
        <div class="card-header">
            <h3 class="card-title">
                Membuat Data Guru Baru
            </h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">
                    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form method="POST" action="{{ route('teacher.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body col-md-10">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
                        <div class="alert-text">
                            Isilah data guru dengan baik dan benar
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="E.g : Muhammad Fulan" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap guru.</span>
                </div>
                <div class="form-group">
                    <label>NIK/NIP<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="nik" placeholder="E.g : 123456789" />
                    <span class="form-text text-muted">Isilah sesuai dengan NIP guru.</span>
                </div>
                <div class="form-group ">
                    <label>Tempat,Tanggal Lahir<span class="text-danger">*</span></label>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="E.g : Cilacap" name="birth_place" />
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" value="2022-08-17" name="birth_date" />
                            </div>
                        </div>
                        <span class="form-text text-muted">Isilah sesuai dengan Tanggal lahir murid murid.</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" placeholder="E.g : Email@example.coms" />
                    <span class="form-text text-muted">Isilah sesuai dengan email murid(email ini digunakan untuk login)
                    </span>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="number" class="form-control" name="phone" placeholder="E.g : 08123456789" />
                    <span class="form-text text-muted">Isilah sesuai dengan Nomor Telepon guru.</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                        placeholder="Password" />
                </div>

                <div class="form-group">
                    <label for="exampleSelect1">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-control" name="gender" id="exampleSelect1">
                        <option value="">Pilih salah satu</option>
                        <option value="1">Pria</option>
                        <option value="2">Wanita</option>

                    </select>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
@endsection
