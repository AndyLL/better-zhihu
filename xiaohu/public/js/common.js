;(function(){
	'use strict'

	var app = angular.module('common', [])

	app.service('TimelineService', [
		'$http',
		'AnswerService',
		function($http, AnswerService){
			var me = this
			me.data = []
			me.current_page = 1;

			// 获取首页数据
			me.get = function(conf){
				if(me.pending) return 

				me.pending = true
				conf = conf || {page: me.current_page}

				$http.post('api/timeline', conf)
					.then(function(r){
						if(r.data.status){
							if(r.data.data.length){
								me.data = me.data.concat(r.data.data)
								me.data = AnswerService.count_vote(me.data)
								me.current_page++
							}
							else
								me.no_more_data = true
						}
						else 
							cosole.error('network error')
					}, function(){
						console.error('network error')
					})
					.finally(function(){
						me.pending = false
					})
			}

			// 在时间线中投票
			me.vote = function(conf){
				// 调用核心投票功能
				AnswerService.vote(conf)
					.then(function(r){
						if(r)
							AnswerService.update_data(conf.id)
					})
			}
		}
	])

	app.controller('HomeController', [
		'$scope',
		'TimelineService',
		'AnswerService',
		function($scope, TimelineService, AnswerService){
			var $win
			$scope.Timeline = TimelineService
			TimelineService.get()
			$win = $(window)

			// 滑倒页面底端load 新的数据
			$win.on('scroll', function(){
				if(($(document).height() - $win.scrollTop() - $win.height() < 30)){
					TimelineService.get()
				} 
			})

			// 监控回答数据的变化
			$scope.$watch(function(){
				return AnswerService.data
			}, function(new_data, old_data){
				var timeline_data = TimelineService.data
				for(var k in new_data){
					for(var i = 0; i < timeline_data.length; i++){
						if(k == timeline_data[i].id)
							timeline_data[i] = new_data[k]
					}
				}

				TimelineService.data = AnswerService.count_vote(TimelineService.data)
			}, true)
		}
	])
})()
