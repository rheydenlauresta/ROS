<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Controller;

class Topics extends Model
{
    use SoftDeletes;
    
    protected $table = 'topics';

    protected $fillable = [
        'nickname', 'title', 'content',
    ];

    public function scopeList($query, $data){

    	$globalController = new Controller;

    	$res = Topics::where(function($qry) use($data){
    			$qry->where('nickname','like','%'.$data['keyword'].'%')
	    			->orWhere('title','like','%'.$data['keyword'].'%')
	    			->orWhere('content','like','%'.$data['keyword'].'%');
    		})
    		->simplePaginate(20)
    		->setPath(URL('/')."$_SERVER[REQUEST_URI]");

        return $globalController->response($res,'topics-list',$res);

    }
}
