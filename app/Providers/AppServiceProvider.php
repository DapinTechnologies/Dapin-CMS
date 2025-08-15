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
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // Prevent DB queries from running during artisan commands
        if (!App::runningInConsole()) {
            try {
                // Ensure the DB connection works before querying
                DB::connection()->getPdo();

                // Fetch common data and handle possible null values
                $user_languages = Schema::hasTable('languages') 
                    ? Language::where('status', '1')->get() 
                    : collect();

                $setting = Schema::hasTable('settings') 
                    ? Setting::where('status', '1')->first() 
                    : null;

                $topbarSetting = Schema::hasTable('topbar_settings') 
                    ? TopbarSetting::where('status', '1')->first() 
                    : null;

                $socialSetting = Schema::hasTable('social_settings') 
                    ? SocialSetting::where('status', '1')->first() 
                    : null;

                $schedule_setting = Schema::hasTable('schedule_settings') 
                    ? ScheduleSetting::where('slug', 'fees-schedule')->first() 
                    : null;

                $language = Schema::hasTable('languages') ? Language::version() : null;

                $footer_pages = ($language && Schema::hasTable('pages'))
                    ? Page::where('language_id', $language->id)
                        ->where('status', '1')
                        ->orderBy('id', 'asc')
                        ->get()
                    : collect();

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

            } catch (QueryException $e) {
                Log::error('Database query failed in AppServiceProvider: ' . $e->getMessage());
            } catch (\Exception $e) {
                Log::error('Database connection failed in AppServiceProvider: ' . $e->getMessage());
            }
        }
    }
}
