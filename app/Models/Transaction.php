<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function stakeholder()
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholderId');
    }
}
