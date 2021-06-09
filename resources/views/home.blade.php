@extends('layouts.app')

@section('title')Телепрограмма@endsection

@section('categories')
<nav class="navbar navbar-expand-md navbar-light">
    <a class="navbar-brand" href="#">Телепрограмма</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <!-- Пункты меню с категориями -->
        <ul class="navbar-nav" id="sort">

            <div class="controls">
                <div class="control_item">
                    <a id="fav" class="hidden-xs" data-toggle="tooltip" data-placement="bottom" title="Избранное"
                        data-mixitup-control data-filter=".favour"><i class="favour_switch far fa-star"></i></a>
                </div>
                <div class="control_item">
                    <a data-toggle="tooltip" data-placement="bottom" title="Текущие передачи"><i
                            class="switch fas fa-tv" id="onlyCurrent"></i></a>
                </div>
                <div class="control_item">
                    <a href="{{route('rank')}}" class="black_link" data-toggle="tooltip" data-placement="bottom"
                        title="Популярное сейчас"><i class="far fa-thumbs-up"></i></a>
                </div>
                <div class="control_item">
                    @if(session('theme') == 'dark')
                    <a data-toggle="tooltip" data-placement="bottom" title="Светлая тема"><i class="fas fa-sun"
                            id="theme-button"></i></a>

                    @else
                    <a data-toggle="tooltip" data-placement="bottom" title="Темная тема"><i class="fas fa-moon"
                            id="theme-button"></i></a>
                    @endif
                </div>
                <div class="control_item">
                    <a data-toggle="modal" data-target="#faq"><i class="far fa-question-circle"></i></a>
                </div>
            </div>
            <li class="nav-item">
                <a class="nav-link" id="all" href="#" data-mixitup-control data-filter="all"><strong>Все</strong></a>
            </li>
            @foreach ($genres as $genre)
            <li class="nav-item">
                <a class="nav-link" href="#" data-mixitup-control
                    data-filter=".genreNum{{ $genre->id }}">{{ $genre->title }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</nav>
</div>
@endsection

@section('content')
<div class="col-md-12">
    <center>
        <h2>Телепрограмма GigabyteTV</h2> <br>
    </center>
</div>
<div class="row channels">
    @php $ids = explode(",", Cookie::get('channel'))@endphp
    @foreach ($channels as $channel)
    @php
    $marker = Helpers::getFavourSet($channel->channel_id, $ids)
    @endphp
    <div class="mix col-md-3 channel_item genreNum{{ $channel->genre_id }} {{ $marker['div'] }}">
        <h5 class="channel_title">
            <img class="logo" src="/storage/{{ $channel->logo_path }}"> <a
                href="{{ route('program', $channel->channel_id) }}">{{ $channel->channel_name }}</a> <a
                id="{{ $channel->channel_id }}" name="{{ $channel->channel_name }}" data-toggle="tooltip"
                data-placement="bottom" title="Добавить в Избранное"><i
                    class="favour_star {{ $marker['marker'] }} fa-star"></i></a>
            @if (Auth::check()) <a href="{{ route('logo_data', $channel->channel_id) }} "
                class="badge badge-info">Изменить
                лого</a>@endif
        </h5>
        @php
        $program = ProgramList::getProgram($channel->channel_id, 1);
        @endphp
        @if(sizeof($program) == 2)
        <div class="alert alert-danger">
            К сожалению, для данного телеканала программа пока недоступна.
        </div>
        @else
        @foreach ($program as $prog)
        @switch($prog->order)
        @case('previous')
        <div class="before">
            <strong>{{ date('H:i', strtotime($prog->time)) }}</strong>
            @if ($prog->descr_len != 0)
            <a href="#" id="{{ $prog->id }}" class="description_before" data-toggle="modal"
                data-target="#basicModal">{{ $prog->name }}</a> @else
            {{ $prog->name }}
            @endif
        </div>
        @break
        @case('current')
        <div class="current">
            @php $progress = ProgramList::getProgress($prog->time, $prog->time_to); @endphp
            {{ date('H:i', strtotime($prog->time)) }}
            @if ($prog->descr_len != 0)
            <a href="#" id="{{ $prog->id }}" class="current_link" data-toggle="modal"
                data-target="#basicModal">{{ $prog->name }}</a>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                    aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            @else
            <a>{{ $prog->name }}</a>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                    aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            @endif
        </div>
        @break
        @case('next')
        <div class="after">
            <strong>{{ date('H:i', strtotime($prog->time)) }}</strong>
            @if ($prog->descr_len != 0)
            <a href="#" id="{{ $prog->id }}" class="description_after" data-toggle="modal"
                data-target="#basicModal">{{ $prog->name }}</a> @else
            {{ $prog->name }}
            @endif
        </div>
        @break
        @endswitch
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
                    <li>
                        <i class="favour_switch far fa-star"></i> - просмотреть Ваши <strong>избранные телеканалы.
                        </strong>
                    </li>
                    <li>
                        <i class="switch fas fa-tv"></i> - просмотреть передачи, <strong>идущие в данный момент.
                        </strong>
                    </li>
                    <li>
                        <i class="far fa-thumbs-up"></i> - просмотреть передачи, которые смотрят зрители <strong>в
                            данный момент.</strong>
                    </li>
                    <li>
                        <i class="fas fa-moon"></i> / <i class="fas fa-sun"></i> - применить <strong>темную или светлую
                            тему.</strong>
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
