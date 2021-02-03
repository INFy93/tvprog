<?php
namespace App\Helpers;
use App\Models\Epg;
use App\Models\Itv;
use App\Models\Logos;

class ProgrammList {
        public static function getBeforeProgramm($id) {
            $time = date("Y-m-d H:i:s");
            $epg = Epg::select('id', 'ch_id', 'time', 'time_to', 'name', 'descr')
            ->where([
                ['ch_id', '=', $id],
                ['time', '<', $time]
            ])
            ->limit(3)
            ->orderBy('time', 'desc')
            ->get();

            $epg = $epg->reverse();
            $epg->pop();
            return $epg;
        }

        public static function getCurrentProgramm($id) {

            $time = date("Y-m-d H:i:s");
            $epg = Epg::select('id', 'ch_id', 'time', 'time_to', 'name', 'descr', 'duration')
            ->where([
                ['ch_id', '=', $id],
                ['time', '<=', $time],
                ['time_to', '>', $time]
            ])
            ->orderBy('time', 'desc')
            ->first();
            if ($epg)
            {
                $diff = ( (strtotime($time) - strtotime($epg->time)) / (strtotime($epg->time_to) - strtotime($epg->time)) )*100; //находим процент прогресса текущей передачи
            $progress = round($diff); //округляем
            return [
                'epg' => $epg,
                'progress' => $progress
            ];
            }
        }

        public static function getAfterProgramm($id, $limit_key) {
            $time = date("Y-m-d H:i:s");
            if ($limit_key == 1) {
                $epg = Epg::select('id', 'ch_id', 'time', 'time_to', 'name', 'descr')
                ->where([
                    ['ch_id', '=', $id],
                    ['time', '>', $time]
                ])
                ->limit(4)
                ->orderBy('time', 'asc')
                ->get();

            } else if ($limit_key == 0) {
                $epg = Epg::select('id', 'ch_id', 'time', 'time_to', 'name', 'descr')
                ->where([
                    ['ch_id', '=', $id],
                    ['time', '>', $time]
                ])
                ->orderBy('time', 'asc')
                ->get();
            }
            return $epg;
        }
}

class Helpers {
        public static function correctDate($month, $day) {
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

            return $month_name.$week_day;
        }

        public static function getLogo($channel_id) {
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
