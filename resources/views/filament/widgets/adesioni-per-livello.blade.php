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
                    @endphp

                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="text-sm font-medium ">
                                {{ $livello->nome }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <div class="w-24 h-1.5 rounded-full bg-gray-300!">
                                <div class="h-full rounded-full bg-lime-500!" style="width: {{ $percentuale }}%"></div>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold min-w-8 justify-center bg-lime-500 ">
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
