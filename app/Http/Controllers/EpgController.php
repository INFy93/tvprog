<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Epg;
use App\Models\Itv;
use App\Models\Logos;

class EpgController extends Controller
{
    //здесь мы творим дичь с телепрограммой :D

    public function getProgram($id) {
      $epg = Epg::where('ch_id', '=', $id)->first();
      $channel = Itv::where('id', '=', $id)->first();
      $logo = Logos::where('ch_id', '=', $id)
      ->first();
      return view('program', ['epg' => $epg, 'channel' => $channel, 'logo' => $logo]);
    }

    public function getDescr($id) { //получаем описание программы (для ajax)
      $descr = Epg::select('time', 'time_to', 'name', 'descr')
      ->where('id', '=', $id)
      ->first();

      return $descr->toJson();
    }

    public function getDescrCurrent($id) { //получаем описание программы с картинкой (для ajax)
      $descr = Epg::
        leftJoin('itv', function($join) {
            $join->on('itv.id', '=', 'epg.ch_id');
        })
        ->where('epg.id', '=', $id)
        ->select('epg.time as time', 'epg.time_to as time_to', 'epg.name as name', 'epg.descr as descr', 'itv.number as number')
        ->first();

      return $descr->toJson();
    }
}
