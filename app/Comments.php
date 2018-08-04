<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;

class Comments extends Model
{
    protected $table = 'comments';
    
    protected $fillable = [
        'nickname', 'topic_id', 'content',
    ];

    public function scopeList($query, $data){

    	$globalController = new Controller;

    	$res = Comments::where('topic_id',$data['topic_id'])
    		->simplePaginate(20)
    		->setPath(URL('/')."$_SERVER[REQUEST_URI]");

        return $globalController->response($res,'topics-list',$res);

    }
}
