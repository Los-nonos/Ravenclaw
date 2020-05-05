<?php
declare(strict_types=1);

namespace Infrastructure\Providers;

use Domain\Interfaces\Repositories\AdminRepositoryInterface;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;
use Domain\Interfaces\Repositories\TokenRepositoryInterface;
use Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Persistence\Repositories\AdminRepository;
use Infrastructure\Persistence\Repositories\CustomerRepository;
use Infrastructure\Persistence\Repositories\TokenRepository;
use Infrastructure\Persistence\Repositories\UserRepository;

final class DoctrineRepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TokenRepositoryInterface::class, TokenRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
    }
}
