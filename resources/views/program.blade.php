@extends('layouts.single')

@section('title')Телепрограмма@endsection

@section('content')
@php
//да, знаю, говнокод, но для удобства объявлю переменные в начале
$time = date("Y-m-d H:i:s");
$now = date("d", strtotime($time));
$day = date("j", strtotime($time));
$day_week = date("N", strtotime($time));
$month_now = date("n", strtotime($time));
if ($epg) {
$program = ProgramList::getProgram($epg->ch_id, 0);
$count = 0;
}
@endphp
<div class="col-12">
    <center>
        <h3 class="channel_title"><img class="logo_program" src="/storage/{{ $logo->path }}" alt="">
            {{ $channel->name }}</h3>
        <a href="{{ route('home') }}"><button type="submit" class="btn btn-primary">Вернуться к
                телепрограмме</button></a>
        @if (!$program)
        <div class="col-md-12">
            <hr>
            <div class="alert alert-danger message">
                К сожалению, для данного телеканала программа пока недоступна.
            </div>
        </div>
    </center>
    @else
</div>
<div class="row">
    <div class="col-12">
        <center>
            <hr>
            <h4 class="date_block"> Сегодня: {{ $day }} {{ Helpers::correctDate($month_now, $day_week) }} </h4>
        </center>

    </div>
    <div class="col-md-4 program">

        @foreach ($program as $prog)
        @switch($prog->order)
        @case('previous')
        <div class="before">
            <strong>{{ date('H:i', strtotime($prog->time)) }}</strong>
            @if ($prog->descr_len != 0)
            <a href="#" id="{{ $prog->id }}" class="load_description" data-toggle="modal" data-target="#basicModal"
                onClick="description(this);">{{ $prog->name }}</a> @else
            {{ $prog->name }}
            @endif
        </div>
        @break
        @case('current')
        <div class="current">
            @php $progress = ProgramList::getProgress($prog->time, $prog->time_to); @endphp
            {{ date('H:i', strtotime($prog->time)) }}
            @if ($prog->descr_len != 0)
            <a href="#" id="{{ $prog->id }}" class="load_description" data-toggle="modal" data-target="#basicModal"
                onClick="descriptionCurrent(this);">{{ $prog->name }}</a>
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
        <?php
                $prog_time = date('d', strtotime($prog->time));
                $prog_month = date('n', strtotime($prog->time));
                if ($now < $prog_time || $month_now < $prog_month) { $now=$prog_time; $month_now=$prog_month;
                    $day_f=date('j', strtotime($prog->time));
                    $month_f = date('n', strtotime($prog->time));
                    $day_week_f = date('N', strtotime($prog->time));
                    ?>
    </div>
    <br>
    <div class="col-12">
        <center>
            <hr>
            <h4 class="date_block"> {{ $day_f }} {{ Helpers::correctDate($month_f, $day_week_f) }} </h4>
        </center>

    </div>
    <div class="col-md-4 program">
        <?php $count = 0;
            }
            ?>
        <div class="after">
            <strong>{{ date('H:i', strtotime($prog->time)) }}</strong>
            @if ($prog->descr_len != 0)
            <a href="#" id="{{ $prog->id }}" class="load_description" data-toggle="modal" data-target="#basicModal"
                onClick="description(this);">{{ $prog->name }}</a> @else
            {{ $prog->name }}
            @endif
            <?php $count++; ?>
        </div>

        @if ($count == 10)
    </div> <br>
    <div class="col-md-4 program">
        <?php $count = 0; ?>
        @endif
        @endswitch
        @endforeach
    </div>
    @endif
    <!-- окошко для вывода описания -->
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    @endsection
