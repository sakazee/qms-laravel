<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\Template;
use Illuminate\Support\Facades\View;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Symfony\Component\HttpFoundation\Response;

class ReportService
{
    public function getTemplateSummary(int $templateId, int $userId): array
    {
        $template = Template::with([
            'animals.animalShares.partner',
            'partners.animalShares.animal',
            'expenses.distributions.animal',
            'payments.partner',
        ])->where('id', $templateId)->where('user_id', $userId)->firstOrFail();

        return [
            'template' => $template,
            'stats' => [
                'total_animals' => $template->animals->count(),
                'total_partners' => $template->partners->count(),
                'total_animal_cost' => $template->animals->sum('purchase_price'),
                'total_expenses' => $template->expenses->sum('amount'),
                'total_cost' => $template->animals->sum('purchase_price') + $template->expenses->sum('amount'),
                'total_collection' => $template->payments->sum('amount'),
                'due' => max(0, ($template->animals->sum('purchase_price') + $template->expenses->sum('amount')) - $template->payments->sum('amount')),
                'advance' => max(0, $template->payments->sum('amount') - ($template->animals->sum('purchase_price') + $template->expenses->sum('amount'))),
            ],
        ];
    }

    public function getPartnerDueSummary(int $templateId, int $userId): array
    {
        $template = Template::with([
            'expenses.distributions.animal',
        ])->where('id', $templateId)->where('user_id', $userId)->firstOrFail();

        $animalExpenses = $template->expenses
            ->flatMap(fn ($e) => $e->distributions)
            ->filter(fn ($d) => $d->animal_id !== null)
            ->groupBy('animal_id')
            ->map(fn ($ds) => $ds->sum('amount'));

        $partners = Partner::with(['animalShares.animal', 'payments'])
            ->forTemplate($templateId)
            ->forUser($userId)
            ->get()
            ->map(function ($partner) use ($animalExpenses) {
                $totalShares = $partner->animalShares->sum('shares');
                $totalDue = $partner->animalShares->sum(function ($as) use ($animalExpenses) {
                    $animalExpense = $animalExpenses[$as->animal_id] ?? 0;
                    $totalShares = $as->animal->total_shares;
                    $expenseShare = $totalShares > 0
                        ? round($animalExpense / $totalShares * $as->shares, 2)
                        : 0;

                    return $as->share_amount + $expenseShare;
                });

                $totalPaid = $partner->payments->sum('amount');

                return [
                    'partner' => $partner,
                    'total_shares' => $totalShares,
                    'total_due' => round($totalDue, 2),
                    'total_paid' => $totalPaid,
                    'balance' => round($totalDue - $totalPaid, 2),
                ];
            })
            ->filter(fn ($r) => $r['total_shares'] > 0)
            ->values();

        return ['partners' => $partners];
    }

    public function getPartnerSummary(int $templateId, int $userId): array
    {
        $partners = Partner::with(['animalShares.animal', 'payments'])
            ->forTemplate($templateId)
            ->forUser($userId)
            ->get()
            ->map(function ($partner) {
                return [
                    'partner' => $partner,
                    'total_share' => $partner->animalShares->sum('share_amount'),
                    'total_paid' => $partner->payments->sum('amount'),
                    'due' => max(0, $partner->animalShares->sum('share_amount') - $partner->payments->sum('amount')),
                    'advance' => max(0, $partner->payments->sum('amount') - $partner->animalShares->sum('share_amount')),
                ];
            });

        return ['partners' => $partners];
    }

    public function generatePdf(string $view, array $data, string $filename, string $defaultFont = 'shonar-bangla'): Response
    {
        $defaultConfig = (new ConfigVariables)->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables)->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_left' => 15,
            'margin_right' => 15,
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts/bengali'),
            ]),
            'fontdata' => $fontData + [
                'solaimanlipi' => [
                    'R' => 'SolaimanLipi.ttf',
                    'B' => 'SolaimanLipi_Bold.ttf',
                    'useOTL'    => 0xFF,
                    'useKashida' => 75,
                ],
                'kalpurush' => [
                    'R' => 'Kalpurush.ttf',
                    'useOTL'    => 0xFF,
                ],
                'shonar-bangla' => [
                    'R' => 'ShonarBangla-N.ttf',
                    'B' => 'ShonarBangla-B.ttf',
                    'useOTL'    => 0xFF,
                    'useKashida' => 75,
                ],
            ],
            'default_font' => $defaultFont,
        ]);

        $mpdf->SetTitle($data['title'] ?? 'কোরবানি রিপোর্ট');
        $mpdf->SetAuthor(config('app.name'));

        $html = View::make($view, $data)->render();
        $mpdf->WriteHTML($html);

        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
