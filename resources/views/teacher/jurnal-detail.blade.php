@extends('base')

@section('title', 'List Student')
@section('du_di', 'menu-item-open')
@section('list_du_di', 'menu-item-active')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.notifications')
        </div>
    </div>
    <div class="card card-custom col-md-10">
        <div class="card-header">
            <h3 class="card-title">
                Jurnal Detail {{ $data['title'] }}
            </h3>

        </div>

        <!--begin::Form-->
        <div class="card-body">

            <table class="table table-borderless">
                @role('teacher')
                <tr>
                    <td>Nama</td>
                    <td>: {{ $data['student']['user']['name'] }}</td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td>: {{ $data['student']['nisn'] }}</td>
                </tr>
                @endrole
                @role('company')
                <tr>
                <td>Nama</td>
                    <td>: {{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td>: {{ $data['nisn'] }}</td>
                </tr>

                @endrole
                @role('student')
                <tr>
                    <td>Guru Pembimbing</td>
                    <td>: {{ $data['teacher']['user']['name'] }}</td>
                </tr>
                @endrole
                <tr>
                    <td>Title</td>
                    <td>: {{ $data['title'] }}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>: {{ $data['description'] }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ date('d F Y H:i:s', strtotime( $data['created_at'])) }}</td>
                </tr>
                @if (!empty($data['image']))
                    <td>Dokumentasi</td>
                    <td>: <img src="{{ env('URL_STORAGE').$data['image'] }}" width="500px" alt=""></td>
                @endif
            </table>

        </div>
        <!--end::Form-->
    </div>
@endsection
