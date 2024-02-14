<?php

namespace LP\surveys\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public $guarded = [];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function surveyResponse()
    {
        return $this->hasOne(Survey_responses::class);
    }
}
