<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
function rq($key = null, $default = null){
	if (!$key)
		return Request::all();
	return Request::get($key, $default);
}

function user_ins(){
	return new App\User;
}

function question_ins(){
	return new App\Question;
}

function answer_ins(){
	return new App\Answer;
}

function comment_ins(){
	return new App\Comment;
}

function paginate($page = 1, $limit = 15){
	$limit = $limit ? : 15;
	$skip = ($page ? $page - 1 : 0) * $limit;
	return [$limit, $skip];
}

function err($msg = null){
	return ['status' => 0, 'msg' => $msg];
}

function suc($data_to_add = []){
	$data = ['status' => 1, 'data' => []];
	if($data_to_add)
		$data['data'] = $data_to_add;

	return $data;
}


function is_logged_in(){
	return session('user_id') ? : false;
}

Route::get('/', function () {
    return view('index');
});

// Route::get('api/user', function(){
// 	return ['version' => 0.1];
// });

Route::any('api/signup', function(){
	return user_ins()->signup();
});

Route::any('api/login', function(){
	return user_ins()->login();
});

Route::any('api/logout', function(){
	return user_ins()->logout();
});

Route::any('api/test', function(){
	dd(user_ins()->is_logged_in());
});

/* user utilities */
Route::any('api/user/change_password', function(){
	return user_ins()->change_password();
});

Route::any('api/user/reset_password', function(){
	return user_ins()->reset_password();
});

Route::any('api/user/validate_reset_password', function(){
	return user_ins()->validate_reset_password();
});

Route::any('api/user/read', function(){
	return user_ins()->read();
});

Route::any('api/user/exist', function(){
	return user_ins()->exist();
});

/* questions */
Route::any('api/question/add', function(){
	return question_ins()->add();
});

Route::any('api/question/change', function(){
	return question_ins()->change();
});

Route::any('api/question/read', function(){
	return question_ins()->read();
});

Route::any('api/question/remove', function(){
	return question_ins()->remove();
});

/* answers */
Route::any('api/answer/add', function(){
	return answer_ins()->add();
});

Route::any('api/answer/change', function(){
	return answer_ins()->change();
});

Route::any('api/answer/read', function(){
	return answer_ins()->read();
});

Route::any('api/answer/remove', function(){
	return answer_ins()->remove();
});

Route::any('api/answer/vote', function(){
	return answer_ins()->vote();
});

/* comments */
Route::any('api/comment/add', function(){
	return comment_ins()->add();
});

Route::any('api/comment/read', function(){
	return comment_ins()->read();
});

Route::any('api/comment/remove', function(){
	return comment_ins()->remove();
});

Route::any('api/timeline', 'CommonController@timeline');

Route::get('tpl/page/home', function(){
	return view('pages.home');
});

Route::get('tpl/page/signup', function(){
	return view('pages.signup');
});

Route::get('tpl/page/login', function(){
	return view('pages.login');
});


Route::get('tpl/page/question_add', function(){
	return view('pages.question_add');
});

Route::get('tpl/page/user', function(){
	return view('pages.user');
});

Route::get('tpl/page/question_detail', function(){
	return view('pages.question_detail');
});
























