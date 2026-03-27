<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('sync:all')->dailyAt('02:00');
Schedule::command('sync:all')->dailyAt('14:00');

// Temporary hack removed.

// RSS Haber Akışı (Günde iki kez)
Schedule::command('app:sync-rss')->dailyAt('06:00');
Schedule::command('app:sync-rss')->dailyAt('18:00');
