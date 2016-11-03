;(function(){
	'use strict'

	var app	= angular.module('answer', [])

	app.service('AnswerService', [
		'$http',
		function($http){
			var me = this
			me.data = {}

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
		}
	])
})();














