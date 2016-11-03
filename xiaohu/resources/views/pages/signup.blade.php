<div ng-controller="SignupController" class="container">
	<div class="card form-padding">
		<h3>Signup</h3>
		<!-- <h4>data: [: User.signup_data :]</h4> -->
		<form class="col s12" name="signup_form" ng-submit="User.signup()" >
			<div class="row">
				<div class="input-field col s12">
					<input 
				        id="username" 
				        name="username" 
				        type="text" 
				        class="validate" 
				        ng-minlength="4"
				        ng-maxlength="16"
				        ng-model="User.signup_data.username"
				        ng-model-options="{debounce: 300}"
				        required
				    >
					<label for="username">Username</label>
					<div class="input-error-set" ng-if="signup_form.username.$touched">
						<div ng-if="signup_form.username.$error.required">Username is required.</div>
						<div ng-if="signup_form.username.$error.minlength || signup_form.username.$error.maxlength">Username length invalid .</div>
						<div ng-if="User.signup_username_exists">Username existed.</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input 
				        id="last_name" 
				        name="password" 
				        type="password" 
				        class="validate" 
				        ng-minlength="4"
				        ng-maxlength="255"
				        ng-model="User.signup_data.password"
				        g-model-options="{updataOn:blur}"
				        required
				    >
					<label for="last_name">Password</label>
					<div class="input-error-set" ng-if="signup_form.password.$touched">
						<div ng-if="signup_form.password.$error.required">Password is required.</div>
						<div ng-if="signup_form.password.$error.minlength || signup_form.password.$error.maxlength">Password length invalid .</div>
					</div>
				</div>
			</div>
			<button class="waves-effect waves-light btn" 
				type="submit"
				ng-disabled="signup_form.$invalid"
			>Submit</button>
		</form>
	</div>
</div>
