<div class="p-4 bg-white rounded-lg shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Participantes del sorteo</h2>
            <p class="text-sm text-gray-500">Listado de inscripciones con detalles y fecha de registro.</p>
        </div>

        <div class="flex items-center gap-3">
            <button
                wire:click="pickWinner"
                onclick="return confirm('¿Deseas elegir un ganador al azar?')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-green-600 to-green-500 text-white rounded-lg shadow hover:from-green-700 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                </svg>
                Elegir ganador
            </button>
        </div>
    </div>

    @if($winner)
        <div class="mb-6 p-4 border-l-4 border-green-400 bg-green-50 rounded-md flex items-center gap-4">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-white shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-gray-500">Ganador seleccionado</div>
                <div class="text-lg font-semibold text-gray-800">{{ $winner->name }} {{ $winner->last_name }} <span class="text-gray-400 text-sm">(ID {{ $winner->id }})</span></div>
                <div class="text-sm text-gray-600">DNI: {{ $winner->dni }} · Tel: {{ $winner->phone }} · Mesa: {{ $winner->table_number }}</div>
            </div>
        </div>
    @endif

    @if($entries->isEmpty())
        <div class="text-center py-8 text-gray-500">No hay participantes registrados.</div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellido</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mesa</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora visita</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Puntuación</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($entries as $entry)
                        <tr class="hover:bg-gray-50 {{ ($winner && $winner->id === $entry->id) ? 'bg-yellow-50' : '' }}">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $entry->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $entry->dni }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $entry->last_name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $entry->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $entry->phone }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $entry->table_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $entry->visit_time }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $entry->rating ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500" title="{{ optional($entry->created_at)->format('Y-m-d H:i:s') }}">{{ optional($entry->created_at)->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-end">
            {{ $entries->links() }}
        </div>
    @endif
</div>
