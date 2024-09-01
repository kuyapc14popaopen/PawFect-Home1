<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Base Styles */
        body {
            background: url('pet.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

.login {
    width: 100%;
    max-width: 550px; /* Increased width */
    height: 420px; /* Explicit height set to 800px */
    margin: 50px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.6); /* White background with transparency */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}




        .panel {
            margin-top: 20px;
        }

        .panel-heading h3 {
            margin: 0;
            color: #333;
            font-weight: bold;
            text-align: center;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
        }

        .panel-heading h3::after {
            content: '';
            width: 50px;
            height: 3px;
            background: #8B4513;
            display: block;
            margin: 10px auto 0;
        }

        /* Close Button */
        .close_wrapper {
            position: relative;
        }

        .close_btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
            color: #333;
        }

        /* Form Styles */
        #loginForm {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative; /* Ensure button stays within the input field */
        }

        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            outline: none;
            box-sizing: border-box;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Light shadow for input fields */
        }

        input[type="email"],
        input[type="password"],
        input[type="text"]{
            width: 100%;
            padding: 10px;
            border-color: #8B4513; /* Light brown border on focus */
            box-shadow: 0 0 10px rgba(139, 69, 19, 0.2); /* Slightly stronger shadow on focus */
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #8B4513; /* Light brown color */
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #A0522D; /* Darker shade of brown when hovered */
        }

        .g-recaptcha {
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .g-signin2 {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px; /* Space between the form and the Google Sign-In button */
        }

        .panel-footer {
            text-align: center;
            margin-top: 20px;
        }

        .panel-footer a {
            color: #8B4513;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .panel-footer a:hover {
            color: #A0522D; /* Darker shade of brown when hovered */
        }

        .toggle-password-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 14px; /* Adjust the size of the button */
            color: #8B4513; /* Match the form colors */
            background: none;
            border: none;
            outline: none;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .login {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .login {
                width: 90%;
                margin: 30px auto;
            }

            .g-recaptcha {
                transform: scale(0.8);
            }
        }

        @media (max-width: 320px) {
            .g-recaptcha {
                transform: scale(0.7);
            }
        }
    </style>

    <!-- Google reCAPTCHA and Sign-In -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="google-signin-client_id" content="50464464530-tusv1dr2vgblra4tgkckfet6m5r6r8s9.apps.googleusercontent.com">
</head>
<body>
    <div class="login">

        <div class="panel">
            <div class="panel-heading">
                <h3>LOGIN</h3>
            </div>
            <div class="panel-body">
               
                <p class="login_fail text-danger"></p>
                <form id="loginForm">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control pass" name="password" placeholder="Password (min. 8 characters)" pattern=".{8,}" required>
                        <button type="button" id="togglePasswordBtn" class="toggle-password-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LfmLMApAAAAAAOqN3pVzsOkbVFNCYX_QI88TXsg"></div>
                    <div class="form-group text-center">
                        <input type="submit" value="Login" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
            <div class="panel-footer text-center">Don't have an account yet? <a href="signup.php">Register</a></div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        // Function to handle form submission
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            var response = grecaptcha.getResponse();

            if (response.length == 0) {
                $('.login_fail').empty().append('Please complete the captcha verification.');
                return false;
            }

            const formData = new FormData(this);

            $.ajax({
                url: 'login_submit.php',
                method: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    switch (data) {
                        case 'user':
                            window.location.replace('index.php');
                            break;
                        case 'admin':
                            window.location.replace('admin/dashboard.php');
                            break;
                        case 'invalid':
                        default:
                            $('.login_fail').empty().append('Invalid email or password.');
                            setTimeout(function() {
                                window.location.replace('Login.php');
                            }, 2000); // Redirect after 2 seconds
                            break;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('.login_fail').empty().append('An error occurred while processing your request. Please try again.');
                    setTimeout(function() {
                        window.location.replace('Login.php');
                    }, 2000); // Redirect after 2 seconds
                }
            });
        });

        // Function to toggle password visibility
        $('#togglePasswordBtn').click(function(){
            var passwordField = $('.pass');
            var passwordFieldType = passwordField.attr('type');
            var icon = $(this).find('i');

            if (passwordFieldType == 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>

</body>
</html>
