<?php
session_start();

include 'header.php';

?>
<section class="gradient-form">
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-11 col-lg-10 col-xl-9">
                <div class="card text-black" id="login-signup-card">
                    <div class="row g-0">
                        <div class="col-lg-6 align-items-center justify-content-center login-signup-card-body"
                            id="login-card-body">

                            <div
                                class="card-body mx-md-4 my-3 my-lg-1 d-flex flex-column align-items-center justify-content-center">

                                <div class="text-center">
                                    <h4 class="mt-2 mb-4 pb-1">Welcome back!</h4>
                                </div>
                                <p>Please login to your account</p>

                                <form id="loginform" method="POST" action="login_process.php">

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" id="login_username" class="form-control"
                                            placeholder="Username" name="username" required />
                                        <label class="form-label" for="login_username">Username</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="login_password" class="form-control"
                                            placeholder="Password" name="password" required />
                                        <label class="form-label" for="login_password">Password</label>
                                    </div>

                                    <div class="text-center m-3">
                                        <?php if (isset($_GET['usernameError'])) { ?>
                                            <span style="color:red"><?php echo $_GET['usernameError']; ?></span>
                                        <?php } ?>

                                        <?php if (isset($_GET['passwordError'])) { ?>
                                            <span style="color:red"><?php echo $_GET['passwordError']; ?></span>
                                        <?php } ?>
                                    </div>

                                    <div class="text-center pt-1 mb-4 pb-1">
                                        <button data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-primary btn-block fa-lg gradient-custom-3 mb-3 rounded"
                                            type="submit">Log in</button>
                                        <br>
                                        <a class="text-muted" href="#!">Forgot password?</a>

                                    </div>

                                </form>
                            </div>
                        </div>



                        <div class="col-lg-6 align-items-center justify-content-center text-center gradient-custom-2 login-signup-card-design"
                            id="login-signup-card-design-desktop">
                            <div class="text-white px-3 py-4 p-md-2 m-md-4">
                                <img src="../Images/logo/Restaurant-booking-02.png" alt="logo" class="login-img">

                                <div class="align-items-center justify-content-center pb-2 createnew-div">
                                    <p class="mb-2 me-2">Don't have an account?</p>
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-danger rounded" onclick="CreateNew()">Create
                                        new</button>
                                </div>

                                <div class="align-items-center justify-content-center pb-2 pb-lg-1 login-div">
                                    <p class="mb-2 me-2">Already have an account?</p>
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-danger rounded" onclick="SignIn()">Log In</button>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 align-items-center justify-content-center login-signup-card-body"
                            id="signup-card-body">
                            <div
                                class="card-body mx-md-4 my-3 my-lg-1 align-items-center justify-content-center d-flex flex-column">

                                <div class="text-center">
                                    <h4 class="mt-2 mt-lg-0 mb-4 mb-lg-2">Sign Up</h4>
                                </div>
                                <p class="mb-lg-1">Please sign up your new account</p>

                                <form id="signupform" method="POST" action="signup_process.php">

                                    <div data-mdb-input-init class="form-outline mb-4 mb-lg-1">
                                        <input type="text" id="username" class="form-control" placeholder="Username"
                                            name="username" required />
                                        <label class="form-label" for="username">Username</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4 mb-lg-1">
                                        <input type="text" id="phone" class="form-control" placeholder="Phone Number"
                                            minlength="8" maxlength="8" name="phone" required />
                                        <label class="form-label" for="phone">Phone number</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4 mb-lg-1">
                                        <input type="email" id="login-email" class="form-control"
                                            placeholder="Email address" name="email" required />
                                        <label class="form-label" for="email">Email</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4 mb-lg-1">
                                        <input type="password" id="password" placeholder="Password" class="form-control"
                                            name="password" required />
                                        <label class="form-label" for="password">Password</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4 mb-lg-1">
                                        <input type="password" id="confirm_password" placeholder="Confirm Password"
                                            class="form-control" name="confirm_password" required />
                                        <label class="form-label" for="confirm_password"> Confirm Password</label>
                                    </div>

                                    <div class="text-center mb-2 mt-1">
                                        <?php if (isset($_GET['usernameErrorSignUp'])) { ?>
                                            <span style="color:red"><?php echo $_GET['usernameErrorSignUp']; ?></span>
                                        <?php } ?>

                                        <?php if (isset($_GET['EmailErrorSignUp'])) { ?>
                                            <span style="color:red"><?php echo $_GET['EmailErrorSignUp']; ?></span>
                                        <?php } ?>
                                        <br>
                                        <span id="passwordError" style="color:red"></span>
                                    </div>

                                    <div class="text-center pt-1 pb-1">
                                        <button data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-primary btn-block fa-lg gradient-custom-3 mb-3 mb-lg-2 rounded"
                                            type="submit" id="signup-btn">
                                            Sign up</button>
                                    </div>


                                </form>
                            </div>
                        </div>

                        <div class="col-lg-6 align-items-center justify-content-center text-center gradient-custom-2 login-signup-card-design"
                            id="login-signup-card-design-mobile">

                            <div class="text-white px-3 py-4 p-md-2 m-md-4">
                                <img src="../Images/logo/Restaurant-booking-02.png" alt="logo" class="login-img">

                                <div class="align-items-center justify-content-center pb-2 createnew-div-mobile">
                                    <p class="mb-2 me-2">Don't have an account?</p>
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-danger rounded" onclick="CreateNew()">Create
                                        new</button>
                                </div>

                                <div class="align-items-center justify-content-center pb-2 pb-lg-1 login-div-mobile">
                                    <p class="mb-2 me-2">Already have an account?</p>
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-danger rounded" onclick="SignIn()">Log In</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (isset($_GET['usernameErrorSignUp']) || isset($_GET['EmailErrorSignUp'])) { ?>
    <script>
        // Hide the login form
        function showSignUpForm() {
            let loginCardBody = document.querySelector('#login-card-body');
            loginCardBody.style.display = 'none';

            // Show the sign-up form
            let signupCardBody = document.querySelector('#signup-card-body');
            signupCardBody.style.display = 'flex';
            signupCardBody.style.flexDirection = 'column';

            document.querySelector('.createnew-div').style.display = 'none';
            document.querySelector('.login-div').style.display = 'block';
            document.querySelector('.createnew-div-mobile').style.display = 'none';
            document.querySelector('.login-div-mobile').style.display = 'block';

            switchGradient('#login-signup-card-design-desktop', false);
            switchGradient('#login-signup-card-design-mobile', false);
        }

        function switchGradient(selector, toRight = false) {
            const element = document.querySelector(selector);
            if (element) {
                const currentGradient = window.getComputedStyle(element).backgroundImage;
                const direction = toRight ? 'to right' : 'to left';
                const newGradient = currentGradient.replace(/to (left|right)/g, direction);
                element.style.backgroundImage = newGradient;
                if (selector === '#login-signup-card-design-desktop') {
                    element.style.borderRadius = toRight ? "10rem 1rem 1rem 10rem" : "1rem 10rem 10rem 1rem";
                }
            }
        }

        document.addEventListener('DOMContentLoaded', showSignUpForm);
    </script>
<?php } ?>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirm_password');
        const passwordError = document.getElementById('passwordError');
        [passwordField, confirmPasswordField].forEach(field => {
            field.addEventListener('keyup', () => {
                const password = passwordField.value;
                const confirmPassword = confirmPasswordField.value;
                if (password !== confirmPassword) {
                    passwordError.innerHTML = "Passwords do not match.";
                    document.getElementById('signup-btn').disabled = true;
                } else {
                    passwordError.innerHTML = ""; // Clear error if passwords match
                    document.getElementById('signup-btn').disabled = false;
                }
            });
        });
    });

    function CreateNew() {
        // Hide the login form
        let loginCardBody = document.querySelector('#login-card-body');
        loginCardBody.style.display = 'none';
        // Show the sign-up form
        let signupCardBody = document.querySelector('#signup-card-body');
        signupCardBody.style.display = 'flex';
        signupCardBody.style.flexDirection = 'column';

        document.querySelector('.createnew-div').style.display = 'none';
        document.querySelector('.login-div').style.display = 'block';
        document.querySelector('.createnew-div-mobile').style.display = 'none';
        document.querySelector('.login-div-mobile').style.display = 'block';

        switchGradient('#login-signup-card-design-desktop');
        switchGradient('#login-signup-card-design-mobile');
    }

    function SignIn() {
        // Hide the sign-up form 
        let signupCardBody = document.querySelector('#signup-card-body');
        signupCardBody.style.display = 'none';

        // Show the login form
        let loginCardBody = document.querySelector('#login-card-body');
        loginCardBody.style.display = 'flex';
        loginCardBody.style.flexDirection = 'column';

        document.querySelector('.login-div').style.display = 'none';
        document.querySelector('.createnew-div').style.display = 'block';
        document.querySelector('.login-div-mobile').style.display = 'none';
        document.querySelector('.createnew-div-mobile').style.display = 'block';

        switchGradient('#login-signup-card-design-desktop', true);
        switchGradient('#login-signup-card-design-mobile', true);
    }

    function switchGradient(selector, toRight = false) {
        const element = document.querySelector(selector);
        const currentGradient = window.getComputedStyle(element).backgroundImage;
        const direction = toRight ? 'to right' : 'to left';
        const newGradient = currentGradient.replace(/to (left|right)/g, direction);
        element.style.backgroundImage = newGradient;

        if (selector === '#login-signup-card-design-desktop') {
            element.style.borderRadius = toRight ? "10rem 1rem 1rem 10rem" : "1rem 10rem 10rem 1rem";
        }
    }

    // Hiding the buttons with class .loginbtn1 and .loginbtn2
    document.addEventListener('DOMContentLoaded', function () {
        // Hide login buttons
        document.querySelectorAll('header button.loginbtn1, div.header-div-nav-links2 li.loginbtn2').forEach(btn => {
            btn.style.display = 'none';
        });
    });

    // Target number input fields
    var numberInputs = document.querySelectorAll('input[type="number"]');
    // Loop through each number input
    numberInputs.forEach(function (input) {
        // Disable the default spin buttons
        input.style['-moz-appearance'] = 'textfield'; // Firefox
        input.style['-webkit-appearance'] = 'none'; // Chrome, Safari, Opera
        input.style['appearance'] = 'none'; // Modern browsers
    });

    // Function to check screen size and hide/show the div
    function checkScreenSize() {
        const desktopDiv = document.getElementById('login-signup-card-design-desktop');
        const mobileDiv = document.getElementById('login-signup-card-design-mobile');

        if (window.matchMedia('(max-width: 991.2px)').matches) {
            desktopDiv.style.display = 'none';
            mobileDiv.style.display = 'flex';
        } else {
            desktopDiv.style.display = 'flex';
            mobileDiv.style.display = 'none';
        }
    }

    // Initial check when the page loads
    checkScreenSize();

    // Check the screen size whenever the window is resized
    window.addEventListener('resize', checkScreenSize);


</script>

<?php include 'footer.php'; ?>