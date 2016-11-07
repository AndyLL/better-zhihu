;(function(){
	'use strict'

	var app = angular.module('user', ['answer'])

	app.service('UserService', [
		'$state',
		'$http',
		function($state, $http){
			var me = this
			me.signup_data = {}
			me.login_data = {}
			me.data = {}

			me.signup = function(){
				$http.post('api/signup', me.signup_data)
					.then(function(r){
						if(r.data.status){
							me.signup_data = {}						
							$state.go('login')
						}
					}),
					function(e){
						console.log(e)
					}
			}

			me.username_exists = function(){
				$http.post('api/user/exist', {username: me.signup_data.username})
					.then(function(r){
						if(r.data.status && r.data.data.count)
							me.signup_username_exists = true
						else me.signup_username_exists = false
					}, function(e){
						console.log('e', e)
					})
			}

			me.login = function(){
				$http.post('api/login', me.login_data)
					.then(function(r){
						if(r.data.status)
							location.href = '/'
						else
							me.login_failed = true
					}), function(){

					}
			}

			me.logout = function(){
				$http.post('api/logout', me.login_data)
					.then(function(r){
						if(r.data.status){
							console.log('yse')
							location.href = '/'
						}
						else{
							console.log('no')
							location.href = '/'
						}
					}), function(){
						console.log('???')
					}
			}

			me.read = function(param){
				return $http.post('/api/user/read', param)
					.then(function(r){
						if(r.data.status){
							me.current_user = r.data.data
							// //console.log(r.data.data)
							// if(param.id == 'self')
							// 	me.self_data = r.data.data
							// else
							me.data[param.id] = r.data.data //??????????

							// if(param.id == 'self')
							// 	me.data.self = r.data.data
						}
						else{
							if(r.data.msg == 'login required.')
								$state.go('login')
						}
					})
			}
	}])

	app.controller('SignupController', [
		'$scope',
		'UserService',
		function($scope, UserService){
			$scope.User = UserService;

			$scope.$watch(function(){
				return UserService.signup_data
			}, function(n, o){
				if(n.username != o.username)
					UserService.username_exists()
			}, true)
	}])

	app.controller('LoginController', [
		'$scope',
		'UserService',
		function($scope, UserService){
			$scope.User = UserService
		}
	])

	app.controller('UserController', [
		'$scope',
		'$stateParams',
		'AnswerService',
		'QuestionService',
		'UserService',
		function($scope, $stateParams, AnswerService, QuestionService, UserService){
			$scope.User = UserService
			//console.log($stateParams)
			UserService.read($stateParams)
			AnswerService.read({user_id: $stateParams.id})
				.then(function(r){
					if(r)
						UserService.his_answers = r
				})
			QuestionService.read({user_id: $stateParams.id})
				.then(function(r){
					if(r)
						UserService.his_questions = r
				})
		}
	])
})()


















