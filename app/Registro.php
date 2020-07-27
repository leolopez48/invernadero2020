<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Registro extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'registros';

    protected $fillable = [
        'id', 'temperatura', 'radiacion', 'humedad', 'updated_at', 'created_at'
    ];

    protected $dateFormat = 'U';

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];
}
