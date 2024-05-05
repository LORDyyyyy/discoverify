<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<section>
        <h2>Add Comment</h2>
        <form enctype="multipart/form-data" action="/api/posts/comments" method="POST" novalidate>
            <?php include $this->resolve('partials/_csrf.php'); ?>
            <label for="comment">Your Comment:</label><br>
            <textarea id="comment" name="content" rows="3"></textarea><br><br>
            <div class="invalid-feedback">
            <?php if (isset($errors['content'])) : ?>
                <?php echo esc($errors['content'][0]); ?>
            <?php endif; ?>
        </div>
            <button type="submit">Post Comment</button>
        </form>
    </section>

</body>

</html>