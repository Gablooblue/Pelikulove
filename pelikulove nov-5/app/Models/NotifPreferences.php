<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;


class NotifPreferences extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notif_pref';
   
    protected $fillable = [
        'user_id', 'tambayan_email', 'saluhan_email', 'topic_email', 'vod_email',
    ];

    public static function getTambayanEmailPref($id)
    {    
        $tambayanEmailPref = NotifPreferences::where('user_id', $id)
        ->first();

        if (isset($tambayanEmailPref)) {
            return $tambayanEmailPref->tambayan_email;
        }

    	return 1;
    }

    public static function getSaluhanEmailPref($id)
    {    
        $saluhanEmailPref = NotifPreferences::where('user_id', $id)
        ->first();

        if (isset($saluhanEmailPref)) {
            return $saluhanEmailPref->saluhan_email;
        }

    	return 1;
    }

    public static function getTopicEmailPref($id)
    {    
        $topicEmailPref = NotifPreferences::where('user_id', $id)
        ->first();

        if (isset($topicEmailPref)) {
            return $topicEmailPref->topic_email;
        }

    	return 1;
    }

    public static function getVodEmailPref($id)
    {    
        $vodEmailPref = NotifPreferences::where('user_id', $id)
        ->first();

        if (isset($vodEmailPref)) {
            return $vodEmailPref->vod_email;
        }

    	return 1;
    }
}


