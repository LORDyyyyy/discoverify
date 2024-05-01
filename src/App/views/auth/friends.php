<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Friend Request</title>
</head>

<body>
    <h2>Send Friend Request</h2>
    <form action="/friends" method="POST">
        <?php include $this->resolve('partials/_csrf.php'); ?>
        <label for="id">Friend's ID:</label><br>
        <input type="text" id="id" name="id" required><br><br>
        <input type="submit" value="Send Request">
    </form>
</body>

</html>
