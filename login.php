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
<?php
require_once("koneksi.php");
if (isset($_REQUEST["btLogin"])) {
    if ($_REQUEST["username"]=="IniAdmin" && md5($_REQUEST["password"])==md5("Admin")) {
        header("Location: admin.php");
    }else{
        $query = $koneksi->prepare("SELECT * from list_user");
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $ada = false;
        $berhasil = 0;
        foreach ($result as $key => $value) {
            if ($value["username"] == $_REQUEST["username"]) {
                $ada = true;
                if ($value["password"] == md5($_REQUEST["password"])) {
                    $berhasil = 3; //berhasil Login
                    header("Location: index.php");
                    $_SESSION["active"] = $value;
                    $_SESSION["tipe"]="user";
                } else {
                    $berhasil = 1; //password salah
                }
            }
        }
        if (!$ada) {
            $berhasil = 2; //username tidak terdaftar
        }
    }
}
?>

<body>
    <?php
    if (isset($berhasil)) {
        if ($berhasil == 1) {
            echo '<div class="modal" id="aler" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body bg-danger p-0">
                        <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-danger d-flex pt-0 justify-content-center  pb-4">
                        <h4 class="text-light">Password Salah !</h4>
                    </div>
                    </div>
                </div>
                </div>
            ';
        } else if ($berhasil == 2) {
            echo '<div class="modal" id="aler" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body bg-danger p-0">
                        <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-danger d-flex pt-0 justify-content-center  pb-4">
                        <h4 class="text-light">Username Belum Terdaftar !</h4>
                    </div>
                    </div>
                </div>
                </div>
            ';
        }
    }
    ?>
    <div class="container d-flex flex-column align-items-center">
        <a href="index.php"><img src="asset/logo.png" alt="" height="120px"></a>
        <div class="card shadow fade" id="card" style="width: 50%; height:300px;">
            <form action="" method="POST" class="d-flex flex-column align-items-center">
                <h1 class="mt-4 mb-0">LOGIN</h1>
                <input class="mt-4" type="text" placeholder="Username" style="border-radius: 5px; height:40px; width:78%;" name="username">
                <input class="mt-4" type="password" placeholder="Password" style="border-radius: 5px; height:40px; width:78%;" name="password">
                <button class="btn btn-outline-custom2 mt-4" style="height:40px; width:78%;" name="btLogin">LOGIN</button>
                <p>Belum punya akun ? <a href="register.php">Register!</a></p>
            </form>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $("#card").addClass("show");
        $("#aler").modal("show");
    });
</script>