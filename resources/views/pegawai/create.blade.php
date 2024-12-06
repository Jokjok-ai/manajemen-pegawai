@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Pegawai</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data" id="tambahForm">
            @csrf
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Software Engineer" {{ old('jabatan') == 'Software Engineer' ? 'selected' : '' }}>Software Engineer</option>
                    <option value="System Analyst" {{ old('jabatan') == 'System Analyst' ? 'selected' : '' }}>System Analyst</option>
                    <option value="IT Support" {{ old('jabatan') == 'IT Support' ? 'selected' : '' }}>IT Support</option>
                    <option value="Admin HR" {{ old('jabatan') == 'Admin HR' ? 'selected' : '' }}>Admin HR</option>
                    <option value="Admin Keuangan" {{ old('jabatan') == 'Admin Keuangan' ? 'selected' : '' }}>Admin Keuangan</option>
                </select>
                @error('jabatan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tanggal_bergabung">Tanggal Bergabung</label>
                <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror" id="tanggal_bergabung" name="tanggal_bergabung" value="{{ old('tanggal_bergabung') }}" required>
                @error('tanggal_bergabung')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="gaji">Gaji</label>
                <input type="number" class="form-control @error('gaji') is-invalid @enderror" id="gaji" name="gaji" value="{{ old('gaji') }}" required>
                @error('gaji')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label class="form-label text-muted opacity-75 fw-medium" for="formImage">Image</label>
                <div id="dropzone" class="dropzone">
                    <span>Drag file here to upload</span>
                </div>
                <input type="file" name="foto" id="fileInput" style="display: none;" accept="image/*">
                <div id="fileName" class="mt-2"></div>
                <div class="invalid-feedback fw-bold">Please upload an image.</div>
            </div>
            
            <button type="submit" class="btn btn-success">Simpan</button>
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
            timer: 1500 // Durasi notifikasi (dalam milidetik)
        }).then(() => {
            setTimeout(function() {
                window.location.href = "{{ route('pegawai.index') }}"; // Pindah ke halaman setelah timer
            }, 1500); // Delay yang sama dengan timer notifikasi
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2 pada elemen dengan ID 'jabatan'
        $('#jabatan').select2({
            placeholder: 'Pilih Jabatan',
            allowClear: true
        });
    });
</script>

<script>
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
        $('#tambahForm').submit(function(e) {
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
    
</script>
@endpush
