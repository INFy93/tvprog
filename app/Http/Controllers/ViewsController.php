<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CachedChannels;
use App\Models\Option;
use Illuminate\Support\Facades\Http;

class ViewsController extends Controller
{
    public function index()
    {
        $rank_array = json_decode(Http::get(env('VIEWS_URL', 0)), true); //получаем массив с просмотрами
        if($rank_array)
        {
            $max_category = CachedChannels::max('category');
            $min_channel_rate = Option::where('name', 'min_channel_rate')->first(); //минимальный %
            $channel_array = array(); //массив для результата
            $sum_array = array(0); //массив для сумм
            $i = 0; //переменная - счетчик и индексы
            $sum = 0;
            foreach($rank_array as $key => $value)
            {
                $channel = CachedChannels::
                    where('cmd', 'like', '%' . $key . '%')
                    ->first(); //запрос для получения канала
                if($channel) //не добавляем не существующие каналы
                {
                    $channel_array[$i] = $channel;
                    $channel_array[$i]['views'] = $value; //добавляем в массив кол-во просмотров
                    if (!isset($sum_array[$channel_array[$i]['category']-1])) {
                        $sum_array[$channel_array[$i]['category']-1] = 0;
                    }
                    $sum_array[$channel_array[$i]['category']-1] += $value;
                }

                $i++;
            }
           $poltora_zemlekopa = $sum_array[0] * $min_channel_rate->value;

            $channel_array = collect($channel_array); //коллекционируем

            $start = $channel_array->where('category', 1)->where('views', '>=', $sum_array[0] * $min_channel_rate->value)->sortByDesc('views'); //старт
            $baza = $channel_array->where('category', 2)->where('views', '>=', $sum_array[1] * $min_channel_rate->value)->sortByDesc('views')->take(5); //базовый
            $premium = $channel_array->where('category', 3)->where('views', '>=', $sum_array[2] * $min_channel_rate->value)->sortByDesc('views')->take(2); //премиум HDTV
            $tv1000 = $channel_array->where('category', 4)->where('views', '>=', $sum_array[3] * $min_channel_rate->value)->sortByDesc('views')->take(2); //TV1000

           //dd($start);
        }

        return view('rank', compact('start', 'baza', 'premium', 'tv1000'));
    }
}
