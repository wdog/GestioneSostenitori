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
        // dd($adesione->livello->toArray());

        $pdf = Pdf::loadView($template, [
            'adesione' => $adesione,
            'socio' => [
                'nome' => $adesione->socio->nome,
                'cognome' => $adesione->socio->cognome,
                'codice' => $adesione->codice_tessera,
                'anno_iscrizione' => $adesione->anno,
            ],
            'livello' => $adesione->livello,
            'ente' => [
                'nome' => Impostazione::getNomeAssociazione(),
            ],
            'nomeAssociazione' => Impostazione::getNomeAssociazione(),
            'logoPath' => $logoPath,
            'logoUrl' => $logoUrl,
            'palette' => [
                'primary' => $adesione->livello->color_primary,       // fasce
                'secondary' => $adesione->livello->color_secondary,     // sfondo tessera
                'accent' => $adesione->livello->color_accent,        // badge/elementi evidenziati
                'label' => $adesione->livello->color_label,         // label secondarie
            ],
        ]);

        // 85.6mm x 54mm in points (1mm = 2.83465 points)
        $pdf->setPaper([0, 0, 242.65, 153.07], 'portrait');

        $filename = "tessere/{$adesione->anno}/tessera_{$adesione->socio->id}_{$adesione->anno}.pdf";

        Storage::disk('public')->put($filename, $pdf->output());

        $adesione->update(['tessera_path' => $filename]);

        return $filename;
    }

    public function download(Adesione $adesione): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Rigenera sempre per avere il PDF aggiornato
        $this->genera($adesione);

        $filename = "Tessera_{$adesione->socio->cognome}_{$adesione->socio->nome}_{$adesione->anno}.pdf";
        $path = Storage::disk('public')->path($adesione->tessera_path);

        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function getPath(Adesione $adesione): ?string
    {
        if (! $adesione->tessera_path) {
            return null;
        }

        return Storage::disk('public')->path($adesione->tessera_path);
    }

    protected function getTemplate(string $livelloSlug): string
    {
        $templates = [
            'base' => 'pdf.tessera-base',
        ];

        return $templates[$livelloSlug] ?? 'pdf.tessera-base';
    }
}
