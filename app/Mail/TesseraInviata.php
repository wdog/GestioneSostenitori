<?php

namespace App\Mail;

use App\Models\Adesione;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TesseraInviata extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Adesione $adesione) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Tessera Associativa {$this->adesione->anno} - {$this->adesione->livello->nome}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tessera-inviata',
            with: [
                'socio' => $this->adesione->socio,
                'livello' => $this->adesione->livello,
                'anno' => $this->adesione->anno,
            ],
        );
    }

    public function attachments(): array
    {
        if (! $this->adesione->tessera_path) {
            return [];
        }

        $path = Storage::disk('public')->path($this->adesione->tessera_path);

        if (! file_exists($path)) {
            return [];
        }

        return [
            Attachment::fromPath($path)
                ->as("Tessera_{$this->adesione->socio->cognome}_{$this->adesione->anno}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
