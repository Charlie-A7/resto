<?php
session_start();

include 'header.php';
?>

<div class="col-12 align-items-center justify-content-center" id="reset-pass-div">
    <div class="card-body mx-md-4 my-3 my-lg-1 align-items-center justify-content-center d-flex flex-column">

        <div class="text-center mb-4">
            <h4 class="mt-2 mb-4">Reset Password</h4>
            <h6>Enter your new password and the key from the email you received.</h6>
        </div>

        <form id="reset-pass-form" method="POST" action="reset_password_process.php">

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="reset_key">Reset Key</label>
                <input type="text" id="reset_key" placeholder="Reset Key" class="form-control" name="key" required />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="password">New Password</label>
                <input type="password" id="password" placeholder="New Password" class="form-control" name="password" required />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" placeholder="Confirm Password" class="form-control" name="confirm_password" required />
            </div>

            <div class="text-center pt-1 pb-1">
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-3 mb-3 mb-lg-2 rounded" type="submit" id="reset-pass-btn">
                    Reset Password
                </button>
            </div>

            <div>
                <?php if (isset($_GET['confirm_pass_reset_message'])) { ?>
                    <span style="color:red;"><?php echo $_GET['confirm_pass_reset_message']; ?></span>
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<script>
</script>

<?php include 'footer.php'; ?>
