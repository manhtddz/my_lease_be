<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:run-example-batch')
    ->dailyAt('01:00')
    ->withoutOverlapping()
    ->onOneServer();


