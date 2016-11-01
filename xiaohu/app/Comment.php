<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    public function add(){
    	if(!user_ins()->is_logged_in())
   			return err('Login required.'); 

   		if(!rq('content'))
   			return err('Empty content.'); 
   

   		if((!rq('question_id') && !rq('answer_id')) || (rq('question_id') && rq('answer_id')))
   			return err('question_id or answer_id are required.'); 

   		if(rq('question_id')){
   			$question = question_ins()->find(rq('question_id'));
   			if(!$question)
   				return err('Question doesnt exist.');  

   			$this->question_id = rq('question_id');
    	}
    	else{
    		$answer = answer_ins()->find(rq('answer_id'));
   			if(!$answer)
   				return err('Answer doesnt exist.');  

   			$this->answer_id = rq('answer_id');
    	}

    	if(rq('reply_to')){
    		$target = $this->find('reply_to');
    		if(!$target)
    			return err('Target comment doesnt exist.');   

    		if($target->user_id == session('user_id'))
    			return err('You cant reply to yourself.');   

    		$this->reply_to = rq('reply_to');
    	}

    	$this->content = rq('content');
    	$this->user_id = session('user_id');

    	return $this->save() ?
   			suc(['id' => $this->id]) : 
    		err('DB insert failed.');
   	}

   	public function read(){
   		if(!rq('question_id') && !rq('answer_id'))
   			return err('question_id or answer_id required.');   

   		if(rq('question_id')){
   			$question = question_ins()->find(rq('question_id'));

   			if(!$question)
   				return err('Question doesnt exist.');  

   			$data = $this->where('question_id', rq('question_id'))->get();
   		}
   		else{
			$answer = answer_ins()->find(rq('answer_id'));

   			if(!$answer)
   				return err('Answer doesnt exist.');  
   			
   			$data = $this->where('answer_id', rq('answer_id'));
   		}

   		$data = $data->get()->keyBy('id');

   		return suc(['data' => $data]); 
   	} 

   	public function remove(){
   		if(!user_ins()->is_logged_in())
   			return err('Login required.'); 

   		if(!rq('id'))
   			return err('ID is required.'); 

   		$comment = $this->find(rq('id'));
   		if(!$comment)
   			return err('Comment doesnt exist.'); 

   		if($comment->user_id != session('user_id'))
   			return err('Permission denied.'); 

   		$this->where('reply_to', rq('id'))->delete();

   		return $comment->delete() ?
   			suc('Delete success!') : 
    		err('DB delete failed.');
   	}
}




















