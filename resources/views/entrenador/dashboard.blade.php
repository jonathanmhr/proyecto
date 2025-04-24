<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel del Entrenador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">¡Bienvenido, entrenador!</h3>

                <ul class="list-disc pl-5 space-y-2">
                    <li>📋 Ver y gestionar tus clases.</li>
                    <li>🧍‍♂️ Ver tus clientes y sus progresos.</li>
                    <li>💪 Crear o asignar rutinas de entrenamiento.</li>
                    <li>🗓 Consultar tu calendario de actividades.</li>
                    <li>💬 Comunicarte con los clientes o con administración.</li>
                </ul>
            </div>

        </div>
    </div>
</form>
</x-app-layout>
