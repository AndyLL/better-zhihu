;(function(){
	'use strict'

	var app = angular.module('question', [])
	
	app.service('QuestionService', [
		'$http',
		'$state',
		'AnswerService',
		function($http, $state, AnswerService){
			var me = this
			me.new_question = {}
			me.data = {}
			me.go_add_question = function(){
				console.log("sdafsad")
				$state.go('question.add')
			}

			me.add = function(){
				if(!me.new_question.title)
					return 

				$http.post('/api/question/add', me.new_question)
					.then(function(r){
						me.new_question = {}
						$state.go('home')
					}), function(e){

					}
			}

			me.read = function(params) {
				return $http.post('/api/question/read', params)
					.then(function(r){
						if(r.data.status){
							if(params.id){
								me.data[params.id] = me.current_question = r.data.data
								me.its_answers = me.current_question.answers_with_user_info
								me.its_answers = AnswerService.count_vote(me.its_answers)
							}
							else
								me.data = angular.merge({}, me.datat, r.data.data)

							return r.data.data
						}
						return false
					})
			}

			me.vote = function(conf){
				AnswerService.vote(conf)
					.then(function(r){
						if(r)
							me.update_answer(conf.id)
					})
			}

			me.update_answer = function(answer_id){
				$http.post('/api/answer/read', {id: answer_id})
					.then(function(r){
						if(r.data.status)
							for(var i = 0; i < me.its_answers.length; i++){
								var answer = me.its_answers[i]
								if(answer.id == answer_id){
									//console.log(r.data.data)
									me.its_answers[i] = r.data.data
									AnswerService.data[answer_id] = r.data.data
								}
							}
					})
			}
		}
	])

	app.controller('QuestionController', [
		'$scope',
		'QuestionService',
		function($scope, QuestionService){
			$scope.Question = QuestionService
			//console.log($scope.Question)
		}
	])

	app.controller('QuestionAddController', [
		'$scope',
		'$state',
		'QuestionService',
		function($scope, $state, QuestionService){
			$scope.Question = QuestionService
			if(!his.id)
				$state.go('login')
		}
	])

	app.controller('QuestionDetailController',[
		'$scope',
		'$stateParams',
		'AnswerService',
		'QuestionService',
		function($scope, $stateParams, AnswerService, QuestionService){
		$scope.Answer = AnswerService
			QuestionService.read($stateParams)
			if($stateParams.answer_id)
				QuestionService.current_answer_id = $stateParams.answer_id
			else 
				QuestionService.current_answer_id = null
		}
	])
})()

















