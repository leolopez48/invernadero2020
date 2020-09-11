<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Station extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'station';

    protected $fillable = [
        'id', 'title', 'description', 'photo', 'state', 'updated_at', 'created_at'
    ];

    protected $dateFormat = 'U';

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];
}
