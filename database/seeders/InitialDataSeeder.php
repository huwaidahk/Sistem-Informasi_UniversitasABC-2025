<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |----------------------------------
        | 1. USERS
        |----------------------------------
        */
        $rafif = User::firstOrCreate(
            ['email' => 'rafif@universitasabc.ac.id'],
            [
                'name' => 'Rafif',
                'password' => Hash::make('123123123'),
                'role' => 'administrator',
            ]
        );

        $mayla = User::firstOrCreate(
            ['email' => 'mayla@universitasabc.ac.id'],
            [
                'name' => 'Nur Mayla',
                'password' => Hash::make('123123123'),
                'role' => 'administrator',
            ]
        );

        $huwaidah = User::firstOrCreate(
            ['email' => 'huwaidah@universitasabc.ac.id'],
            [
                'name' => 'Huwaidah',
                'password' => Hash::make('123123123'),
                'role' => 'tendik',
            ]
        );

        $nanda = User::firstOrCreate(
            ['email' => 'nanda@universitasabc.ac.id'],
            [
                'name' => 'Tri Nanda',
                'password' => Hash::make('123123123'),
                'role' => 'tendik',
            ]
        );

        /*
        |----------------------------------
        | 2. DOSEN (TANGGAL SESUAI SS)
        |----------------------------------
        */
        $dosens = [
            ['nidn'=>'0012345678','nama'=>'Aurora Sofia','user'=>$nanda,'tgl'=>'2025-11-30'],
            ['nidn'=>'0012345679','nama'=>'Clarissa Yunita','user'=>$rafif,'tgl'=>'2025-11-28'],
            ['nidn'=>'0012345670','nama'=>'Elvano Adijaya','user'=>$rafif,'tgl'=>'2025-11-28'],
            ['nidn'=>'0012345671','nama'=>'Felicia Evaliona','user'=>$rafif,'tgl'=>'2025-11-28'],
            ['nidn'=>'0012345672','nama'=>'Kenzo Alvaro','user'=>$rafif,'tgl'=>'2025-11-28'],
            ['nidn'=>'1234567890','nama'=>'Mayla','user'=>$huwaidah,'tgl'=>'2025-12-09'],
            ['nidn'=>'0012345673','nama'=>'Natasha Aleona','user'=>$rafif,'tgl'=>'2025-11-28'],
            ['nidn'=>'0012345674','nama'=>'Sean Abraham','user'=>$huwaidah,'tgl'=>'2025-11-28'],
        ];

        $dosenModel = [];
        foreach ($dosens as $d) {
            $dosenModel[$d['nidn']] = Dosen::firstOrCreate(
                ['nidn' => $d['nidn']],
                [
                    'nama_dosen' => $d['nama'],
                    'user_id' => $d['user']->id,
                    'created_at' => Carbon::parse($d['tgl']),
                ]
            );
        }

        /*
        |----------------------------------
        | 3. MATA KULIAH (TANGGAL SESUAI SS)
        |----------------------------------
        */
        $matkuls = [
            ['kode'=>'ED033','nama'=>'Elektronika Digital','sks'=>3,'user'=>$nanda,'tgl'=>'2025-11-30'],
            ['kode'=>'JK022','nama'=>'Jaringan Komputer','sks'=>3,'user'=>$mayla,'tgl'=>'2025-11-28'],
            ['kode'=>'K0003','nama'=>'Kalkulus','sks'=>3,'user'=>$rafif,'tgl'=>'2025-11-28'],
            ['kode'=>'M0023','nama'=>'Matematika','sks'=>2,'user'=>$mayla,'tgl'=>'2025-12-02'],
            ['kode'=>'MN123','nama'=>'Metode Numerik','sks'=>3,'user'=>$mayla,'tgl'=>'2025-11-28'],
            ['kode'=>'OA456','nama'=>'Organisasi dan Arsitektur Komputer','sks'=>2,'user'=>$huwaidah,'tgl'=>'2025-12-08'],
            ['kode'=>'PB011','nama'=>'Pemrograman Berorientasi Objek','sks'=>3,'user'=>$huwaidah,'tgl'=>'2025-11-28'],
            ['kode'=>'SB001','nama'=>'Sistem Basis Data','sks'=>3,'user'=>$rafif,'tgl'=>'2025-11-28'],
        ];

        $mkModel = [];
        foreach ($matkuls as $m) {
            $mkModel[$m['kode']] = MataKuliah::firstOrCreate(
                ['kode_matkul'=>$m['kode']],
                [
                    'nama_matkul'=>$m['nama'],
                    'sks'=>$m['sks'],
                    'user_id'=>$m['user']->id,
                    'created_at'=>Carbon::parse($m['tgl']),
                ]
            );
        }

        /*
        |----------------------------------
        | 4. RELASI DOSEN ↔ MATA KULIAH
        |----------------------------------
        */
        $dosenModel['0012345678']->mataKuliahs()->sync([$mkModel['ED033']->id]);
        $dosenModel['0012345679']->mataKuliahs()->sync([$mkModel['SB001']->id]);
        $dosenModel['0012345670']->mataKuliahs()->sync([$mkModel['ED033']->id]);
        $dosenModel['0012345671']->mataKuliahs()->sync([$mkModel['K0003']->id,$mkModel['OA456']->id]);
        $dosenModel['0012345672']->mataKuliahs()->sync([$mkModel['MN123']->id,$mkModel['M0023']->id]);
        $dosenModel['1234567890']->mataKuliahs()->sync([$mkModel['JK022']->id,$mkModel['K0003']->id,$mkModel['M0023']->id]);
        $dosenModel['0012345673']->mataKuliahs()->sync([$mkModel['JK022']->id]);
        $dosenModel['0012345674']->mataKuliahs()->sync([$mkModel['PB011']->id]);
    }
}
