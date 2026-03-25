<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('sync:all')->dailyAt('02:00');
Schedule::command('sync:all')->dailyAt('14:00');

// Schedule::command('als:fetch-content')->hourly();
