<!doctype html>
<html lang="en" 
		ng-app="xiaohu" 
		user-id="{{session('user_id')}}"
		ng-controller="BaseController"
	>
<head>
	<meta charset="UTF-8">
	<title>xiaohu</title>
	<link rel="stylesheet" href="node_modules/normalize-css/normalize.css">
	<link rel="stylesheet" href="/css/materialize.min.css">
	<link rel="stylesheet" href="/css/base.css">
	<script src="/node_modules/jquery/dist/jquery.js"></script>
	<script src="js/materialize.js"></script>
	<script src="/node_modules/angular/angular.js"></script>
	<script src="/node_modules/angular-ui-router/release/angular-ui-router.js"></script>
	<script src="/js/base.js"></script>
	<script src="/js/common.js"></script>
	<script src="/js/user.js"></script>
	<script src="/js/question.js"></script>
	<script src="/js/answer.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400" rel="stylesheet">
</head>

<body>
	<nav class="transparent">
	    <div class="nav-wrapper">
	      	<a href="" class="brand-logo" ui-sref="home"></a>
	      	<a href="#" data-activates="mobile-demo" class="button-collapse">
	      		<i class="material-icons">menu</i>
	      	</a>
			<ul class="left hide-on-med-and-down searchbar">
				<li>
			        <form id="quick_ask" ng-submit="Question.go_add_question()" ng-controller="QuestionAddController">
				        <div class="input-field">
				          	<input id="search" type="search" ng-model="Question.new_question.title" required>
				          	<label for="search"><i class="material-icons">search</i></label>
				          	<i id="search_close" class="material-icons">close</i>
				        </div>
			      	</form>
			      	<!-- ask new question  -->
		      	</li>
			</ul>

	      	<ul class="right hide-on-med-and-down">
		        <li><a href="" ui-sref="home">Home</a></li>
		        @if(is_logged_in())
		        <li><a ui-sref="signup">{{session('username')}}</a></li>
		        <li><a href="{{url('api/logout')}}">Logout</a></li>
		        @else
		        <li><a ui-sref="signup">Signup</a></li>
		        <li><a ui-sref="login">Login</a></li>
		        @endif
	     	</ul>

	      	<ul class="side-nav" id="mobile-demo">
		        <li><a ui-sref="home">Home</a></li>
		        <li><a hui-sref="signup">Signup</a></li>
		        <li><a ui-sref="login">Login</a></li>
	      	</ul>
	    </div>
  	</nav>

<!-- 	<nav>
	    <div class="nav-wrapper">
	    	<a href="" class="brand-logo" ui-sref="home">Logo</a>
	      	<ul id="nav-mobile" class="right hide-on-med-and-down">
	      		<li><a href="" ui-sref="home">Home</a></li>
		        <li><a href="" ui-sref="signup">Signup</a></li>
		        <li><a href="" ui-sref="login">Login</a></li>
	      	</ul>
	    </div>
  	</nav> -->

	<div class="page">
		<div ui-view></div>
	</div>

	<footer class="page-footer black-text">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5>Footer Content</h5>
					<p>You can use rows and columns here to organize your footer content.</p>
				</div>
				<div class="col l4 offset-l2 s12">
					<h5>Links</h5>
					<ul>
						<li><a href="#!">Link 1</a></li>
						<li><a href="#!">Link 2</a></li>
						<li><a href="#!">Link 3</a></li>
						<li><a href="#!">Link 4</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container"> © 2016 AndyLL <a href="#!">More Links</a> </div>
		</div>
	</footer>

	<script type="text/ng-template" id="comment.tpl">
		<div class="conmment-block">
			<div class="hr"></div>
			<div class="comment-item-set">
				<div ng-if="!helper.obj_length(data)" class="tac"> No comment.</div>
				<div ng-if="helper.obj_length(data)" 
					ng-repeat="item in data" class="comment-item clear-float">
					<div class="user">[: item.user.username :]</div>
					<div class="comment-content"> [: item.content :] </div>
				</div>
			</div> 
		</div> 

		<form ng-submit="_.add_comment()" class="col s12 comment-form">
	      	<div class="row">
	        	<div class="input-field col s12">
		          	<textarea ng-model="Answer.new_comment.content" id="textarea1" class="materialize-textarea"></textarea>
		          	<label for="textarea1">Reply</label>
	        	</div>
	        	<button class="float-right btn waves-effect waves-light light-blue darken-1" type="submit">
	        		Reply<i class="material-icons right">send</i></button>
	      	</div>
	    </form>
	</script>

	<script>
		$(".button-collapse").sideNav();
		$("#search_close").click(function(){
			console.log("sa")
			$(".input-field input[type=search]").val("").focus()
		})
		$(".input-field input[type=search]").focus(function(){
			$("#search_close").css('display', 'block')
		})
		$(".input-field input[type=search]").blur(function(){
			$("#search_close").css('display', 'none')
		})
	</script>
</body>
</html>




























