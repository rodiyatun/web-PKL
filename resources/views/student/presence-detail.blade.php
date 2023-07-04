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
                Detail Presence Clock {{ $data['type'] }} Pada {{ date('d F Y H:i:s',strtotime($data['created_at'])) }}
            </h3>

        </div>

        <!--begin::Form-->
        <div class="card-body">

            <table class="table no-border">
                <tr>
                    <td>Nama</td>
                    <td> : {{ \Auth::user()->user_type == 2 ? $data['student']['user']['name'] : $data['name'] }}</td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td>: {{ \Auth::user()->user_type == 2 ? $data['student']['nisn'] : $data['nisn'] }}</td>
                </tr>
                <tr>
                    <td>Tanggal/Waktu</td>
                    <td>: {{ date('d F Y H:i:s',strtotime($data['created_at']))  }}</td>
                </tr>
                <tr>
                    <td>Longitude & Latitude</td>
                    <td>: {{ $data['longitude']. ' | '. $data['latitude'] }}</td>
                </tr>
                <tr>
                    <td>Region</td>
                    <td>: {{ $data['region'] }}</td>
                </tr>
                <tr>
                    <td>IP Address</td>
                    <td>: {{ $data['ip_address'] }}</td>
                </tr>
                <tr>
                    <td>User Agent</td>
                    <td>: {{ $data['user_agent'] }}</td>
                </tr>
            </table>
            <img src="{{ env('URL_STORAGE').$data['image_presence'] }}" alt="masuk">


        </div>
        <!--end::Form-->
    </div>
@endsection
