<?php

namespace App\Services;

use App\Models\Template;
use App\Models\Animal;
use App\Models\Partner;
use App\Models\AnimalShare;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

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
            'stats'    => [
                'total_animals'    => $template->animals->count(),
                'total_partners'   => $template->partners->count(),
                'total_animal_cost'=> $template->animals->sum('purchase_price'),
                'total_expenses'   => $template->expenses->sum('amount'),
                'total_cost'       => $template->animals->sum('purchase_price') + $template->expenses->sum('amount'),
                'total_collection' => $template->payments->sum('amount'),
                'due'              => max(0, ($template->animals->sum('purchase_price') + $template->expenses->sum('amount')) - $template->payments->sum('amount')),
                'advance'          => max(0, $template->payments->sum('amount') - ($template->animals->sum('purchase_price') + $template->expenses->sum('amount'))),
            ],
        ];
    }

    public function getPartnerSummary(int $templateId, int $userId): array
    {
        $partners = Partner::with(['animalShares.animal', 'payments'])
                           ->forTemplate($templateId)
                           ->forUser($userId)
                           ->get()
                           ->map(function ($partner) {
                               return [
                                   'partner'         => $partner,
                                   'total_share'     => $partner->animalShares->sum('share_amount'),
                                   'total_paid'      => $partner->payments->sum('amount'),
                                   'due'             => max(0, $partner->animalShares->sum('share_amount') - $partner->payments->sum('amount')),
                                   'advance'         => max(0, $partner->payments->sum('amount') - $partner->animalShares->sum('share_amount')),
                               ];
                           });

        return ['partners' => $partners];
    }

    public function generatePdf(string $view, array $data, string $filename): \Symfony\Component\HttpFoundation\Response
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'orientation'   => 'P',
            'margin_top'    => 15,
            'margin_bottom' => 15,
            'margin_left'   => 15,
            'margin_right'  => 15,
            'fontDir'       => array_merge($fontDirs, [
                public_path('fonts/bengali'),
            ]),
            'fontdata'      => $fontData + [
                'solaimanlipi' => [
                    'R'  => 'SolaimanLipi.ttf',
                    'B'  => 'SolaimanLipi_Bold.ttf',
                ],
                'kalpurush' => [
                    'R' => 'Kalpurush.ttf',
                ],
            ],
            'default_font'  => 'solaimanlipi',
        ]);

        $mpdf->SetTitle($data['title'] ?? 'কোরবানি রিপোর্ট');
        $mpdf->SetAuthor(config('app.name'));

        $html = View::make($view, $data)->render();
        $mpdf->WriteHTML($html);

        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
