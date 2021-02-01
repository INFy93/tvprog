<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ItvController@getChannelData'
)->name('home'); //главная

Route::get('/channel/{id}', 'EpgController@getProgram'
)->name('program'); //запрос на получение id телепрограммы

Route::get('/descr/{id}', 'EpgController@getDescr'
)->name('descr'); //запрос на получение описания

Route::get('/descr/current/{id}', 'EpgController@getDescrCurrent'
)->name('descr'); //запрос на получение описания для текущей телепередачи с картинкой

Route::get('/genres/{id}', 'ItvController@getGenreChannels'
)->name('genre_channels'); //запрос на получение категорий

//работаем с куками
Route::get('/cookie/set/{id}', 'CookieController@setCookie'
)->name('set_cookies'); //добавляем канал в избранное через куки

Route::get('/cookie/delete/{id}', 'CookieController@deleteChannelFromCookie'
)->name('delete_cookie'); //удаляем канал из избранного через куки

Route::get('/tariff/{id}', 'TariffController@getChannelByTariff'
)->name('tariff'); //получение списка каналов по пакетам для вывода на основной сайт

Route::get('/theme/{theme}', 'ThemeController@getTheme'
)->name('theme-switcher'); //сохранение выбранной темы в сессии, чтобы выбор не слетал после перезагрузки страницы


// админская часть
Auth::routes();
Route::middleware('auth')->group(function () {
  Route::get('/dashboard', 'ItvController@getChannelData')->name('admin-home'); // главная стр админки

  Route::get('/dashboard/logo/add/{id}/upload', 'LogoController@oneLogoToChange'
  )->name('logo_add'); // добавляем логотип. вьюшка

  Route::post('/dashboard/logo/add/{id}/upload', 'LogoController@oneLogoToChange'
  )->name('logo_add'); // добавляем логотип. роут для добавления

  Route::get('/dashboard/logos/all/{id}', 'LogoController@oneLogoToEdit'
  )->name('logo_data'); // меняем логотип. вьюшка

  Route::get('/dashboard/logos/all/{id}/update', 'LogoController@updateLogo'
  )->name('logo_update'); // ф-ция обновления логотипа

  Route::post('/dashboard/logos/all/{id}/update', 'LogoController@updateLogo'
  )->name('logo_update'); // ф-ция обновления логотипа

  Route::get('/dashboard/logos/all', 'LogoController@allLogos'
  )->name('logo_show'); // показываем ВСЕ логотипы

  Route::post('/dashboard/logo/{id}/submit', 'LogoController@submit'
  )->name('logo_upload'); // загружаем логотип

  Route::get('/dashboard/logout', 'Auth\LoginController@logout'
  )->name('logout'); //разлогин

  Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode1 = Artisan::call('config:clear');
    $exitCode2 = Artisan::call('route:clear');
    $exitCode3 = Artisan::call('view:clear');
    // return what you want
    return Artisan::output();
});

Route::get('/storage-link', function () {
    $command = 'storage:link';
    $result = Artisan::call($command);
    return Artisan::output();
});

Route::get('/version', function () {
    return app()->version();
});

});
