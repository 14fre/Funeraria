<x-cliente-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-book mr-2"></i>
            Obituarios
        </h2>
    </x-slot>
    @section('page-title', 'Obituarios')

    <div class="py-6">
        <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-600">
            <i class="fas fa-book text-4xl mb-4"></i>
            <p>Aquí podrás ver los obituarios públicos publicados por la funeraria.</p>
            <a href="{{ url('/obituarios') }}" class="inline-block mt-4 text-red-600 hover:text-red-700 font-medium">Ver obituarios públicos</a>
        </div>
    </div>
</x-cliente-layout>
