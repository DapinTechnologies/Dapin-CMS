<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\Paginator;
use App\Models\Web\TopbarSetting;
use App\Models\Web\SocialSetting;
use App\Models\ScheduleSetting;
use App\Models\Web\Page;
use App\Models\Language;
use App\Models\Setting;
use View;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // Fetch common data and handle possible null values
        $user_languages = Language::where('status', '1')->get();
        $setting = Setting::where('status', '1')->first();
        $topbarSetting = TopbarSetting::where('status', '1')->first();
        $socialSetting = SocialSetting::where('status', '1')->first();
        $schedule_setting = ScheduleSetting::where('slug', 'fees-schedule')->first();
        
        // Check if language version is available
        $language = Language::version();
        $footer_pages = $language 
            ? Page::where('language_id', $language->id)
                  ->where('status', '1')
                  ->orderBy('id', 'asc')
                  ->get() 
            : collect();  // Use an empty collection if no language is found

        // Set Time Zone if $setting is available
        if ($setting && $setting->time_zone) {
            Config::set('app.timezone', $setting->time_zone);
        }

        // Share data with views
        View::share([
            'setting' => $setting, 
            'user_languages' => $user_languages, 
            'schedule_setting' => $schedule_setting, 
            'topbarSetting' => $topbarSetting, 
            'socialSetting' => $socialSetting, 
            'footer_pages' => $footer_pages
        ]);
    }

    
}
