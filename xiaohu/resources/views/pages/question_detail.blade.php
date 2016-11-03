<div ng-controller="QuestionDetailController" class="container question-detail">
	<div class="card margin-top">
		<h4>[: Question.current_question.title:] </h4>
		<div class="hr"></div>
		<div> [: Question.current_question.desc:]</div>

		<div class="hr"></div>
		<div class="tac">
			<h6>[: Question.current_question.answers_with_user_info.length :] replies in totle.</h6>
		</div>
	</div>

	<div class="card margin-top answer-block">
		<div ng-repeat="item in Question.current_question.answers_with_user_info" class="item clear-float">
			<div class="vote">
				<div ng-click="Question.vote({id:item.id, vote:1})" class="up">
					<i class="material-icons">keyboard_arrow_up</i> 
					[:item.upvote_count:]
				</div>

				<div ng-click="Question.vote({id:item.id, vote:2})" class="down">
					<i class="material-icons">keyboard_arrow_down</i>
					[:item.downvote_count:]
				</div>
			</div>

			<div >
				<a ui-sref="user({id: item.user.id})">[:item.user.username:]</a>
			</div>

			<div>
				<div>[:item.content:]</div>
				<div></div>
			</div>
			<div class="hr"></div>
		</div>
	</div>
</div>