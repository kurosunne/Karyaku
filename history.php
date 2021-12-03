<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <?php
    require_once("head.php");
    ?>
</head>
<?php
require_once("koneksi.php");
require_once("header.php");

$query = $koneksi->prepare("SELECT *, (h.qty*lp.price) as 'total', lp.name as namaProduk from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.user_id=? order by h.History_id desc");
$query->bind_param("i", $_SESSION["active"]["users_id"]);
$query->execute();
$data = $query->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<body style="min-height:100vh; display: flex; flex-direction:column;">
    <div class="container" style="flex-grow: 1;">
        <div class="row justify-content-center">
            <div class="col p-2 d-flex justify-content-center">
                <div class="btn shadow bg-purple" onclick="alllist()" id="all" style="width: 80%;">All</div>
            </div>
            <div class="col p-2 d-flex justify-content-center">
                <div class="btn shadow bg-gold" onclick="menunggu()" id="menunggu" style="width: 80%;">Menunggu konfirmasi</div>
            </div>
            <div class="col p-2 d-flex justify-content-center">
                <div class="btn shadow bg-gold" onclick="dikirim()" id="dikirim" style="width: 80%;">Sedang Dikirim</div>
            </div>
            <div class="col p-2 d-flex justify-content-center">
                <div class="btn shadow bg-gold" onclick="completed()" id="completed" style="width: 80%;">Completed</div>
            </div>
            <div class="col p-2 d-flex justify-content-center">
                <div class="btn shadow bg-gold" onclick="gagal()" id="gagal" style="width: 80%;">Gagal</div>
            </div>
        </div>
        <div id="box" >
            <?php
            foreach ($data as $key => $value) {
            ?>
                <div style="width: 100%;" class="shadow p-2 row my-2">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <img src="<?= $value["image"] ?>" class="shadow " width="100%" alt="">
                    </div>
                    <div class="col-xxl-10 col-md-9 col-xxs-8">
                        <p class="mx-2 mb-0"><?= $value["namaProduk"] ?></p>
                        <p class="mx-2 mb-0">Quantity : <?= $value["qty"] ?></p>
                        <p class="mx-2 mb-0">Price : <?= number_format($value["price"], 2, ',', '.') ?></p>
                        <p class="mx-2 mb-0">Total : <?= number_format($value["total"], 2, ',', '.') ?></p>
                        <p class="mx-2 mb-0" style="color:<?= $value["order_info"] == "completed" ? "green" : ($value["order_info"] == "sedang dikirim" ? "blue" : ($value["order_info"] == "menunggu konfirmasi" ? "#FDB827" : "red")) ?>;">Order Info : <?= $value["order_info"] ?></p>
                    </div>
                    <?php
                    if ($value["order_info"] == "completed"  && $value["rate"] == 0) {
                        echo '<div class="col-1"><div style="height:70%;"></div><a href="review.php?id='.$value["History_id"].'"><button class="btn btn-primary">Review</button></a></div>';
                    }
                    if ($value["order_info"] == "completed"  && $value["rate"] != 0) {
                        echo '<div class="col-1"><div style="height:70%;"></div><a href="#"><button class="btn btn-secondary">Reviewed</button></a></div>';
                    }
                    if ($value["order_info"] == "sedang dikirim") {
                        echo '<div class="col-1"><div style="height:70%;"></div><button onclick="selesai(' . $value["History_id"] . ')" class="btn btn-success">Selesai</button></div>';
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
        require_once("footer.php");
    ?>
</body>

</html>
<script>
    function alllist() {
        $("#all").removeClass("bg-gold");
        $("#menunggu").removeClass("bg-gold");
        $("#dikirim").removeClass("bg-gold");
        $("#completed").removeClass("bg-gold");
        $("#gagal").removeClass("bg-gold");
        $("#all").removeClass("bg-purple");
        $("#menunggu").removeClass("bg-purple");
        $("#dikirim").removeClass("bg-purple");
        $("#completed").removeClass("bg-purple");
        $("#gagal").removeClass("bg-purple");
        $("#all").addClass("bg-purple");
        $("#menunggu").addClass("bg-gold");
        $("#dikirim").addClass("bg-gold");
        $("#completed").addClass("bg-gold");
        $("#gagal").addClass("bg-gold");
        $.post("kontroler.php", {
            action: "allList"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    function menunggu() {
        $("#all").removeClass("bg-gold");
        $("#menunggu").removeClass("bg-gold");
        $("#dikirim").removeClass("bg-gold");
        $("#completed").removeClass("bg-gold");
        $("#gagal").removeClass("bg-gold");
        $("#all").removeClass("bg-purple");
        $("#menunggu").removeClass("bg-purple");
        $("#dikirim").removeClass("bg-purple");
        $("#completed").removeClass("bg-purple");
        $("#gagal").removeClass("bg-purple");
        $("#all").addClass("bg-gold");
        $("#menunggu").addClass("bg-purple");
        $("#dikirim").addClass("bg-gold");
        $("#completed").addClass("bg-gold");
        $("#gagal").addClass("bg-gold");
        $.post("kontroler.php", {
            action: "menunggu"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    function dikirim() {
        $("#all").removeClass("bg-gold");
        $("#menunggu").removeClass("bg-gold");
        $("#dikirim").removeClass("bg-gold");
        $("#completed").removeClass("bg-gold");
        $("#gagal").removeClass("bg-gold");
        $("#all").removeClass("bg-purple");
        $("#menunggu").removeClass("bg-purple");
        $("#dikirim").removeClass("bg-purple");
        $("#completed").removeClass("bg-purple");
        $("#gagal").removeClass("bg-purple");
        $("#all").addClass("bg-gold");
        $("#menunggu").addClass("bg-gold");
        $("#dikirim").addClass("bg-purple");
        $("#completed").addClass("bg-gold");
        $("#gagal").addClass("bg-gold");
        $.post("kontroler.php", {
            action: "dikirim"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    function completed() {
        $("#all").removeClass("bg-gold");
        $("#menunggu").removeClass("bg-gold");
        $("#dikirim").removeClass("bg-gold");
        $("#completed").removeClass("bg-gold");
        $("#gagal").removeClass("bg-gold");
        $("#all").removeClass("bg-purple");
        $("#menunggu").removeClass("bg-purple");
        $("#dikirim").removeClass("bg-purple");
        $("#completed").removeClass("bg-purple");
        $("#gagal").removeClass("bg-purple");
        $("#all").addClass("bg-gold");
        $("#menunggu").addClass("bg-gold");
        $("#dikirim").addClass("bg-gold");
        $("#completed").addClass("bg-purple");
        $("#gagal").addClass("bg-gold");
        $.post("kontroler.php", {
            action: "completed"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    function gagal() {
        $("#all").removeClass("bg-gold");
        $("#menunggu").removeClass("bg-gold");
        $("#dikirim").removeClass("bg-gold");
        $("#completed").removeClass("bg-gold");
        $("#gagal").removeClass("bg-gold");
        $("#all").removeClass("bg-purple");
        $("#menunggu").removeClass("bg-purple");
        $("#dikirim").removeClass("bg-purple");
        $("#completed").removeClass("bg-purple");
        $("#gagal").removeClass("bg-purple");
        $("#all").addClass("bg-gold");
        $("#menunggu").addClass("bg-gold");
        $("#dikirim").addClass("bg-gold");
        $("#completed").addClass("bg-gold");
        $("#gagal").addClass("bg-purple");
        $.post("kontroler.php", {
            action: "gagal"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    function selesai(index) {
        $.post("kontroler.php", {
            action: "selesai",
            id: index
        }, function(data, status) {
            completed();
        });
    }
</script>