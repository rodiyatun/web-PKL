<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama/NISN</th>
            <th scope="col">Tipe Presensi</th>
            <th scope="col">Jam Presensi</th>


        </tr>
    </thead>
    <tbody>
        @forelse ($data as $key => $row)

            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $row->name.' ('.$row->nisn.')' }}</td>
                <td>{{ "Clock ". Str::ucfirst($row->type) }}</td>
                <td>{{ date('d-F-Y H:i:s', strtotime($row->created_at)) }}</td>
            </tr>
        @empty
            <tr>
                <td>Data Tidak Ditemukan</td>
            </tr>
        @endforelse

    </tbody>
</table>
