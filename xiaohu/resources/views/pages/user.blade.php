<div ng-controller="UserController">
	<div class="card center-container margin-top">
		<h4>User Info</h4>
		<div class="hr"></div>

		<div class="user-info">
			<div class="info-item clear-float margin-top">
				<div>Username: </div>
				<div>[:User.current_user.username:]</div>
			</div>
			<div class="info-item clear-float">
				<div>Intro: </div>
				<div>[:User.current_user.intro || 'User left nothing here.':]</div>
			</div>
		</div>
	</div>

	<div class="card center-container margin-top">
		<h4>User Asked</h4>
		<div class="hr"></div>
		<!-- <ul class="collection">
	        <li ng-repeat="(key, value) in User.his_questions" class="collection-item">
	        	<div>
	        		[: value.title :]
		        	<a href="#!" class="secondary-content">
		        		<i class="material-icons">send</i>
		        	</a>
	       		</div>
	       	</li>
      	</ul> -->
		<ul class="collapsible" data-collapsible="accordion">
			<li>
		      	<div class="collapsible-header clear-float">
		      		<div class="float-left "><span class="collapsible-title">Title</span></div> 
		      		<div class="float-right">Created Time</div>
		      	</div>
		    </li>
		    <li ng-repeat="(key, value) in User.his_questions">
		      	<div class="collapsible-header clear-float">
		      		<div class="float-left show-underline"><a href="">[: value.title :]</a></div> 
		      		<div class="float-right">[:value.created_at:]</div>
		      	</div>
		      	<div class="collapsible-body"><p>[:value.desc || 'No description.':]</p></div>
		    </li>
		</ul>
	</div>

	<div class="card center-container margin-top">
		<h4>User Answered</h4>
		<div class="hr"></div>
		<ul class="collapsible" data-collapsible="accordion">
			<li>
		      	<div class="collapsible-header clear-float">
		      		<div class="float-left "><span class="collapsible-title">Title</span></div> 
		      		<div class="float-right">Updated Time</div>
		      	</div>
		    </li>
		    <li ng-repeat="(key, value) in User.his_answers">
		      	<div class="collapsible-header clear-float">
		      		<div class="float-left show-underline">Replied post > <a href="">[: value.question.title :]</a></div> 
		      		<div class="float-right">[:value.created_at:]</div>
		      	</div>
		      	<div class="collapsible-body"><p>[: value.content :]</p></div>
		    </li>
		</ul>

		<!-- <div class="replied-item" ng-repeat="(key, value) in User.his_answers">
			<div>Replied post > "[: value.question.title :]"</div>
			<div>[: value.content :]</div>
		</div> -->
	</div>
</div>

<script>
	$('.collapsible').collapsible({
      	accordion: false, // A setting that changes the collapsible behavior to expandable instead of the default accordion style
      	onOpen: function(el) {}, // Callback for Collapsible open
      	onClose: function(el) { } // Callback for Collapsible close
    }
  );
</script>