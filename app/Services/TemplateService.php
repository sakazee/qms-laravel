<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Support\Facades\Cache;

class TemplateService
{
    public function getAllForUser(int $userId)
    {
        return Template::forUser($userId)->latest()->get();
    }

    public function create(array $data, int $userId): Template
    {
        $this->clearCache($userId);
        return Template::create(array_merge($data, ['user_id' => $userId]));
    }

    public function update(Template $template, array $data): Template
    {
        $template->update($data);
        $this->clearCache($template->user_id);
        return $template->fresh();
    }

    public function delete(Template $template): void
    {
        $template->delete();
        $this->clearCache($template->user_id);
    }

    public function getDashboardStats(int $templateId, int $userId): array
    {
        return Cache::remember("dashboard_stats_{$userId}_{$templateId}", 300, function () use ($templateId, $userId) {
            $template = Template::with(['animals', 'partners', 'expenses', 'payments'])
                                ->where('id', $templateId)
                                ->where('user_id', $userId)
                                ->firstOrFail();

            return [
                'total_animals'    => $template->animals->count(),
                'total_partners'   => $template->partners->count(),
                'total_expenses'   => $template->expenses->sum('amount'),
                'total_collection' => $template->payments->sum('amount'),
                'total_cost'       => $template->animals->sum('purchase_price') + $template->expenses->sum('amount'),
                'due'              => $template->due,
                'advance'          => $template->advance,
            ];
        });
    }

    private function clearCache(int $userId): void
    {
        // Clear all cached stats for this user
        Cache::flush(); // In production, use tagged cache
    }
}
