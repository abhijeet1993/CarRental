<?php
if (!empty($_GET)) {
    if ($_GET['message'] == "email") {
        $message = "Email already exists, try another email.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<html>
    <head>
        <link href="../resources/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="../resources/jquery/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="../resources/jquery/jquery.validate.min.js"></script>
    </head>
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

        .form-group{
            width: 150%;
        }

        .my-error-class {
            color:#FF0000;  /* red */
        }
        .my-valid-class {
            color:#00CC00; /* green */
        }
    </style>
    <script>

        $(document).ready(function () {
            $("#register_form").validate({
                errorClass: "my-error-class",
                validClass: "my-valid-class",
                rules: {
                    full_name: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    },
                    email: {
                        email: true,
                        required: true
                    },
                    phone_number: {
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    }
                },
                messages: {
                    full_name: {
                        required: "Please enter your Full Name"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Password must be minimum 8 characters"
                    },
                    confirm_password: {
                        required: "Please provide a password",
                        equalTo: "Please enter the same password as above"
                    },
                    email: {
                        required: "Please enter a valid email address",
                        email: "Please enter valid email"
                    },
                    phone_number: {
                        number: "Please enter numbers only",
                        minlength: "Number should have 10 digits",
                        maxlength: "Number should have 10 digits"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>

    <body>
        <div class="container">
            <!--<form action="new_user.php" method="POST">-->
            <form action="new_user.php" method="post" id="register_form">
                <fieldset>
                    <legend>Register</legend>
                    <div class="form-group ">
                        <label for="example">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" aria-describedby="emailHelp" placeholder="Enter Full Name">
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputCofirmPassword1">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </fieldset>
            </form>
        </div>
    </body>

</html>

