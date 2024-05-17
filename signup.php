<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
            <div class="signup login">
                
                    <div class="col-lg-6 col-sm-6 col-lg-offset-3 col-sm-offset-3 col-xs-12">
                        <div class="close_wrapper">
                            <span class="close_btn" onclick="close_dynamic_window()">x</span>
                        <div class="panel">
                        <div class="panel-heading">
                                <h3>SIGN UP</h3>
                            </div>
                        <div class="panel-body">
                            <p class="signup_fail" style="text-align: center; color: red;"></p>
                            <form id="signUpForm" method="post" >
                             <div class="form-group">
    <input type="text" class="form-control" name="name" placeholder="Name (letters only, minimum 2 letters)" required="true" pattern="[A-Za-z]{2,}" title="Please enter letters only (minimum 2 letters)">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email" required="true" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                            </div> 
                           <div class="form-group">
    <input type="password" class="form-control pass" name="password" placeholder="Password (8-16 characters, at least one uppercase, lowercase, digit, and special character)" required="true" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*\s).{8,16}$">
</div>
                            
                             <div class="form-group">
                                <input type="password" class="form-control confirm-pass" name="password" placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters')" oninput="this.setCustomValidity('')"  required>
                                <p class="confirm-pass-invalid" style="text-align: center; color: red;"></p>
                            </div>
                            
                               <div class="form-group">
    <input type="tel" class="form-control" name="contact" placeholder="Contact Number" title="eg.09171234567 or +639171234567"required="true" pattern="((\+[0-9]{2})|0)[.\- ]?9[0-9]{2}[.\- ]?[0-9]{3}[.\- ]?[0-9]{4}">
</div>
                          
                   <div class="form-group">
    <label for="city">City</label>
    <select class="form-control" name="city" id="city" required="true">
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
                            
                                        <div class="form-group center">
                        <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP" required="true">
                        <button type="button" class="btn btn-default" id="sendOtp">Send OTP</button>
                        <p class="otp-invalid" style="text-align: center; color: red;"></p>
                    </div>
                            <div class="form-group center">
                                <input type="submit" class="btn " value="Sign Up">
                            </div>
                        </form>
                        </div>
                    </div>
                        </div>
                    </div>
               
               <script>
    let generatedOtp = '';

    $('#sendOtp').click(function() {
        const email = $('#email').val();
        if(email === '') {
            $('.otp-invalid').empty().append("Please enter your email first.");
            return;
        }

        generatedOtp = generateOTP();

        $.ajax({
            url: 'send_otp.php',
            method: 'POST',
            data: { email: email, otp: generatedOtp },
            success: function(data) {
                if(data === "OTP sent successfully.") {
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

    function generateOTP() {
        const digits = '0123456789';
        let otp = '';
        for(let i=0; i<6; i++) {
            otp += digits[Math.floor(Math.random() * 10)];
        }
        return otp;
    }

    $('#signUpForm').submit(function (e) {
        e.preventDefault();

        const enteredOtp = $('#otp').val();

        if(enteredOtp !== generatedOtp) {
            $('.otp-invalid').empty().append("Invalid OTP.");
            return;
        } else {
            $('.otp-invalid').empty();
        }

        if($('.pass').val() !== $('.confirm-pass').val()) {
            $('.confirm-pass-invalid').empty().append("Password doesn't match.");
            return;
        } else {
            $('.confirm-pass-invalid').empty();
        }

        const formData = new FormData(this);
        
        $.ajax({
            url: 'user_registration_script.php',
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                switch(data) {
                    case '1':
                        window.location.replace('index.php');
                        break;
                    default:
                        $('.signup_fail').empty().append(data);
                        break;
                }
            },
            error: function(error) {
                $('.signup_fail').empty().append("An error occurred. Please try again.");
            }
        });
    });
</script>

</body>
</html>
            
