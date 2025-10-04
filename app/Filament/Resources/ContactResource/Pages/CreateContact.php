<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;

    protected function beforeCreate(): void
    {
        if (Contact::exists()) {
            $this->halt(); // منع إنشاء سجل إذا كان هناك سجل موجود
        }
    }
}