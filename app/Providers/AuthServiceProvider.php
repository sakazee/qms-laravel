<?php

namespace App\Providers;

use App\Models\Animal;
use App\Models\Expense;
use App\Models\Partner;
use App\Models\Payment;
use App\Models\Template;
use App\Policies\AnimalPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\PartnerPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\TemplatePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Template::class => TemplatePolicy::class,
        Animal::class   => AnimalPolicy::class,
        Partner::class  => PartnerPolicy::class,
        Expense::class  => ExpensePolicy::class,
        Payment::class  => PaymentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
