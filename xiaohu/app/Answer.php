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
   			suc(['Success!']) : 
    		err('DB update failed.');
    }

    public function read(){
    	if(!rq('id') && !rq('question_id'))
    		return err('ID and question_id are required.');

   		if(rq('id')){
   			$answer = $this
                ->with('user')
                ->with('users')
                ->find(rq('id'));

   			if(!$answer)
   				return err('answer does not exist');

   			return ['status' => 1, 'data' => $answer];
   		}

   		if(!question_ins()->find(rq('question_id')))
   			return err('answer does not exist');

   		$answer = $this
        ->with('user')
        ->with('users')
   			->where('question_id', rq('question_id'))
   			->get()
   			->keyBy('id');

   		return suc([$answer]);
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

        // 1: support, 2: against, 3: clear vote
   		$vote = rq('vote');
        if($vote != 1 && $vote !=2 && $vote !=3)
            return err('invalid vote');

   		$answer->users()
   			->newPivotStatement()
   			->where('user_id', session('user_id'))
   			->where('answer_id', rq('id'))
   			->delete();

        if($vote == 3)
            return ['status' => 1];

   		$answer
   			->users()
   			->attach(session('user_id'), ['vote' => $vote]);

   		return suc(['success!']);
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






















