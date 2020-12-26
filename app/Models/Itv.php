<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itv extends Model
{
      /* так как имя таблицы отличается от названия модели (мне не нужно мн. число),
         то явно указываем, с какой таблицей работать */
     protected $table = 'itv';
}
