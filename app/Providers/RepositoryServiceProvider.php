<?php
// app/Providers/RepositoryServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use App\Repositories\Implementations\ConcessionRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Implementations\OrderRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ConcessionRepositoryInterface::class, 
            ConcessionRepository::class,
        );

        $this->app->bind(
            OrderRepositoryInterface::class, 
            OrderRepository::class
        );
    }

    public function boot()
    {
        //
    }
}