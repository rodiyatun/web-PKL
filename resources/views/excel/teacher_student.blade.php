<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NISN</th>
            <th scope="col">Nama</th>
            <th scope="col">Email</th>


        </tr>
    </thead>
    <tbody>
        @forelse ($data['practice_place']['student'] as $key => $row)
        @if(!empty($row['student']) && !empty($row['student']['user']))
            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $row->student->nisn }}</td>
                <td>{{ $row->student->user->name }}</td>

                <td>{{ $row->student->user->email }}</td>


            </tr>
            @endif
        @empty
            <tr>
                <td>Data Tidak Ditemukan</td>
            </tr>
        @endforelse

    </tbody>
</table>
