<?php

namespace App\Services;

use App\Models\Animal;
use App\Models\AnimalShare;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;

class AnimalShareService
{
    public function assign(array $data, int $templateId, int $userId): AnimalShare
    {
        return DB::transaction(function () use ($data, $templateId, $userId) {
            $animal = Animal::findOrFail($data['animal_id']);

            // Validate share limit
            $this->validateShares($animal, $data['shares'], $data['partner_id'] ?? null);

            // Calculate share amount
            $shareAmount = ($animal->purchase_price / $animal->total_shares) * $data['shares'];

            return AnimalShare::create([
                'user_id'      => $userId,
                'template_id'  => $templateId,
                'animal_id'    => $data['animal_id'],
                'partner_id'   => $data['partner_id'],
                'shares'       => $data['shares'],
                'share_amount' => round($shareAmount, 2),
                'notes'        => $data['notes'] ?? null,
            ]);
        });
    }

    public function update(AnimalShare $share, array $data): AnimalShare
    {
        return DB::transaction(function () use ($share, $data) {
            $animal = $share->animal;
            $this->validateShares($animal, $data['shares'], $share->partner_id, $share->id);

            $shareAmount = ($animal->purchase_price / $animal->total_shares) * $data['shares'];

            $share->update([
                'shares'       => $data['shares'],
                'share_amount' => round($shareAmount, 2),
                'notes'        => $data['notes'] ?? null,
            ]);

            return $share->fresh();
        });
    }

    private function validateShares(Animal $animal, int $requestedShares, ?int $partnerId, ?int $excludeShareId = null): void
    {
        // Check max shares for animal type
        if (!in_array($animal->type, Animal::LARGE_ANIMALS) && $requestedShares > Animal::MAX_SHARES_SMALL) {
            throw new \RuntimeException(__('shares.small_animal_one_share'));
        }

        if ($requestedShares > Animal::MAX_SHARES_LARGE) {
            throw new \RuntimeException(__('shares.max_shares_exceeded'));
        }

        // Check available shares
        $assignedQuery = $animal->animalShares();
        if ($excludeShareId) {
            $assignedQuery->where('id', '!=', $excludeShareId);
        }
        $assigned = $assignedQuery->sum('shares');

        if (($assigned + $requestedShares) > $animal->total_shares) {
            $available = $animal->total_shares - $assigned;
            throw new \RuntimeException(__('shares.overflow', ['available' => $available]));
        }
    }

    public function delete(AnimalShare $share): void
    {
        $share->delete();
    }

    public function getForTemplate(int $templateId, int $userId)
    {
        return AnimalShare::with(['animal', 'partner'])
                          ->where('template_id', $templateId)
                          ->where('user_id', $userId)
                          ->get();
    }
}
