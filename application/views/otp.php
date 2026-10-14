<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print htmlspecialchars($SITE_TITLE); ?> | Verify OTP</title>
    <link rel="shortcut icon" href="<?php echo $theme_link; ?>images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo $theme_link; ?>assets/fonts/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $theme_link; ?>assets/css/login-pro.css?v=<?php echo @filemtime(FCPATH.'theme/assets/css/login-pro.css'); ?>">
</head>
<body class="lp">
<main class="lp-page">
    <div class="lp-card">
        <a class="lp-logo" href="<?php echo $base_url; ?>" title="<?php echo htmlspecialchars($SITE_TITLE); ?>">
            <img src="<?php echo base_url(get_site_logo()); ?>" alt="<?php echo htmlspecialchars($SITE_TITLE); ?>">
        </a>
        <h1>Verify OTP</h1>
        <p class="lp-lead">Enter the security code sent to your email</p>

        <?php if ($this->session->flashdata('failed')): ?>
            <div class="lp-msg err"><i class="fa fa-exclamation-circle"></i> <?php echo $this->session->flashdata('failed'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="lp-msg err"><i class="fa fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="lp-msg ok"><i class="fa fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <form action="<?php echo $base_url; ?>login/verify_otp" method="POST" id="password-form" autocomplete="on">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="email" id="email" value="<?= $this->session->userdata('email')?>">

            <div class="lp-field">
                <label class="lp-label" for="otp">Security OTP Code</label>
                <div class="lp-input-group">
                    <i class="fa fa-key lp-input-icon"></i>
                    <input name="otp" id="otp" type="password" placeholder="Enter OTP code" required autocomplete="one-time-code" autofocus style="letter-spacing: 4px; font-weight: 700;">
                </div>
            </div>

            <button type="submit" class="lp-submit">VERIFY &amp; CONTINUE</button>

            <div style="margin-top: 22px; text-align: center;">
                <a href="<?php echo $base_url; ?>login/forgot_password" style="color: #64748b; font-size: 13.5px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s ease;">
                    <i class="fa fa-arrow-left"></i> <span>Resend OTP / Change Email</span>
                </a>
            </div>
        </form>

        <div class="lp-footer">
            <p class="lp-secure"><i class="fa fa-shield"></i> 256-bit Encrypted Connection · Official Portal</p>
            <p class="lp-copyright">Copyright &copy; <?php echo date('Y'); ?> JAAS BD</p>
        </div>
    </div>
</main>

<script src="<?php echo $theme_link; ?>assets/js/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    $.ajaxSetup({ data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'} });
});
</script>
</body>
</html>
