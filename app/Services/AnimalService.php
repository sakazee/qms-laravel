<?php

namespace App\Services;

use App\Models\Animal;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class AnimalService
{
    public function getAllForTemplate(int $templateId, int $userId)
    {
        return Animal::forTemplate($templateId)
                     ->forUser($userId)
                     ->withCount('animalShares')
                     ->with('animalShares.partner')
                     ->latest()
                     ->get();
    }

    public function create(array $data, int $templateId, int $userId): Animal
    {
        $data['user_id']     = $userId;
        $data['template_id'] = $templateId;
        return Animal::create($data);
    }

    public function update(Animal $animal, array $data): Animal
    {
        $animal->update($data);
        return $animal->fresh();
    }

    public function cycleStatus(Animal $animal): Animal
    {
        $animal->update(['status' => $animal->next_status]);
        return $animal->fresh();
    }

    public function bulkDelete($animals): array
    {
        $deleted = 0;
        $skipped = 0;
        foreach ($animals as $animal) {
            try {
                $this->delete($animal);
                $deleted++;
            } catch (\RuntimeException) {
                $skipped++;
            }
        }
        return [$deleted, $skipped];
    }

    public function delete(Animal $animal): void
    {
        if ($animal->animalShares()->exists()) {
            throw new \RuntimeException(__('animals.cannot_delete_has_shares'));
        }
        $animal->delete();
    }

    public function getMaxShares(string $type): int
    {
        return in_array($type, Animal::LARGE_ANIMALS)
            ? Animal::MAX_SHARES_LARGE
            : Animal::MAX_SHARES_SMALL;
    }

    public function validateShareLimit(string $type, int $shares): bool
    {
        $max = $this->getMaxShares($type);
        return $shares >= 1 && $shares <= $max;
    }
}
