<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

Class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'maintenance_message',
        'maintenance_message_visible',
        'pagination_limit',
        'ua_number',
        'gtm_number'
    ];
}
