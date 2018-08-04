<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Topics;

use App\Http\Requests\Api\TopicsRequest;

class TopicsController extends Controller
{
    //
    public function list(){
    	return Topics::list(request()->all());
    }

    public function create(TopicsRequest $request){
    	// return Topics::create(request()->all());
    	return $this->get_api_store(request()->all(), new Topics(), 'create-topic');
    }
}
