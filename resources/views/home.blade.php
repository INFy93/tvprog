@extends('layouts.app')

@section('title')Телепрограмма@endsection

@section('categories')
<nav class="navbar navbar-expand-md navbar-light">
    <a class="navbar-brand" href="#">Категории</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <!-- Пункты меню с категориями -->
        <ul class="navbar-nav" id="sort">
            <hr>
            <li class="nav-item">
                @if(session('theme') == 'dark')
                <input type="checkbox" class="form-check-input" id="onlyCurrent" onClick="onlyCurrentDark(this);">
                @else
                <input type="checkbox" class="form-check-input" id="onlyCurrent" onClick="onlyCurrent(this);">
                @endif
                <label class="form-check-label sort-label" for="onlyCurrent">Сейчас в эфире <a href="#"
                        data-toggle="tooltip" data-placement="bottom"
                        title="Если галочка отмечена, то показываются только те передачи, которые идут в данный момент."><i
                            class='fas fa-question-circle' style='font-size:16px'></i></a> </label>
            </li>
            <hr>
            <li class="nav-item">
                @if(session('theme') == 'dark')
                <button type="button" class="btn btn-secondary" id="theme-button">Светлая тема</button>
                @else
                <button type="button" class="btn btn-dark" id="theme-button">Темная тема</button>
                @endif
                <a href="#" data-toggle="tooltip" data-placement="bottom"
                    title="Применяет темную или светлую тему для общей программы и программы конкретного канала. По умолчанию - светлая тема."><i
                        class='fas fa-question-circle'
                        style='font-size:24px; vertical-align: middle; paddnig-right: 5px;'></i></a> </label>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link" id="all" href="#" data-mixitup-control data-filter="all"><strong>Все</strong></a>
            </li>
            @foreach ($genres as $genre)
            <li class="nav-item">
                <a class="nav-link" href="#" data-mixitup-control
                    data-filter=".genreNum{{ $genre->id }}">{{ $genre->title }}</a>
            </li>
            @endforeach
            <li class="nav-item">
                <a class="nav-link" id="fav" data-mixitup-control data-filter=".favour"><strong>Избранное</strong></a>

            </li>
        </ul>
    </div>
</nav>
</div>
@endsection

@section('content')
<div class="col-md-12">
    <center>
        <h2>Телепрограмма GigabyteTV <a href="#" data-toggle="modal" data-target="#faq"><i
                    class='fas fa-question-circle'></i></a> </h2> <br>
    </center>
</div>
<div class="row channels">
    @php $ids = explode(",", Cookie::get('channel'))@endphp
    @foreach ($channels as $channel)
    @php
    $favour_set = Helpers::getFavourSet($channel->channel_id, $ids)
    @endphp
    <div
        class="mix col-md-3 channel_item genreNum{{ $channel->genre_id }} {{ Cookie::get('channel') }} {{ $favour_set['div'] }}">
        <h5 class="channel_title">
            <img class="logo" src="/storage/{{ $channel->logo_path }}"> <a
                href="{{ route('program', $channel->channel_id) }}">{{ $channel->channel_name }}</a> <a
                class="{{ $favour_set['link'] }} favour_link" id="{{ $channel->channel_id }}"
                name="{{ $channel->channel_name }}" onClick="favour(this);">
                <img src="/storage/images/{{ $favour_set['picture'] }}.png"
                    class="favour_image img_id{{ $channel->channel_id }}">
                @if (Auth::check()) <a href="{{ route('logo_data', $channel->channel_id) }} "
                    class="badge badge-info">Изменить
                    лого</a>@endif
            </a>
        </h5>
        @if (!ProgrammList::getBeforeProgramm($channel->channel_id) ||
        !ProgrammList::getCurrentProgramm($channel->channel_id) || !ProgrammList::getAfterProgramm($channel->channel_id,
        1))
        <div class="alert alert-danger">
            К сожалению, для данного телеканала программа пока недоступна.
        </div>

        @else
        @foreach (ProgrammList::getBeforeProgramm($channel->channel_id) as $progB)
        <div class="before">
            <strong>{{ date('H:i', strtotime($progB->time)) }}</strong>
            @if (strlen($progB->descr) != 0)
            <a href="#" id="{{ $progB->id }}" class="load_description" data-toggle="modal" data-target="#basicModal"
                onClick="description(this);">{{ $progB->name }}</a> @else
            {{ $progB->name }}
            @endif
        </div>
        @endforeach
        <div class="current">
            @php
            $programCurrent = ProgrammList::getCurrentProgramm($channel->channel_id);
            @endphp
            {{ date('H:i', strtotime($programCurrent['epg']['time'])) }}
            @if (strlen($programCurrent['epg']['descr']) != 0)
            <a href="#" id="{{ $programCurrent['epg']->id }}" class="load_description" data-toggle="modal"
                data-target="#basicModal" onClick="descriptionCurrent(this);">{{ $programCurrent['epg']['name'] }}</a>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar" role="progressbar" style="width: {{ $programCurrent['progress'] }}%"
                    aria-valuenow="{{ $programCurrent['progress'] }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            @else
            <a>{{ $programCurrent['epg']['name'] }}</a>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar" role="progressbar" style="width: {{ $programCurrent['progress'] }}%"
                    aria-valuenow="{{ $programCurrent['progress'] }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            @endif
        </div>
        @foreach (ProgrammList::getAfterProgramm($channel->channel_id, 1) as $progA)
        <div class="after">
            <strong>{{ date('H:i', strtotime($progA->time)) }}</strong>
            @if (strlen($progA->descr) != 0)
            <a href="#" id="{{ $progA->id }}" class="load_description" data-toggle="modal" data-target="#basicModal"
                onClick="description(this);">{{ $progA->name }}</a> @else
            {{ $progA->name }}
            @endif
        </div>
        @endforeach
        @endif
    </div>
    @endforeach
</div>
<!-- окошко для вывода описания/уведомлений -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="screen">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- окошко для вывода FAQ -->
<div class="modal fade" id="faq" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Как пользоваться телепрограммой</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>
                        Чтобы выбрать категорию каналов, <strong>нажмите на ее название с левой стороны.</strong>
                        Категория, которую Вы просматриваете в данный момент, выделена.
                    </li>
                    <li>
                        Чтобы открыть полную программу канала, <strong>нажмите на его название.</strong><br>
                    </li>
                    <li>
                        Чтобы открыть полное описание программы, <strong>нажмите на ее название</strong>.
                    </li>
                    <li>
                        Нажатие на звездочку рядом с названием канала <strong>добавит его в избранное.</strong>
                        Повторное нажатие на звездочку <strong>удалит канал из избранного.</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="no_favour">
    <div class="alert alert-danger message">
        В данной категории нет ни одного канала! <br>
        Если вы видите данное сообщение, нажав на "Избранное", то добавляйте каналы в избранное, нажимая на звездочку
        (<img src="/storage/images/favour_ready.png" class="favour_image_no_favour">).
    </div>
</div>
</div>
@endsection
