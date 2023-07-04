@extends('base')

@section('title', 'Create Student')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.notifications')
        </div>
    </div>
    <div class="card card-custom col-md-8">
        <div class="card-header">
            <h3 class="card-title">
                Membuat Data Murid Baru
            </h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">
                    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form method="POST" action="{{ route('student.save') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body col-md-10">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
                        <div class="alert-text">
                            Isilah data murid dengan baik dan benar
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="E.g : Muhammad Fulan" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap murid.</span>
                </div>
                <div class="form-group">
                    <label>NISN<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="nisn" placeholder="E.g : 123456789" />
                    <span class="form-text text-muted">Isilah sesuai dengan NISN murid.</span>
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
                    <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                        placeholder="Password" />
                </div>

                <div class="form-group">
                    <label for="exampleSelect1">Jurusan <span class="text-danger">*</span></label>
                    <select class="form-control" name="major_id" id="exampleSelect1">
                        <option value="1">Teknik Komputer dan Jaringan</option>
                        <option value="2">Animasi</option>
                        <option value="3">Pemasaran</option>
                        <option value="4">Perbankan</option>
                        <option value="5">Teknik Sepeda Motor</option>
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
