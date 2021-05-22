@if(Auth::check())

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">GigabyteTV. Админка</h5>

    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="{{ route('admin-home') }}">Список каналов</a>
        <a class="p-2 text-dark" href="{{ route('logo_show') }}">Работа с логотипами</a>
        <a class="p-2 text-dark" href="{{ route('cache') }}">Команды Artisan</a>
        <a class="p-2 text-dark" href="{{ route('cache-table') }}">Кеширующая таблица</a>
        <a class="p-2 text-dark" href="{{ route('settings') }}">Настройки</a>
    </nav>
    <a class="btn btn-outline-primary" href="{{ route('logout') }}">Выход</a>

</div>
@endif
