<?php

namespace Database\Seeders;

use App\Models\ExpenseHead;
use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultExpenseHeadsSeeder extends Seeder
{
    public function run(): void
    {
        $heads = [
            // Feed & Care
            ['name' => 'খাদ্য',           'desc' => 'পশুর খাদ্য (ঘাস, খড়, ভুসি ইত্যাদি)',                   'color' => '#059669'],
            ['name' => 'পানি',           'desc' => 'পানি সরবরাহ ও পানির খরচ',                              'color' => '#0284c7'],
            ['name' => 'খনিজ লবণ',       'desc' => 'লবণ ও খনিজ সাপ্লিমেন্ট',                               'color' => '#059669'],
            ['name' => 'ভিটামিন/সাপ্লিমেন্ট', 'desc' => 'ভিটামিন ও পুষ্টি সাপ্লিমেন্ট',                'color' => '#059669'],

            // Medical
            ['name' => 'চিকিৎসা',         'desc' => 'পশুর চিকিৎসা ও ঔষধ',                                  'color' => '#e11d48'],
            ['name' => 'ভ্যাকসিন',        'desc' => 'টিকা ও প্রতিরোধমূলক টিকাদান',                          'color' => '#e11d48'],
            ['name' => 'পরীক্ষা/ল্যাব',   'desc' => 'রক্ত পরীক্ষা, মল পরীক্ষা ইত্যাদি',                       'color' => '#e11d48'],

            // Infrastructure
            ['name' => 'শেড নির্মাণ',      'desc' => 'পশুর আবাসন/শেড নির্মাণ ব্যয়',                          'color' => '#475569'],
            ['name' => 'শেড রক্ষণাবেক্ষণ','desc' => 'শেডের মেরামত ও রক্ষণাবেক্ষণ',                            'color' => '#475569'],
            ['name' => 'বাঁশ/পাট ব্যবহার', 'desc' => 'বাঁশ, পাট, দড়ি ইত্যাদি',                               'color' => '#475569'],

            // Operations
            ['name' => 'পরিবহন',          'desc' => 'পশু পরিবহন ও লোডিং/আনলোডিং',                           'color' => '#d97706'],
            ['name' => 'শ্রম/মজুরি',      'desc' => 'শ্রমিক ও দিনমজুরি',                                    'color' => '#7c3aed'],
            ['name' => 'স্থান ভাড়া',      'desc' => 'জমি/স্থান ভাড়া',                                        'color' => '#475569'],
            ['name' => 'কসাই মজুরি',      'desc' => 'কসাই ও কোরবানি প্রস্তুতি',                                'color' => '#7c3aed'],

            // Packaging & Storage
            ['name' => 'প্যাকেজিং',       'desc' => 'পলিথিন, ব্যাগ, দড়ি ইত্যাদি',                            'color' => '#7c3aed'],
            ['name' => 'ফ্রিজ/সংরক্ষণ',   'desc' => 'ফ্রিজ/ফ্রিজার ভাড়া ও বিদ্যুৎ খরচ',                      'color' => '#0284c7'],

            // Sales
            ['name' => 'বিক্রয় খরচ',     'desc' => 'বিক্রয় সংক্রান্ত খরচ',                                   'color' => '#d97706'],
            ['name' => 'স্টল/বাজার ভাড়া', 'desc' => 'বিক্রয় স্টল/বাজারের ভাড়া',                              'color' => '#d97706'],

            // General
            ['name' => 'আনুষ্ঠানিক',      'desc' => 'দোয়া, মাহফিল ও আনুষ্ঠানিক খরচ',                        'color' => '#059669'],
            ['name' => 'অন্যান্য',         'desc' => 'অন্যান্য খরচ',                                           'color' => '#475569'],
        ];

        $users = User::all();

        foreach ($users as $user) {
            foreach ($heads as $i => $head) {
                $exists = ExpenseHead::where('user_id', $user->id)
                                     ->where('name', $head['name'])
                                     ->exists();
                if (!$exists) {
                    ExpenseHead::create([
                        'user_id'     => $user->id,
                        'name'        => $head['name'],
                        'description' => $head['desc'],
                        'color'       => $head['color'],
                    ]);
                }
            }
        }

        $this->command->info("✅ {$users->count()} user(s) seeded with " . count($heads) . " expense heads.");
    }
}