<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NISN</th>
            <th scope="col">Nama</th>
            <th scope="col">Penilaian</th>
            <th scope="col">Nilai Perusahaan</th>
            <th scope="col">Nilai Guru</th>
            <th scope="col">Akumulasi</th>


        </tr>
    </thead>
    <tbody>
        @forelse ($data['practice_place']['student'] as $key => $row)
        @if(!empty($row['student']) && !empty($row['student']['user']) && count($row['student']['student_assesment']) > 0)
            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $row->student->nisn }}</td>
                <td>{{ $row->student->user->name }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

               @foreach ($row['student']['student_assesment'] as $item)
                   <tr>
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td>{{ $item['assessment'] }}</td>
                    <td>{{ $item['company_score'] }}</td>
                    <td>{{ $item['teacher_score'] }}</td>
                    <td>{{ ($item['company_score'] + $item['teacher_score']) / 2 }}</td>
                   </tr>
               @endforeach

        @endif
        @empty
            <tr>
                <td>Data Tidak Ditemukan</td>
            </tr>
        @endforelse

    </tbody>
</table>
