<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/certificate2.css') }}" />
    <title>Certificate</title>
</head>

<body>
    <main>
        <div class="page">
            <div id="bgdiv">
                <img width="120px" src="{{ asset('img/logo.png') }}" alt="cert_logo" />
                <div class="top">
                    <h1 class="cursive"><strong>CERTIFICATE OF COMPLETION</strong></h1>
                </div>

                <div>
                    <p id="csize" class="cursive" style="margin-top: 2px">This Certificate is Presented To</p>
                    <h1 id="size">{{ $data['user']['name'] }}</h1>
                    <hr width="800px" />
                    <p id="csize" class="cursive">
                        Sudah Menyelesaikan PKL pada Perusahaan <strong
                            id="color">{{ $data['student_du']['practice_place']['name'] }}</strong> Selama 8 Minggu
                    </p>

                    <p id="resize" class="underline"></p>
                </div>

                <div class="bottom">
                    <table width="100%">
                        <tr class="tr-table">
                            <th class="td1">{{ date('d') }}<sup>th</sup> {{ date('F Y') }}</th>
                            <th class="td1">
                                <img width="200" height="50" src="{{ asset('img/signature.png') }}"
                                    alt="" />
                            </th>
                        </tr>
                        <tr class="tr-table">
                            <td class="td1"><em>Date</em></td>
                            <td class="td1"><em>Signature</em></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="page-break" style="page-break-after: always"></div>
        <div>

            <h3 style = "text-align:center">
                Daftar Nilai Hasil Pelaksanaan Praktik Kerja Lapangan
            </h3>

            <div class="row" style="margin-bottom: 20px">
                <table class="table2" style="margin-left: auto;margin-right:auto;text-align:left">
                    <tr style="margin-bottom:2px">
                        <td style="border: none"><strong>Nama Perusahaan</strong></td>
                        <td>:<strong> {{ $data['student_du']['practice_place']['name'] }}</strong></td>
                    </tr>
                    <tr>
                        <td style="border: none"><strong>Alamat Perusahaan</strong></td>
                        <td>:<strong> {{ (!empty($data['student_du']['practice_place']['address'])) ? $data['student_du']['practice_place']['address'] : '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="border: none"><strong>Nama Siswa</strong></td>
                        <td>:<strong> {{ $data['user']['name'] }}</strong></td>
                    </tr>
                    <tr>
                        <td style="border: none"><strong>NISN</strong></td>
                        <td>:<strong> {{ $data['nisn'] }}</strong></td>
                    </tr>
                </table>
            </div>
                <table class="table1">
                <thead>
                    <tr>
                        <th scope="col" class="td2">No</th>
                        <th scope="col" class="td2">Aspek Yang Dinilai</th>
                        <th scope="col" class="td2">Nilai </th>
                        <th scope="col" class="td2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_nilai as $key => $val)
                        @foreach ($val['assessment'] as $k => $v)
                            @php
                                $nilai = ($v['company_score'] + $v['teacher_score']) / 2;
                            @endphp
                            <tr class="tr-table">
                                <td class="td2">{{ $key + 1 }}</td>
                                <td data-label="Due Date" class="td2">{{ $v['assessment'] }}</td>
                                <td data-label="Amount" class="td2">{{ $nilai }}</td>
                                <td data-label="Period" class="td2">{{ $nilai >= 90 ? 'A' : ($nilai >= 80 ? 'B' : 'C') }}</td>
                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="bottom">
            <table class="table1" width="100%">
                <tr class="tr-table">
                    <th class="td2">{{ date('d') }}<sup>th</sup> {{ date('F Y') }}</th>
                    <th class="td2">
                        <img width="200" height="50" src="{{ asset('img/signature.png') }}"
                            alt="" />
                    </th>
                </tr>
                <tr class="tr-table">
                    <td class="td2"><em>Date</em></td>
                    <td class="td2"><em>Signature</em></td>
                </tr>
            </table>
        </div>
    </main>
</body>

</html>
