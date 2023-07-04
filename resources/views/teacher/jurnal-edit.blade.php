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
                Membuat data jurnal baru
            </h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">
                    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form method="POST" action="{{ route('teacher.jurnal.update', $data['id']) }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body col-md-10">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
                        <div class="alert-text">
                            Isilah Jurnal dengan baik dan benar, Jurnal akan tidak bisa dihapus dan diedit jika sudah berbeda hari
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Murid <span class="text-danger">*</span></label>
                    <select name="student_id" id="" class="form-control">
                        @foreach ($student as $item)
                            <option {{ $data['student_id'] == $item['id'] ? 'selected' : '' }} value="{{ $item['id'] }}">{{ $item['nisn'].'-'.$item['name'] }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label>Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title" value="{{ $data['title'] }}" placeholder="E.g : Kegiatan Hari Senin" />
                    <span class="form-text text-muted">Isilah sesuai dengan judul jurnal.</span>
                </div>
                <div class="form-group">
                    <label>Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="description" id="" class="form-control" placeholder="E.g : Kegiatan hari ini melakukan install ulang windows" cols="30" rows="10">{{ $data['description'] }}</textarea>
                    <span class="form-text text-muted">Isilah sesuai dengan deskripsi jurnal.</span>
                </div>
                @if(!empty($data['image']))
                <div class="col-md-6">
                    <img src="{{ env('URL_STORAGE').$data['image'] }}" alt="" width="200px">
                </div>
                @endif
                <br>
                <div class="form-group">
                    <label>Dokumentasi (Silahkan Upload Ulang Jika akan merevisi Gambar)</label>
                    <div></div>
                    <div class="custom-file">
                        <input type="file" name="jurnal_image" class="custom-file-input" id="customFile" />
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
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
