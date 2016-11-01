<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model{
    public function add(){
    	if(!user_ins()->is_logged_in())
   			return err('Login required.'); 

   		if(!rq('question_id') || !rq('content'))
   			return err('Question_id and content are required.'); 

   		$question = question_ins()->find(rq('question_id'));

   		if(!$question)
   			return err('Question doesn\'t exist.');

   		$answered = $this
   			->where(['question_id' => rq('question_id'), 'user_id' => session('user_id')])
   			->count();

   		if($answered)
   			return err('duplicate answers.');


   		$this->content = rq('content');
   		$this->question_id = rq('question_id');
   		$this->user_id = session('user_id');

   		return $this->save() ? 
   			suc(['id' => $this->id]) : 
    		err('DB insert failed.'); 
    }

    public function change(){
    	if(!user_ins()->is_logged_in())
   			return err('Login required.'); 

   		if(!rq('id') || !rq('content'))
   			return err('ID and content are required.'); 

   		$answer = $this->find(rq('id'));

   		if(!$answer)
   			return err('Answer doesnt exist.'); 

   		if($answer->user_id != session('user_id'))
   			return err('Permission denied.');

   		$answer->content = rq('content');

   		return $answer->save() ?
   			suc('Success!') : 
    		err('DB update failed.');
    }

    public function read(){
    	if(!rq('id') && !rq('question_id'))
    		return suc('ID and question_id are required.');

   		if(rq('id')){
   			$answer = $this->find(rq('id'));
   			if(!$answer)
   				return err('answer does not exist');

   			return suc('data', $answer);
   		}

   		if(!question_ins()->find(rq('question_id')))
   			return err('answer does not exist');

   		$answer = $this
   			->where('question_id', rq('question_id'))
   			->get()
   			->keyBy('id');

   		return suc(['data' => $answer]);
   	}

   	public function vote(){
   		if(!user_ins()->is_logged_in())
   			return err('Login required.'); 

   		if(!rq('id') || !rq('vote'))
   			return err('answer_id and vote are required.');

   		/* check if user voted or not */ 
   		$answer = $this->find(rq('id'));

   		if(!$answer)
   			return err('Answer doesnt exist.');

   		$vote = rq('vote') <= 1 ? 1 : 2;

   		$answer->users()
   			->newPivotStatement()
   			->where('user_id', session('user_id'))
   			->where('answer_id', rq('id'))
   			->delete();

   		$answer
   			->users()
   			->attach(session('user_id'), ['vote' => $vote]);

   		return suc('success!');
   	}
    
    public function user(){
        return $this->belongsTo('App\User');
    }

   	public function users(){
   		return $this
   			->belongsToMany('App\User')
   			->withPivot('vote')
   			->withTimestamps();
	}


}






















