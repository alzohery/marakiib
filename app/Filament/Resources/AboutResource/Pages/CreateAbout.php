<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Filament\Resources\AboutResource;
use App\Models\About;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAbout extends CreateRecord
{
    protected static string $resource = AboutResource::class;

    protected function beforeCreate(): void
    {
        if (About::exists()) {
            $this->halt(); // منع إنشاء سجل إذا كان هناك سجل موجود
        }
    }
}