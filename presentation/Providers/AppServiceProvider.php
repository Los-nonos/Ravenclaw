<?php

namespace Presentation\Providers;

use Application\Results\Customers\CreateCustomerResult;
use Application\Results\Customers\CreateCustomerResultInterface;

use Application\Results\Customers\IndexCustomerResult;
use Application\Results\Customers\IndexCustomerResultInterface;
use Application\Results\Users\UpdateUserResult;
use Application\Results\Users\UpdateUserResultInterface;
use Application\Services\CustomerService;
use Application\Services\CustomerServiceInterface;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use Domain\CommandBus\CommandBusInterface;
use Infrastructure\CommandBus\CommandBus;
use Infrastructure\Persistence\Doctrine\Repositories\CustomerRepository;
use Presentation\Http\Presenters\Customers\IndexCustomerPresenter;
use Presentation\Http\Presenters\Users\UpdateUserPresenter;
use Presentation\Http\Validators\Customers\CreateCustomerValidator;
use Presentation\Http\Validators\Customers\CreateCustomerValidatorInterface;

use Application\Services\UserService;
use Application\Services\UserServiceInterface;

use Presentation\Http\Presenters\Customers\CreateCustomerPresenter;
use Presentation\Http\Validators\Customers\IndexCustomerValidator;
use Presentation\Http\Validators\Customers\IndexCustomerValidatorInterface;
use Presentation\Http\Validators\Users\UpdateUserValidator;
use Presentation\Http\Validators\Users\UpdateUserValidatorInterface;
use Presentation\Interfaces\Customers\CreateCustomerPresenterInterface;

use Domain\Interfaces\Repositories\UserRepositoryInterface;
use Infrastructure\Persistence\Doctrine\Repositories\UserRepository;

use Presentation\Interfaces\Customers\IndexCustomerPresenterInterface;
use Presentation\Interfaces\Users\UpdateUserPresenterInterface;
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
        /**
         *  Services
         */
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind(CustomerServiceInterface::class, CustomerService::class);

        /**
         * Command Bus
         */
        $this->app->bind(CommandBusInterface::class, CommandBus::class);

        /**
         * Repositories
         */
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        /**
         * Presenters
         */
        $this->app->bind(CreateCustomerPresenterInterface::class, CreateCustomerPresenter::class);

        $this->app->bind(UpdateUserPresenterInterface::class, UpdateUserPresenter::class);

        $this->app->bind(IndexCustomerPresenterInterface::class, IndexCustomerPresenter::class);

        /**
         * Results
         */
        $this->app->bind(CreateCustomerResultInterface::class, CreateCustomerResult::class);

        $this->app->bind(UpdateUserResultInterface::class, UpdateUserResult::class);

        $this->app->bind(IndexCustomerResultInterface::class, IndexCustomerResult::class);

        /**
         * Validators
         */
        $this->app->bind(
            CreateCustomerValidatorInterface::class,
            CreateCustomerValidator::class
        );

        $this->app->bind(UpdateUserValidatorInterface::class, UpdateUserValidator::class);

        $this->app->bind(IndexCustomerValidatorInterface::class, IndexCustomerValidator::class);

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
