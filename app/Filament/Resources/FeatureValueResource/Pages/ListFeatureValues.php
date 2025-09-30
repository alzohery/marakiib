<?php

namespace App\Filament\Resources\FeatureValueResource\Pages;

use App\Filament\Resources\FeatureValueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeatureValues extends ListRecords
{
    protected static string $resource = FeatureValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
