<?php

namespace LP\surveys\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    public $guarded = [];
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function surveyResponses()
    {
        return $this->hasMany(Survey_responses::class);
    }

    public function surveyUsers()
    {
        return $this->belongsToMany(SurveyUser::class);
    }

}
