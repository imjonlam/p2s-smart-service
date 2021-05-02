<div id="login" ng-style="{ 'background-image': 'url({{myBackgroundUrl}})', 'background-repeat': 'no-repeat', 'margin': 0,  'padding': 0, 'height': '100vh'}">
  <div class="container">
    <div id="login-row" class="row justify-content-center align-items-center">
      <div id="login-column" class="col-md-6">
        <div id="login-box" class="col-md-12 bg-white">
          <form id="login-form" class="form" ng-submit="submit()" method="post">
            <h3 class="text-center">Login</h3>
            <p id="error" style="color:red"></p>
            <div class="form-group">
              <label for="username">Username:</label><br>
              <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password" >Password:</label><br>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group row justify-content-between" style="padding: 0.5rem 0px">
               <div class="col-4">
                   <label for="remember-me">
                  <span>Remember me</span>
                  <span><input id="remember-me" name="remember-me" type="checkbox"></span>
                   </label>
                   <br>
                 </div>
                <div id="register-link" class="text-right col-4" style="text-align:right">
                <a href="#!register" class="text-primary">Register here</a>
              </div>
            </div>
            <div class="form-group row justify-content-start">
              <div class="col-4">
                <input type="submit" name="submit" class="btn btn-primary btn-md" value="submit">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
