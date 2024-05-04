<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/lib/fontawesome/css/all.min.css">

    <script src="/assets/js/dev/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/dev/jquery.min.js"></script>
    <script src="/assets/js/dev/socket.io.min.js"></script>
    <script src="/assets/js/dev/socket.io.min.js.map"></script>

    <title> <?= $title ?? 'Discoverify' ?> </title>
</head>

<body>
    <nav class="navbar fixed-top navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-home"></i> ONLINE3OOK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <i class="fa-solid fa-earth-europe fa-lg d-none d-lg-inline"></i>
                            <span class="d-lg-none">Home</span>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-user fa-lg d-none d-lg-inline"></i>
                            <span class="d-lg-none">Account</span>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-envelope fa-lg d-none d-lg-inline"></i>
                            <span class="d-lg-none">Contact</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bell fa-lg d-none d-lg-inline"></i>
                            <sup>
                                <span class="badge rounded-pill text-bg-success">3</span>
                            </sup>
                            <span class="d-lg-none">Notifications</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">One new friend request</a></li>
                            <li><a class="dropdown-item" href="#">John Doe posted on your wall</a></li>
                            <li><a class="dropdown-item" href="#">Jane likes your post</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav  mb-2 mb-lg-0">
                    <li class="nav-item me-2">
                        <a class="nav-link" href="#">
                            <img src="/assets/img/e1.jpg" alt="profile photo" class="rounded-circle d-none d-lg-inline" width="24" height="24">
                            <span class="d-lg-none">My Account</span>
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link btn btn-primary" href="/logout">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>