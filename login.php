<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>
    /* Responsive reCAPTCHA styling */
    .g-recaptcha {
        max-width: 100%;
        display: block; /* Ensure it's block-level for auto margin */
        margin: auto; /* Center horizontally and vertically */
    }

    /* Media query for phones */
    @media (max-width: 480px) {
        .g-recaptcha {
            transform: scale(0.7); /* Reduce size for very small screens */
            transform-origin: 0 0;
        }
    }

    /* Additional adjustments for very small screens */
    @media (max-width: 320px) {
        .g-recaptcha {
            transform: scale(0.6); /* Further reduce size for mini screens */
        }
    }
</style>

<div class="login">
    <div class="col-lg-6 col-sm-6 col-lg-offset-3 col-sm-offset-3 col-xs-12">
        <div class="close_wrapper">
            <span class="close_btn" onclick="close_dynamic_window()">x</span>
            <div class="panel">
                <div class="panel-heading">
                    <h3>LOGIN</h3>
                </div>
                <div class="panel-body">
                    <p>Login for more.</p>
                    <p class="login_fail" style="text-align: center; color: red;"></p>
                    <form id="loginForm">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password(min. 8 characters)" pattern=".{8,}" required>
                        </div>
                        <div class="g-recaptcha" data-sitekey="6LfmLMApAAAAAAOqN3pVzsOkbVFNCYX_QI88TXsg"></div>
                        <div class="form-group center">
                            <input type="submit" value="Login" class="btn btn-primary">
                        </div>
                    </form>
                </div>
                <div class="panel-footer">Don't have an account yet? <a href="javascript:signUp();">Register</a></div>
            </div>
        </div>
    </div>
</div>

<script>
    var onloadCallback = function() {
        grecaptcha.render('g-recaptcha', {
            'sitekey': '6LfmLMApAAAAAAOqN3pVzsOkbVFNCYX_QI88TXsg'
        });
    };

    $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        var response = grecaptcha.getResponse();
        
        if(response.length == 0) {
            alert('Please complete the captcha verification.');
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
                switch(data) {
                    case 'user':
                        window.location.replace('index.php');
                        break;
                    case 'admin':
                        window.location.replace('admin/dashboard.php');
                        break;
                    case 'Invalid email format.':
                    case 'Password should have at least 8 characters.':
                    case 'Invalid email or password.':
                        $('.login_fail').empty().append(data);
                        break;
                    default:
                        $('.login_fail').empty().append("Unknown error occurred.");
                        break;
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>
