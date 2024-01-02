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
        $request->validate([
            'data_pengguna' => 'required'
        ], [
            'data_pengguna.required' => 'Data Pengguna Wajib Diisi'
        ]);
        $input = strtoupper($request->data_pengguna);
        $inputParts = explode(' ', $input);

        $ageIndex = -1;
        for ($i = 0; $i < count($inputParts); $i++) {
            if (is_numeric($inputParts[$i]) || preg_match('/\d+(TAHUN|THN|TH)/i', $inputParts[$i])) {
                $ageIndex = $i;
                break;
            }
        }

        $age = $inputParts[$ageIndex];
        $age = trim(preg_replace('/(TAHUN|THN|TH)/i', '', $age));

        $inputParts[$ageIndex] = $age;

        $name = implode(' ', array_slice($inputParts, 0, $ageIndex));
        $city = implode(' ', array_slice($inputParts, $ageIndex + 1));

        $city = trim(preg_replace('/(TAHUN|THN|TH)/i', '', $city));

        $user = new User;
        $user->name = $name;
        $user->age = $age;
        $user->city = $city;
        $user->save();

        return redirect('/')->with('success', 'Data Pengguna Berhasil Disimpan');
    }
}
