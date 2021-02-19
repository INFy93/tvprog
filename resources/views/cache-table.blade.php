@extends('layouts.single')

@section('title')Таблица кеширования @endsection

@section('content')

<h1>Управление кеширующей таблицей</h1>
</div>
</div>
<div class="row">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Параметр</th>
                <th>Значение</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Количество каналов в основной таблице</td>
                <td>{{ $info['orig_count'] }}</td>
            </tr>
            <tr>
                <td>Количество каналов в кеширующей таблице</td>
                <td>{{ $info['cache_count'] }}</td>
            </tr>
            <tr>
                <td>Совпадают ли данные? </td>
                <td><span style="color: {{ $info['color'] }}">{{ $info['diff'] }}</span></td>
            </tr>
            <tr>
                <td rowspan="2"><a class="btn btn-danger" href="{{ route('update-cache-table') }}"
                        role="button">Обновить кеширующую таблицу</a></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
