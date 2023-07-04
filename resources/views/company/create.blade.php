@extends('base')

@section('title', 'Create Student')
@section('du_di', 'menu-item-open')
@section('create_du_di', 'menu-item-active')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.notifications')
        </div>
    </div>
    <div class="card card-custom col-md-8">
        <div class="card-header">
            <h3 class="card-title">
                Membuat Data DU/DI Baru
            </h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">
                    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
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
                    <input type="text" class="form-control" name="name" placeholder="E.g : Muhammad Fulan" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap owner DU/DI.</span>
                </div>
                <div class="form-group">
                    <label>Nama Perusahaan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="company_name" placeholder="E.g : PT Indocomp Nusantara" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap DU/DI.</span>
                </div>

                <div class="form-group">
                    <label>Email address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" placeholder="E.g : Email@example.coms" />
                    <span class="form-text text-muted">Isilah sesuai dengan email DU/DI(email ini digunakan untuk login)
                    </span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                        placeholder="Password" />
                </div>
                <div class="form-group">
                    <label>Alamat Perusahaan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="company_address" placeholder="E.g : PT Indocomp Nusantara" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap DU/DI.</span>
                </div>
                <div class="form-group">
                    <label>P.I.C<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="pic" placeholder="E.g : Muhammad Fulan" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap owner DU/DI.</span>
                </div>
                <div class="form-group">
                    <label>Email P.I.C<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="pic_email" placeholder="E.g : email@example.com" />
                    <span class="form-text text-muted">Isilah sesuai dengan nama lengkap owner DU/DI.</span>
                </div>

                <div class="form-group">
                    <label>Phone P.I.C<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="pic_phone" placeholder="E.g : 0812345678" />
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
