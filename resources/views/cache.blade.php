@extends('layouts.single')

@section('title')Artisan @endsection

@section('content')

<h1>Artisan</h1>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Команда</th>
                    <th>Выполнить</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>php artisan cache:clear</td>
                    <td><a class="btn btn-primary" href="#" id="cache" role="button" onClick="clearCache(this);">Глобальный кеш</a></td>
                </tr>
                <tr>
                    <td>php artisan config:clear</td>
                    <td><a class="btn btn-primary" href="#" id="config" role="button" onClick="clearCache(this);">Кеш конфига</a></td>
                </tr>
                <tr>
                    <td>php artisan route:clear</td>
                    <td><a class="btn btn-primary" href="#" id="route" role="button" onClick="clearCache(this);">Кеш роутов</a></td>
                </tr>
                <tr>
                    <td>php artisan view:clear</td>
                    <td><a class="btn btn-primary" href="#" id="view" role="button" onClick="clearCache(this);">Кеш вьюшек</a></td>
                </tr>
                <tr>
                    <td>php artisan migrate</td>
                    <td><a class="btn btn-primary" href="#" id="migrate" role="button" onClick="clearCache(this);">Сделать миграцию</a></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
@endsection
