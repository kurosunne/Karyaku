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
<?php
    require_once("koneksi.php");
    if(isset($_REQUEST["btRegister"])){
        $query = $koneksi->prepare("SELECT username,email from list_user");
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $username=$_REQUEST["username"];
        $password=$_REQUEST["password"];
        $cpassword=$_REQUEST["cpassword"];
        $nama=$_REQUEST["nama"];
        $email=$_REQUEST["email"];
        $alamat=$_REQUEST["alamat"];
        $phone=$_REQUEST["phone"];
        $usernameSama = false;
        $emailSama = false;
        $berhasil=0;//field ada yang kosong
        if ($username!="" && $password!="" && $cpassword!="" && $nama!="" && $email!="" && $alamat!="" && $phone!="") {
            if ($password==$cpassword) {
                foreach ($result as $key => $value) {
                    if ($value["username"]==$username) {
                        $usernameSama=true;
                    }
                    if ($value["email"]==$email) {
                        $emailSama=true;
                    }
                }
                if ($usernameSama) {
                    $berhasil=1; //username sudah pernah dipakai
                }else if ($emailSama) {
                    $berhasil=2; //email sudah pernah dipakai
                }else{
                    if( preg_match('([a-zA-Z])', $phone) ) 
                    { 
                        $berhasil=4;//phone number ada tulisan
                    }
                    else 
                    {
                        $berhasil=5; //berhasil buat akun
                        $query = $koneksi->prepare("INSERT into list_user (username,password,name,email,address,phone_number) values(?,?,?,?,?,?)");
                        $md5 = md5($password);
                        $query->bind_param("ssssss",$username,$md5,$nama,$email,$alamat,$phone);
                        $query->execute();
                    }
                }
            }else{
                $berhasil=3;//password & confirm password beda
            }
        }
    }
?>
<body>
    <div class="container d-flex flex-column align-items-center">
        <?php
            if(isset($berhasil)){
                if ($berhasil==0) {
                    echo '<div class="modal" id="aler" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body bg-danger p-0">
                          <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-danger d-flex pt-0 justify-content-center  pb-4">
                          <h4 class="text-light">Field Harus Diisi Semua !</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                ';
                }else if ($berhasil==1) {
                    echo '<div class="modal" id="aler" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body bg-danger p-0">
                          <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-danger d-flex pt-0 justify-content-center  pb-4">
                          <h4 class="text-light">Username Telah Terpakai !</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                ';
                }else if ($berhasil==2) {
                    echo '<div class="modal" id="aler" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body bg-danger p-0">
                          <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-danger d-flex pt-0 justify-content-center  pb-4">
                          <h4 class="text-light">Email Telah Terpakai !</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                ';
                }else if ($berhasil==3) {
                    echo '<div class="modal" id="aler" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body bg-danger p-0">
                          <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-danger d-flex pt-0 justify-content-center  pb-4">
                          <h4 class="text-light">Confirm Password Tidak Sama Dengan Password !</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                ';
                }else if ($berhasil==4) {
                    echo '<div class="modal" id="aler" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body bg-danger p-0">
                          <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-danger d-flex pt-0 justify-content-center  pb-4">
                          <h4 class="text-light">Format Phone Number Salah !</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                ';
                }else if ($berhasil==5) {
                    echo '<div class="modal" id="aler" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body bg-success p-0">
                                <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body bg-success d-flex pt-0 justify-content-center  pb-4">
                                <h4 class="text-light">Register Berhasil !</h4>
                            </div>
                            </div>
                        </div>
                    </div>
                    ';
                } 
            }     
        ?>
        <a href="index.php"><img src="asset/logo.png" alt="" height="120px" ></a>
        <div class="card shadow fade" id="card" style="width: 50%; height:650px;">
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
                <div style="width: 78%;">
                    <p style="color: gray;" class="my-0">Example : 08123456789</p>
                </div>
                <button class="btn btn-outline-custom2 mt-3" name="btRegister" style="height:40px; width:78%;">REGISTER</button>
                <p>Sudah punya akun ? <a href="login.php">Login!</a></p>
            </form>
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function () {
        $("#card").addClass("show");
        $("#aler").modal("show");
    });
</script>
