@extends('layouts.single')

@section('title')ENV @endsection

@section('content')
<div class="col-12">
    <h2>Настройки</h2>
</div>
<div class="col-12">
    <hr>
    <h3>Ссылки на скрипты </h3>
    <form>
        <div class="form-group">
          <label for="script_tariff">Пакеты каналов</label>
          <input type="text" readonly class="form-control" id="script_tariff" value="{{env('CHANNEL_LIST_URL')}}">
          <small id="script1Help" class="form-text text-muted">Вывод каналов для разделения по тарифам</small>
        </div>
        <div class="form-group">
            <label for="script_rank">Рейтинг каналов</label>
            <input type="text" readonly class="form-control" id="script_rank" value="{{env('VIEWS_URL')}}">
            <small id="script1Help" class="form-text text-muted">Вывод рейтинга каналов</small>
          </div>
      </form>
      <hr>
      <h3>Различные параметры</h3>
      <form method="POST" action="{{ route('env-change') }}">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="timezone">Часовой пояс</label>
          <input type="text" readonly class="form-control" id="timezone" value="{{env('TIMEZONE')}}">
          <small id="script1Help" class="form-text text-muted">Выбор часового пояса</small>
        </div>
        @foreach ($options as $option)
        <div class="form-group">
            <label for="min_percent">{{$option->tag}}</label>
            <input type="{{$option->type}}" step="any" class="form-control" id="{{$option->id}}" name="{{$option->name}}" value="{{$option->value}}">
            <small id="script1Help" class="form-text text-muted">{{$option->descr}}</small>
          </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Применить</button>
      </form>
</div>

@endsection
