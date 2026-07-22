@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Dashboard
</h1>

<div class="grid grid-cols-4 gap-6">

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-gray-500">Passeios</h2>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-gray-500">Reservas</h2>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-gray-500">Galeria</h2>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-gray-500">Dias Bloqueados</h2>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

</div>

@endsection