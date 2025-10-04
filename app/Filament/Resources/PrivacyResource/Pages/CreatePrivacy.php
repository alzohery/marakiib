<?php

namespace App\Filament\Resources\PrivacyResource\Pages;

use App\Filament\Resources\PrivacyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Privacy;

class CreatePrivacy extends CreateRecord
{
    protected static string $resource = PrivacyResource::class;

    

    protected function beforeCreate(): void
    {
        if (Privacy::exists()) {
            $this->halt(); // منع إنشاء سجل إذا كان هناك سجل موجود
        }
    }
}