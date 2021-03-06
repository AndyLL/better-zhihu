<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommonController extends Controller{
    public function timeline(){
    	list($limit, $skip) = paginate(rq('page'), rq('limit'));

    	$questions = question_ins()
            ->with('user')
    		->limit($limit)
    		->skip($skip)
    		->orderBy('created_at', 'desc')
    		->get();

    	$answers = answer_ins()
            ->with('question')
            ->with('user')
            ->with('users')
    		->limit($limit)
    		->skip($skip)
    		->orderBy('created_at', 'desc')
    		->get();

    	//dd($answers->toArray());

    	/* merge questions and answers and save to data */
    	$data = $questions->merge($answers);
    	$data = $data->sortByDesc(function($item){
    		return $item->created_at;
    	});

    	$data = $data->values()->all();

    	return suc($data);
    }
}
