<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $data = [
            'users' => User::all()
        ];

        return view('app', $data);
    }

    public function store(Request $request)
    {
        // validasi input
        $request->validate([
            'data_pengguna' => 'required'
        ], [
            'data_pengguna.required' => 'Data Pengguna Wajib Diisi'
        ]);

        // ubah input menjadi huruf kapital semua
        $input = strtoupper($request->data_pengguna);

        // pecah input berdasarkan spasi
        $inputParts = explode(' ', $input);

        // cari index umur, jika tidak ditemukan maka index umur = -1
        $ageIndex = -1;
        for ($i = 0; $i < count($inputParts); $i++) {
            // periksa apakah elemen saat ini berupa angka atau berisi indikator usia (TAHUN, THN, TH)
            if (is_numeric($inputParts[$i]) || preg_match('/\d+(TAHUN|THN|TH)/i', $inputParts[$i])) {
                $ageIndex = $i;
                break;
            }
        }

        // ekstrak usia dari array dan hapus indikator usia (TAHUN, THN, TH)
        $age = $inputParts[$ageIndex];
        $age = trim(preg_replace('/(TAHUN|THN|TH)/i', '', $age));

        // ubah elemen array usia dengan usia yang sudah di ekstrak
        $inputParts[$ageIndex] = $age;
        
        // ekstrak nama dari array (semua elemen sebelum umur)
        $name = implode(' ', array_slice($inputParts, 0, $ageIndex));
        // ekstrak kota dari array (semua elemen setelah umur)
        $city = implode(' ', array_slice($inputParts, $ageIndex + 1));

        // hapus semua indikator usia yang tersisa dari kota
        $city = trim(preg_replace('/(TAHUN|THN|TH)/i', '', $city));

        // simpan data pengguna ke database tabel users
        $user = new User;
        $user->name = $name;
        $user->age = $age;
        $user->city = $city;
        $user->save();

        // redirect ke halaman utama dengan pesan sukses
        return redirect('/')->with('success', 'Data Pengguna Berhasil Disimpan');
    }
}
