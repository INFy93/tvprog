@extends('layouts.single')

@section('title')Телепрограмма@endsection

@section('content')
@php
//да, знаю, говнокод, но для удобства объявлю переменные в начале
$time     = date("Y-m-d H:i:s");
$now       = date("d", strtotime($time));
$day      = date("j", strtotime($time));
$day_week = date("N", strtotime($time));
$month_now = date("n", strtotime($time));
if ($epg) {
$programBefore = ProgrammList::getBeforeProgramm($epg->ch_id);
$programCurrent = ProgrammList::getCurrentProgramm($epg->ch_id);
$programAfter = ProgrammList::getAfterProgramm($epg->ch_id, 0);
$count = 0;
}
@endphp
<div class="col-12">
  <center>
    <h3><img class = "logo_program" src="/storage/{{$logo->path}}" alt="">  {{$channel->name}}</h3>
    <a href="{{ route('home') }}"><button type="submit" class="btn btn-primary">Вернуться к телепрограмме</button></a>
    <hr>
    @if(!$epg)
<div class="col-md-12">
    <div class="alert alert-danger message">
        К сожалению, для данного телеканала программа пока недоступна.
    </div>
</div>
</h4>
@else
    <h4 class="date_block"> Сегодня {{ $day }} {{Helpers::correctDate($month_now, $day_week)}} </h4></center>
  </center>
  <br>
</div>
<div class="row">

  <div class="col-md-4 program">

          @foreach ($programBefore as $progB)
          <div class="before">
            <strong>{{ date("H:i", strtotime($progB->time)) }}</strong> @if(strlen($progB->descr) != 0)
  					<a href="#" id="{{ $progB->id }}" class = "load_description" data-toggle="modal" data-target="#basicModal" onClick="description(this);">{{ $progB->name }}</a> @else
  					 {{ $progB->name }}
             @endif
          </div>
          @endforeach
          @if (strlen($programCurrent) > 0)
          <div class="current">
            {{date("H:i", strtotime($programCurrent['time']))}} @if(strlen($programCurrent['descr']) != 0)
  					<a href="#" id="{{ $programCurrent->id }}" class = "load_description" data-toggle="modal" data-target="#basicModal" onClick="description(this);">{{$programCurrent['name']}}</a> @else
  					{{$programCurrent['name']}}
            @endif
          </div>
          @endif
          @foreach($programAfter as $progA)
          <?php
          $prog_time = date("d", strtotime($progA->time));
          $prog_month = date("n", strtotime($progA->time));
          if ($now < $prog_time || $month_now < $prog_month) {
              $now        = $prog_time;
              $month_now  = $prog_month;
              $day_f      = date("j", strtotime($progA->time));
              $month_f   = date("n", strtotime($progA->time));
              $day_week_f = date("N", strtotime($progA->time));
              ?>
            </div>
              <br>
                <div class="col-12">
                    <center>
                      <hr>
                        <h4 class="date_block"> {{ $day_f }} {{Helpers::correctDate($month_f, $day_week_f)}} </h4></center>
                        <br>
                </div>
                <div class="col-md-4 program">
                    <?php $count = 0; } ?>
          <div class="after">
            <strong>{{date("H:i", strtotime($progA->time))}}</strong> @if(strlen($progA->descr) != 0)
  						<a href="#" id="{{ $progA->id }}" class = "load_description" data-toggle="modal" data-target="#basicModal" onClick="description(this);">{{ $progA->name }}</a> @else
  						{{ $progA->name }}
              @endif
            <?php $count++; ?>
          </div>

        @if($count == 10)
      </div> <br>  <div class="col-md-4 program">
        <?php $count = 0; ?>
        @endif
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
