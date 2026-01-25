<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

new #[Layout('layouts.public', ['title' => 'Posts Dashboard'])] class extends Component {
    //
};
?>

<div class="min-h-screen bg-linear-to-br from-slate-900 via-slate-800 to-slate-900">
    {{-- Header --}}
    <header class="border-b border-slate-700/50">
        <div class="mx-auto max-w-6xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-500/10">
                        <svg class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456Z" />
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-white">Trasimeno Prog</span>
                </div>
                <a href="{{ route('filament.admin.auth.login') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-slate-700/50 px-4 py-2 text-sm font-medium text-slate-200 transition hover:bg-slate-700 hover:text-white">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Area Riservata
                </a>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <main>
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Sostieni il <span class="text-amber-500">Trasimeno Prog</span>
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-400">
                    Diventa sostenitore dell'associazione e contribuisci a portare avanti
                    la passione per la musica progressive sul Lago Trasimeno.
                </p>
            </div>

            {{-- Features --}}
            <div class="mt-16 grid gap-8 sm:grid-cols-3">
                <div
                    class="group rounded-2xl border-2 border-emerald-500/30 bg-slate-900/80 p-8 text-center shadow-lg shadow-emerald-500/5 transition hover:border-emerald-500/50 hover:bg-slate-900 hover:shadow-emerald-500/10">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-500/20 ring-4 ring-emerald-500/10">
                        <svg class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-white">Comunità</h3>
                    <p class="mt-3 text-slate-300">Entra a far parte di una comunità di appassionati</p>
                </div>

                <div
                    class="group rounded-2xl border-2 border-blue-500/30 bg-slate-900/80 p-8 text-center shadow-lg shadow-blue-500/5 transition hover:border-blue-500/50 hover:bg-slate-900 hover:shadow-blue-500/10">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-500/20 ring-4 ring-blue-500/10">
                        <svg class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m9 9 10.5-3m0 6.553v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 1 1-.99-3.467l2.31-.66a2.25 2.25 0 0 0 1.632-2.163Zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 0 1-.99-3.467l2.31-.66A2.25 2.25 0 0 0 9 15.553Z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-white">Eventi</h3>
                    <p class="mt-3 text-slate-300">Accesso prioritario a concerti ed eventi esclusivi</p>
                </div>

                <div
                    class="group rounded-2xl border-2 border-purple-500/30 bg-slate-900/80 p-8 text-center shadow-lg shadow-purple-500/5 transition hover:border-purple-500/50 hover:bg-slate-900 hover:shadow-purple-500/10">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-purple-500/20 ring-4 ring-purple-500/10">
                        <svg class="h-8 w-8 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-white">Tessera</h3>
                    <p class="mt-3 text-slate-300">Tessera digitale personalizzata per ogni sostenitore</p>
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-20 text-center">
                <a href="{{ route('filament.admin.auth.login') }}"
                    class="mt-4 inline-flex items-center gap-2 rounded-lg bg-amber-500 px-6 py-3 font-semibold text-slate-900 transition hover:bg-amber-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                    </svg>
                    Accedi all'Area Riservata
                </a>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-700/50">
        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} Trasimeno Prog. Tutti i diritti riservati.
            </p>
        </div>
    </footer>
</div>
