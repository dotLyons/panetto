<div x-data="{ printDoc() { window.print() } }" class="w-full h-full max-w-5xl mx-auto p-6 md:p-8 bg-white text-sm text-panetto-dark">
    <style>
        .table-header { background-color: #f9fafb; text-align: left; padding: 8px 12px; border: 1px solid #e5e7eb; color: #4b5563; font-weight: 700; }
        .table-cell { padding: 8px 12px; border: 1px solid #e5e7eb; }
        
        @media print {
            body { background: white; margin: 0; padding: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .print-hidden { display: none !important; }
            .accordion-content { display: block !important; }
            .table-header { background-color: #f9fafb !important; color: #000 !important; }
            .table-cell { border-color: #9ca3af !important; color: #000 !important; }
            @page { margin: 10mm; }
            .bg-panetto-orange { background-color: #f9fafb !important; color: #000 !important; border: 1px solid #000; }
        }
    </style>

    <!-- Header area -->
    <div class="mb-8 flex flex-col items-center border-b border-gray-100 pb-6 print:border-b-2 print:border-black">
        <h1 class="text-2xl md:text-3xl font-bold text-panetto-orange print:text-black">Planilla de Control de Salón – Panetto</h1>
        <p class="text-gray-500 mt-2 print:hidden">Completa la planilla correspondiente a la sucursal asignada.</p>
    </div>

    <!-- The form -->
    <form wire:submit.prevent="saveAndPreview">
        
        <!-- Top grids -->
        <div class="overflow-x-auto mb-6 rounded-lg border border-gray-200 shadow-sm print:shadow-none print:border-gray-800">
            <table class="w-full border-collapse">
                <tr>
                    <td class="table-header w-1/4 uppercase text-xs tracking-wider">Sucursal:</td>
                    <td class="table-cell">
                        <input type="text" wire:model="branch" class="w-full border-none focus:outline-none bg-transparent font-bold text-gray-800" readonly>
                        @error('location_id') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </td>
                    <td class="table-header w-1/6 uppercase text-xs tracking-wider">Fecha:</td>
                    <td class="table-cell">
                        <input type="text" wire:model="timestampText" class="w-full border-none focus:outline-none bg-transparent font-bold text-gray-800 {{ $previewMode ? 'text-sm' : 'text-sm text-panetto-dark' }}" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="table-header uppercase text-xs tracking-wider">Turno:</td>
                    <td class="table-cell flex gap-4 border-none border-b border-gray-200 pt-3 print:border-gray-800 flex-wrap">
                        <label class="flex items-center cursor-pointer hover:text-panetto-orange transition"><input type="radio" wire:model="shift" value="Mañana" class="mr-2 text-panetto-orange focus:ring-panetto-orange cursor-pointer" {{ $previewMode ? 'disabled' : '' }}> <span class="font-medium">Mañana</span></label>
                        <label class="flex items-center cursor-pointer hover:text-panetto-orange transition"><input type="radio" wire:model="shift" value="Tarde" class="mr-2 text-panetto-orange focus:ring-panetto-orange cursor-pointer" {{ $previewMode ? 'disabled' : '' }}> <span class="font-medium">Tarde</span></label>
                        <label class="flex items-center cursor-pointer hover:text-panetto-orange transition"><input type="radio" wire:model="shift" value="Noche" class="mr-2 text-panetto-orange focus:ring-panetto-orange cursor-pointer" {{ $previewMode ? 'disabled' : '' }}> <span class="font-medium">Noche</span></label>
                        @error('shift') <span class="text-red-500 text-xs font-bold flex items-center ml-2">{{ $message }}</span> @enderror
                    </td>
                    <td class="table-header border-l border-gray-200 uppercase text-xs tracking-wider print:border-gray-800">Encargado:</td>
                    <td class="table-cell border-l border-gray-200 print:border-gray-800">
                        <input type="text" wire:model="manager" class="w-full border-none focus:outline-none bg-transparent font-bold text-gray-800" readonly>
                        @error('manager') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </td>
                </tr>
            </table>
        </div>

        <!-- Secciones con Acordeones -->
        <div class="space-y-4 print:space-y-2">
            @foreach($items_data as $sectionName => $items)
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden print:shadow-none print:border-gray-800" x-data="{ open: {{ $previewMode ? 'true' : 'false' }} }">
                    <div class="flex items-center justify-between p-4 cursor-pointer bg-gray-50 hover:bg-gray-100 transition print:bg-gray-200 print:text-black" @click="open = !open">
                        <h3 class="font-bold text-panetto-orange text-base flex items-center print:text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 print:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $sectionName }}
                        </h3>
                        <span class="transform transition-transform duration-200 text-gray-400 print-hidden" :class="open ? 'rotate-180' : ''">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </div>
                    
                    <div x-show="open" class="border-t border-gray-200 accordion-content print:border-gray-800">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-white text-gray-500 uppercase text-[10px] font-bold tracking-wider print:text-black">
                                        <th class="p-3 border-b border-gray-200 print:border-gray-800 w-1/4 md:w-1/3">Control a realizar</th>
                                        <th class="p-3 border-b border-gray-200 print:border-gray-800 w-[250px] text-center">Calificación (1-10)</th>
                                        <th class="p-3 border-b border-gray-200 print:border-gray-800 pl-4 border-l border-gray-200">Observaciones específicas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 print:divide-gray-400">
                                    @foreach($items as $itemName => $itemValues)
                                        <tr class="hover:bg-orange-50/50 transition">
                                            <td class="p-3 font-medium text-gray-700 print:text-black">{{ $itemName }}</td>
                                            <td class="p-3 text-center align-middle border-l border-gray-100 print:border-gray-400">
                                                <div class="flex justify-center flex-wrap gap-1 max-w-[220px] mx-auto print:hidden">
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <button type="button" 
                                                            wire:click="setRating('{{ addslashes($sectionName) }}', '{{ addslashes($itemName) }}', {{ $i }})"
                                                            title="{{ $i }} estrellas"
                                                            class="text-xl transition-transform hover:scale-125 focus:outline-none"
                                                            {{ $previewMode ? 'disabled' : '' }}>
                                                            <span class="{{ (isset($itemValues['rating']) ? $itemValues['rating'] : 0) >= $i ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-200' }}">★</span>
                                                        </button>
                                                    @endfor
                                                </div>
                                                <div class="hidden print:block font-bold text-center">
                                                    {{ $itemValues['rating'] ?? 0 }} / 10
                                                </div>
                                            </td>
                                            <td class="p-3 border-l border-gray-200 print:border-gray-800">
                                                <input type="text" wire:model="items_data.{{ $sectionName }}.{{ $itemName }}.obs" placeholder="..." class="w-full bg-transparent border-b border-dashed border-gray-300 focus:border-panetto-orange focus:outline-none text-gray-700 py-1 transition" {{ $previewMode ? 'disabled' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bottom section: Observaciones Generales and Firma -->
        <div class="mt-8 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-8 print:shadow-none print:border-gray-800">
            <div class="bg-gray-50 text-panetto-dark p-3 uppercase tracking-wider text-xs border-b border-gray-200 font-bold print:border-gray-800">
                Observaciones Generales
            </div>
            <div class="p-4">
                <textarea wire:model="general_observations" placeholder="Escribe aquí cualquier eventualidad, problema o detalle importante ocurrido durante el turno..." class="w-full h-24 border border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-panetto-orange focus:border-panetto-orange bg-gray-50 text-gray-800 resize-none transition print:border-none print:bg-white" {{ $previewMode ? 'disabled' : '' }}></textarea>
            </div>
        </div>

        <div class="mt-8 mb-8 border-t border-gray-200 print:border-t-0 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-panetto-orange print:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-bold text-gray-500 italic text-sm print:text-black">"Excelencia que inspira, servicio que honra."</p>
            </div>

            <div class="flex flex-col items-center">
                <span class="w-64 border-b-2 border-gray-300 text-center pb-1 text-lg font-bold font-mono text-panetto-dark print:border-black">{{ $manager }}</span>
                <span class="text-xs text-gray-400 mt-2 uppercase tracking-widest font-bold print:text-black">Firma del Encargado</span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="print-hidden flex flex-wrap justify-center gap-4 py-6 border-t border-gray-100 mb-4 bg-gray-50 rounded-xl px-4">
            @if(!$previewMode)
                <button type="submit" class="bg-panetto-orange text-white px-8 py-3 rounded-xl font-bold shadow-md hover:bg-orange-600 transition flex items-center gap-2 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Completar y Previsualizar
                </button>
            @else
                <button type="button" wire:click="edit" class="bg-white text-gray-600 border border-gray-300 px-6 py-3 rounded-xl font-bold shadow-sm hover:bg-gray-50 transition flex items-center gap-2 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Volver a Editar
                </button>
                <a href="{{ route('salon-control.pdf', ['id' => $savedId]) }}" target="_blank" class="bg-panetto-dark text-white px-8 py-3 rounded-xl font-bold shadow-md hover:bg-black transition flex items-center gap-2 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Generar / Imprimir PDF
                </a>
            @endif
        </div>
    </form>
</div>
