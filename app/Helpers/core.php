<?php

namespace App\Helpers;

use DB;
use App\Models\Epg;
use App\Models\Itv;
use App\Models\Logos;

class ProgramList
{
    public static function getProgram($id, $key = 1)
    {
        switch ($key) {
            case 0:
                $limit = '';
                break;
            case 1:
                $limit = 'limit 4';
                break;

            default:
                $limit = 4;
        }

        $query = DB::select('(select \'previous\' as \'order\', id, ch_id, time, time_to, name, length(descr) as descr_len from epg where ch_id = ' . $id . ' and time < now() and time_to < now() order by time desc limit 2) union (select \'current\' as \'order\', id, ch_id, time, time_to, name, length(descr) as descr_len from epg where ch_id = ' . $id . ' and time <= now() and time_to > now() order by time desc limit 1) union (select \'next\' as \'order\', id, ch_id, time, time_to, name, length(descr) as descr_len from epg where ch_id = ' . $id . ' and time > now() order by time asc ' . $limit . ') order by time');
        $query = collect($query);

        return $query;
    }

    public static function getProgress($time, $time_to)
    {
        $diff = ((strtotime('now') - strtotime($time)) / (strtotime($time_to) - strtotime($time))) * 100; //находим процент прогресса текущей передачи
        $progress = round($diff); //округляем

        return $progress;
    }
}

class Helpers
{
    public static function correctDate($month, $day)
    {
        //формируем массив с корректными названиями месяцев
        $month_array = [
            ' января',
            ' февраля',
            ' марта',
            ' апреля',
            ' мая',
            ' июня',
            ' июля',
            ' августа',
            ' сентября',
            ' октября',
            ' ноября',
            ' декабря'
        ];

        //так как месяцы начинаются с 1, а элементы массива с 0, делаем поправку
        $month_correct = $month - 1;

        //формируем красивый вывод месяца
        $month_name = $month_array[$month_correct];

        //массив с правильными названиями дней недели
        $day_array = [
            ', понедельник',
            ', вторник',
            ', среда',
            ', четверг',
            ', пятница',
            ', суббота',
            ', воскресенье'
        ];

        //аналогичная поправка как с массивом месяцев
        $day_correct = $day - 1;

        //красиво выводим
        $week_day = $day_array[$day_correct];

        return $month_name . $week_day;
    }

    public static function getLogo($channel_id)
    {
        $logo = Logos::where('ch_id', $channel_id)->first();

        return $logo;
    }

    public static function getFavourSet($channel_id, $cookie_set) //формируем тип картинки, класс ссылки и блок для избранного
    {
        if (in_array($channel_id, $cookie_set)) {
            $picture = 'favour_active';
            $link_class = 'delete_favour';
            $div = 'favour';
        } else {
            $picture = 'favour_ready';
            $link_class = 'add_favour';
            $div = '';
        }

        return $favour_set = [
            'picture' => $picture,
            'link' => $link_class,
            'div' => $div
        ];
    }

    public static function checkLogo($logo)
    {
        if ($logo) {
            $path = $logo->path;
        } else {
            $path = 'images/no_logo.png';
        }

        return $path;
    }
}

class Tariff
{
    public static function zeroFill($tech_id)
    {
        return str_pad($tech_id, 3, "0", STR_PAD_LEFT);
    }
}
