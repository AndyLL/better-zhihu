<!doctype html>
<html lang="en" ng-app="xiaohu" user-id="{{session('user_id')}}">
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
	<script src="/js/question_add.js"></script>
	<script src="/js/answer.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
		        <li><a href="" ui-sref="signup">{{session('username')}}</a></li>
		        <li><a href="{{url('api/logout')}}">Logout</a></li>
		        @else
		        <li><a href="" ui-sref="signup">Signup</a></li>
		        <li><a href="" ui-sref="login">Login</a></li>
		        @endif
	     	</ul>

	      	<ul class="side-nav" id="mobile-demo">
		        <li><a href="" ui-sref="home">Home</a></li>
		        <li><a href="" ui-sref="signup">Signup</a></li>
		        <li><a href="" ui-sref="login">Login</a></li>
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




























