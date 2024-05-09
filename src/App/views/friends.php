<?php include $this->resolve('partials/_header.php'); ?>
<?php debug($notifications) ?>
<main class="container mt-3 mb-5">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="content">
        <div class="container">
            <?php $i = 0 ?>
            <?php foreach ($friends as $friend) : ?>
                <?php $friendId = $friend['sID'] == $user['id'] ? $friend['rID'] : $friend['sID']; ?>
                <?= $i == 0 ? '<div class="row">' : '' ?>
                <div class="col-lg-4">
                    <div class="text-center card-box">
                        <div class="member-card pt-2 pb-2">
                            <div class="thumb-lg member-thumb mx-auto">
                                <img src="<?= $friend['pfp'] ?>" class="rounded-circle img-thumbnail img-fluid" alt="profile-image">
                            </div>
                            <div class="my-2">
                                <h4><?= $friend['fname'] . " " . $friend['lname'] ?></h4>
                            </div>
                            <form action="/friends/<?= $friendId ?>" method="POST">
                                <?php include $this->resolve('partials/_csrf.php'); ?>
                                <input type="hidden" name="_METHOD" value="DELETE">
                                <a href="/chat/<?= $friendId ?>" class="btn btn-primary mt-3 btn-rounded waves-effect w-md waves-light">Message Now</a>
                                <button type="submit" class="btn btn-danger mt-3 btn-rounded waves-effect w-md waves-light">Remove Friend</button>
                            </form>
                            <form action="/block/<?= $friendId ?>" method="POST">
                                <?php include $this->resolve('partials/_csrf.php'); ?>
                                <button type="submit" class="btn btn-warning mt-3 btn-rounded waves-effect w-md waves-light">Block Friend</button>
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
<?php include $this->resolve('partials/_footer.php'); ?>