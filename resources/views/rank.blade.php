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
                <a class="nav-link" href="/">Вернуться на главную</a>
            </li>
        </ul>
    </div>
</nav>
</div>
@endsection

@section('content')
<div class="row popular">
    <div class="col-md-12">
        <h3> Пакет "Старт TV"</h3>
    </div>
    @foreach ($start as $st)
    <div class="col-md-3 channel_item">
        <h5 class="channel_title">
            <img class="logos_list" src="{{ asset('storage/'.$st->logo) }}"> {{$st->name}}
        </h5>
        @php
        $program = ProgramList::getCurrentProgram($st->ch_id);
        @endphp
        @if($program)
        <div class="program_name">
            <strong> {{date('H:i', strtotime($program->time))}}</strong> {{$program->name}}
        </div>
        @php $progress = ProgramList::getProgress($program->time, $program->time_to); @endphp
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="decription">
            @if($program->descr)
            {{Helpers::cutString($program->descr)}} <a href="#" id="{{ $program->id }}" class="load_description"
                data-toggle="modal" data-target="#basicModal" onClick="descriptionCurrent(this);">Далее</a> @else
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
        <h3> Пакет "Базовый TV"</h3>
    </div>
    @foreach ($baza as $bz)
    <div class="col-md-3 channel_item">
        <h5 class="channel_title">
            <img class="logos_list" src="{{ asset('storage/'.$bz->logo) }}"> {{$bz->name}}
        </h5>
        @php
        $program = ProgramList::getCurrentProgram($bz->ch_id);
        @endphp
        @if($program)
        <div class="program_name">
            <strong> {{date('H:i', strtotime($program->time))}}</strong> {{$program->name}}
        </div>
        @php $progress = ProgramList::getProgress($program->time, $program->time_to); @endphp
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="decription">
            {{Helpers::cutString($program->descr)}}
        </div>
        @else
        <div class="alert alert-danger">
            К сожалению, для данного телеканала программа пока недоступна.
        </div>
        @endif
    </div>
    @endforeach
    <div class="col-md-12 rank_category">
        <h3> Пакет "Премиум HDTV"</h3>
    </div>
    @foreach ($premium as $prem)
    <div class="col-md-3 channel_item">
        <h5 class="channel_title">
            <img class="logos_list" src="{{ asset('storage/'.$prem->logo) }}"> {{$prem->name}}
        </h5>
        @php
        $program = ProgramList::getCurrentProgram($prem->ch_id);
        @endphp
        @if($program)
        <div class="program_name">
            <strong> {{date('H:i', strtotime($program->time))}}</strong> {{$program->name}}
        </div>
        @php $progress = ProgramList::getProgress($program->time, $program->time_to); @endphp
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="decription">
            {{$program->descr}}
        </div>
        @else
        <div class="alert alert-danger">
            К сожалению, для данного телеканала программа пока недоступна.
        </div>
        @endif
    </div>
    @endforeach
    <div class="col-md-12 rank_category">
        <h3> Пакет "Премиум HDTV + TV1000"</h3>
    </div>
    @foreach ($tv1000 as $t1000)
    <div class="col-md-3 channel_item">
        <h5 class="channel_title">
            <img class="logos_list" src="{{ asset('storage/'.$t1000->logo) }}"> {{$t1000->name}}
        </h5>
        @php
        $program = ProgramList::getCurrentProgram($t1000->ch_id);
        @endphp
        @if($program)
        <div class="program_name">
            <strong> {{date('H:i', strtotime($program->time))}}</strong> {{$program->name}}
        </div>
        @php $progress = ProgramList::getProgress($program->time, $program->time_to); @endphp
        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="decription">
            {{$program->descr}}
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
