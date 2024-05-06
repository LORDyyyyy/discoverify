<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">

    <script defer src="/assets/js/dev/bootstrap.bundle.min.js"></script>

    <title> <?php echo esc($title); ?> </title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
        }

        .box-area {
            width: 930px;
        }

        .right-box {
            padding: 40px 30px 40px 40px;
        }

        ::placeholder {
            font-size: 16px;
        }

        .rounded-4 {
            border-radius: 20px;
        }

        .rounded-5 {
            border-radius: 30px;
        }

        .error {
            border-color: red !important;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="/assets/images/reset_pass.png" class="img-fluid" style="width: 225px;">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Reset Password</p>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Reset Your Password</h2>
                        <p>Enter your new password below.</p>
                    </div>
                    <form action="/resetpass" method="POST">
                        <?php include $this->resolve('partials/_csrf.php'); ?>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="New Password" name="newPassword">
                        </div>
                        <div class="error-message mb-2 text-danger">
                            <?php if (isset($errors['newPassword'])) : ?>
                                <?php echo esc($errors['newPassword'][0]); ?>
                            <?php endif; ?>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Confirm Password" name="confirmPassword">
                        </div>
                        <div class="error-message mb-2 text-danger">
                            <?php if (isset($errors['confirmPassword'])) : ?>
                                <?php echo esc($errors['confirmPassword'][0]); ?>
                            <?php endif; ?>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>