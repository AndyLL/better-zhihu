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

    public function read_by_user_id($user_id){
        $user = user_ins()->find($user_id);
        
        if(!$user)
            return err('user does not exist');

        $r = $this
                ->with('question')
                ->where('user_id', $user_id)
                ->get()
                ->keyBy('id');

        return suc($r->toArray());
    }

    public function read(){
    	if(!rq('id') && !rq('question_id') && !rq('user_id'))
    		return err('ID and question_id are required.');

        if(rq('user_id')){
            $user_id = rq('user_id') === 'self' ? 
                session('user_id') : 
                rq('user_id');       

            return $this->read_by_user_id($user_id);
        }

   		if(rq('id')){
   			// 查看单个问题回答
   			$answer = $this
                ->with('user')
                ->with('users')
                ->find(rq('id'));

   			if(!$answer)
   				return err('answer does not exist');

   			$answer = $this->count_vote($answer);

   			return ['status' => 1, 'data' => $answer];
   		}

   		// chech if question exists
   		if(!question_ins()->find(rq('question_id')))
   			return err('question does not exist');

   		$answers = $this
        ->with('user')
        ->with('users')
   			->where('question_id', rq('question_id'))
   			->get()
   			->keyBy('id');

   		return ['status' => 1, 'data' => $answers];
   	}

   	public function count_vote($answer){
   		$upvote_count = 0;
   		$downvote_count = 0;
   		foreach($answer->users as $user){
   			if($user->pivot->vote == 1)
				$upvote_count++;
			else
				$downvote_count++;
   		}

   		$answer->upvote_count = $upvote_count;
   		$answer->downvote_count = $downvote_count;

   		return $answer;
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

        // check if user has voted, if so delete the vote
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

    public function question(){
        return $this->belongsTo('App\Question');
    }
}






















