<!doctype html>
<html lang="en" ng-app="xiaohu">
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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
	<nav class="transparent">
	    <div class="nav-wrapper">
	      	<a href="" class="brand-logo" ui-sref="home">Logo</a>
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


	<script type="text/ng-template" id="home.tpl">
		<div class="home center-container card" ng-controller="HomeController">
			<h3>Latest</h3>
			<div class="hr"></div>

			<div class="item-set">
				<div ng-repeat="item in Timeline.data" class="item  card-padding">
					<div class="vote"></div>
					<div class="item-content">
						<div ng-if="item.question_id" class="content-act">][:item.user.username:] added Answer</div>
						<div ng-if="!item.question_id" class="content-act">[:item.user.username:] added Question</div>
						<div class="title">[:item.title:]</div>
						<div class="content-owner"> [:item.user.username:]
							<span class="desc">编程话题优秀回答者装配脑袋一路走好。</span>
						</div>
						<div class="content-main">
							[:item.desc:]
						</div>
						<div class="action-set">
							<div class="comment">Comment</div>
						</div>
						<div class="conmment-block">
							<div class="hr"></div>
							<div class="comment-item-set">
								<div class="comment-item clear-float">
									<div class="user">simulife</div>
									<div class="comment-content">
										微软能革自己的命是因为windows是微软一家的平台，微软革了命，微软掌握着平台和用户，开发者就得跟着屁股跑在后头，还有人骂微软折腾苦逼开发者呢。html/css/js是web app的基础吧，google想革就能把整个世界都革了么，google只是其中有影响力的一员，没有平台和用户绑架其他跟他竞争的开发者的...google自己推出了Dart，，都要兼容js，微软也有TypeScript。开发者跟了多少...呵呵。
									</div>
								</div>

								<div class="comment-item clear-float">
									<div class="user">Ivony</div>
									<div class="comment-content">
										我认为Google应当和各个厂商合作积极推进Web技术的发展，而不是出于自己的目的积极推进标准化。可以说其实所谓的Web标准化目前在阻碍用户体验的提升，用个不恰当的例子，Web技术需要一次跨越性的发展，就像转基因技术一样，虽然会有公众的不理解和风险，但在这个上面的投入可以得到非常大的回报大大改善人类的生活质量。而传统的杂交育种技术，虽然有广泛的群众基础和较为容易被接受，却已经是穷途末路，能够带来的产量提升长远来看非常有限。
									</div>
								</div>

								<div class="comment-item clear-float">
									<div class="user">Minko</div>
									<div class="comment-content">
										javascript刚出来时，java正在风行全球，故为了扩大该语言知名度，命名为javascript
									</div>
								</div>

								<div class="comment-item clear-float">
									<div class="user">franky</div>
									<div class="comment-content">
										不要乱喷，CISC架构是不如RISC架构，但是事实上CPU内部是有指令译码器直接把CISC的指令译码成RISC的执行，所以这个问题只是译码由编译器完成还是由CPU完成，本质上并没有区别，而且x86的CISC架构在兼容和面向程序员友好方面优势巨大。当然目前的方向是虚拟机，这样一来下面的指令集是什么就更不重要了。

Windows明显很差？如果真的很差为什么还有这么多人用？你以为用户和软件商都是傻子？你要说Win32 API很丑陋也算有道理，但那是历史余孽，显然微软是愿意革自己的命的，微软在2000年就推出了.NET代替原有的Windows API，现在XAML更是部署到了所有的平台。

而Google呢？我只能说不能革自己命的公司迟早被别人革命。
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="hr"></div>
				</div>

				<div ng-if="Timeline.pending" class="tac">Loading...</div>
				<div ng-if="Timeline.no_more_data" class="tac">No more data.</div>
			</div>
		</div>
	</script>

	<script type="text/ng-template" id="login.tpl">
		<div ng-controller="LoginController" class="container">
			<div class="card form-padding">
				<h3>Login</h3>
				<!-- <h4>data: [: User.signup_data :]</h4> -->
				<form class="col s12" name="login_form" ng-submit="User.login()" >
					<div class="row">
				        <div class="input-field col s12">
				          	<input 
				          		id="username" 
				          		name="username" 
				          		type="text" 
				          		class="validate" 
				          		ng-minlength="4"
				          		ng-maxlength="16"
				          		ng-model="User.login_data.username"
				          		ng-model-options="{debounce: 300}"
				          		required
				          	>
				          	<label for="username">Username</label>

				          	<div class="input-error-set" ng-if="login_form.username.$touched">
				          		<div ng-if="login_form.username.$error.required">Username is required.</div>
				          		<div ng-if="User.login_failed">Wrong username or password.</div>
				          	</div>
				        </div>
				    </div>

					<div class="row">
				        <div class="input-field col s12">
				          	<input 
				          		id="last_name" 
				          		name="password" 
				          		type="password" 
				          		class="validate" 
				          		ng-model="User.login_data.password"
				          		ng-model-options="{updataOn:blur}"
				          		required
				          	>
				          	<label for="last_name">Password</label>

				          	<div class="input-error-set" ng-if="login_form.password.$touched">
				          		<div ng-if="login_form.password.$error.required">Password is required.</div>
				          	</div>
				        </div>
			      	</div>
					
					<button class="waves-effect waves-light btn" 
						type="submit"
						ng-disabled="login_form.$invalid"
					>Submit</button>
				</form>
			</div>
		</div>
	</script>

	<script type="text/ng-template" id="signup.tpl">
		<div ng-controller="SignupController" class="container">
			<div class="card form-padding">
				<h3>Signup</h3>
				<!-- <h4>data: [: User.signup_data :]</h4> -->
				<form class="col s12" name="signup_form" ng-submit="User.signup()" >
					<div class="row">
				        <div class="input-field col s12">
				          	<input 
				          		id="username" 
				          		name="username" 
				          		type="text" 
				          		class="validate" 
				          		ng-minlength="4"
				          		ng-maxlength="16"
				          		ng-model="User.signup_data.username"
				          		ng-model-options="{debounce: 300}"
				          		required
				          	>
				          	<label for="username">Username</label>

				          	<div class="input-error-set" ng-if="signup_form.username.$touched">
				          		<div ng-if="signup_form.username.$error.required">Username is required.</div>
				          		<div ng-if="signup_form.username.$error.minlength || signup_form.username.$error.maxlength">Username length invalid .</div>
				          		<div ng-if="User.signup_username_exists">Username existed.</div>
				          	</div>
				        </div>
					</div>

					<div class="row">
				        <div class="input-field col s12">
				          	<input 
				          		id="last_name" 
				          		name="password" 
				          		type="password" 
				          		class="validate" 
				          		ng-minlength="4"
				          		ng-maxlength="255"
				          		ng-model="User.signup_data.password"
				          		ng-model-options="{updataOn:blur}"
				          		required
				          	>
				          	<label for="last_name">Password</label>

				          	<div class="input-error-set" ng-if="signup_form.password.$touched">
				          		<div ng-if="signup_form.password.$error.required">Password is required.</div>
				          		<div ng-if="signup_form.password.$error.minlength || signup_form.password.$error.maxlength">Password length invalid .</div>
				          	</div>
				        </div>
			      	</div>
					
					<button class="waves-effect waves-light btn" 
						type="submit"
						ng-disabled="signup_form.$invalid"
					>Submit</button>
				</form>
			</div>
		</div>
	</script>

	<script type="text/ng-template" id="question.add.tpl">
		<div ng-controller="QuestionAddController" class="container">
			 <div class="row form-padding card ">
			    <form name="question_add_form" class="col s12" ng-submit="Question.add()">
			      	<div class="row">
			        	<div class="input-field col s12">
				          	<input  
				          		id="title" 
				          		name="title"
				          		type="text" 
				          		ng-minlength="5"
				          		ng-model="Question.new_question.title"
				          		required
				          	>
				          	<label for="title">Title</label>
				        </div>
			      	</div>
			      	
			      	<div class="row">
				        <div class="input-field col s12">
				          	<textarea 
				          		id="textarea1" 
				          		name="desc"
				          		class="materialize-textarea"
				          		ng-model="Question.new_question.desc"
				          	></textarea>
				          	<label for="textarea1">Textarea</label>
				      	</div>
			      	</div>

			      	<button 
			      		class="waves-effect waves-light btn" 
			      		type="submit"
			      		ng-disabled="question_add_form.$invalid"
			      	>Submit</button>

			    </form>
			</div>
		</div>
	</script>

	<script>
		$(".button-collapse").sideNav();
		$("#search_close").click(function(){
			$("#search").val("").focus();
		})
	</script>

	<script>

	</script>
</body>
</html>




























