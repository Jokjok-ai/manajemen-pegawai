<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('email')->unique();
            $table->date('tanggal_bergabung');
            $table->integer('gaji')->default(0);;
            $table->text('alamat');
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
}
