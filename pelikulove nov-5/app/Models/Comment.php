<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
  
class Comment extends Model
{
    use SoftDeletes;
   
    protected $dates = ['deleted_at'];
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'type', 'topic_id', 'parent_id', 'body'];
   
    /**
     * The belongs to Relationship
     *
     * @var array
     */
     
     
    public static function getAllTopicComments ($topic_id) {
    	$comments = null;
    	$comments = Comment::where('type', '=', 'topic')
    						->where('topic_id', '=', $topic_id)
    						->whereNull('parent_id')
    						->orderBy('created_at', 'ASC')
    						->get();
    					
    	return $comments;
    }
     
    public static function getAllVodComments ($vod_id) {
    	$comments = null;
    	$comments = Comment::where('type', '=', 'vod')
    						->where('topic_id', '=', $vod_id)
    						->whereNull('parent_id')
    						->orderBy('created_at', 'ASC')
    						->get();
    					
    	return $comments;
    }
    
     public static function getAllComments ($topic_id, $type) {
    	$comments = null;
    
    	$comments = Comment::where('type', '=', $type)
    						->where('topic_id', '=', $topic_id)
    						->whereNull('parent_id')
    						->orderBy('created_at', 'ASC')
    						->get();
    					
    	return $comments;						
    						
    	
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    
    
    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
