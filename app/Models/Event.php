<?php

namespace App\Models;

use App\Libraries\UserInterface;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'subtitle',
        'description',
        'scheduled_date',
        'scheduled_time',
        'image',
        'show_in_home',
        'start_show_at',
        'ends_show_at',
        'featured'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'start_show_at' => 'date',
        'ends_show_at' => 'date',
        'scheduled_time' => 'time',
    ];

    public function scopeCanBeShownAtHome($query) {
        $current = date('Y-m-d');

        return $query
                  ->where('show_in_home', 'Y')
                  ->whereRaw( " CAST('$current' as DATE) BETWEEN CAST(start_show_at as DATE) and CAST(ends_show_at as DATE)" ) ;
    }
}
