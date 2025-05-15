<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function readers()
    {
        return $this->hasMany(Reader::class, 'notificationId');
    }
}
