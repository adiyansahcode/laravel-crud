<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add([
                'header' => 'mainNavigation'
            ]);
            $event->menu->add([
                'text' => 'dashboard',
                'url' => '/home',
                'icon' => 'fas fa-fw fa-tachometer-alt'
            ]);
            $event->menu->add([
                'key' => 'bookSetting',
                'text' => 'bookSetting',
                'url' => '#',
                'icon' => 'fas fa-fw fa-book'
            ]);
            $event->menu->addIn('bookSetting', [
                'text' => 'book',
                'url' => '/book',
                'active' => ['book', 'book/*']
            ]);
            $event->menu->addIn('bookSetting', [
                'text' => 'category',
                'url' => '#',
            ]);
            $event->menu->addIn('bookSetting', [
                'text' => 'author',
                'url' => '#',
            ]);
            $event->menu->addIn('bookSetting', [
                'text' => 'publisher',
                'url' => '#',
            ]);
        });
    }
}
