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
    <script defer src="/assets/js/login.js"></script>

    <title> <?php echo esc($title); ?> </title>
</head>

<body>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 justify-content-center">
                    <img src="/assets/images/main_logo_transparent.png" alt="Image" class="img-fluid logo">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-center mt-5 mb-3">
                                <h3 class="fw-bold h2">Log in</h3>
                            </div>
                            <form action="/login" method="POST" novalidate>
                                <?php include $this->resolve('partials/_csrf.php'); ?>
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" value="<?php echo esc($oldFormData['email'] ?? '') ?>" class="form-control <?php echo isset($errors['email']) || isset($errors['credentials']) ? 'is-invalid' : '' ?>" id="email" name="email">
                                    <div class="invalid-feedback">
                                        <?php if (isset($errors['email'])) : ?>
                                            <?php echo esc($errors['email'][0]); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <div class="invalid-feedback">
                                            <?php if (isset($errors['password'])) : ?>
                                                <?php echo esc($errors['password'][0]); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" name="rememberMe" type="checkbox" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Remember Me
                                    </label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="ml-auto">
                                        <a href="/forgotpass" class="link">Forgot Password?</a>
                                    </span>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <span class="ml-auto">
                                        Don't have an account?<a href="/signup" class="link"> Sign up</a>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>