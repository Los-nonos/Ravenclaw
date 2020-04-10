<?php

namespace Presentation\Providers;

use Domain\Interfaces\Repositories\CustomerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use Domain\CommandBus\CommandBusInterface;
use Infrastructure\CommandBus\CommandBus;
use Infrastructure\Persistence\Doctrine\Repositories\CustomerRepository;
use Presentation\Http\Validators\Customers\CreateCustomerValidator;
use Presentation\Http\Validators\Customers\CreateCustomerValidatorInterface;

use Application\Services\UserService;
use Application\Services\UserServiceInterface;

use Presentation\Http\Presenters\Customers\CreateCustomerPresenter;
use Presentation\Interfaces\Customers\CreateCustomerPresenterInterface;

use Domain\Interfaces\Repositories\UserRepositoryInterface;
use Infrastructure\Persistence\Doctrine\Repositories\UserRepository;

use Presentation\Interfaces\ValidatorServiceInterface;
use Presentation\Services\ValidatorService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind(CommandBusInterface::class, CommandBus::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        $this->app->bind(CreateCustomerPresenterInterface::class, CreateCustomerPresenter::class);

        $this->app->bind(
            CreateCustomerValidatorInterface::class,
            CreateCustomerValidator::class
        );

        $this->app->bind(ValidatorServiceInterface::class, ValidatorService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
