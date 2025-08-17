<?php

namespace Database\Seeders;

use App\Models\AnalisisTanah;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@agrobalangan.com',
            'password' => bcrypt(12345678)
        ]);

        User::factory()->create([
            'name' => 'DKPPP Kabupaten Balangan',
            'username' => 'dkppp',
            'email' => 'dkppp@agrobalangan.com',
            'password' => bcrypt('balangan')
        ]);

        $this->call(KecamatanSeeder::class);
        $this->call(LokasiAgropolitanSeeder::class);
        $this->call(KepemilikanLahanBatumandiSeeder::class);
        $this->call(KepemilikanLahanHalongSeeder::class);
        $this->call(KepemilikanLahanLampihongSeeder::class);
        $this->call(KepemilikanLahanParinginSeeder::class);
        $this->call(KepemilikanLahanParinginSelatanSeeder::class);
        $this->call(KepemilikanLahanAwayanSeeder::class);
        $this->call(AnalisisTanahSeeder::class);
    }
}
