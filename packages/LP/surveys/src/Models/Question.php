<?php

namespace LP\surveys\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $guarded = [];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function answerLinear()
    {
        return $this->hasOne(AnswerLinear::class);
    }

}
