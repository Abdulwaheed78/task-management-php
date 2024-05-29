<!DOCTYPE html>
<html lang="en">
<?php
if (isset($_POST['login'])) {
} else if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($name != '' && $email != '' && $password != '') {
        // 
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" ></script>
    <style>
        .card {
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title text-center">Login/Signup</h5>
                        <div id="loginForm">

                            <div class="form-group">
                                <label for="loginEmail">Email address</label>
                                <input type="email" class="form-control" name="emaill" id="loginEmail" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="loginPassword">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="passwordl" id="loginPassword" aria-describedby="passwordHelp">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('loginPassword', 'loginPasswordVisibilityIcon')">
                                            <i id="loginPasswordVisibilityIcon" class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" onclick="authLogin()" class="btn btn-primary btn-block">Login</button>
                            <p class="mt-3 text-center">Don't have an account? <a href="#" onclick="showRegisterForm()">Register</a></p>

                        </div>
                        <div id="registerForm" style="display: none;">

                            <div class="form-group">
                                <label for="registerName">Full Name</label>
                                <input type="text" name="name" class="form-control" id="registerName" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="registerEmail">Email address</label>
                                <input type="email" name="emailr" class="form-control" id="registerEmail" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="registerPassword">Password</label>
                                <div class="input-group">
                                    <input type="password" name="passwordr" class="form-control" id="registerPassword" aria-describedby="passwordHelp">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('registerPassword', 'registerPasswordVisibilityIcon')">
                                            <i id="registerPasswordVisibilityIcon" class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" onclick="authRegister()" class="btn btn-primary btn-block">Register</button>
                            <p class="mt-3 text-center">Already have an account? <a href="#" onclick="showLoginForm()">Login</a></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showRegisterForm() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        }

        function showLoginForm() {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('registerForm').style.display = 'none';
        }

        function togglePasswordVisibility(inputId, iconId) {
            var passwordInput = document.getElementById(inputId);
            var passwordVisibilityIcon = document.getElementById(iconId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordVisibilityIcon.className = "fa fa-eye-slash";
            } else {
                passwordInput.type = "password";
                passwordVisibilityIcon.className = "fa fa-eye";
            }
        }

        function authRegister() {
            const name = document.getElementsByName("name");
            const email = document.getElementsByName("emailr");
            const password = document.getElementsByName("passwordr");
            console.log(name);
            if(name.value != '' && email.value != '' && password.value != '') {
                $.ajax({
                    url: 'authverify.php',
                    type: 'post',
                    data: {
                        name: name.value,
                        email: email.value,
                        password: password.value
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });

            } else {
                alert("Please Fill All Details")
            }
        }
    </script>

</body>

</html>