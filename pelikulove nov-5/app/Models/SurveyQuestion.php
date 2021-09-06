<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{    
    protected $table = 'survey_questions';

    protected $fillable = [
        'title', 
        'survey_id', 
        'description',
        'type',
        'necessity',
        'answer',
        'dummy_answer',
    ];
}
