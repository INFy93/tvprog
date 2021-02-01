<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LogoRequest;
use App\Models\Logos;
use App\Models\Itv;
use DB;
use Illuminate\Support\Facades\Auth;

class LogoController extends Controller {



    public function submit($id, Request $request) { //добавляем новый логотип

      $logo = new Logos;
   if ($request->has('logo')) {
    $extension = $request->file('logo')->getClientOriginalExtension(); //получаем расширение файла
        $path = $request->file('logo')->storeAs('logos', 'channel'.$id.'.'.$extension, 'public'); //загружаем его
        $logo->ch_id = $id;
        $logo->path = $path;

        $logo->save();

        return redirect()->route('logo_show')->with('success', 'Логотип успешно добавлен');
      } else {
        return redirect()->route('logo_show')->with('error', 'Ошибка добавления логотипа: файл не найден. Забыли выбрать файл?');

      }
    }
      public function allLogos() { //отображаем табличку с логотипами
        $logo = Itv::
        leftJoin('logos', function ($join) {
            $join->on('itv.id', '=', 'logos.ch_id');
        })
        ->select('itv.id AS channel_id', 'itv.number AS channel_number', 'itv.name AS channel_name', DB::raw( 'IFNULL(logos.path, "images/no_logo.png") as logo_path' ))
        ->orderBy('itv.number', 'asc')
        ->get();
        return view('logos', ['logos' => $logo]);
      }

      public function oneLogoToChange($id) { //страничка изменения логотипа
        $logo_single = Itv::
        leftJoin('logos', function ($join){
            $join->on('itv.id', '=', 'logos.ch_id');
        })
        ->where('itv.id', '=', $id)
        ->select('itv.id AS channel_id', 'itv.name AS channel_name', DB::raw( 'IFNULL(logos.path, "images/no_logo.png") as logo_path' ))
        ->first();
       // dd($logo_single);
        return view('logo-upload', ['logo_single' => $logo_single]);
      }

      public function oneLogoToEdit($id) { //страничка добавления логотипа
        $logo_single = Itv::
        leftJoin('logos', function ($join){
            $join->on('itv.id', '=', 'logos.ch_id');
        })
        ->where('itv.id', '=', $id)
        ->select('itv.id AS channel_id', 'itv.name AS channel_name', DB::raw( 'IFNULL(logos.path, "images/no_logo.png") as logo_path' ))
        ->first();
      // dd($logo_single);
        return view('logo-update', ['logo_single' => $logo_single]);
      }

      public function updateLogo($id, Request $request) { //функция обновления логотипа
        $logo = Logos::where('ch_id', $id)->first();
        if ($request->has('logo')) {
            \File::delete($logo->path);
            $extension = $request->file('logo')->getClientOriginalExtension(); //получаем расширение файла
            $path = $request->file('logo')->storeAs('logos', 'channel'.$id.'.'.$extension, 'public'); //загружаем его


        } else {
          return redirect()->route('logo_show')->with('error', 'Ошибка обновления логотипа: файл не найден. Забыли выбрать файл?');

        }

        $logo->path = $path;

        $logo->save();

        return redirect()->route('logo_show')->with('success', 'Логотип успешно обновлен');
      }
}
