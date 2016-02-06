<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page Peeper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="description" />
    <link rel="shortcut icon" href="/images/favicon.png">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/ui.css" rel="stylesheet">
    <link href="/assets/plugins/icheck/skins/all.css" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap-loading/lada.min.css" rel="stylesheet">
</head>
<body class="account separate-inputs" data-page="signup">
<div class="container" id="login-block">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-md-offset-3">
            <div class="account-wall">
                <i class="user-img icons-faces-users-03"></i>
                <form class="form-signup" action="/register/" method="post" role="form">
                    <div class="append-icon">
                        <input type="text" name="username" id="username" class="form-control form-white username" placeholder="Username" required>
                        <i class="icon-user"></i>
                    </div>
                    <script>document.getElementById("username").focus();</script>
                    <div class="append-icon">
                        <input type="text" name="name" id="name" class="form-control form-white name" placeholder="Full Name" required>
                        <i class="icon-user"></i>
                    </div>
                    <div class="append-icon">
                        <input type="email" name="email" id="email" class="form-control form-white email" placeholder="E-mail">
                        <i class="icon-envelope"></i>
                    </div>
                    <div class="append-icon">
                        <input type="password" name="password" id="password" class="form-control form-white password" placeholder="Password" required>
                        <i class="icon-lock"></i>
                    </div>
                    <div class="append-icon m-b-20">
                        <input type="password" name="password2" id="password2" class="form-control form-white password2" placeholder="Repeat Password" required>
                        <i class="icon-lock"></i>
                    </div>
                    <div class="terms option-group">
                        <label  for="terms" class="m-t-10">
                            <input type="checkbox" name="terms" id="terms" data-checkbox="icheckbox_square-blue" required/>
                            I agree with the <a style="text-decoration: underline;" target="_blank" href="http://www.pagepeeper.com/terms/">terms and conditions</a>
                        </label>
                    </div>
                    <button type="submit" id="submit-form" class="btn btn-lg btn-dark m-t-20" data-style="expand-left">Register</button>
                    <div class="social-btn">
                        <!--
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="button" class="btn-fb btn btn-lg btn-block btn-primary"><i class="icons-socialmedia-08 pull-left"></i>Connect with Facebook</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-lg btn-block btn-blue"><i class="icon-social-twitter pull-left"></i>Login with Twitter</button>
                            </div>
                        </div>
                        -->
                    </div>
                    <div class="clearfix">
                        <p class="pull-right m-t-20"><a href="/login/">Already have an account? Sign In</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script src="/assets/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="/assets/plugins/gsap/main-gsap.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/plugins/icheck/icheck.min.js"></script>
<script src="/assets/plugins/backstretch/backstretch.min.js"></script>
<script src="/assets/plugins/bootstrap-loading/lada.min.js"></script>
<script src="/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="/assets/js/plugins.js"></script>
<script src="/assets/js/pages/login-v1.js"></script>
</body>
</html>