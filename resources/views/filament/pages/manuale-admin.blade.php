<x-filament-panels::page>

    <div class="space-y-8 max-w-4xl">

        {{-- INDICE --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white mb-4">Indice</h2>
            <ol class="space-y-1 text-sm text-gray-600 dark:text-gray-400 list-decimal list-inside">
                <li><a href="#sostenitori" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">Gestione Sostenitori</a></li>
                <li><a href="#adesioni" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">Gestione Adesioni</a></li>
                <li><a href="#stati" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">Stati delle Adesioni</a></li>
                <li><a href="#chiusura" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">Regole di Chiusura Automatica</a></li>
                <li><a href="#telegram" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">Notifiche Telegram</a></li>
                <li><a href="#email" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">Notifiche Email al Sostenitore</a></li>
                <li><a href="#livelli" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">Gestione Livelli</a></li>
                <li><a href="#impostazioni" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">Impostazioni</a></li>
            </ol>
        </div>

        {{-- 1. SOSTENITORI --}}
        <div id="sostenitori" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-sm font-bold shrink-0">1</div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Gestione Sostenitori</h2>
            </div>
            <div class="space-y-3 text-sm">
                <p class="text-gray-600 dark:text-gray-400">I sostenitori sono le persone fisiche che aderiscono all'associazione. Ogni sostenitore è identificato da un'email univoca.</p>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Come creare un sostenitore</p>
                    <ol class="list-decimal list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Vai su <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">Sostenitori → Nuovo sostenitore</span></li>
                        <li>Compila nome, cognome, email (obbligatoria) e cellulare (opzionale)</li>
                        <li>Il formato del cellulare accettato è <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">XXX.XXXX.XX.XX</span></li>
                    </ol>
                </div>

                <div class="rounded-lg bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-800 p-4 space-y-1">
                    <p class="font-medium text-amber-800 dark:text-amber-200">Attenzione</p>
                    <ul class="list-disc list-inside space-y-1 text-amber-700 dark:text-amber-300">
                        <li>Email e cellulare devono essere univoci nel sistema</li>
                        <li>Ogni sostenitore può avere al massimo <strong>una sola adesione per anno</strong></li>
                        <li>Puoi vedere tutte le adesioni di un sostenitore aprendo la sua scheda</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- 2. ADESIONI --}}
        <div id="adesioni" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-sm font-bold shrink-0">2</div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Gestione Adesioni</h2>
            </div>
            <div class="space-y-3 text-sm">
                <p class="text-gray-600 dark:text-gray-400">Un'adesione collega un sostenitore a un livello di supporto per uno specifico anno. Il sistema genera automaticamente un codice tessera univoco di 5 caratteri.</p>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Come creare un'adesione</p>
                    <ol class="list-decimal list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Vai su <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">Adesioni → Nuova adesione</span></li>
                        <li>Seleziona il sostenitore (cerca per nome, cognome o email)</li>
                        <li>Scegli il livello di supporto</li>
                        <li>Imposta l'anno (default: anno corrente)</li>
                        <li>Scegli lo stato iniziale (vedi sezione Stati)</li>
                        <li>L'importo versato va inserito <strong>solo ad avvenuto incasso</strong></li>
                    </ol>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Azioni disponibili su ogni adesione</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li><span class="text-cyan-600 dark:text-cyan-400 font-medium">PDF</span> — Scarica la tessera in formato PDF</li>
                        <li><span class="text-green-600 dark:text-green-400 font-medium">Email</span> — Invia la tessera via email al sostenitore (richiede conferma)</li>
                        <li><span class="font-medium text-gray-800 dark:text-gray-200">Modifica / Elimina</span> — Solo per adesioni dell'anno corrente</li>
                    </ul>
                </div>

                <div class="rounded-lg bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800 p-4">
                    <p class="font-medium text-blue-800 dark:text-blue-200 mb-1">Adesioni anni passati</p>
                    <p class="text-blue-700 dark:text-blue-300">Le adesioni di anni precedenti sono <strong>in sola lettura</strong>: non possono essere modificate né eliminate. Questo garantisce l'integrità storica dei dati.</p>
                </div>
            </div>
        </div>

        {{-- 3. STATI --}}
        <div id="stati" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-sm font-bold shrink-0">3</div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Stati delle Adesioni</h2>
            </div>
            <div class="space-y-3 text-sm">
                <p class="text-gray-600 dark:text-gray-400">Ogni adesione ha uno dei quattro stati seguenti:</p>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div class="rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-950 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-green-600 dark:text-green-400" />
                            <span class="font-semibold text-green-800 dark:text-green-200">Attiva</span>
                        </div>
                        <p class="text-green-700 dark:text-green-300">Adesione pagata e valida per l'anno corrente. L'importo versato è stato incassato.</p>
                    </div>

                    <div class="rounded-lg border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <x-heroicon-s-clock class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                            <span class="font-semibold text-amber-800 dark:text-amber-200">Da Incassare</span>
                        </div>
                        <p class="text-amber-700 dark:text-amber-300">Adesione creata ma il pagamento non è ancora stato ricevuto. L'importo versato rimane a 0.</p>
                    </div>

                    <div class="rounded-lg border border-rose-200 dark:border-rose-800 bg-rose-50 dark:bg-rose-950 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <x-heroicon-s-x-circle class="w-5 h-5 text-rose-600 dark:text-rose-400" />
                            <span class="font-semibold text-rose-800 dark:text-rose-200">Scaduta</span>
                        </div>
                        <p class="text-rose-700 dark:text-rose-300">Adesione che era <em>Attiva</em> in un anno passato e non è stata rinnovata. Storico pagato conservato.</p>
                    </div>

                    <div class="rounded-lg border border-rose-200 dark:border-rose-800 bg-rose-50 dark:bg-rose-950 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <x-heroicon-s-x-circle class="w-5 h-5 text-rose-600 dark:text-rose-400" />
                            <span class="font-semibold text-rose-800 dark:text-rose-200">Annullata</span>
                        </div>
                        <p class="text-rose-700 dark:text-rose-300">Adesione che era <em>Da Incassare</em> in un anno passato: il pagamento non è mai arrivato.</p>
                    </div>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Come cambiare lo stato manualmente</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Apri l'adesione in modifica</li>
                        <li>Usa i pulsanti di stato nella sezione del form</li>
                        <li>Se imposti <strong>Da Incassare</strong>, l'importo versato si azzera automaticamente</li>
                        <li>L'importo va inserito solo quando passi a <strong>Attiva</strong> dopo aver ricevuto il pagamento</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- 4. CHIUSURA AUTOMATICA --}}
        <div id="chiusura" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-sm font-bold shrink-0">4</div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Regole di Chiusura Automatica</h2>
            </div>
            <div class="space-y-3 text-sm">
                <p class="text-gray-600 dark:text-gray-400">Il sistema chiude automaticamente le adesioni degli anni passati ogni settimana tramite il comando <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">adesioni:scadi</span>.</p>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-2 pr-4 font-medium text-gray-800 dark:text-gray-200">Condizione</th>
                                <th class="text-left py-2 pr-4 font-medium text-gray-800 dark:text-gray-200">Stato corrente</th>
                                <th class="text-left py-2 font-medium text-gray-800 dark:text-gray-200">Diventa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            <tr>
                                <td class="py-2 pr-4 text-gray-600 dark:text-gray-400">Anno &lt; anno corrente</td>
                                <td class="py-2 pr-4">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 dark:bg-green-900 px-2 py-0.5 text-xs font-medium text-green-700 dark:text-green-300">Attiva</span>
                                </td>
                                <td class="py-2">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 dark:bg-rose-900 px-2 py-0.5 text-xs font-medium text-rose-700 dark:text-rose-300">Scaduta</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 text-gray-600 dark:text-gray-400">Anno &lt; anno corrente</td>
                                <td class="py-2 pr-4">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 dark:bg-amber-900 px-2 py-0.5 text-xs font-medium text-amber-700 dark:text-amber-300">Da Incassare</span>
                                </td>
                                <td class="py-2">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 dark:bg-rose-900 px-2 py-0.5 text-xs font-medium text-rose-700 dark:text-rose-300">Annullata</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">(importo → €0)</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="rounded-lg bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800 p-4">
                    <p class="font-medium text-blue-800 dark:text-blue-200 mb-1">Frequenza</p>
                    <p class="text-blue-700 dark:text-blue-300">Il processo viene eseguito automaticamente <strong>ogni settimana</strong>. Non richiede intervento manuale. Le transizioni sono irreversibili per le adesioni di anni passati.</p>
                </div>
            </div>
        </div>

        {{-- 5. TELEGRAM --}}
        <div id="telegram" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-sm font-bold shrink-0">5</div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Notifiche Telegram</h2>
            </div>
            <div class="space-y-3 text-sm">
                <p class="text-gray-600 dark:text-gray-400">Il sistema può inviare notifiche automatiche su Telegram a un gruppo e/o a singoli amministratori.</p>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Quando vengono inviate le notifiche</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li><strong class="text-gray-900 dark:text-gray-100">Nuovo sostenitore creato</strong> — nome, email, data, totale sostenitori</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Sostenitore modificato</strong> — nome ed email aggiornati</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Nuova adesione creata</strong> — sostenitore, livello, anno, importo, codice tessera, stato</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Adesione modificata</strong> — dati aggiornati dell'adesione</li>
                    </ul>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">A chi arrivano le notifiche</p>
                    <ol class="list-decimal list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li><strong class="text-gray-900 dark:text-gray-100">Gruppo Telegram</strong> — se configurato un Chat ID di gruppo in Impostazioni</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Singoli admin</strong> — ogni utente admin con Chat ID impostato nel profilo e notifiche abilitate</li>
                    </ol>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Come configurare le notifiche Telegram</p>
                    <ol class="list-decimal list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Abilita globalmente da <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">Impostazioni → Notifiche Telegram → Abilita</span></li>
                        <li>Per il <strong class="text-gray-900 dark:text-gray-100">gruppo</strong>: aggiungi il bot al gruppo e inserisci il Chat ID (es. <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">-1001234567890</span>)</li>
                        <li>Per <strong class="text-gray-900 dark:text-gray-100">notifiche individuali</strong>: vai su <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">Profilo → Chat ID Telegram</span> e inserisci il proprio ID</li>
                    </ol>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Come trovare il proprio Chat ID</p>
                    <ol class="list-decimal list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Apri Telegram e cerca il bot dell'associazione</li>
                        <li>Invia il comando <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">/start</span></li>
                        <li>Il bot risponderà con il tuo Chat ID numerico</li>
                        <li>Copia quel numero nel tuo profilo admin</li>
                    </ol>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Comandi bot disponibili</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li><span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">/start</span> — Mostra il tuo Chat ID</li>
                        <li><span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">/menu</span> — Statistiche rapide: totale sostenitori, adesioni per anno</li>
                    </ul>
                </div>

                <div class="rounded-lg bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-800 p-4">
                    <p class="font-medium text-amber-800 dark:text-amber-200 mb-1">Attenzione</p>
                    <p class="text-amber-700 dark:text-amber-300">Se le notifiche Telegram sono disabilitate globalmente in Impostazioni, <strong>nessuna notifica viene inviata</strong>, indipendentemente dalle impostazioni individuali degli admin.</p>
                </div>
            </div>
        </div>

        {{-- 6. EMAIL --}}
        <div id="email" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-sm font-bold shrink-0">6</div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Notifiche Email al Sostenitore</h2>
            </div>
            <div class="space-y-3 text-sm">
                <p class="text-gray-600 dark:text-gray-400">L'email <strong class="text-gray-800 dark:text-gray-200">non viene inviata automaticamente</strong>: è sempre una scelta manuale dell'amministratore.</p>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Come inviare la tessera via email</p>
                    <ol class="list-decimal list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Vai all'adesione nella lista (o nella scheda sostenitore)</li>
                        <li>Clicca il pulsante <span class="text-green-600 dark:text-green-400 font-medium">Email</span></li>
                        <li>Conferma l'invio nella finestra di dialogo</li>
                        <li>Il sistema genera il PDF (se non esiste già) e invia l'email in coda</li>
                    </ol>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Cosa contiene l'email</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Oggetto: <span class="italic">Tessera Associativa {anno} - {nome livello}</span></li>
                        <li>Corpo: saluto personalizzato, ringraziamento, info livello e anno</li>
                        <li>Allegato: tessera PDF con nome e codice del sostenitore</li>
                    </ul>
                </div>

                <div class="rounded-lg bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800 p-4">
                    <p class="font-medium text-blue-800 dark:text-blue-200 mb-1">Invio in coda</p>
                    <p class="text-blue-700 dark:text-blue-300">L'email viene messa in coda e inviata dal queue worker in background. La notifica "Email inviata" compare subito, ma l'invio effettivo avviene nei secondi successivi.</p>
                </div>
            </div>
        </div>

        {{-- 7. LIVELLI --}}
        <div id="livelli" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-sm font-bold shrink-0">7</div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Gestione Livelli</h2>
            </div>
            <div class="space-y-3 text-sm">
                <p class="text-gray-600 dark:text-gray-400">I livelli definiscono le categorie di supporto. Ogni livello ha un importo suggerito e una palette di colori che determina l'aspetto visivo della tessera PDF.</p>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Livelli predefiniti</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li><strong class="text-gray-900 dark:text-gray-100">Base</strong> — €20,00</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Pro</strong> — €50,00</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Avanzato</strong> — €100,00</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Eterno</strong> — €500,00 (contributo una tantum)</li>
                    </ul>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Colori della tessera</p>
                    <p class="text-gray-700 dark:text-gray-300">Ogni livello ha 4 colori configurabili:</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li><strong class="text-gray-900 dark:text-gray-100">Primario</strong> — header e footer della tessera</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Secondario</strong> — sfondo della card</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Accento</strong> — badge e highlights</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Label</strong> — etichette secondarie</li>
                    </ul>
                    <p class="text-gray-700 dark:text-gray-300">Usa il pulsante <span class="font-medium text-gray-900 dark:text-gray-100">Genera Colori</span> per ottenere una palette casuale armoniosa.</p>
                </div>

                <div class="rounded-lg bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-800 p-4">
                    <p class="font-medium text-amber-800 dark:text-amber-200 mb-1">Disattivazione livelli</p>
                    <p class="text-amber-700 dark:text-amber-300">Puoi disattivare un livello con il toggle <strong>Attivo</strong>: i livelli inattivi non compaiono nel form di creazione adesioni, ma le adesioni esistenti che li usano rimangono invariate.</p>
                </div>
            </div>
        </div>

        {{-- 8. IMPOSTAZIONI --}}
        <div id="impostazioni" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-400 text-sm font-bold shrink-0">8</div>
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Impostazioni</h2>
            </div>
            <div class="space-y-3 text-sm">
                <p class="text-gray-600 dark:text-gray-400">Vai su <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">Impostazioni</span> nel menu laterale per configurare:</p>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Dati Associazione</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li><strong class="text-gray-900 dark:text-gray-100">Nome associazione</strong> — appare nell'intestazione del pannello e nelle tessere</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Logo</strong> — appare sulle tessere PDF (max 300px larghezza)</li>
                    </ul>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Notifiche Telegram</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li><strong class="text-gray-900 dark:text-gray-100">Abilita notifiche</strong> — interruttore globale: se spento, nessuna notifica viene mai inviata</li>
                        <li><strong class="text-gray-900 dark:text-gray-100">Chat ID Gruppo</strong> — ID del gruppo Telegram (inizia sempre con <span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">-100...</span>)</li>
                    </ul>
                </div>

                <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 space-y-2">
                    <p class="font-medium text-gray-800 dark:text-gray-200">Profilo admin (impostazioni individuali)</p>
                    <p class="text-gray-700 dark:text-gray-300">Ogni admin può configurare nel proprio profilo (<span class="font-mono bg-gray-200 dark:bg-gray-700 dark:text-gray-300 px-1 rounded text-xs">icona utente in alto a destra → Profilo</span>):</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                        <li>Chat ID Telegram personale — per ricevere notifiche in privato</li>
                        <li>Attiva/disattiva notifiche Telegram individuali</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</x-filament-panels::page>
