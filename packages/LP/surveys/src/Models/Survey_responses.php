<?php

namespace LP\surveys\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_responses extends Model
{
    use HasFactory;
    public $guarded = [];
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
