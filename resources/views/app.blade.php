<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>Program Data Pengguna</title>
</head>
<body>
    @if(session('success'))
    <div class="bg-red-100 text-red-700 px-4 py-3 relative" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    <div class="flex justify-center items-center h-screen bg-primary">
        <div class="bg-quaternary p-6 rounded-lg shadow-lg w-2/3">
            <form action={{ route('users.store') }} method="POST">
                @csrf
                    <h1 class="text-2xl font-bold text-secondary text-center">DATA PENGGUNA</h1>
                    <input type="text" class="border border-secondary rounded-lg w-full p-2 mt-4" placeholder="Masukkan Data Pengguna ( CUT MINI 28 BANDA ACEH )" name="data_pengguna" autofocus>
                    <button type="submit" class="bg-secondary text-quaternary rounded-lg w-full p-2 mt-4">Simpan</button>    
            </form>
        </div>
    </div>
    <div>

    @vite('resources/js/app.js')
</body>
</html>