<?php include $this->resolve('partials/_header.php'); ?>
<link rel="stylesheet" href="/assets/css/posts.css">

<form enctype="multipart/form-data" action="/posts" method="POST" novalidate>
    <?php include $this->resolve('partials/_csrf.php'); ?>

    <label for="content">Content:</label><br>
    <input id="content" name="content" rows="5" class="form-control <?= ($errors['content'] ?? false) ? 'is-invalid' : '' ?>" type="text" />
    <div class="invalid-feedback">
        <?php if (isset($errors['content'][0])) : ?>
            <?php echo esc($errors['content'][0]); ?>
        <?php endif; ?>
    </div><br>

    <label for="image">Upload Picture:</label><br>
    <input type="file" id="image" name="image[]" multiple accept="image/*"><br><br>
    <div class="invalid-feedback">
        <?php if (isset($errors[0])) : ?>
            <?php echo ($errors[0]); ?>
        <?php endif; ?>
    </div>
    <label for="video">Upload videos:</label><br>
    <input type="file" id="video" name="video[]" multiple accept="video/*"><br><br>

    <button type="submit">Submit</button>
</form>


</body>

</html>