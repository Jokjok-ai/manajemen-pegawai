@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-column align-items-center">
    <!-- Menempatkan teks di tengah atas -->
    <h3 class="m-0 font-weight-bold text-primary">Daftar Pegawai</h3>
    <!-- Menempatkan tombol di bawah teks, di sisi kanan -->
    <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm mt-2 align-self-start">Tambah Pegawai</a>
</div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>Tanggal Bergabung</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>Tanggal Bergabung</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($pegawais as $pegawai)
                        <tr>
                            <td>
                            @if ($pegawai->foto)
                                <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai" width="50" height="50" class="rounded-circle">
                            @else
                            <img src="{{ asset('storage/' . ($pegawai->foto ?? 'images/default.jpg')) }}" alt="Foto Pegawai" width="50" height="50">
                            @endif
                            </td>

                            <td>{{ $pegawai->nama }}</td>
                            <td>{{ $pegawai->jabatan }}</td>
                            <td>{{ $pegawai->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($pegawai->tanggal_bergabung)->format('d-m-Y') }}</td>
                            <td>{{ $pegawai->status }}</td>
                            <td>
                                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
