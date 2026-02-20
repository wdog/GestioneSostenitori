<?php

namespace App\Filament\Pages;

use App\Models\Adesione;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        $anni = Adesione::query()
            ->distinct()
            ->orderByDesc('anno')
            ->pluck('anno', 'anno')
            ->toArray();

        if (empty($anni)) {
            $anni = [(int) date('Y') => date('Y')];
        }

        return $schema->components([
            Section::make()->schema([
                Select::make('anno')
                    ->label('Anno')
                    ->options($anni)
                    ->default(array_key_first($anni))
                    ->selectablePlaceholder(false),
            ])->columns(1),
        ]);
    }
}
