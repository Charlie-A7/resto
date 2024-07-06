<?php
session_start();

include 'header.php';
?>

<div class="col-12 align-items-center justify-content-center" id="forgot-pass-div">
    <div class="card-body mx-md-4 my-3 my-lg-1 align-items-center justify-content-center d-flex flex-column">

        <div class="text-center mb-4">
            <h4 class="mt-2 mb-4">Forgot Your Password?</h4>
            <h6 class="mb-0">No worries!</h6>
            <h6>Just enter your email below, and we'll send you a link to reset it.</h6>
        </div>

        <!--  action="forgot_pass_process.php"  -->
        <form id="forgot-pass-form" method="POST">

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="login-email" class="form-control" placeholder="Email address" name="email"
                    required />
            </div>

            <div class="text-center pt-1 pb-1">
                <button data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-primary btn-block fa-lg gradient-custom-3 mb-3 mb-lg-2 rounded" type="submit"
                    id="continue-reset-pass-btn">
                    Continue
                </button>
            </div>

            <div>
                <?php if (isset($_GET['forgotPass'])) { ?>
                    <span id="forgotPassMessage" style="color:red; display:none;"><?php echo $_GET['forgotPass']; ?></span>
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<div class="col-12 align-items-center justify-content-center" id="reset-pass-div" style="display:none;">
    <div class="card-body mx-md-4 my-3 my-lg-1 align-items-center justify-content-center d-flex flex-column">

        <div class="text-center mb-4">
            <h4 class="mt-2 mb-4">Reset Password</h4>
            <h6>Just enter your new password, and you're good to go.</h6>
        </div>

        <form id="forgot-pass-form" method="POST" action="">


            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" placeholder="Password" class="form-control" name="password"
                    required />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="confirm_password"> Confirm Password</label>
                <input type="password" id="confirm_password" placeholder="Confirm Password" class="form-control"
                    name="confirm_password" required />
            </div>

            <div class="text-center pt-1 pb-1">
                <button data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-primary btn-block fa-lg gradient-custom-3 mb-3 mb-lg-2 rounded" type="submit"
                    id="reset-pass-btn">
                    Reset Password
                </button>
            </div>

            <div>
                <?php if (isset($_GET['forgotPass'])) { ?>
                    <span id="forgotPassMessage" style="color:red; display:none;"><?php echo $_GET['forgotPass']; ?></span>
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelector('#continue-reset-pass-btn').addEventListener('click', function () {
        // document.querySelector('#forgotPassMessage').style.display = 'inline';
        document.querySelector('#forgot-pass-div').style.display = 'none';
        document.querySelector('#reset-pass-div').style.display = 'flex';
    });

    document.querySelector('#continue-reset-pass-btn').addEventListener('click', function () {
    });
</script>

<?php include 'footer.php'; ?>