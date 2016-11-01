<div ng-controller="LoginController" class="container">
			<div class="card form-padding">
				<h3>Login</h3>
				<!-- <h4>data: [: User.signup_data :]</h4> -->
				<form class="col s12" name="login_form" ng-submit="User.login()" >
					<div class="row">
				        <div class="input-field col s12">
				          	<input 
				          		id="username" 
				          		name="username" 
				          		type="text" 
				          		class="validate" 
				          		ng-minlength="4"
				          		ng-maxlength="16"
				          		ng-model="User.login_data.username"
				          		ng-model-options="{debounce: 300}"
				          		required
				          	>
				          	<label for="username">Username</label>

				          	<div class="input-error-set" ng-if="login_form.username.$touched">
				          		<div ng-if="login_form.username.$error.required">Username is required.</div>
				          		<div ng-if="User.login_failed">Wrong username or password.</div>
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
				          		ng-model="User.login_data.password"
				          		ng-model-options="{updataOn:blur}"
				          		required
				          	>
				          	<label for="last_name">Password</label>

				          	<div class="input-error-set" ng-if="login_form.password.$touched">
				          		<div ng-if="login_form.password.$error.required">Password is required.</div>
				          	</div>
				        </div>
			      	</div>
					
					<button class="waves-effect waves-light btn" 
						type="submit"
						ng-disabled="login_form.$invalid"
					>Submit</button>
				</form>
			</div>
		</div>