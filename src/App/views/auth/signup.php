<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <script defer src="/assets/js/bootstrap.bundle.min.js"></script>
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
                            <form action="/login" method="POST" novalidate>
                                <?php include $this->resolve('partials/_csrf.php'); ?>
                                <div class="form-group first">
                                    <label for="fname">Frist Name</label>
                                    <input type="text" class="form-control" id="fname" name="fname">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="form-group first">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="form-control" id="lname" name="lname">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Gender</span>
                                    <select class="form-select" name="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <div class="invalid-feedback" id="signup-passwordValidation">
                                    </div>
                                </div>
                                <div class="mb-3 input-group">
                                    <label for="dateOfBirth" class="input-group-text">Date of birth</label>
                                    <input type="date" id="dateOfBirth" name="dateOfBirth" class="form-control" />
                                    <div class="invalid-feedback">
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