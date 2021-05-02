
<div id="login" ng-style="{ 'background-image': 'url({{myBackgroundUrl}})', 'background-repeat': 'no-repeat', 'margin': 0,  'padding': 0, 'height': '100vh'}">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12 bg-white">
                    <form id="login-form" class="form" ng-submit="submit()" method="post">
                        <h3 class="text-center">Register</h3>
                        <div class="form-group row justify-content-between">
							<div class="col-5">
								<label for="name">First Name</label>
								<input type="text" name="name" id="name" class="form-control" pattern="[A-Za-z]+" required>
							</div>
							<div class="col-5">
								<label for="phone">Phone #</label>
								<input type="tel" id="phone" name="phone" class="form-control" pattern="([0-9]{3}-[0-9]{3}-[0-9]{4})||[0-9]{10}" required>
							</div>
						</div>
                        <div class="form-group">
                            <label for="email" >E-mail:</label><br>
                            <input type="text" name="email" id="email" class="form-control" pattern="\w+@\w+\.\w+" required>
                        </div>
                        <div class="form-group">
                            <label for="username" >Username:</label><br>
                            <input type="text" name="username" id="username" pattern="\w+" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" >Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control" pattern="(\w|[^a-zA-Z0-9\s])+" required>
                        </div>
                        <div class="form-group">
                            <hr>
                            <input type="submit" name="submit" class="btn btn-primary btn-md" value="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

