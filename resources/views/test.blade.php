@extends('layouts.tariff')

@section('title')Тест @endsection

@section('content')
@foreach($channels as $ch)
<h2>{{ $ch->name }} {{$ch->id}}</h2>
    @php
        $prog = ProgrammList::getProgram($ch->id, 1);
    @endphp
        @foreach($prog as $p)
            {{$p->name}} <br>
        @endforeach
@endforeach
@endsection
