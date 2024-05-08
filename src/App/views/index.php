<?php include $this->resolve('partials/_header.php'); ?>
<main class="container mt-3">
    <div class="row">
        <div class="col-lg-3">
            <div class="shadow p-3 rounded mb-4">
                <div class="h5 text-center">My Profile</div>
                <div class="text-center py-3 border-bottom">
                    <img src="<?= $user['pfp'] ?>" alt="My profile" class="rounded-circle" width="128" height="128">
                </div>

                <div>
                    <div class="my-3">
                        <i class="fa-solid fa-fw fa-pen me-2 text-secondary"></i>
                        Designer,UI
                    </div>
                    <div class="my-3">
                        <i class="fa-solid fa-fw fa-home me-2 text-secondary"></i>
                        London,UK
                    </div>

                    <div class="my-3">
                        <i class="fa-solid fa-fw fa-birthday-cake me-2 text-secondary"></i>
                        April 1,1988
                    </div>
                </div>
            </div>
            <div class="shadow p4 rounded">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-primary list-group-item-action active" aria-current="true">
                        <i class="fa-solid fa-circle-notch me-2"></i>
                        My Groups
                    </a>
                    <a href="#" class="list-group-item list-group-item-primary list-group-item-action">
                        <i class="fa-solid fa-calender-check me-2"></i>
                        My Events</a>
                    <a href="#" class="list-group-item list-group-item-primary list-group-item-action">
                        <i class="fa-solid fa-images me-2"></i>
                        My Photos</a>


                </div>
            </div>
            <div class="shadow p-3 rounded mb-4 mt-3">
                <h5>Interests</h5>
                <div><span class="badge bg-dark"></span>News</div>
                <div><span class="badge bg-dark"></span>W3Scholl</div>
                <div><span class="badge bg-dark"></span>Games</div>
                <div><span class="badge bg-dark"></span>Label</div>
                <div><span class="badge bg-dark"></span>Friends</div>
                <div><span class="badge bg-dark"></span>Food</div>
                <div><span class="badge bg-dark"></span>Design</div>
                <div><span class="badge bg-dark"></span>Alert</div>
                <div><span class="badge bg-dark"></span>Art</div>
                <div><span class="badge bg-dark"></span>photos</div>
            </div>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Hey!</h5>
                <p class="mb-0">People are looking at your profile.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        </div>
        <div class="col-lg-7">
            <div class="shadow p-3 rounded mb-4">
                <div class="mb-2">
                    <input type="text" class="form-control" placeholder="Status: Feeling Blue">
                </div>
                <button class="btn btn-rpimary"><i class="fa-solid fal-pen">Post</i></button>
            </div>

            <?php foreach ($postContents as $postContent) : ?>
                <div class="post_section shadow p-3 rounded mb-4">
                    <div class="profile_section border-bottom pb-3 mb-2 clearfix">
                        <span class="float-end text-muted"><?php echo "{$postContent['created_at']}" ?></span>
                        <div class="d-flex align-items-center">

                            <img src="/<?= $postContent['owner']['profile_picture'] ?>" class="rounded-circle me-2" width="60" height="60" alt="avatar">
                            <h5><?php echo "{$postContent['owner']['first_name']} {$postContent['owner']['last_name']}"    ?></h5>
                        </div>
                    </div>
                    <p>


                        <?php echo "{$postContent['content']}" ?>
                    </p>
                    <?php foreach ($postContent['media'] as $postMedia) : ?>
                        <div class="media_section row">
                            <?php foreach ($postMedia['content'] as $postUrl) : ?>
                                <div class="col-lg-6 m">
                                    <?php if ($postUrl['media_type'] == 'photo') :  ?>
                                        <img src="<?= $postUrl['media_url'] ?>" alt="p1" class="w-100 mb-3">

                                    <?php else : ?>
                                        <video width="320" height="240" controls>
                                            <source src="<?= $postUrl['media_url'] ?>" type="video/mp4">
                                        </video>
                                </div>
                            <?php endif ?>

                        <?php endforeach ?>

                        </div>
                    <?php endforeach ?>
                    <div>
                        <a href="#!" class="btn btn-primary"><i class="fa-solid fa-thumbs-up me-2"></i>Like</a>
                        <a href="/comments" class="btn btn-primary"><i class="fa-solid fa-comment me-2"></i>Comment</a>

                    </div>
                </div>
            <?php endforeach ?>
            <!-- <div  class="post_section shadow p-3 rounded mb-4">
                <div class="profile_section border-bottom pb-2 mb-2 clearfix">
                    <span class="float-end text-muted">16 </span>
                    <div class=" d-flex align-items-center">
                        <img src="/assets/img/k2.jpg" class="rounded-circle me-2" width="60" height="60" alt="avatar">
                        <h5>Jane Doe</h5>
                    </div>
                </div>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet vitae iusto ea consequatur,
                    dolor nesciunt libero eius omnis doloribus iure tenetur quidem, quam veniam natus.</p>
                <div>
                    <a href="#!" class="btn btn-primary"><i class="fa-solid fa-thumbs-up me-2"></i>Like</a>
                    <a href="#!" class="btn btn-primary"><i class="fa-solid fa-comment me-2"></i>Comment</a>
                </div>
            </div>
            <div class="shadow p-3 rounded mb-4">
                <div class="border-bottom pb-2 mb-2 clearfix">
                    <span class="float-end text-muted">32 min</span>
                    <div class="d-flex align-items-center">
                        <img src="/assets/img/k3.jpg" class="rounded-circle me-2" width="60" height="60" alt="avatar">
                        <h5>Angie Jane</h5>
                    </div>
                </div>
                <p>Have you seen this</p>
                <div>
                    <img src="/assets/img/m4.jpg" alt="photo" class="w-100 mb-3">
                </div>
                <div>
                    <a href="#!" class="btn btn-primary"><i class="fa-solid fa-thumbs-up me-2"></i>Like</a>
                    <a href="#!" class="btn btn-primary"><i class="fa-solid fa-comment me-2"></i>Comment</a>
                </div>
            </div> -->
        </div>
        <div class="col-lg-2">
            <div class="shadow p-3 rounded mb-4 text-center">
                <h5>Upcoming Events</h5>
                <img src="/assets/img/m3.jpg" alt="bridge" class="w-100 mb-3">
                <p class="fw-bold">Holiday</p>
                <p>Friday 15:00</p>
                <a href="#!" class="btn btn-primary w-100">Info</a>
            </div>
            <div class="shadow p-3 rounded mb-4 text-center">
                <h5>Friend Request</h5>
                <img src="/assets/img/k1.jpg" alt="avatar" class="w-75 mb-1">
                <p class="fw-bold">Jane Doe</p>
                <div class="btn-group d-flex">
                    <a href="#!" class="btn btn-success "><i class="fa-solid fa-check"></i></a>
                    <a href="#!" class="btn btn-danger "><i class="fa-solid fa-times"></i></a>
                </div>
            </div>
            <div class="shadow p-3 rounded mb-4 text-center">
                <p class="my-4">ADS</p>
            </div>
            <div class="shadow p-3 rounded mb-4 text-center">
                <p class="my-4"><i class="fa-solid fa-bug display-6"></i></p>
            </div>
        </div>
    </div>
</main>
<?php include $this->resolve('partials/_footer.php'); ?>