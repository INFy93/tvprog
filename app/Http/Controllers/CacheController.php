<?php

namespace App\Http\Controllers;

use App\Models\CachedChannels;
use App\Models\Itv;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function index()
    {
        $cache_count = CachedChannels::count(); //количество записей в кеширующей таблице
        $orig_count = Itv::count(); //количество записей в оригинальной таблице

        $orig = Itv::select('name', 'number')->get()->toArray();
        $cached = CachedChannels::select('name', 'number')->get()->toArray(); //получаем данные из двух таблиц в виде массива, а не коллекцию
        $diff = array_diff(array_map('serialize', $cached), array_map('serialize', $orig)); //сравниваем, используя сериализацию, т.к. массив многомерный

        if (sizeof($diff) == 0) { //проверяем наличие элементов в переменной-"разнице", формируем цвета и вывод
            $msg = 'Да';
            $color = 'green';
        } else {
            $msg = 'Нет';
            $color = 'red';
        }

        $info = [ //массив с нужными данными для отображения состояния кеширующей таблицы
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
