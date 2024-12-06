<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('pegawai')->insert([
                'nama' => $faker->name,
                'jabatan' => $faker->randomElement(['Manager', 'Staff HR', 'Supervisor', 'Staff IT', 'Marketing']),
                'email' => $faker->unique()->safeEmail,
                'tanggal_bergabung' => $faker->date,
                'gaji' => $faker->numberBetween(5000000, 20000000),
                'alamat' => $faker->address,
                'foto' => null,
                'status' => $faker->randomElement(['aktif', 'tidak aktif']),
            ]);
        }
    }
}
