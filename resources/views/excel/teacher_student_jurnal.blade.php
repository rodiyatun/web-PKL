<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Judul</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Dibuat Pada</th>


        </tr>
    </thead>
    <tbody>
        @forelse ($data as $key => $row)

            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ $row->title }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td>Data Tidak Ditemukan</td>
            </tr>
        @endforelse

    </tbody>
</table>
