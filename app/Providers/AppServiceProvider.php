<?php

namespace App\Providers;

use App\Models\Setting;
use App\Rules\StepCanExpire;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\ChequeRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Eloquent\BordereauRepository;
use App\Repositories\Contracts\IUserRepositoryContract;
use App\Repositories\Contracts\IChequeRepositoryContract;
use App\Repositories\Contracts\IProductRepositoryContract;
use App\Repositories\Contracts\IBordereauRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(IBordereauRepositoryContract::class, BordereauRepository::class);
        $this->app->bind(IChequeRepositoryContract::class, ChequeRepository::class);
        $this->app->bind(IUserRepositoryContract::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Laravel Macros are great way of extending Laravel's core classes and add extra functionality
         * required for our application.
         * It is a way to add somme missing functionality to Laravel's internal component with a piece of code
         * that doesn't exist in the Laravel class.
         *
         * Blueprint is macroable, so we can just define a macro on it in this service provider to get base fields
         */
        Blueprint::macro('baseFields', function () {
            $this->uuid('uuid');
            $this->string('tags')->nullable()->comment('Tags, if any');
            $this->foreignId('status_id')->nullable()
                ->comment('status reference')
                ->constrained('statuses')->onDelete('set null');
            $this->boolean('is_default')->default(false)->comment('determine whether is the default one.');
            $this->timestamps();
        });
        Blueprint::macro('dropBaseForeigns', function () {
            $this->dropForeign(['status_id']);
        });

        JsonResource::withoutWrapping();

        /**
         * tell Laravel that, when the App boots,
         * which is after all other Services are already registered,
         * we are gonna add to the config array our own settings
         */
        config([
            'Settings' => Setting::getAllGrouped()
        ]);

        /*Validator::extend('stepcanexpire_if', function($attribute, $value, $parameters, $validator) {
            $rule = new StepCanExpire($parameters[0]);

            return $rule->passes($attribute, $value);
        });*/
    }
}
