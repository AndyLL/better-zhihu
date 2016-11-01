<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model{
    public function add(){
    	if(!user_ins()->is_logged_in())
    		return err('Login required');

    	if(!rq('title'))
    		return err('Require title');

    	$this->title = rq('title');
    	$this->user_id = session('user_id');

    	if(rq('desc'))
    		$this->desc = rq('desc');

    	return $this->save() ? 
    		suc(['id' => $this->id]) : 
    		err('DB insert failed');
   	}

   	public function change(){
   		if(!user_ins()->is_logged_in())
   			return err('Login required.'); 

   		if(!rq('id'))
   			return err('ID required.');

   		$question = $this->find(rq('id'));

   		if(!$question)
   			return err('Question does not exist.'); 

   		if($question->user_id != session('user_id'))
   			return err('Permission denied.'); 

   		if(rq('title'))
   			$question->title = rq('title');

   		if(rq('desc'))
   			$question->desc = rq('desc');

   		return $question->save() ?
    		suc('Success') : 
    		err('DB insert failed');
   	}

   	public function read(){
   		if(rq('id'))
   			return suc(['data' => $this->find(rq('id'))]);

   		//$limit = rq('limit') ? : 15;
   		// $skip = ((rq('page') ? : 1) - 1)* $limit;

   		list($limit, $skip) = paginate(rq('page'), rq('limit'));

   		$r = $this->orderBy('created_at')
   					->limit($limit)
   					->skip($skip)
   					->get(['id', 'title', 'desc', 'user_id', 'created_at', 'updated_at'])
   					->keyBy('id');

   		return suc(['data' => $r]);
   	}

   	public function remove(){
   		if(!user_ins()->is_logged_in())
   			return err('Login required.'); 

   		if(!rq('id'))
   			return err('ID required.'); 

   		$question = $this->find(rq('id'));

   		if(!$question)
   			return err('Question doesnot exist.'); 

   		if(session('user_id') != $question->user_id)
   			return err('Permission denied.'); 

   		return $question->delete() ?
   			suc('Success!') : 
    		err('DB delete failed.');
	}

    public function user(){
        return $this->belongsTo('App\User');
    }
}








































