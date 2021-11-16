<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Karyaku</title>
    <?php
        require_once("head.php");
    ?>
</head>
<body>
    <div class="container d-flex flex-column align-items-center">
        <a href="index.php"><img src="asset/logo.png" alt="" height="120px" ></a>
        <div class="card shadow " style="width: 50%; height:650px;">
            <form action="" method="POST" class="d-flex flex-column align-items-center">
                <h1 class="mt-4 mb-0">REGISTER</h1>
                <input class="mt-4" type="text" placeholder="Username" style="border-radius: 5px; height:40px; width:78%;" name="username">
                <input class="mt-4" type="password" placeholder="Password" style="border-radius: 5px; height:40px; width:78%;" name="password">
                <input class="mt-4" type="password" placeholder="Confirm Password" style="border-radius: 5px; height:40px; width:78%;" name="cpassword">
                <input class="mt-4" type="text" placeholder="Nama" style="border-radius: 5px; height:40px; width:78%;" name="nama">
                <input class="mt-4" type="email" placeholder="Email" style="border-radius: 5px; height:40px; width:78%;" name="email">
                <div style="width: 78%;">
                    <p style="color: gray;" class="my-0">Example : Karyaku@gmail.com</p>
                </div>
                <input class="mt-3" type="text" placeholder="Alamat Rumah" style="border-radius: 5px; height:40px; width:78%;" name="alamat">
                <input class="mt-4" type="text" placeholder="Nomor Telepon" style="border-radius: 5px; height:40px; width:78%;" name="phone">
                <button class="btn btn-outline-custom2 mt-4" style="height:40px; width:78%;">REGISTER</button>
                <p>Sudah punya akun ? <a href="login.php">Login!</a></p>
            </form>
        </div>
    </div>
</body>
</html>
