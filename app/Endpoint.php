<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enpoints extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'endpoints';

    protected $fillable = [
        'endpoint',
        'expirationTime',
        'keys',
        'updated_at',
        'created_at'
    ];

    protected $dateFormat = 'U';

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];
}
