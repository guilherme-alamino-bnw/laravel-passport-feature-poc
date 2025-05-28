<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Passport::enablePasswordGrant();

        Passport::tokensExpireIn(now()->addDays(15));

        Passport::tokensCan(
            [
            'user.master:read' => 'Acesso para leitura de todos os usuários',
            'user:read' => 'Ler dados do usuário',
            'user:write' => 'Alterar dados do usuário',
            'admin.metrics:read' => 'Acesso administrativo para leitura de métricas',
            ]
        );
    }
}
