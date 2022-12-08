<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>IceFeet - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <?php require 'header.php' ?>
    <div class="container">
        <?php if (isset($_GET['invalid-user'])) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                Invalid User!
            </div>
        <?php endif ?>
        <form class="mt-4" action="processuser.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input class="form-control type=" text" name="username" id="username" required="required">
            </div>

            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input class="form-control" type=" password" name="pass" id="pass" required="required">
            </div>

            <div class="mb-3">
                <label for="repass" class="form-label">Re-Enter Password</label>
                <input class="form-control" type=" password" name="repass" id="repass" required="required">
            </div>

            <div class="mb-3">
                <button type="submit" name="command" class="btn btn-primary" value="Register">Register</button>
            </div>
            <div class="mb-3">
                <a href="login.php">Already a user? Sign in</a>
            </div>
            <div class="mb-3">
                <a href="index.php">Back to home page</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>