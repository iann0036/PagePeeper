<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - Page Peeper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="description" />
    <link rel="shortcut icon" href="/assets/images/favicon.png">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/ui.css" rel="stylesheet">
    <link href="/assets/plugins/bootstrap-loading/lada.min.css" rel="stylesheet">
</head>
<body class="account separate-inputs" data-page="login">
<div class="container" id="login-block">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <i class="user-img icons-faces-users-03"></i>
                <?php if (isset($loginerror)) { ?>
                <div class="alert media fade in alert-danger">
                    <p><strong>ERROR</strong>&nbsp;&nbsp;Incorrect username or password</p>
                </div>
                <?php } ?>
                <form class="form-signin" action="/login/" method="post" role="form">
                    <div class="append-icon">
                        <input type="text" name="username" id="username" class="form-control form-white username" placeholder="Username" required>
                        <i class="icon-user"></i>
                    </div>
                    <script>document.getElementById("username").focus();</script>
                    <div class="append-icon m-b-20">
                        <input type="password" name="password" class="form-control form-white password" placeholder="Password" required>
                        <i class="icon-lock"></i>
                    </div>
                    <button type="submit" id="submit-form" class="btn btn-lg btn-danger btn-block ladda-button" data-style="expand-left">Sign In</button>
                    <div class="social-btn">
                        <!--
                        <a href="<?php echo $facebookurl; ?>"><button type="button" class="btn-fb btn btn-lg btn-block btn-primary"><i class="icons-socialmedia-08 pull-left"></i>Connect with Facebook</button></a>
                        <button type="button" class="btn btn-lg btn-block btn-blue"><i class="icon-social-twitter pull-left"></i>Login with Twitter</button>
                        -->
                    </div>
                    <div class="clearfix">
                        <p class="pull-left m-t-20"><a id="password" href="#">Forgot password?</a></p>
                        <p class="pull-right m-t-20"><a href="/register/">New here? Sign up</a></p>
                    </div>
                </form>
                <form class="form-password" role="form">
                    <div class="append-icon m-b-20">
                        <input type="email" name="email" class="form-control form-white email" placeholder="E-mail" required>
                        <i class="icon-lock"></i>
                    </div>
                    <button type="submit" id="submit-password" class="btn btn-lg btn-danger btn-block ladda-button" data-style="expand-left">Send Password Reset Link</button>
                    <div class="clearfix">
                        <p class="pull-left m-t-20"><a id="login" href="#">Already got an account? Sign In</a></p>
                        <p class="pull-right m-t-20"><a href="/register/">New here? Sign up</a></p>
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
<script src="/assets/plugins/backstretch/backstretch.min.js"></script>
<script src="/assets/plugins/bootstrap-loading/lada.min.js"></script>
<script src="/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="/assets/js/pages/login-v1.js"></script>
</body>
</html>