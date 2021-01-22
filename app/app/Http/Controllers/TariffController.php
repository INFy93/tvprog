<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Itv;
use App\Models\Tariff;
use Illuminate\Support\Facades\Http;

class TariffController extends Controller
{
    public function getChannelByTariff($id) //выводим список каналов в зависимости от пакета
    {
        $tariff = Tariff::where('id', $id)->first(); //получаем название тарифа
        $array_with_tariffs = json_decode(Http::get('http://horse.crimeastar.net/test.php?get_channels_categories'), true); //получаем и декодируем массив из json
        //говнокод
        $temp_array = array(); //временный массив для наполнения основного массива
        $current_cat = array(); //основной массив
        $i = $id;
            while ($i <> 0) //наполняем массив
            {
                $temp_array = array_keys($array_with_tariffs, $i); //помещаем в temp_array каналы из текущего пакета...

                $current_cat[] = $temp_array; //...и формируем полный список каналов по формуле "ID пакета <= запрошенного"
                $i--; //уменьшаем i
            }

       // dd(array_reverse($current_cat)); //отладка


        $channel_list = array(); //массив для результата
        $j = 0; //счетчик

        if ($id == 1) { //переменная для формирования столбцов
            $rows = [
                'count' => 3,
                'div' => 4
            ];
        } else {
            $rows = [
                'count' => 4,
                'div' => 3
            ];
        }
        foreach ($current_cat as $channel_array)
        {
            foreach ($channel_array as $key=>$value) //перебор массива + запрос
            {
            $channel_data = Itv::
            leftJoin('logos', function ($join) {
                $join->on('logos.ch_id', '=', 'itv.id');
            })
            ->where('itv.cmd', 'like', '%channel-'.\Tariff::zeroFill($value).'%')
            ->select ('itv.id AS channel_id', 'itv.name AS channel_name', 'itv.tv_genre_id as genre_id', DB::raw( 'IFNULL(logos.path, "images/no_logo.png") as logo_path' ))
            ->orderBy('itv.number', 'asc')
            ->first();

            $channel_list[$j] = $channel_data; //формируем массив с необходимыми каналами
            $j++;
            }
        }
        //dd($channel_list);

        $brake_point = ceil(count($channel_list) / $rows['count']); //считаем, сколько каналов у нас будет в каждом столбце

        return view('t-list', ['channels' => $channel_list, 'tariff' => $tariff, 'rows' => $rows])->with('brake', $brake_point);
    }
}
