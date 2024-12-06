@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Pegawai</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $pegawai->nama) }}" required>
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $pegawai->jabatan) }}" required>
                @error('jabatan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $pegawai->email) }}" required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_bergabung">Tanggal Bergabung</label>
                <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" class="form-control @error('tanggal_bergabung') is-invalid @enderror" value="{{ old('tanggal_bergabung', $pegawai->tanggal_bergabung) }}" required>
                @error('tanggal_bergabung')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $pegawai->alamat) }}</textarea>
                @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="gaji">Gaji</label>
                <input type="number" name="gaji" id="gaji" class="form-control @error('gaji') is-invalid @enderror" value="{{ old('gaji', $pegawai->gaji) }}" required>
                @error('gaji')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="Aktif" {{ old('status', $pegawai->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ old('status', $pegawai->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="form-label text-muted opacity-75 fw-medium" for="formImage">Foto</label>
                <div id="dropzone" class="dropzone">
                    <span>Drag file here to upload</span>
                </div>
                <input type="file" name="foto" id="fileInput" style="display: none;" accept="image/*">
                <div id="fileName" class="mt-2">
                    @if($pegawai->foto)
                        File selected: {{ basename($pegawai->foto) }}
                    @endif
                </div>
                <div class="invalid-feedback fw-bold">Please upload an image.</div>
            </div>

            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan Perubahan</button>
            <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = "{{ route('pegawai.index') }}";
        });
    </script>
@endif

@endsection

@push('styles')
    <style>
        #dropzone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            color: #888;
            font-size: 16px;
        }

        #dropzone:hover {
            border-color: #4caf50;
        }

        #dropzone span {
            display: inline-block;
            font-weight: bold;
        }

        #fileName {
            font-size: 14px;
            color: #333;
            margin-top: 10px;
        }
    </style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi Dropzone
        document.getElementById('dropzone').addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.border = '2px dashed #4caf50';
        });

        document.getElementById('dropzone').addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.border = '2px dashed #ccc';
        });

        document.getElementById('dropzone').addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.border = '2px dashed #ccc';

            let file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('fileInput').files = e.dataTransfer.files;
                document.getElementById('fileName').innerText = 'File selected: ' + file.name;
            } else {
                document.getElementById('fileName').innerText = 'Please select a valid image file.';
            }
        });

        document.getElementById('dropzone').addEventListener('click', function() {
            document.getElementById('fileInput').click();
        });

        document.getElementById('fileInput').addEventListener('change', function() {
            let file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('fileName').innerText = 'File selected: ' + file.name;
            } else {
                document.getElementById('fileName').innerText = 'Please select a valid image file.';
            }
        });

        // Handling form submission with SweetAlert2 for notification
        $('#editForm').submit(function(e) {
            e.preventDefault();  // Prevent the form from submitting immediately

            Swal.fire({
                title: 'Perubahan disimpan!',
                text: 'Data pegawai berhasil diperbarui.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Submit the form after the notification
                this.submit();
            });
        });
    });
</script>
@endpush
