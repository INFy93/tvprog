<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ClearController extends Controller
{
    public function index() //отображение странички с действиями
    {
        return view('cache');
    }

    public function clearCaches($action) //чистим кеш через Artisan::call
    {
        switch ($action) {
            case 'cache':
                Artisan::call('cache:clear'); //общий кеш
                break;

            case 'config':
                Artisan::call('config:clear'); //кеш конфигов
                break;

            case 'route':
                Artisan::call('route:clear'); //кеш роутов
                break;

            case 'view':
                Artisan::call('view:clear'); //кеш вьюшек
                break;

            default:
                Artisan::call('cache:clear'); //по дефолту чистим общий кеш
        }

        return Artisan::output();
    }
}
