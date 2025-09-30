<?php

namespace App\Filament\Resources\SiteCommissionResource\Pages;

use App\Filament\Resources\SiteCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteCommissions extends ListRecords
{
    protected static string $resource = SiteCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
