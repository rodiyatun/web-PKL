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
                Edit Profile
            </h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">
                    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form method="POST" action="{{ route('update.profile') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body col-md-10">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
                        <div class="alert-text">
                            Isilah data profile dengan baik dan benar
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $data['name'] }}" disabled placeholder="E.g : Muhammad Fulan" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap guru.</span>
                </div>

                <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" disabled value="{{ $data['email'] }}" placeholder="E.g : Email@example.coms" />
                    <span class="form-text text-muted">Isilah sesuai dengan email murid(email ini digunakan untuk login)
                    </span>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                        placeholder="Kosongkan Jika Tidak mengupdate Password" />
                        <span>Kosongkan Jika Tidak mengupdate Password</span>
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
