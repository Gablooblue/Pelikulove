<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{    
    protected $table = 'survey_answers';

    protected $fillable = [
        'user_id', 
        'survey_id', 
        'question_id',
        'answer',
    ];
}
