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
    <div class="row populars">
        @foreach ($start as $st)
        @php
        $marker_st = Helpers::getFavourSet($st->ch_id, $ids)
        @endphp
        <div class="col-md-3 channel_item">
            <h5 class="channel_title">
                <img class="logo" src="/storage/{{ $st->logo }}"> <a
                    href="{{ route('program', $st->ch_id) }}">{{ $st->name }}</a> <a id="{{ $st->ch_id }}"
                    name="{{ $st->name }}" data-toggle="tooltip" data-placement="bottom" title="Добавить в Избранное"><i
                        class="favour_star {{ $marker_st['marker'] }} fa-star"></i></a>
            </h5>
            @php
            $program = ProgramList::getCurrentProgram($st->ch_id);
            @endphp
            @if($program)
            <div class="program_name">
                <strong> {{date('H:i', strtotime($program->time))}}</strong> @if($program->descr) <a href="#"
                    id="{{ $program->id }}" class="rank_link" data-toggle="modal"
                    data-target="#basicModal">{{$program->name}}</a> @else
                <{{$program->name}} @endif </div> @php $progress=ProgramList::getProgress($program->time,
                    $program->time_to); @endphp
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
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
        </div>
        <div class="col-md-12 rank_category rank_title">
            <h3 class="cat_title"> Пакет "Базовый TV"</h3>
        </div>
        <div class="row populars">
            @foreach ($baza as $bz)
            @php
            $marker_bz = Helpers::getFavourSet($st->ch_id, $ids)
            @endphp
            <div class="col-md-3 channel_item rank_item">
                <h5 class="channel_title">
                    <img class="logo" src="/storage/{{ $bz->logo }}"> <a
                        href="{{ route('program', $bz->ch_id) }}">{{ $bz->name }}</a> <a id="{{ $bz->ch_id }}"
                        name="{{ $bz->name }}" data-toggle="tooltip" data-placement="bottom"
                        title="Добавить в Избранное"><i class="favour_star {{ $marker_bz['marker'] }} fa-star"></i></a>
                </h5>
                @php
                $program = ProgramList::getCurrentProgram($bz->ch_id);
                @endphp
                @if($program)
                <div class="program_name">
                    <strong> {{date('H:i', strtotime($program->time))}}</strong> @if($program->descr) <a href="#"
                        id="{{ $program->id }}" class="rank_link" data-toggle="modal"
                        data-target="#basicModal">{{$program->name}}</a> @else
                    <{{$program->name}} @endif </div> @php $progress=ProgramList::getProgress($program->time,
                        $program->time_to); @endphp
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                                aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="decription">
                            @if($program->descr)
                            {{Helpers::cutString($program->descr)}} <a href="#" id="{{ $program->id }}"
                                class="read_more" data-toggle="modal" data-target="#basicModal">Далее</a> @else
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

            <div class="col-md-12 rank_category rank_title">
                <h3 class="cat_title"> Пакет "Премиум HDTV"</h3>
            </div>
            <div class="row populars">
                @foreach ($premium as $prem)
                @php
                $marker_p = Helpers::getFavourSet($prem->ch_id, $ids)
                @endphp
                <div class="col-md-3 channel_item">
                    <h5 class="channel_title">
                        <img class="logo" src="/storage/{{ $prem->logo }}"> <a
                            href="{{ route('program', $prem->ch_id) }}">{{ $prem->name }}</a> <a id="{{ $prem->ch_id }}"
                            name="{{ $prem->name }}" data-toggle="tooltip" data-placement="bottom"
                            title="Добавить в Избранное"><i
                                class="favour_star {{ $marker_p['marker'] }} fa-star"></i></a>
                    </h5>
                    @php
                    $program = ProgramList::getCurrentProgram($prem->ch_id);
                    @endphp
                    @if($program)
                    <div class="program_name">
                        <strong> {{date('H:i', strtotime($program->time))}}</strong> @if($program->descr) <a href="#"
                            id="{{ $program->id }}" class="rank_link" data-toggle="modal"
                            data-target="#basicModal">{{$program->name}}</a> @else
                        <{{$program->name}} @endif </div> @php $progress=ProgramList::getProgress($program->time,
                            $program->time_to); @endphp
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                                    aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="decription">
                                @if($program->descr)
                                {{Helpers::cutString($program->descr)}} <a href="#" id="{{ $program->id }}"
                                    class="read_more" data-toggle="modal" data-target="#basicModal">Далее</a> @else
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

                <div class="col-md-12 rank_category rank_title">
                    <h3 class="cat_title"> Пакет "Премиум HDTV + TV1000"</h3>
                </div>
                <div class="row populars">
                    @foreach ($tv1000 as $t1000)
                    @php
                    $marker_t = Helpers::getFavourSet($t1000->ch_id, $ids);
                    @endphp
                    <div class="col-md-3 channel_item">
                        <h5 class="channel_title">
                            <img class="logo" src="/storage/{{ $t1000->logo }}"> <a
                                href="{{ route('program', $t1000->ch_id) }}">{{ $t1000->name }}</a> <a
                                id="{{ $t1000->ch_id }}" name="{{ $t1000->name }}" data-toggle="tooltip"
                                data-placement="bottom" title="Добавить в Избранное"><i
                                    class="favour_star {{ $marker_t['marker'] }} fa-star"></i></a>
                        </h5>
                        @php
                        $program = ProgramList::getCurrentProgram($t1000->ch_id);
                        @endphp
                        @if($program)
                        <div class="program_name">
                            <strong> {{date('H:i', strtotime($program->time))}}</strong> @if($program->descr) <a
                                href="#" id="{{ $program->id }}" class="rank_link" data-toggle="modal"
                                data-target="#basicModal">{{$program->name}}</a> @else
                            <{{$program->name}} @endif </div> @php $progress=ProgramList::getProgress($program->time,
                                $program->time_to); @endphp
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"
                                        aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="decription">
                                    @if($program->descr)
                                    {{Helpers::cutString($program->descr)}} <a href="#" id="{{ $program->id }}"
                                        class="read_more" data-toggle="modal" data-target="#basicModal">Далее</a> @else
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
                </div>

                <!-- окошко для вывода описания/уведомлений -->
                <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
                    aria-hidden="true">
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
