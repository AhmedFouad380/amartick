<?php

namespace App\Providers;

use App\Models\Inbox;
use App\Models\LoginLog;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Kreait\Firebase\Factory;

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
//        ob_start();
        $languages = ['ar', 'en'];
        App::setLocale('ar');
        date_default_timezone_set('Asia/Riyadh');


//        View::share('getadmins_mail', $getadmins_mail);
        View::share('orderNotifications', Order::where('type', 'Pending')->where('created_at', '<', Carbon::now()->subDay())->OrderBy('id', 'desc')->take(10)->get());
        View::share('inboxes_count', Inbox::where('receiver_type', 'admin')->where('is_read', 0)->OrderBy('id', 'desc')->get());
        View::share('orderNotifications_count', Order::where('type', 'Pending')->where('created_at', '<', Carbon::now()->subDay())->OrderBy('id', 'desc')->get());
        View::share('Login_logs', LoginLog::OrderBy('id', 'desc')->take(10)->get());

        $languages = ['ar', 'en'];

        $lang = request()->header('lang');
        if ($lang) {
            if (in_array($lang, $languages)) {
                App::setLocale($lang);
            } else {
                App::setLocale('ar');
            }
        }

    }
}
