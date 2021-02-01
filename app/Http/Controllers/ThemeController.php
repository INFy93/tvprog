<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function getTheme($theme, Request $request)
    {
        if (isset($theme))
        {
            $set = $theme;

            if ($set == 'app' || $set == 'dark')
            {
                $request->session()->put('theme', $set);
            }
        }
    }
}
