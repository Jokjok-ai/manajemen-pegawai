<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    // Menampilkan daftar pegawai
    public function index()
    {
        $pegawais = Pegawai::all(); // Mengambil semua data pegawai
        return view('pegawai.index', compact('pegawais')); // Menampilkan ke view 'pegawai.index'
    }

    // Menampilkan form untuk menambah pegawai
    public function create()
    {
        return view('pegawai.create'); // Menampilkan view form tambah pegawai
    }

    // Menyimpan data pegawai baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email',
            'tanggal_bergabung' => 'required|date',
            'alamat' => 'required|string',
            'gaji' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        try {
            // Menyimpan data pegawai ke database
            $pegawai = new Pegawai();
            $pegawai->nama = $request->nama;
            $pegawai->jabatan = $request->jabatan;
            $pegawai->email = $request->email;
            $pegawai->tanggal_bergabung = $request->tanggal_bergabung;
            $pegawai->alamat = $request->alamat;
            $pegawai->gaji = $request->gaji;
    
            // Menyimpan foto hanya jika ada file yang diunggah
            if ($request->hasFile('foto')) {
                $pegawai->foto = $request->file('foto')->store('images', 'public');
            } else {
                $pegawai->foto = null; // Atau bisa menggunakan foto default
            }
            
    
            $pegawai->status = 'aktif'; // Status default
            $pegawai->save();
    
            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    

    // Menampilkan detail pegawai
    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    // Menampilkan form edit pegawai
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:12288', // Maksimal 12MB
    ]);

    try {
        // Simpan file di folder public/images
        $path = $request->file('file')->store('images', 'public');

        return response()->json(['success' => 'Image uploaded successfully.', 'path' => $path], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to upload image. ' . $e->getMessage()], 500);
    }
}

    // Memperbarui data pegawai
    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'jabatan' => 'required|string|max:255',
        'email' => 'required|email|unique:pegawai,email,' . $id,
        'tanggal_bergabung' => 'required|date',
        'alamat' => 'required|string',
        'gaji' => 'required|numeric|min:0',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // foto opsional
        'status' => 'required|string',
        
    ]);

    try {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->nama = $request->nama;
        $pegawai->jabatan = $request->jabatan;
        $pegawai->email = $request->email;
        $pegawai->tanggal_bergabung = $request->tanggal_bergabung;
        $pegawai->alamat = $request->alamat;
        $pegawai->gaji = $request->gaji;
        $pegawai->status = $request->status;
        

        // Proses foto hanya jika ada foto baru yang diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pegawai->foto && Storage::exists($pegawai->foto)) {
                Storage::delete($pegawai->foto); // Menghapus foto lama
            }
            // Simpan foto baru
            $pegawai->foto = $request->file('foto')->store('images', 'public');
        }

        $pegawai->save(); // Simpan perubahan

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}


    // Menghapus data pegawai
    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);

            // Hapus foto dari storage
            if ($pegawai->foto && Storage::exists($pegawai->foto)) {
                Storage::delete($pegawai->foto);
            }

            $pegawai->delete(); // Menghapus data pegawai
            return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Mengubah status pegawai (aktif/tidak aktif)
    public function changeStatus($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->status = $pegawai->status === 'aktif' ? 'tidak aktif' : 'aktif';
            $pegawai->save();

            return redirect()->route('pegawai.index')->with('success', 'Status pegawai berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
