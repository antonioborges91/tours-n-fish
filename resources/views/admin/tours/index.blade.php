@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-3xl font-bold">
            Passeios
        </h1>

        <p class="text-gray-500 mt-1">
            Gerir os passeios do Tours N Fish.
        </p>
    </div>

    <a
        href="{{ route('admin.tours.create') }}"
        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
    >
        <span class="text-lg leading-none">+</span>
        <span>Novo Passeio</span>
    </a>

</div>

<div class="bg-white rounded-lg shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">

        <tr>

            <th class="text-left p-4">Nome</th>

            <th class="text-left p-4">Preço</th>

            <th class="text-left p-4">Capacidade</th>

            <th class="text-left p-4">Estado</th>

            <th class="text-right p-4">Ações</th>

        </tr>

        </thead>

        <tbody>

        <tr>

            <td colspan="5"
                class="text-center text-gray-500 py-12">

                Ainda não existem passeios.

            </td>

        </tr>

        </tbody>

    </table>

</div>

@endsection