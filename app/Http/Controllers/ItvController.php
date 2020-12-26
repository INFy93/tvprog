<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Itv;
use App\Models\Epg;
use App\Models\TV_Genre;
class ItvController extends Controller
{
    public function getChannelData() { //функция отображения всех телеканалов с логотипами

      $itv = Itv::
        leftJoin('logos', function ($join) {
            $join->on('logos.ch_id', '=', 'itv.id');
        })
        ->select ('itv.id AS channel_id', 'itv.name AS channel_name', 'itv.tv_genre_id as genre_id', DB::raw( 'IFNULL(logos.path, "images/no_logo.png") as logo_path' ))
        ->orderBy('itv.number', 'asc')
        ->get();


        $genres = TV_Genre::
        orderBy('number')
        ->get();

      return view('home', ['channels' => $itv, 'genres' => $genres]);
    }

    public function getGenres() {
      $genres = TV_Genre::
      orderBy('number')
      ->get();

      return view('home', ['genres' => $genres]);
    }

}
