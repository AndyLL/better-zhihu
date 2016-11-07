;(function(){
	'use strict'

	var app	= angular.module('answer', [])

	app.service('AnswerService', [
		'$http',
		'$state',
		function($http, $state){
			var me = this
			me.data = {}
			me.answer_form = {}

			/*统计票数
			 * @answers array 用于统计投票的数据
			 * 此数据可以款也是问题也可以是回答
			 * 如果是问题跳过统计
			 * */
			me.count_vote = function(answers){
				for(var i = 0; i < answers.length; i++){
					var item = answers[i]

					// not a question 
					if(!item['question_id'] ) 
						continue
					
					me.data[item.id] = item

					if(!item['users'])
						continue

					item.upvote_count = 0
					item.downvote_count = 0	

					// users - 所有投票用户的用户信息		
					var votes = item['users']

					// 获取
					if(votes){
						for(var j = 0; j < votes.length; j++){
							var v = votes[j]

							// 获取pivote 元素中的用户投票信息
							if(v['pivot'].vote === 1)
								item.upvote_count++
							if(v['pivot'].vote === 2)
								item.downvote_count++
						}
					}
				}
				
				return answers
			}

			me.vote = function(conf){
				if(!conf.id || !conf.vote){
					console.log('id and vote are required')
					return 
				}

				var answer = me.data[conf.id]
				var users = answer.users

				// chech if user has already vote for support, if yes, cancel it(set vote =3) 
				for(var i = 0; i < users.length; i++){
					if(users[i].id == his.id && conf.vote == users[i].pivot.vote)
						conf.vote = 3
				}

				return $http.post('/api/answer/vote', conf)
					.then(function(r){
						if(r.data.status)
							return true
						else if(r.data.msg == 'Login required.')
							$state.go('login')
						else
							return false
					}, function(){
						return false
					}) 
			}

			me.update_data = function(id){ //input
				// if(angular.isNumeric(input))
				// 	var id = input

				// if(angular.isArray(input))
				// 	var id_set = input
				return $http.post('/api/answer/read', {id: id})
					.then(function(r){
						me.data[id] = r.data.data
					})
			}

			me.read = function(params){
				return $http.post('/api/answer/read', params)
					.then(function(r){
						if(r.data.status){
							me.data = angular.merge({}, me.data, r.data.data)
							return r.data.data
						}
						return false
					})
			}

			me.add_or_update = function(question_id){
				if(!question_id){
					console.error('question_id is required')
					return
				}
				me.answer_form.question_id = question_id
				if(me.answer_form.id)
					$http.post('/api/answer/change', me.answer_form)
						.then(function(r){
							if(r.data.status){
								me.answer_form = {}
								$state.reload()
								console.log('1')
								return	
							}
						})
				else
					$http.post('/api/answer/add', me.answer_form)
						.then(function(r){
							if(r.data.status){
								me.answer_form = {}
								$state.reload()
								console.log('1')
								return	
							}
						})
			}

			me.delete = function(id){
				if(!id){
					cnosole.log('id is required')
					return 
				}

				$http.post('api/answer/remove', {id: id})
					.then(function(r){
						if(r.data.status){
							console.log('1')
							$state.reload()
							return
						}
					})
			}

			me.add_comment = function(){
				return $http.post('api/comment/add', me.new_comment)
							.then(function(r){
								if(r.data.status)
									return true
								return false
						})
			}
		}
	])

	.directive('commentBlock', [
		'$http',
		'AnswerService',
		'$state',
		function($http, AnswerService, $state){
			var o = {}
			o.templateUrl = 'comment.tpl' 

			o.scope = {
				answer_id: '=answerId',
			}

			o.link = function(sco, ele, attr){ //ele = $(this)
				sco.Answer = AnswerService
				sco._ = {}
				sco.data = {}
				sco.helper = helper

				function get_comment_list(){
					return $http.post('/api/comment/read', {answer_id: sco.answer_id})
						.then(function(r){
							if(r.data.status)
								sco.data = angular.merge({}, sco.data, r.data.data)
						})
				}
				//ele.on('click', function(){
					//console.log(sco.answer_id + "asd")
				if(sco.answer_id)
					get_comment_list()
				//})

				sco._.add_comment = function(){
					AnswerService.new_comment.answer_id = sco.answer_id
					AnswerService.add_comment()
						.then(function(r){
							if(r){
								AnswerService.new_comment = {}
								get_comment_list()
							}
						})
				}
			}
			return o
	}])
})();














