<?php

namespace App\Http\Controllers;

use App\Models\CachedChannels;
use Illuminate\Http\Request;
use DB;
use App\Models\Itv;
use App\Models\Tariff;
use Illuminate\Support\Facades\Http;

class TariffController extends Controller
{
    public function getChannelByTariff($id) //выводим список каналов в зависимости от пакета
    {
        if ($id == 1) { //переменная для формирования столбцов и выделения каналов в данной категории
                $rows = [
                    'count' => 3,
                    'div' => 4,
                    'caregory_channels' => 0
                ];
            } else {
                $rows = [
                    'count' => 4,
                    'div' => 3,
                    'caregory_channels' => $id
                ];
            }

            $channel_list = CachedChannels::where('category', '<=', $id)->orderBy('number')->get();
            //dd($channel_list);
            $brake_point = ceil($channel_list->count() / $rows['count']); //считаем, сколько каналов у нас будет в каждом столбце

            return view('t-list', ['channels' => $channel_list, 'rows' => $rows])->with('brake', $brake_point);
   }
}
