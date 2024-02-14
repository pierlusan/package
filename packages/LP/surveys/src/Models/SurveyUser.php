<?php

namespace LP\surveys\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyUser extends Model
{
    use HasFactory;
    public $guarded = [];

    public function surveys()
    {
        return $this->belongsToMany(Survey::class);
    }
}
