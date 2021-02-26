@extends('layouts.single')

@section('title')Логотипы@endsection

@section('content')
<h1>Логотипы</h1>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th>
                <center>Number</center>
            </th>
            <th>
                <center>ID телеканала</center>
            </th>
            <th>
                <center>Название телеканала</center>
            </th>
            <th>
                <center>Логотип</center>
            </th>
            <th>
                <center>Действие</center>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($logos as $logo)
        <tr>
            <th>
                <center>{{$logo->channel_number}}</center>
            </th>
            <th>
                <center>{{$logo->channel_id}}</center>
            </th>
            <th>
                <center>{{$logo->channel_name}}</center>
            </th>
            <th>
                <center><img class="logo" src="{{ asset('/storage/' . $logo->logo_path) }}" alt=""></center>
            </th>
            <th>
                <center><a href="{{ route('logo_data', $logo->channel_id) }}"><button type="submit"
                        class="btn btn-success">Изменить логотип</button></a></center>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
