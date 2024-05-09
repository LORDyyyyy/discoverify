<?php include $this->resolve('partials/_header.php') ?>

<main class="container mt-3 mb-5">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="content">
        <div class="container">
            <?php $i = 0 ?>
            <?php foreach ($searchResults as $res) : ?>
                <?= $i == 0 ? '<div class="row">' : '' ?>
                <div class="col-lg-4">
                    <div class="text-center card-box">
                        <div class="member-card pt-2 pb-2">
                            <div class="thumb-lg member-thumb mx-auto">
                                <a href="/profile/<?= $res['id'] ?>">
                                    <img src="<?= $res['pfp'] ?>" class="rounded-circle img-thumbnail img-fluid" alt="profile-image">
                                </a>
                            </div>
                            <div class="my-2">
                                <h4><?= $res['fname'] . " " . $res['lname'] ?></h4>
                            </div>
                            <form action="/friends/<?= $res['id'] ?>" method="POST">
                                <?php include $this->resolve('partials/_csrf.php'); ?>
                                <button type="submit" class="btn btn-success mt-3 btn-rounded waves-effect w-md waves-light">Add Friend</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <?= $i == 2 ? '</div>' : '' ?>
                <?= $i == 2 ? '<!-- end row -->' : '' ?>
                <?php $i = ($i == 2 ? 0 : $i + 1)  ?>
            <?php endforeach ?>
            <?= $i != 2 ? '</div>' : '' ?>
            <?= $i != 2 ? '<!-- end row -->' : '' ?>
        </div>
        <!-- container -->
    </div>
</main>

<?php include $this->resolve('partials/_footer.php') ?>