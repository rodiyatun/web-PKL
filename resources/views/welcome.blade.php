@extends("base")

@section('title', 'welcome')

@section('content')

            @role('Admin')
            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 4-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-light-success p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 35% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-5.svg)">
                                    <p class="text-success pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Total Siswa Terdaftar
                                    <br>
                                    <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data1 }}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 4-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 5-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-info p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: right bottom; background-size: 55% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-6.svg)">
                                    <p class="text-inverse-info pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Total Guru Terdaftar
                                        <br>
                                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data2 }}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 5-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 6-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-danger p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 35% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-7.svg)">
                                    <p class="text-inverse-info pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Total DU/DI Terdaftar
                                        <br>
                                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data3}}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 6-->
                    </div>
                </div>
            </div>
            @endrole
            @role('student')

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @include('layouts.notifications')
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 4-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-light-success p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 35% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-5.svg)">
                                    <p class="text-success pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Jurnal Siswa
                                    <br>
                                    <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data1 }}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 4-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 5-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-info p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: right bottom; background-size: 55% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-6.svg)">
                                    <p class="text-inverse-info pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Jurnal Guru
                                        <br>
                                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data2 }}</h2>
                                        <br>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 5-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 6-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-danger p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 35% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-7.svg)">
                                    <p class="text-inverse-info pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Absensi Hari Ini
                                        <br>
                                        @forelse ($data3 as $value)

                                        <table class="table table-borderless">

                                            <tr>
                                                <td style="font-size: 20px">Clock {{ $value['type'] }}</td>
                                                <td style="font-size: 20px">: {{ date('H:i:s', strtotime($value['created_at'])) }}</td>
                                            </tr>

                                        </table>
                                        @empty
                                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">Tidak Ada Data</h2>

                                        @endforelse
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 6-->
                    </div>
                </div>
            </div>

            @endrole
            @role('company')
            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 4-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-light-success p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 35% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-5.svg)">
                                    <p class="text-success pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Siswa Praktik
                                    <br>
                                    <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data1 }}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 4-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 5-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-info p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: right bottom; background-size: 55% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-6.svg)">
                                    <p class="text-inverse-info pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Jurnal Siswa
                                        <br>
                                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data2 }}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 5-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 6-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-danger p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 35% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-7.svg)">
                                    <p class="text-inverse-info pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Jurnal Guru
                                        <br>
                                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data3}}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 6-->
                    </div>
                </div>
            </div>
            @endrole
            @role('teacher')
            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 4-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-light-success p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 35% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-5.svg)">
                                    <p class="text-success pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Siswa Dibimbing
                                    <br>
                                    <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data1 }}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 4-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 5-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-info p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: right bottom; background-size: 55% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-6.svg)">
                                    <p class="text-inverse-info pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah Jurnal
                                        <br>
                                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data2 }}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 5-->
                    </div>
                    <div class="col-xl-4">
                        <!--begin::Engage Widget 6-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body d-flex p-0">
                                <div class="flex-grow-1 bg-danger p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 35% auto; background-image: url(/metronic/theme/html/demo1/dist/assets/media/svg/humans/custom-7.svg)">
                                    <p class="text-inverse-info pt-10 pb-5 font-size-h3 font-weight-bolder line-height-lg">Jumlah DU/DI
                                        <br>
                                        <h2 class="font-weight-bolder text-dark mb-7" style="font-size: 32px;">{{ $data3}}</h2>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 6-->
                    </div>
                </div>
            </div>
            @endrole
@endsection
