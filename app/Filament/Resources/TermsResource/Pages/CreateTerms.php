<?php

namespace App\Filament\Resources\TermsResource\Pages;

use App\Filament\Resources\TermsResource;
use App\Models\Terms;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTerms extends CreateRecord
{
    protected static string $resource = TermsResource::class;

    protected function beforeCreate(): void
    {
        if (Terms::exists()) {
            $this->halt(); // منع إنشاء سجل إذا كان هناك سجل موجود
        }
    }
}
