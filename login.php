<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Karyaku</title>
    <?php
        require_once("head.php");
    ?>
</head>
<body>
    <div class="container d-flex flex-column align-items-center">
        <a href="index.php"><img src="asset/logo.png" alt="" height="120px" ></a>
        <div class="card shadow " style="width: 50%; height:300px;">
            <form action="" method="POST" class="d-flex flex-column align-items-center">
                <h1 class="mt-4 mb-0">LOGIN</h1>
                <input class="mt-4" type="text" placeholder="Username" style="border-radius: 5px; height:40px; width:78%;" name="username">
                <input class="mt-4" type="password" placeholder="Password" style="border-radius: 5px; height:40px; width:78%;" name="password">
                <button class="btn btn-outline-custom2 mt-4" style="height:40px; width:78%;">LOGIN</button>
                <p>Belum punya akun ? <a href="register.php">Register!</a></p>
            </form>
        </div>
    </div>
</body>
</html>
