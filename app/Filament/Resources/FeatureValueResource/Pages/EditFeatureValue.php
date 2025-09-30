<?php

namespace App\Filament\Resources\FeatureValueResource\Pages;

use App\Filament\Resources\FeatureValueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeatureValue extends EditRecord
{
    protected static string $resource = FeatureValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
