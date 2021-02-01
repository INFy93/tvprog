@extends('layouts.single')

@section('title')Логотипы@endsection

@section('content')
<div class="col-12">
  <h1>Добавление логотипа</h1>
</div>
<div class="col-12">
  Телеканал: <strong>{{ $logo_single->channel_name }}</strong>
  <img class = "logo" src="{{ asset('/storage/' . $logo_single->logo_path) }}" alt="">
  <form action="{{ route('logo_upload', $logo_single->channel_id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="logo">Выберите логотип (в формате <strong>jpg</strong>, <strong>png</strong>, <strong>svg</strong> или <strong>bmp</strong>):</label>
      <input type="file" name="logo" id="logo" class="form-control-file" onchange="ValidateSingleInput(this);>
    </div>
    <button type="submit" class="btn btn-primary">Добавить логотип</button>

  </form>
  <br>
  <a href="{{ route('logo_show') }}"><button type="submit" class="btn btn-success">Вернуться к просмотру логотипов</button></a>
</div>

@endsection
