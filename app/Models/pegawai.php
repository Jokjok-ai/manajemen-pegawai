<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    // Jika tabel Anda memiliki nama khusus, tambahkan properti ini:
    protected $table = 'pegawai';

    // Tambahkan kolom yang bisa diisi (fillable) jika diperlukan
    protected $fillable = [
        'nama',
        'jabatan',
        'email',
        'tanggal_bergabung',
        'gaji',
        'alamat',
        'foto',
        'status',
    ];
}
