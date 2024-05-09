<?php include $this->resolve('partials/_header.php'); ?>
<style>
    
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        /* padding: 20px; */
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .invalid-feedback {
        color: red;
        margin-top: 5px;
        font-size: 14px;
    }
</style>

<body style="width:70%; ">

    <div class="post_section shadow p-3 rounded mb-4">
        <div class="profile_section border-bottom pb-3 mb-2 clearfix">

            <span class="float-end text-muted"><?php echo "{$postContents['created_at']}" ?></span>
            <div class="d-flex align-items-center">

                <img src="/<?= $postContents['owner']['profile_picture'] ?>" class="rounded-circle me-2" width="60" height="60" alt="avatar">
                <h5><?php echo "{$postContents['owner']['first_name']} {$postContents['owner']['last_name']}"    ?></h5>
            </div>
        </div>
        <p>


            <?php echo "{$postContents['content']}" ?>
        </p>
        <?php foreach ($postContents['media'] as $postMedia) : ?>
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
        <div class="addcontainer">
            <h2>Add Comment</h2>
            <form enctype="multipart/form-data" action="/posts/{id}/comments" method="POST" novalidate>
                <?php include $this->resolve('partials/_csrf.php'); ?>
                <div class="form-group">
                    <label for="comment">Your Comment:</label>
                    <textarea id="comment" name="content" rows="3" class="form-control"></textarea>
                    <div class="invalid-feedback">
                        <?php if (isset($errors['content'])) : ?>
                            <?php echo esc($errors['content'][0]); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
    </div>
    </div>
    <?php foreach ($postContents['comments'] as $postComment) : ?>
        <div class="container mt-5 ">
            <div class="row">
                <div class="col-md-2">
                    <img src="/<?= $postContents['owner']['profile_picture'] ?>" alt="Profile Picture" class="profile-picture">
                </div>
                <div class="col-md-10 ">
                    <h5 class="username"><?php echo "{$postComment['owner']['first_name']} {$postComment['owner']['last_name']}"    ?></h5>
                    <p class="comment"><?php echo "{$postComment['content']}" ?></p>
                </div>
            </div>
        </div>
    <?php endforeach ?>



</body>

</html>



<!-- <h2>Add Comment</h2>
<form enctype="multipart/form-data" action="/api/posts/comments" method="POST" novalidate>
    <?php //include $this->resolve('partials/_csrf.php'); 
    ?>
    <label for="comment">Your Comment:</label><br>
    <textarea id="comment" name="content" rows="3"></textarea><br><br>
    <div class="invalid-feedback">
        <? //php if (isset($errors['content'])) : 
        ?>
        <? //php echo esc($errors['content'][0]); 
        ?>
        <? //php endif; 
        ?>
    </div>
    <button type="submit">Post Comment</button>
</form> -->