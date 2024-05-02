<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
                <div class="col-md-6">
                    <img src="/assets/images/main_logo_transparent.png" alt="Image" class="img-fluid logo">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-center mt-5 mb-3">
                                <h3 class="fw-bold h2">Sign up</h3>
                            </div>
                            <form action="/signup" method="POST" novalidate>
                                <?php include $this->resolve('partials/_csrf.php'); ?>
                                <div class="form-group first">
                                    <label for="fname">Frist Name</label>
                                    <input value="<?php echo esc($oldFormData['fname'] ?? '') ?>" type="text" class="form-control <?php echo $errors['fname'] ?? '' ? 'is-invalid' : '' ?>" id="fname" name="fname">
                                    <div class="invalid-feedback">
                                        <?php if (isset($errors['fname'])) : ?>
                                            <?php echo esc($errors['fname'][0]); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group first">
                                    <label for="lname">Last Name</label>
                                    <input value="<?php echo esc($oldFormData['lname'] ?? '') ?>" type="text" class="form-control <?php echo $errors['lname'] ?? '' ? 'is-invalid' : '' ?>" id="lname" name="lname">
                                    <div class="invalid-feedback">
                                        <?php if (isset($errors['lname'])) : ?>
                                            <?php echo esc($errors['lname'][0]); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input value="<?php echo esc($oldFormData['email'] ?? '') ?>" type="email" class="form-control <?php echo $errors['email'] ?? '' ? 'is-invalid' : '' ?>" id="email" name="email">
                                    <div class="invalid-feedback">
                                        <?php if (isset($errors['email'])) : ?>
                                            <?php echo esc($errors['email'][0]); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control <?php echo $errors['password'] ?? '' ? 'is-invalid' : '' ?>" id="password" name="password">
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
                                <div class="form-group last mb-4">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control <?php echo $errors['confirmPassword'] ?? '' ? 'is-invalid' : '' ?>" id="confirmPassword" name="confirmPassword">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <div class="invalid-feedback">
                                            <?php if (isset($errors['confirmPassword'])) : ?>
                                                <?php echo esc($errors['confirmPassword'][0]); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Gender</span>
                                    <select class="form-select <?php echo $errors['gender'] ?? '' ? 'is-invalid' : '' ?>" name="gender">
                                        <option value="male" <?php echo esc(($oldFormData['gender'] ?? '') == 'male' ? 'selected' : '') ?>>Male</option>
                                        <option value="female" <?php echo esc(($oldFormData['gender'] ?? '') == 'female' ? 'selected' : '') ?>>Female</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php if (isset($errors['gender'])) : ?>
                                            <?php echo esc($errors['gender'][0]); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 input-group">
                                    <label for="dateOfBirth" class="input-group-text">Date of birth</label>
                                    <input value="<?php echo esc($oldFormData['dateOfBirth'] ?? '') ?>" type="date" id="dateOfBirth" name="dateOfBirth" class="form-control <?php echo $errors['dateOfBirth'] ?? '' ? 'is-invalid' : '' ?>" />
                                    <div class="invalid-feedback">
                                        <?php if (isset($errors['dateOfBirth'])) : ?>
                                            <?php echo esc($errors['dateOfBirth'][0]); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <span class="ml-auto">
                                        Already have an account?<a href="/login" class="link"> Log in</a>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">Sign up</button>
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