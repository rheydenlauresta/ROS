<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Comments;

use App\Http\Requests\Api\CommentsRequest;
use App\Http\Requests\Api\CommentsListRequest;

class CommentsController extends Controller
{
    public function list(CommentsListRequest $request){
    	return Comments::list(request()->all());
    }

    public function create(CommentsRequest $request){
    	// return Comments::create(request()->all());
    	return $this->get_api_store(request()->all(), new Comments(), 'create-topic');
    }
}
