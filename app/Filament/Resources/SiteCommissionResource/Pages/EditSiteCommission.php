<?php

namespace App\Filament\Resources\SiteCommissionResource\Pages;

use App\Filament\Resources\SiteCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiteCommission extends EditRecord
{
    protected static string $resource = SiteCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
