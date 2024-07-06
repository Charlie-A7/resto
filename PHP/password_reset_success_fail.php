<?php
session_start();

include 'header.php';
?>

<div>
    <?php if (isset($_GET['password_reset_success_fail_message'])) { ?>
        <h5 style="text-align:center"><?php echo $_GET['password_reset_success_fail_message']; ?></h5>
    <?php } ?>
</div>

<script>
</script>

<?php include 'footer.php'; ?>