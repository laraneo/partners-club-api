<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Profession extends Model
{
    use LogsActivity;

    protected $fillable = [
        'description', 
    ];

    protected static $logName = 'profession';

    protected static $logAttributes = ['description'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }
}
