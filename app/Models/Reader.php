<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'stakeholderId');
    }
}
