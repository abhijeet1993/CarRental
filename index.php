<?php
if (!empty($_GET)) {
    if ($_GET['message'] == "wrong") {
        $message = "Wrong Credentials, Login again!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } elseif ($_GET['message'] == "login_created") {
        echo "<script type='text/javascript'>alert('Account created, please login');</script>";
    } elseif ($_GET['message'] == "session") {
        echo "<script type='text/javascript'>alert('You have been logged out of other active sessions, please login again');</script>";
    }
}
?>
<html>
    <head>
        <link href="resources/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="resources/jquery/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="resources/jquery/jquery.validate.min.js"></script>
    </head>
    <script type="text/javascript">

        $(document).ready(function () {
            $("#new_user").click(function () {
                window.location.href = 'users/new_userform.php';
            });
        });
    </script>


    <style>
        html,
        body {
            height: 100%;
            /*        background-image: url("resources/images/car2.jpg");
                    background-repeat: no-repeat;
                    background-size: cover;*/
        }
        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>


    <body>
        <div class="container">
            <form action="users/login_check.php" method="post">
                <fieldset>
                    <legend>Sign In</legend>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control col-md-12" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control col-md-12" id="exampleInputPassword1" placeholder="Password" name="password">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="logintype" id="customer" value="1" checked="">
                            Customer
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="logintype" id="employee" value="2">
                            Employee
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="logintype" id="owner" value="3">
                            Owner
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control">Login</button>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-danger form-control" id="new_user">Or New User?</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </body>
</html>
