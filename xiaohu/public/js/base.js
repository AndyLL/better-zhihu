;(function(){
	'use strict'

	window.his = {
		id: parseInt($('html').attr('user-id'))
	}

	var app = angular.module('xiaohu', [
			'ui.router',
			'common',
			'answer',
			'user',
			'question'			
			])
	
	app.config([
			'$interpolateProvider',
			'$stateProvider',
			'$urlRouterProvider',
			function($interpolateProvider, 
						$stateProvider, 
						$urlRouterProvider){
		$interpolateProvider.startSymbol('[:')
		$interpolateProvider.endSymbol(':]')

		$urlRouterProvider.otherwise('/home')

		$stateProvider
			.state('home', {
				url: '/home',
				templateUrl: '/tpl/page/home'
			})
			.state('login', {
				url: '/login',
				templateUrl: '/tpl/page/login'
			})
			.state('signup', {
				url: '/signup',
				templateUrl: '/tpl/page/signup'
			})
			.state('question', {
				abstract: true,
				url: '/question',
				template: '<div ui-view></div>',
				controller: 'QuestionController'
			})
			.state('question.add', {
				url: '/add',
				templateUrl: '/tpl/page/question_add'
			})
			.state('question.detail', {
				url: '/detail/:id',
				templateUrl: '/tpl/page/question_detail'
			})
			.state('user', {
				url: '/user/:id',
				templateUrl: '/tpl/page/user'
			})
	}])

	/* root scope */
	// .controller('TestController', function($scope){
	// 	$scope.name = 'Bob'

	// })
})()






















