<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;

class User extends Model{
    //public $table = 'user_table';
	private function has_username_and_password(){
		$username = rq('username');
		$password = rq('password');

		// if(!($username && $password))
		// 	return err('Username and password mustn\'t be empty.'];
		if($username && $password)
			return [$username, $password];
		
		return false;
	}

	public function read(){
		//echo "wdf";
		if(!rq('id'))
			return err('ID required');

		$get = ['id', 'username', 'avatar_url', 'intro'];
		$user = $this->find(rq('id'), $get);

		$data = $user->toArray();

		$answers_count = answer_ins()->where('user_id', rq('id'))->count();
		$question_count = question_ins()->where('user_id', rq('id'))->count();

		// $answers_count = $user->answers()->count;
		// $question_count = $user->questions()->count;

		// dd($answers_count);
		
		$data['answers_count'] = $answers_count;
		$data['question_count'] = $question_count;
		return suc($data);
	}

	public function signup(){
		// check userName and password 
		$has_username_and_password = $this->has_username_and_password();
		//echo $has_username_and_password;

		if(!$has_username_and_password)
			return err('Username and password mustn\'t be empty.');

		$username = $has_username_and_password[0];
		$password = $has_username_and_password[1];

		$user_exists = $this->where('username', $username)->exists();

		if($user_exists)
			return err('Username exists.'); 

		/*Encrypt password*/
		$hashed_password = Hash::make($password);
		// Hash::make = bcrypt
		// $hashed_password = bcrypt($password);
		//dd($hashed_password);
		$user = $this;
		$user->username = $username;
		$user->password = $hashed_password;
		if($user->save())
			return suc(['id' => $user->id]);
		else 
			return err('database insert failed');

		return 1;
		// dd(Request::get('age'));
		// dd(Request::has('username'));
		// dd(Request::all());
	}

	public function login(){
		$has_username_and_password = $this->has_username_and_password();
		//echo var_dump($has_username_and_password);

		if(!$has_username_and_password)
			return err('Username and password mustn\'t be empty.');

		$username = $has_username_and_password[0];
		$password = $has_username_and_password[1];

		$user = $this->where('username', $username)->first();

		
		if(!$user)
			return err('User does not exist');
		
		$hashed_password = $user->password;
		//echo $hashed_password;

		if(!Hash::check($password, $hashed_password))
			return err('Wrong password');

		session()->put('username', $user->username);
		session()->put('user_id', $user->id);

		//dd(session()->all());

		return suc(['id' => $user->id]);;
	}

	public function logout(){
		/* easiest way */
		//session()->flush();

		/* for more complecated app */
		// session()->put('username', null);
		// session()->put('user_id', null);

		/* another way */
		session()->forget('username');
		session()->forget('user_id');

		//dd(session()->all());

		/* return to index */
		//return redirect('/');
		return ['status' => 1];
	}

	public function is_logged_in(){
		return is_logged_in();
	}

	public function vote(){

	}

	public function change_password(){
		if(!$this->is_logged_in())
			return err('login required');

		if(!rq('old_password'))
			return err('old password required');

		if(!rq('new_password'))
			return err('nre password required');

		$user = $this->find(session('user_id'));
		if(!Hash::check(rq('old_password'), $user->password))
			return err('old password wrong');

		$user->password = bcrypt(rq('new_password'));
		return $user->save() ?
			suc('Password changed.') : 
			err('DB error.');
	}
	
	public function reset_password(){
		if($this->is_robot(2))
			return err('max frequency reached');

		if(!rq('phone'))
			return err('phone number reqiured');

		$user = $this->where('phone', rq('phone'))->first();

		if(!$user)
			return err('invalid phone number');

		$captcha = $this->generate_captcha();
		
		$user->phone_captcha = $captcha;

		if ($user->save()){
			$this->send_sms();
			$this->updata_robot_time();
			return suc();
		}
		return err('db update error');
	}

	public function validate_reset_password(){
		if($this->is_robot(2))
			return err('max frequency reached');

		//echo var_dump(rq('phone'));
		if(!rq('phone') || !rq('phone_captcha') || !rq('new_password'))
			return err('phone, phone_captcha and new_passwrod are required');

		$user = $this->where([
			'phone' => rq('phone'),
			'phone_captcha' => rq('phone_captcha')
		])->first();

		if(!$user)
			return err('invalid phone or captcha');

		$user->password = bcrypt(rq('new_password'));
		$this->updata_robot_time();

		return $user->save() ?
			suc(['success']) : err('db update failed');
	}

	public function send_sms(){
		return true;
	}

	public function is_robot($time = 10){
		if(!session('last_action_time'))
			return false;

		$current_time = time();
		$last_active_time = session('last_action_time');

		$elapsed = $current_time - $last_active_time;
		
		return !($elapsed > $time);

	}

	public function updata_robot_time(){
		session()->set('last_action_time', time());
	}

	public function generate_captcha(){
		return rand(1000, 9999);
	}

	public function answers(){
   		return $this
   			->belongsToMany('App\Answer')
   			->withPivot('vote')
   			->withTimestamps();
	}

	public function questions(){
   		return $this
   			->belongsToMany('App\Questions')
   			->withPivot('vote')
   			->withTimestamps();
	}

	public function exist(){
		return suc(['count' => $this->where(rq())->count()]);
	}
}



























