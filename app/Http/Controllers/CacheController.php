<?php

namespace App\Http\Controllers;

use App\Models\CachedChannels;
use App\Models\Itv;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function index()
    {
        $cache_count = CachedChannels::count();
        $orig_count = Itv::count();

        $orig = Itv::select('name', 'number')->get();
        $diff = $orig->diff(CachedChannels::select('name', 'number')->get());

        if (sizeof($diff) == 0) {
            $msg = 'Да';
            $color = 'green';
        } else {
            $msg = 'Нет';
            $color = 'red';
        }

        $info = [
            'cache_count' => $cache_count,
            'orig_count' => $orig_count,
            'diff' => $msg,
            'color' => $color
        ];

        return view('cache-table', ['info' => $info]);
    }

    public function updateCacheTable()
    {
        CachedChannels::truncate(); //сперва очищаем таблицу

        $channels = json_decode(\Tariffs::getActualChannels()); //получаем массив с каналами

        $i = 0; //переменная для перебора
        $query_array = array();

        while ($i < count($channels)) //готовим массив для заполнения кеширующей таблицы
        {
            $query_array[] = array(
                'number' => $channels[$i]->number,
                'name' => $channels[$i]->channel_name,
                'category' => $channels[$i]->category,
                'logo' => $channels[$i]->logo_path
            );

            $i++;
        }

        CachedChannels::insert($query_array);

        toastr()->success('Кеширующая таблица успешно обновлена!');

        return redirect()->route('cache-table');
    }
}
