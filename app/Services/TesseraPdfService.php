<?php

namespace App\Services;

use App\Models\Adesione;
use App\Models\Impostazione;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TesseraPdfService
{
    public function genera(Adesione $adesione): string
    {
        $livelloSlug = strtolower($adesione->livello->nome);
        $template = $this->getTemplate($livelloSlug);

        $logoPath = Impostazione::getLogoPath();
        $logoUrl = null;

        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            $logoUrl = Storage::disk('public')->path($logoPath);
        }

        $pdf = Pdf::loadView($template, [
            'adesione' => $adesione,
            'socio' => $adesione->socio,
            'livello' => $adesione->livello,
            'nomeAssociazione' => Impostazione::getNomeAssociazione(),
            'logoPath' => $logoPath,
            'logoUrl' => $logoUrl,
        ]);

        $pdf->setPaper([0, 0, 400, 250], 'portrait');

        $filename = "tessere/{$adesione->anno}/tessera_{$adesione->socio->id}_{$adesione->anno}.pdf";

        Storage::disk('public')->put($filename, $pdf->output());

        $adesione->update(['tessera_path' => $filename]);

        return $filename;
    }

    public function download(Adesione $adesione)
    {
        // Rigenera sempre per avere il PDF aggiornato
        $this->genera($adesione);

        $filename = "Tessera_{$adesione->socio->cognome}_{$adesione->socio->nome}_{$adesione->anno}.pdf";

        return Storage::disk('public')->download($adesione->tessera_path, $filename);
    }

    public function getPath(Adesione $adesione): ?string
    {
        if (!$adesione->tessera_path) {
            return null;
        }

        return Storage::disk('public')->path($adesione->tessera_path);
    }

    protected function getTemplate(string $livelloSlug): string
    {
        $templates = [
            'base' => 'pdf.tessera-base',
            'pro' => 'pdf.tessera-pro',
            'avanzato' => 'pdf.tessera-avanzato',
            'eterno' => 'pdf.tessera-eterno',
        ];

        return $templates[$livelloSlug] ?? 'pdf.tessera-base';
    }
}
