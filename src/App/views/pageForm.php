<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .btn-primary {
            background-color: rgb(32, 157, 86);
            border-color: rgb(32, 157, 86);
        }

        .btn-primary:hover {
            background-color:  rgb(14, 96, 49);
            border-color: rgb(14, 96, 49);
        }

        .form-container {
            border: 2px solid rgb(32, 157, 86);
            
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5"> 
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="text-center mb-4">Page Profile</h2>
                    <form action="/pagesForm" method="post" novalidate>
                        <?php include $this->resolve('partials/_csrf.php');?>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name"  name="pname" >
                        </div>
                        <div class="form-group">
                            <label for="profilePic">Page Picture</label>
                            <input type="file" class="form-control-file" id="profilePic" name="page_pic">
                        </div>
                        <div class="form-group">
                            <label for="coverPic">Cover Picture</label>
                            <input type="file" class="form-control-file" id="coverPic" name="coverPic">
                        </div>
                        <div class="form-group">
                            <label for="bio">Description</label>
                            <textarea class="form-control" id="bio" rows="3" placeholder="Enter your Description" name="dis"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>