@extends('layouts.single')

@section('title')Логотипы@endsection

@section('content')

<h1>Очистка кеша</h1>
</div>
</div>
<div class="row">
    <div class="col-md-3">
        <a class="btn btn-primary" href="#" id="cache" role="button" onClick="clearCache(this);">Очистить кеш</a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-primary" href="#" id="config" role="button" onClick="clearCache(this);">Очистить кеш
            конфига</a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-primary" href="#" id="route" role="button" onClick="clearCache(this);">Очистить кеш роутов</a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-primary" href="#" id="view" role="button" onClick="clearCache(this);">Очистить кеш вьюшек</a>
    </div>
</div>
@endsection
