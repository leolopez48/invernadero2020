<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Record extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'record';

    protected $fillable = [
        'id', 'temperature', 'radiation', 'humidity', 'updated_at', 'created_at'
    ];

    protected $dateFormat = 'U';

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];
}
