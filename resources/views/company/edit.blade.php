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
        <form method="POST" action="{{ route('company.update', $data['id']) }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body col-md-10">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
                        <div class="alert-text">
                            Isilah data DU/DI dengan baik dan benar
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap Owner<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $data['user']['name'] }}" placeholder="E.g : Muhammad Fulan" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap owner DU/DI.</span>
                </div>
                <div class="form-group">
                    <label>Nama Perusahaan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="company_name" value="{{ $data['name'] }}" placeholder="E.g : PT Indocomp Nusantara" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap DU/DI.</span>
                </div>

                <div class="form-group">
                    <label>Email address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="company_email" value="{{ $data['user']['email'] }}" placeholder="E.g : Email@example.coms" />
                    <span class="form-text text-muted">Isilah sesuai dengan email murid(email ini digunakan untuk login)
                    </span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak mengganti password" id="exampleInputPassword1"
                        placeholder="Password" />
                </div>
                <div class="form-group">
                    <label>Alamat Perusahaan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="company_address" value="{{ $data['address'] }}" placeholder="E.g : PT Indocomp Nusantara" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap DU/DI.</span>
                </div>
                <div class="form-group">
                    <label>P.I.C<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="pic" value="{{ $data['pic'] }}" placeholder="E.g : Muhammad Fulan" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap owner DU/DI.</span>
                </div>
                <div class="form-group">
                    <label>Email P.I.C<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="pic_email" value={{ $data['email'] }} placeholder="E.g : email@example.com" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap owner DU/DI.</span>
                </div>

                <div class="form-group">
                    <label>Phone P.I.C<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="pic_phone" value="{{ $data['phone'] }}" name="pic_phone" placeholder="E.g : 0812345678" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap owner DU/DI.</span>
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
