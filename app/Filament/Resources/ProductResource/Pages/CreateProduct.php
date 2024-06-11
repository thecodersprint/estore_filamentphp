<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // if($data['photo']){
        //     $data['photo'] = implode(',',$data['photo']);
        // }
        // if($data['size']){
        //     $data['size'] = implode(',',$data['size']);
        // }
        return $data;
    }
}
