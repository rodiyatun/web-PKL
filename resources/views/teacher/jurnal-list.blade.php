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
            @if(!empty($data_student['id']))
            @role('teacher')
            <div class="card-toolbar">
                <a href="{{ route('teacher.jurnal.create', $data_student['id']) }}"  class="btn btn-sm mr-1 btn-success font-weight-bold">
                <i class="flaticon2-send-1"></i>Buat Jurnal</a>

            </div>

            @endrole
            @else
            <div class="card-toolbar">
                <a href="?export=true" class="btn btn-sm btn-primary">Export Data</a>
            </div>
            @endif


        </div>

        <!--begin::Form-->
        <div class="card-body">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NISN</th>
                        <th scope="col">Judul</th>
                        @role('student')
                        <th scope="col">Guru Pembimbing</th>
                        @endrole
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            @hasanyrole('student|teacher')
                            <td>{{ $row->student->user->name }}</td>
                            <td>{{ $row->student->nisn }}</td>
                            @endhasanyrole
                            @role('company')
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->nisn }}</td>
                            @endrole
                            <td>{{ $row->title }}</td>
                            @role('student')
                            <td>{{ $row->teacher->user->name }}</td>
                            @endrole
                            <td>{{ date('d F Y', strtotime($row->created_at)) }}</td>
                            <td>
                                <a href="{{ route('teacher.jurnal.student.detail', $row->id) }}"
                                    class="btn btn-sm btn-info">Detail</a>
                                @role('teacher')
                                <a href="{{ route('teacher.jurnal.edit', $row->id) }}"
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

