<?php

namespace App\Filament\Resources\BrandResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BrandResource;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }



    // protected function handleRecordUpdate(Model $record, array $data): Model
    // {

    //     // dd($data);
    // }
}
