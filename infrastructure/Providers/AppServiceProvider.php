<?php

namespace Infrastructure\Providers;

use Application\Services\Admins\AdminService;
use Application\Services\Admins\AdminServiceInterface;
use Application\Services\HashService\HashService;
use Application\Services\HashService\HashServiceInterface;
use Illuminate\Foundation\Application;
use Application\EventData\EmailNotificationEventData;
use Application\Services\Customer\CustomerService;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Notifiable\NotifiableService;
use Application\Services\Notifiable\NotifiableServiceInterface;
use Domain\Interfaces\Repositories\AdminRepositoryInterface;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;
use Domain\Interfaces\Services\Notifications\MailableInterface;
use Domain\Interfaces\Services\Notifications\NotifiableInterface;
use Domain\ValueObjects\Notifiable;
use Illuminate\Support\ServiceProvider;

use Infrastructure\Cache\Provider\Redis\RedisProvider;
use Infrastructure\CommandBus\CommandBusInterface;
use Infrastructure\CommandBus\CommandBus;
use Infrastructure\Persistence\Repositories\AdminRepository;
use Infrastructure\Persistence\Repositories\CustomerRepository;

use Application\Services\Users\UserService;
use Application\Services\Users\UserServiceInterface;

use Domain\Interfaces\Repositories\UserRepositoryInterface;
use Infrastructure\Persistence\Repositories\UserRepository;

use Presentation\Http\Validators\Utils\ValidatorServiceInterface;
use Presentation\Http\Validators\Utils\ValidatorService;
use Psr\Cache\CacheItemPoolInterface;
use Redis;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HashServiceInterface::class, HashService::class);

        $this->app->singleton(Redis::class, function (Application $application) {
            $client = new Redis();

            $config = $application->make('config')->get('database.redis.cache');

            if (! $client->connect($config['host'], (int) $config['port'])) {
                throw new \Exception("Could not connect to Redis at {$config['host']}:{$config['port']}");
            }

            return $client;
        });
        $this->app->bind(CacheItemPoolInterface::class, RedisProvider::class);

        /**
         *  Services
         */
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind(CustomerServiceInterface::class, CustomerService::class);

        $this->app->bind(AdminServiceInterface::class, AdminService::class);

        /**
         * Repositories
         */
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);

        /**
         * Validators
         */
        $this->app->bind(ValidatorServiceInterface::class, ValidatorService::class);

        /**
         * Mailing
         */
        $this->app->bind(NotifiableServiceInterface::class, NotifiableService::class);
        $this->app->bind(MailableInterface::class, EmailNotificationEventData::class);
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
