<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($SITE_TITLE); ?> | Login</title>
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
        <h1>Login</h1>
        <p class="lp-lead">Sign in to your POS account</p>

        <?php if ($this->session->flashdata('failed')): ?>
            <div class="lp-msg err"><i class="fa fa-exclamation-circle"></i> <?php echo $this->session->flashdata('failed'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="lp-msg ok"><i class="fa fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <form id="login-form" action="<?php echo $base_url; ?>login/verify" method="post" autocomplete="on">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="lp-field">
                <label class="lp-label" for="email">Username</label>
                <div class="lp-input-group">
                    <i class="fa fa-user-o lp-input-icon"></i>
                    <input name="email" id="email" type="text" placeholder="Type your username or email" autocomplete="username" required autofocus>
                </div>
            </div>

            <div class="lp-field">
                <label class="lp-label" for="pass">Password</label>
                <div class="lp-input-group">
                    <i class="fa fa-lock lp-input-icon"></i>
                    <div class="lp-pass-wrap">
                        <input name="pass" id="pass" type="password" placeholder="Type your password" autocomplete="current-password" required>
                        <button type="button" class="lp-toggle-pass" id="togglePass" aria-label="Toggle password visibility"><i class="fa fa-eye"></i></button>
                    </div>
                </div>
            </div>

            <div class="lp-actions">
                <a href="<?php echo base_url('login/forgot_password'); ?>">Forgot password?</a>
            </div>

            <button type="submit" class="lp-submit">LOGIN</button>
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
    $('#togglePass').on('click', function (e) {
        e.preventDefault();
        var $i = $('#pass');
        var show = $i.attr('type') === 'password';
        $i.attr('type', show ? 'text' : 'password');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });
});
</script>
</body>
</html>
