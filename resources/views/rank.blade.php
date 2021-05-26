@extends('layouts.rank_template')

@section('title')Популярное сейчас @endsection

@section('categories')
<nav class="navbar navbar-expand-md navbar-light">
    <a class="navbar-brand" href="#">Популярное сейчас</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <!-- Пункты меню с категориями -->
        <ul class="navbar-nav" id="sort">

            <li class="nav-item">
                <a class="nav-link" href="/">Телепрограмма</a>
            </li>
        </ul>
    </div>
</nav>
</div>
@endsection

@section('content')
<div class="row popular">
    @php $ids = explode(",", Cookie::get('channel'));@endphp
    <div class="col-md-12">
        <h3 class="cat_title"> Пакет "Старт TV"</h3>
    </div>
    @foreach ($start as $st)
    @php
    $favour_set_st = Helpers::getFavourSet($st->ch_id, $ids)
    @endphp
    <div class="col-md-3 channel_item">
        <h5 class="channel_title">
            <img class="logo" src="/storage/{{ $st->logo }}"> <a
            href="{{ route('program', $st->ch_id) }}">{{ $st->name }}</a> <a
            class="{{ $favour_set_st['link'] }} favour_link" id="{{ $st->ch_id }}"
            name="{{ $st->name }}">
            <img src="/storage/images/{{ $favour_set_st['picture'] }}.png"
                class="favour_image img_id{{ $st->ch_id }}">
        </h5>
        @php
        $program = ProgramList::getCurrentProgram($st->ch_id);
        @endphp
        @if($program)
        <div class="program_name">
            <strong> {{date('H:i', strtotime($program->time))}}</strong> @if($program->descr)  <a href="#" id="{{ $program->id }}" class="rank_link"
                data-toggle="modal" data-target="#basicModal">{{$program->name}}</a> @else
                <{{$program->name}} @endif
        </div>
        @php $progress = ProgramList::getProgress($program->time, $program->time_to); @endphp
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="decription">
            @if($program->descr)
            {{Helpers::cutString($program->descr)}} <a href="#" id="{{ $program->id }}" class="read_more"
                data-toggle="modal" data-target="#basicModal">Далее</a> @else
            <div class="alert alert-danger">
                К сожалению, для данной передачи описание недоступно.
            </div>
            @endif
        </div>
        @else
        <div class="alert alert-danger">
            К сожалению, для данного канала передача пока недоступна.
        </div>
        @endif
    </div>
    @endforeach
    <div class="col-md-12 rank_category">
        <h3 class="cat_title"> Пакет "Базовый TV"</h3>
    </div>
    @foreach ($baza as $bz)
    @php
    $favour_set_bz = Helpers::getFavourSet($bz->ch_id, $ids)
    @endphp
    <div class="col-md-3 channel_item">
        <h5 class="channel_title">
            <img class="logo" src="/storage/{{ $bz->logo }}"> <a
            href="{{ route('program', $bz->ch_id) }}">{{ $bz->name }}</a> <a
            class="{{ $favour_set_bz['link'] }} favour_link" id="{{ $bz->ch_id }}"
            name="{{ $bz->name }}" onClick="favour(this);">
            <img src="/storage/images/{{ $favour_set_bz['picture'] }}.png"
                class="favour_image img_id{{ $bz->ch_id }}">
        </h5>
        @php
        $program = ProgramList::getCurrentProgram($bz->ch_id);
        @endphp
        @if($program)
        <div class="program_name">
            <strong> {{date('H:i', strtotime($program->time))}}</strong> @if($program->descr)  <a href="#" id="{{ $program->id }}" class="rank_link"
                data-toggle="modal" data-target="#basicModal">{{$program->name}}</a> @else
                <{{$program->name}} @endif
        </div>
        @php $progress = ProgramList::getProgress($program->time, $program->time_to); @endphp
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="decription">
            @if($program->descr)
            {{Helpers::cutString($program->descr)}} <a href="#" id="{{ $program->id }}" class="read_more"
                data-toggle="modal" data-target="#basicModal">Далее</a> @else
                <div class="alert alert-danger">
                    К сожалению, для данной передачи описание недоступно.
                </div>
            @endif
        </div>
        @else
        <div class="alert alert-danger">
            К сожалению, для данного телеканала программа пока недоступна.
        </div>
        @endif
    </div>
    @endforeach
    <div class="col-md-12 rank_category">
        <h3 class="cat_title"> Пакет "Премиум HDTV"</h3>
    </div>
    @foreach ($premium as $prem)
    @php
    $favour_set_p = Helpers::getFavourSet($prem->ch_id, $ids)
    @endphp
    <div class="col-md-3 channel_item">
        <h5 class="channel_title">
            <img class="logo" src="/storage/{{ $prem->logo }}"> <a
            href="{{ route('program', $prem->ch_id) }}">{{ $prem->name }}</a> <a
            class="{{ $favour_set_p['link'] }} favour_link" id="{{ $prem->ch_id }}"
            name="{{ $prem->name }}" onClick="favour(this);">
            <img src="/storage/images/{{ $favour_set_p['picture'] }}.png"
                class="favour_image img_id{{ $prem->ch_id }}">
        </h5>
        @php
        $program = ProgramList::getCurrentProgram($prem->ch_id);
        @endphp
        @if($program)
        <div class="program_name">
            <strong> {{date('H:i', strtotime($program->time))}}</strong> @if($program->descr)  <a href="#" id="{{ $program->id }}" class="rank_link"
                data-toggle="modal" data-target="#basicModal">{{$program->name}}</a> @else
                <{{$program->name}} @endif
        </div>
        @php $progress = ProgramList::getProgress($program->time, $program->time_to); @endphp
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="decription">
            @if($program->descr)
            {{Helpers::cutString($program->descr)}} <a href="#" id="{{ $program->id }}" class="read_more"
                data-toggle="modal" data-target="#basicModal">Далее</a> @else
                <div class="alert alert-danger">
                    К сожалению, для данной передачи описание недоступно.
                </div>
            @endif
        </div>
        @else
        <div class="alert alert-danger">
            К сожалению, для данного телеканала программа пока недоступна.
        </div>
        @endif
    </div>
    @endforeach
    <div class="col-md-12 rank_category">
        <h3 class="cat_title"> Пакет "Премиум HDTV + TV1000"</h3>
    </div>
    @foreach ($tv1000 as $t1000)
    @php
    $favour_set_t = Helpers::getFavourSet($t1000->ch_id, $ids);
    //dd($ids);
    @endphp
    <div class="col-md-3 channel_item">
        <h5 class="channel_title">
            <img class="logo" src="/storage/{{ $t1000->logo }}"> <a
            href="{{ route('program', $t1000->ch_id) }}">{{ $t1000->name }}</a> <a
            class="{{ $favour_set_t['link'] }} favour_link" id="{{ $t1000->ch_id }}"
            name="{{ $t1000->name }}" onClick="favour(this);">
            <img src="/storage/images/{{ $favour_set_t['picture'] }}.png"
                class="favour_image img_id{{ $t1000->ch_id }}">
        </h5>
        @php
        $program = ProgramList::getCurrentProgram($t1000->ch_id);
        @endphp
        @if($program)
        <div class="program_name">
            <strong> {{date('H:i', strtotime($program->time))}}</strong> @if($program->descr)  <a href="#" id="{{ $program->id }}" class="rank_link"
                data-toggle="modal" data-target="#basicModal">{{$program->name}}</a> @else
                <{{$program->name}} @endif
        </div>
        @php $progress = ProgramList::getProgress($program->time, $program->time_to); @endphp
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="decription">
            @if($program->descr)
            {{Helpers::cutString($program->descr)}} <a href="#" id="{{ $program->id }}" class="read_more"
                data-toggle="modal" data-target="#basicModal">Далее</a> @else
                <div class="alert alert-danger">
                    К сожалению, для данной передачи описание недоступно.
                </div>
            @endif
        </div>
        @else
        <div class="alert alert-danger">
            К сожалению, для данного телеканала программа пока недоступна.
        </div>
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
@endsection
