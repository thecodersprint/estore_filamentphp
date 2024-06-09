<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
{
    // dd($data);
    // if($data['password'] == ''){
    //     unset($data['password']);
    //     unset($data['password_confirmation']);
    // }
    $record->update($data);

    return $record;
}
}
