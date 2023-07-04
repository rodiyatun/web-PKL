<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/certificate.css') }}" />
    <title>Certificate</title>
</head>

<body background="{{ asset('img/blockchain.png') }}">
    <main border="1px">
        <div id="bgdiv">
            <img width="150" src="{{ asset('img/komputama-logo.png') }}" alt="cert_logo" />
            <div class="top">
                <h1 class="cursive"><strong>CERTIFICATE OF COMPLETION</strong></h1>
            </div>

            <div>
                <p id="csize" class="cursive">This Certificate is Presented To</p>
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
                    <tr>
                        <th>{{ date('d') }}<sup>th</sup> {{ date('F Y') }}</th>
                        <th>
                            <img width="200" height="50" src="{{ asset('img/signature.png') }}" alt="" />
                        </th>
                    </tr>
                    <tr>
                        <td><em>Date</em></td>
                        <td><em>Signature</em></td>
                    </tr>
                </table>
            </div>
        </div>
        <table>
            <caption>Daftar Nilai Hasil Pelaksanaan Praktik Kerja Lapangan</caption>
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Aspek Yang Dinilai</th>
                    <th scope="col">Nilai </th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_nilai as $key => $val)
                @foreach($val['assessment'] as $k => $v)
                @php
                    $nilai = ($v['company_score'] + $v['teacher_score'])/2;
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td data-label="Due Date">{{ $v['assessment'] }}</td>
                    <td data-label="Amount">{{ $nilai }}</td>
                    <td data-label="Period">{{ ($nilai >= 90) ? 'A' : (($nilai >= 80) ? 'B' : "C") }}</td>
                </tr>
                @endforeach
                @endforeach

            </tbody>
        </table>
    </main>
</body>

</html>
