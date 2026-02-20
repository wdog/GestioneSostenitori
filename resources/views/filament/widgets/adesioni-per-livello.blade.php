<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Sottoscrizioni per Livello — {{ $anno }}
        </x-slot>

        @if ($livelli->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">Nessuna adesione per l'anno selezionato.</p>
        @else
            <div class="space-y-3">
                @foreach ($livelli as $livello)
                    @php
                        $percentuale = $totale > 0 ? round(($livello->conteggio / $totale) * 100) : 0;
                        $color = $livello->color_primary ?? '#6b7280';
                    @endphp
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <span
                                class="inline-block h-3 w-3 shrink-0 rounded-full"
                                style="background-color: {{ $color }}"
                            ></span>
                            <span class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                {{ $livello->nome }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <div class="w-24 h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                <div
                                    class="h-full rounded-full"
                                    style="width: {{ $percentuale }}%; background-color: {{ $color }}"
                                ></div>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold text-white min-w-[2rem] justify-center"
                                style="background-color: {{ $color }}"
                            >
                                {{ $livello->conteggio }}
                            </span>
                        </div>
                    </div>
                @endforeach

                <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3 flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Totale</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $totale }}</span>
                </div>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
