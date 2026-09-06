<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalShare;
use App\Models\Expense;
use App\Models\ExpenseDistribution;
use App\Models\Partner;
use App\Models\Payment;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user
        $user = User::create([
            'name'     => 'আহমেদ রাহিম',
            'email'    => 'demo@qurbani.app',
            'password' => Hash::make('password'),
            'locale'   => 'bn',
        ]);

        // Create template
        $template = Template::create([
            'user_id'     => $user->id,
            'name'        => 'কোরবানি ২০২৫',
            'year'        => '২০২৫',
            'description' => 'ঢাকা মোহাম্মদপুর এলাকার কোরবানির আয়োজন',
            'status'      => 'active',
        ]);

        // Create animals
        $cow1 = Animal::create([
            'user_id'        => $user->id,
            'template_id'    => $template->id,
            'type'           => 'cow',
            'name'           => 'কালো বলদ',
            'total_shares'   => 7,
            'purchase_price' => 105000.00,
            'status'         => 'purchased',
        ]);

        $cow2 = Animal::create([
            'user_id'        => $user->id,
            'template_id'    => $template->id,
            'type'           => 'cow',
            'name'           => 'লাল গরু',
            'total_shares'   => 7,
            'purchase_price' => 98000.00,
            'status'         => 'purchased',
        ]);

        $goat = Animal::create([
            'user_id'        => $user->id,
            'template_id'    => $template->id,
            'type'           => 'goat',
            'name'           => 'সাদা ছাগল',
            'total_shares'   => 1,
            'purchase_price' => 18000.00,
            'status'         => 'pending',
        ]);

        // Create partners
        $partnerNames = [
            ['name' => 'মোহাম্মদ করিম',   'phone' => '01711-111111', 'address' => 'মোহাম্মদপুর, ঢাকা'],
            ['name' => 'রহিম উদ্দিন',      'phone' => '01811-222222', 'address' => 'মিরপুর, ঢাকা'],
            ['name' => 'আবু বকর',          'phone' => '01911-333333', 'address' => 'ধানমন্ডি, ঢাকা'],
            ['name' => 'সুলতান মাহমুদ',    'phone' => '01611-444444', 'address' => 'উত্তরা, ঢাকা'],
            ['name' => 'নাজমুল হোসেন',     'phone' => '01511-555555', 'address' => 'বনানী, ঢাকা'],
            ['name' => 'ফারুক আহমেদ',      'phone' => '01711-666666', 'address' => 'গুলশান, ঢাকা'],
            ['name' => 'জাহিদুল ইসলাম',    'phone' => '01811-777777', 'address' => 'রমনা, ঢাকা'],
            ['name' => 'মোশারফ হোসেন',     'phone' => '01911-888888', 'address' => 'পল্টন, ঢাকা'],
        ];

        $partners = collect();
        foreach ($partnerNames as $pd) {
            $partners->push(Partner::create([
                'user_id'     => $user->id,
                'template_id' => $template->id,
                'name'        => $pd['name'],
                'phone'       => $pd['phone'],
                'address'     => $pd['address'],
            ]));
        }

        // Assign shares for cow1 (7 shares)
        $sharePrice1 = $cow1->purchase_price / $cow1->total_shares; // 15000 each
        foreach ($partners->take(7) as $i => $partner) {
            AnimalShare::create([
                'user_id'      => $user->id,
                'template_id'  => $template->id,
                'animal_id'    => $cow1->id,
                'partner_id'   => $partner->id,
                'shares'       => 1,
                'share_amount' => round($sharePrice1, 2),
            ]);
        }

        // Assign shares for cow2 (7 shares)
        $sharePrice2 = $cow2->purchase_price / $cow2->total_shares; // 14000 each
        foreach ($partners as $i => $partner) {
            AnimalShare::create([
                'user_id'      => $user->id,
                'template_id'  => $template->id,
                'animal_id'    => $cow2->id,
                'partner_id'   => $partner->id,
                'shares'       => 1,
                'share_amount' => round($sharePrice2, 2),
            ]);
        }

        // Goat for first partner (single share)
        AnimalShare::create([
            'user_id'      => $user->id,
            'template_id'  => $template->id,
            'animal_id'    => $goat->id,
            'partner_id'   => $partners->first()->id,
            'shares'       => 1,
            'share_amount' => 18000.00,
        ]);

        // Create expenses
        $expense1 = Expense::create([
            'user_id'      => $user->id,
            'template_id'  => $template->id,
            'title'        => 'পরিবহন খরচ',
            'amount'       => 7000.00,
            'expense_date' => now()->subDays(3),
        ]);
        // Flat (equal) distribution
        $animals = collect([$cow1, $cow2, $goat]);
        $flatAmt = round(7000 / 3, 2);
        foreach ($animals as $a) {
            ExpenseDistribution::create([
                'expense_id' => $expense1->id, 'animal_id' => $a->id, 'method' => 'percent',
                'percentage' => round(100/3, 2), 'amount' => $flatAmt,
            ]);
        }

        $expense2 = Expense::create([
            'user_id'      => $user->id,
            'template_id'  => $template->id,
            'title'        => 'কসাই মজুরি',
            'amount'       => 5000.00,
            'expense_date' => now()->subDays(1),
        ]);
        $totalPurchase = $cow1->purchase_price + $cow2->purchase_price + $goat->purchase_price;
        foreach ($animals as $a) {
            $pct = ($a->purchase_price / $totalPurchase) * 100;
            ExpenseDistribution::create([
                'expense_id' => $expense2->id, 'animal_id' => $a->id, 'method' => 'percent',
                'percentage' => round($pct, 2), 'amount' => round(5000 * $pct / 100, 2),
            ]);
        }

        // Payments from partners
        $payments = [
            [$partners[0]->id, 20000],
            [$partners[1]->id, 15000],
            [$partners[2]->id, 14000],
            [$partners[3]->id, 14000],
            [$partners[4]->id, 14000],
            [$partners[5]->id, 14000],
            [$partners[6]->id, 14000],
            [$partners[7]->id, 0],
        ];

        foreach ($payments as [$partnerId, $amount]) {
            if ($amount > 0) {
                Payment::create([
                    'user_id'        => $user->id,
                    'template_id'    => $template->id,
                    'partner_id'     => $partnerId,
                    'amount'         => $amount,
                    'payment_date'   => now()->subDays(rand(1, 10)),
                    'payment_method' => ['cash', 'bank', 'mobile_banking'][rand(0, 2)],
                ]);
            }
        }

        $this->call([
            DefaultExpenseHeadsSeeder::class,
        ]);

        $this->command->info('✅ Demo data seeded successfully!');
        $this->command->info('   Email: demo@qurbani.app');
        $this->command->info('   Password: password');
    }
}
