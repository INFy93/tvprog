<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
  public function setCookie($id) { //добавляем куку на год

    if (\Cookie::get('channel') == 0) { //если кука пустая - то создаем ее сроком на 1 год
      \Cookie::queue('channel', $id, time()+60*60*24*365);

    } else {
      $channels_favour = \Cookie::get('channel');
      $cookie_array = explode(",", $channels_favour);
        if (in_array($id, $cookie_array)) {
          \Cookie::get('channel');
        } else {
          $fav_channels = \Cookie::get('channel'); //а если не пустая, до дописываем канал через запятую
          \Cookie::queue('channel', $fav_channels.','.$id, time()+60*60*24*365);
        }
    }
  }

  public function deleteChannelFromCookie($id) {
    if (\Cookie::get('channel') != 0) { //чистим только если есть что-то в куках
      $channels_favour = \Cookie::get('channel');
      $cookie_array = explode(",", $channels_favour); //представляем запись в куках как массив
      $size_of_array = sizeof($cookie_array); //берем его размер
        if ($size_of_array == 1) { //если у нас одинокая (как и ты) кука, то...
          \Cookie::queue('channel', null); //прощаемся с кукой
        } else if ($size_of_array > 1) { //а если в куке что-то есть, то убираем канал
          if (in_array($id, $cookie_array)) {
            $key = array_search($id, $cookie_array); //ищем нашу куку
              if ($key != false) { //проверка корректности получения ключа
                unset($cookie_array[$key]); //удаляем канал
                $new_favour = implode(",", $cookie_array); //формируем новые куки с удаленным каналом
                \Cookie::queue('channel', $new_favour, time()+60*60*24*365); //готово!
              }

            }
        }
  }
}
}
