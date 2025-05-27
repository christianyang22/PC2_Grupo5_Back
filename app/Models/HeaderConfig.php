<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderConfig extends Model
{
    protected $table = 'header_configs';

    protected $fillable = [
        'background_color',
        'header_color',
        'button_color',
        'hover_color',
        'updated_by',
    ];
}
