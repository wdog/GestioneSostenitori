# claude-mem — Guida all'uso nel progetto

## Cos'è

`claude-mem` è un plugin per Claude Code che fornisce **memoria persistente cross-session**.
Usa ChromaDB (database vettoriale locale) per salvare e cercare osservazioni semanticamente.

---

## Installazione rapida (nuovo host)

```bash
# 1. Aggiungi marketplace e installa plugin
claude plugin marketplace add thedotmack/claude-mem
claude plugin install claude-mem

# 2. Installa bun se non presente
curl -fsSL https://bun.sh/install | bash
source ~/.bashrc   # oppure riapri il terminale

# 3. Installa dipendenze Node (sostituire <versione> con output di: ls ~/.claude/plugins/cache/thedotmack/claude-mem/)
VERSION=$(ls ~/.claude/plugins/cache/thedotmack/claude-mem/)
~/.bun/bin/bun install --cwd ~/.claude/plugins/cache/thedotmack/claude-mem/$VERSION
~/.bun/bin/bun pm trust onnxruntime-node protobufjs --cwd ~/.claude/plugins/cache/thedotmack/claude-mem/$VERSION

# 4. Riavviare Claude Code
```

> **Nota:** `claude plugin install claude-mem@thedotmack` (vecchia sintassi) non funziona —
> bisogna prima aggiungere il marketplace separatamente.

---

## Verifica funzionamento

Dopo il riavvio, verificare che il worker sia attivo:

```bash
ps aux | grep worker-service
```

Deve essere presente un processo `bun ... worker-service.cjs --daemon`.

---

## Come funziona nel progetto

```
Claude Code
├── claude-mem  (globale, gira in locale sull'host — NON dentro Docker)
│   └── worker-service.cjs (ChromaDB locale)
│
└── laravel-boost  (project-scoped, gira nel container Docker)
    └── docker exec -i app php artisan boost:mcp
```

`claude-mem` gira **sull'host**, non nel container Docker del progetto.

---

## File di memoria del progetto

La memoria specifica del progetto è in:

```
~/.claude/projects/<percorso-progetto>/memory/MEMORY.md
```

Questo file viene caricato automaticamente in ogni sessione (prime 200 righe).
Per note dettagliate, creare file separati linkati da `MEMORY.md`.

---

## Skill disponibili

| Skill | Invocazione | Uso |
|-------|-------------|-----|
| Ricerca memoria | `/claude-mem:mem-search` | Cerca nelle sessioni precedenti |
| Crea piano | `/claude-mem:make-plan` | Piano con documentazione |
| Esegui piano | `/claude-mem:do` | Esegue piano con subagent |

---

## Tool MCP disponibili (uso interno di Claude)

| Tool | Funzione |
|------|----------|
| `search` | Ricerca semantica nelle osservazioni |
| `timeline` | Contesto attorno a un risultato |
| `get_observations` | Dettagli completi per ID |
| `save_memory` | Salva una memoria manualmente |

---

## Cosa salvare in memoria

- Pattern e convenzioni confermate nel progetto
- Percorsi file importanti e decisioni architetturali
- Soluzioni a problemi ricorrenti
- Preferenze di workflow

## Cosa NON salvare

- Contesto specifico della sessione corrente
- Informazioni non verificate
- Duplicati delle istruzioni in `CLAUDE.md`

---

## Troubleshooting

### `claude plugin install claude-mem@thedotmack` fallisce

La sintassi `plugin@marketplace` non funziona se il marketplace non è registrato.
Usare la procedura in "Installazione rapida" sopra.

### Worker non parte / ChromaDB non disponibile

Cause tipiche:
1. **`node_modules` mancanti** → eseguire `bun install` + `bun pm trust` (vedi sopra)
2. **`bun` non in PATH** → verificare con `which bun` o usare path assoluto `~/.bun/bin/bun`
3. **Processo non reinizializzato** → riavviare Claude Code

### Verifica dipendenze installate

```bash
ls ~/.claude/plugins/cache/thedotmack/claude-mem/$(ls ~/.claude/plugins/cache/thedotmack/claude-mem/)/node_modules/
```

Se la directory non esiste → le dipendenze non sono installate.
