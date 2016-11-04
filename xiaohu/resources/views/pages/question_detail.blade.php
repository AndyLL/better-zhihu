<div ng-controller="QuestionDetailController" class="container question-detail">
	<div class="card margin-top">
		<h4> [: Question.current_question.title:] </h4>
		<div class="hr"></div>
		<div> [: Question.current_question.desc:]</div>

		<div class="hr"></div>
		<div class="tac">
			<h6>[: Question.current_question.answers_with_user_info.length :] replies in totle.</h6>
		</div>
	</div>

	<div class="card margin-top answer-block">
		<div ng-if="!Question.current_answer_id || Question.current_answer_id == item.id" 
			ng-repeat="item in Question.current_question.answers_with_user_info" 
			class="item clear-float">
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

			<div class="float-left answer-content">
				<a ui-sref="user({id: item.user.id})">[:item.user.username:] </a>
				<i ng-if="item.user_id == his.id" 
					ng-click="Answer.answer_form = item"
					class="material-icons edit-icon">mode_edit</i>
				<div> [:item.content:] </div>
				<div class="updated_time"> [:item.updated_at:] </div>
			</div>

			

			<div class="hr"></div>
		</div>

		<!-- reply session -->
		<div class="card">
			<div class="row">
			    <form 
			    	ng-submit="Answer.add_or_update(Question.current_question.id)" 
			    	name="answer_form" 
			    	class="col s12"
			    	>
			      	<div class="row">
			        	<div class="input-field col s12 reply-block">
			        		<i class="material-icons prefix">mode_edit</i>
			          		<textarea 
			          			type="text"
			          			ng-model="Answer.answer_form.content" 
			          			ng-minlength="5"
			          			id="replytext" 
			          			class="materialize-textarea" 
			          			required
			          		></textarea>
			          		<label for="replytext">Add a new reply</label>
			          		<button
			          			ng-disabled="answer_form.$invalid" 
			          			class="btn waves-effect waves-light light-blue darken-1" 
			          			type="submit" 
			          			>
			          			Submit  <i class="material-icons right">send</i>
						  	</button>
			       		</div>
			   		</div>
			    </form>
		  	</div>
		</div>
	</div>
</div>
<script>
  	$('#replytext').trigger('autoresize');
</script>