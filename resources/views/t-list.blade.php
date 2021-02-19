@extends('layouts.tariff')

@section('title')Список по тарифам @endsection

@section('content')


<div class="row channel_list">
    @if ($channels ?? '')
    <div class="col-md-{{ $rows['div'] }} content-container">
        @foreach ($channels as $channel)
        <div class="list_object">
            @if($rows['caregory_channels'] == $channel->category)
            <div class="channel-row-diff">
                <img class="logos_list" src="{{ asset('storage/'.$channel->logo) }}"> {{ $channel->name }}
                <br>
            </div>
            @else
            <div class="channel-row">
                <img class="logos_list" src="{{ asset('storage/'.$channel->logo) }}"> {{ $channel->name }}
                <br>
            </div>

            @endif
        </div>
        @if ($loop->iteration % $brake == 0)
    </div>
    <div class="col-md-{{ $rows['div'] }} content-container">
        @endif
        @endforeach
    </div>
    @else
    <br>
    <div class="alert alert-danger message">
        На данный момент список телеканалов недоступен.
    </div>
    @endif
</div>

@endsection
