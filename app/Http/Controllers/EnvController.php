<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Env;
use App\Models\Option;
class EnvController extends Controller
{
    public function index()
    {
        $options = Option::get();
        return view('env', compact('options'));
    }

    public function changeSettings(Request $request)
    {
        $input = $request->except(['_token']);
        //dd($input);
        foreach ($input as $name => $option)
        {
            $results = Option::where('name','=', $name)->first();
            $results->value = $option;
            $results->save();
        }
        toastr()->success('Настройки обновлены.');
        return redirect()->route('settings');
    }
}
