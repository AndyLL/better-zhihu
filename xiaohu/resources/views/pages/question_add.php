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
