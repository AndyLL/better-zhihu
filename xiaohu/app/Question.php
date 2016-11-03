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

    public function read_by_user_id($user_id){
        $user = user_ins()->find($user_id);
        
        if(!$user)
            return err('user does not exist');

        $r =  $this->where('user_id', $user_id)
                   ->get()
                   ->keyBy('id');

        return suc($r->toArray());
    }

   	public function read(){
   		if(rq('id')){
            $r = $this
                ->with('answers_with_user_info')
                ->find(rq('id'));
            return ['status' => 1, 'data' => $r];
        }
		

        if(rq('user_id')){
            $user_id = rq('user_id') == 'self' ? session('user_id') : rq('user_id'); 
            return $this->read_by_user_id($user_id);
        }
   		//$limit = rq('limit') ? : 15;
   		// $skip = ((rq('page') ? : 1) - 1)* $limit;

   		list($limit, $skip) = paginate(rq('page'), rq('limit'));

   		$r = $this->orderBy('created_at')
   					->limit($limit)
   					->skip($skip)
   					->get(['id', 'title', 'desc', 'user_id', 'created_at', 'updated_at'])
   					->keyBy('id');

   		return ['status' => 1, 'data' => $r];
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

    public function answers(){
        return $this->hasMany('App\Answer');
    }

    public function answers_with_user_info(){
        return $this
                ->answers()
                ->with('user')
                ->with('users');
    }
}









































