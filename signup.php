<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup with Email OTP Verification</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
    min-height: 100vh;
    margin: 0;
}

.signup {
    width: 100%;
    max-width: 400px; /* Reduced max-width to fit the new height */
    margin: 0 auto; /* Center the form */
    padding: 20px 15px; /* Reduced padding to decrease height */
    background-color: rgba(255, 255, 255, 0.6);
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box; /* Ensure padding and border are included in width */
}


        .panel {
            margin-top: 5px; /* Reduced margin to match the login page */
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
        label {
    font-weight: bold;
    color: black; /* Match the primary color scheme */
    margin-bottom: 0px;
    display: block;
}

        #signUpForm {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="submit"],
        input[type="button"] {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            outline: none;
            box-sizing: border-box;
            border-color: #8B4513; /* Light brown border on focus */
            box-shadow: 0 0 10px rgba(139, 69, 19, 0.2); /* Slightly stronger shadow on focus */
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus {
            border-color: #8B4513;
            box-shadow: 0 0 10px rgba(139, 69, 19, 0.2);
        }

        .btn-primary {
            background-color: #8B4513;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #A0522D;
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
            color: #A0522D;
        }

    .toggle-password-btn {
        position: absolute;
        right: 15px; /* Adjusted right position */
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 14px;
        color: #8B4513;
        background: none;
        border: none;
        outline: none;
        padding: 0;
        margin-top: 8px;
    }

        .center-button {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #sendOtp {
            background-color: #8B4513;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 8px;
            margin-bottom: -8px;
        }

        #sendOtp:hover {
            background-color: #A0522D;
        }
        
        .city-dropdown label {
    font-weight: bold;
    color: black; /* Match the primary color scheme */
    margin-bottom: 5px;
    display: block;
}

.city-dropdown select {
    width: 100%;
    background-color: #fff;
    color: #333;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    border-color: #8B4513; /* Light brown border on focus */
    box-shadow: 0 0 10px rgba(139, 69, 19, 0.2); /* Slightly stronger shadow on focus */
    transition: border-color 0.3s ease;
}

.city-dropdown select:focus {
    border-color: #8B4513;
    box-shadow: 0 0 10px rgba(139, 69, 19, 0.2);
}

.city-dropdown select option {
    padding: 10px;
}


        /* Media Queries */
        @media (max-width: 768px) {
            .signup {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .signup {
                width: 90%;
                margin: 20px auto;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="signup">
    <div class="panel">
        <div class="panel-heading">
            <h3>SIGN UP</h3>
        </div>
        <div class="panel-body">
            <p class="signup_fail" style="text-align: center; color: red;"></p>
            <form id="signUpForm" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name (letters only)" required pattern="[A-Za-z]{2,}" title="Please enter letters only (minimum 2 letters)">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control pass" name="password" placeholder="Password" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*\s).{8,16}" title="(8-16 characters, at least one uppercase, lowercase, digit, and special character">
                        <button type="button" id="togglePasswordBtn" class="toggle-password-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control confirm-pass" name="confirm_password" placeholder="Confirm Password" required pattern=".{8,}">
                    <p class="confirm-pass-invalid" style="text-align: center; color: red;"></p>
                        <button type="button" id="toggleConfirmPasswordBtn" class="toggle-password-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                </div>
                <div class="form-group">
                    <label for="contact">Contact Number</label>
                    <input type="tel" class="form-control" name="contact" placeholder="Contact Number" required pattern="((\+[0-9]{2})|0)[.\- ]?9[0-9]{2}[.\- ]?[0-9]{3}[.\- ]?[0-9]{4}" title="eg.09171234567 or +639171234567">
                </div>
<div class="form-group city-dropdown">
    <label for="city">City or Municipality</label>
    <select class="form-control" name="city" id="city" required>
        <option value="" selected disabled>Choose a city</option>
        <option value="Aliaga">Aliaga</option>
        <option value="Bongabon">Bongabon</option>
        <option value="Cabanatuan">Cabanatuan</option>
        <option value="Cabiao">Cabiao</option>
        <option value="Carranglan">Carranglan</option>
        <option value="Cuyapo">Cuyapo</option>
        <option value="Gabaldon">Gabaldon</option>
        <option value="Gapan">Gapan</option>
        <option value="General Mamerto Natividad">General Mamerto Natividad</option>
        <option value="General Tinio">General Tinio</option>
        <option value="Guimba">Guimba</option>
        <option value="Jaen">Jaen</option>
        <option value="Laur">Laur</option>
        <option value="Licab">Licab</option>
        <option value="Llanera">Llanera</option>
        <option value="Lupao">Lupao</option>
        <option value="Nampicuan">Nampicuan</option>
        <option value="Palayan">Palayan</option>
        <option value="Pantabangan">Pantabangan</option>
        <option value="Penaranda">Penaranda</option>
        <option value="Quezon (NE)">Quezon (NE)</option>
        <option value="Rizal (NE)">Rizal (NE)</option>
        <option value="San Antonio (NE)">San Antonio (NE)</option>
        <option value="San Isidro (NE)">San Isidro (NE)</option>
        <option value="San Jose (NE)">San Jose (NE)</option>
        <option value="San Leonardo">San Leonardo</option>
        <option value="Santa Rosa (NE)">Santa Rosa (NE)</option>
        <option value="Santo Domingo (NE)">Santo Domingo (NE)</option>
        <option value="Science City of Munoz">Science City of Munoz</option>
        <option value="Talavera">Talavera</option>
        <option value="Talugtug">Talugtug</option>
        <option value="Zaragoza">Zaragoza</option>
    </select>
</div>

                <div class="form-group">
                    <label for="otp">OTP</label>
                    <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP" required>
                    <div class="center-button">
                        <button type="button" id="sendOtp" class="btn-primary">Send OTP</button>
                    </div>
                    <p class="otp-invalid" style="text-align: center; color: red;"></p>
                </div>
                <div class="form-group center-button">
                    <input type="submit" class="btn-primary" value="Sign Up">
                </div>
            </form>
        </div>
        <div class="panel-footer text-center">Already have an account? <a href="login.php">Login</a></div>
    </div>
</div>

<script>
    let generatedOtp = '';

    $('#sendOtp').click(function() {
        const email = $('#email').val();
        if (email === '') {
            $('.otp-invalid').empty().append("Please enter your email first.");
            return;
        }

        generatedOtp = generateOTP();

        $.ajax({
            url: 'send_otp.php',
            method: 'POST',
            data: { email: email, otp: generatedOtp },
            success: function(data) {
                if (data === "OTP sent successfully.") {
                    $('.otp-invalid').empty().append("OTP sent to your email.");
                } else {
                    $('.otp-invalid').empty().append(data);
                }
            },
            error: function(error) {
                $('.otp-invalid').empty().append("Failed to send OTP. Please try again.");
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

    $('#toggleConfirmPasswordBtn').click(function() {
        var confirmPasswordField = $('.confirm-pass');
        var confirmPasswordFieldType = confirmPasswordField.attr('type');
        var icon = $(this).find('i');

        if (confirmPasswordFieldType === 'password') {
            confirmPasswordField.attr('type', 'text');
             icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            confirmPasswordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#signUpForm').on('submit', function(event) {
        event.preventDefault();

        const inputOtp = $('#otp').val();

        if (inputOtp !== generatedOtp) {
            $('.otp-invalid').empty().append("Invalid OTP.");
            return;
        }

        const password = $('.pass').val();
        const confirmPassword = $('.confirm-pass').val();

        if (password !== confirmPassword) {
            $('.confirm-pass-invalid').empty().append("Passwords do not match.");
            return;
        }

        this.submit();
    });

    function generateOTP() {
        return Math.floor(100000 + Math.random() * 900000).toString();
    }
</script>

</body>
</html>
