<?php

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Filament\Resources\BeneficiaryResource;
use Filament\Actions;
use Illuminate\Validation\ValidationException;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Beneficiary;
use Filament\Notifications\Notification;


class CreateBeneficiary extends CreateRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $familyCard = $data['family_card_number'] ?? $data['nomor'] ?? null;
        $year       = $data['aid_year'] ?? null;
        $department = $data['department_id'] ?? null;

        if ($familyCard && $year && $department) {
            $exists = Beneficiary::where('family_card_number', $familyCard)
                ->where('aid_year', $year)
                ->where('department_id', $department)
                ->exists();

            if ($exists) {
                Notification::make()
                    ->title('Data duplikat')
                    ->body("Nomor KK <strong>{$familyCard}</strong> sudah menerima bantuan pada tahun dan bidang yang sama.")
                    ->danger()
                    ->persistent()
                    ->send();

                throw ValidationException::withMessages([
                    'family_card_number' => 'Nomor KK ini sudah menerima bantuan pada tahun dan bidang yang sama.',
                ]);
            }
        }

        return $data;
    }
}
