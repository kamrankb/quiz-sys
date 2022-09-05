<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\BrandSettings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('brand_name', function(){
            return BrandSettings::where("key_name", '=', "company_name")->first()->key_value;
        });

        view()->composer('*', function($view) {
            $data["brand_settings"] = array(
                "logo" => BrandSettings::where("key_name", '=', "logo")->first(),
                "logo_white" => BrandSettings::where("key_name", '=', "logo_white")->first(),
                "favicon" => BrandSettings::where("key_name", '=', "favicon")->first(),
                "company_alias" => BrandSettings::where("key_name", '=', "company_alias")->first(),
                "company_name" => BrandSettings::where("key_name", '=', "company_name")->first(),
                "company_email" => BrandSettings::where("key_name", '=', "company_email")->first(),
                "company_number" => BrandSettings::where("key_name", '=', "company_phone")->first(),
                "company_address" => BrandSettings::where("key_name", '=', "company_address")->first(),
                "custom_footer" => BrandSettings::where("key_name", '=', "customfooter")->first(),
            );

            $data["brand_name"] = $data["brand_settings"]["company_name"]->key_value;

            if (Auth::check()) {
                $user = Auth::user();
                $data["user"] = $user;
            }

            $view->with($data);
        });
    }
}
