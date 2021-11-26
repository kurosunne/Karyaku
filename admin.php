<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Karyaku</title>
    <?php
    require_once("head.php");
    ?>
</head>
<?php
require_once("koneksi.php");
$berhasil = 0;

$queri = $koneksi->prepare("select * from list_category");
$queri->execute();
$hasil = $queri->get_result()->fetch_all(MYSQLI_ASSOC);

$sql = 'SELECT * FROM list_product order by product_id desc';
$statement = $koneksi->prepare($sql);
$statement->execute();
$result = $statement->get_result();
$all_product = 0;
if (mysqli_num_rows($result) != 0) {
    $row = $result->fetch_assoc();
    $all_product = $row["product_id"];
}
//ADD PRODUCT ACTION
if (isset($_REQUEST["btAdd"])) {
    $_SESSION["index"] = 3;
    if ($_REQUEST["name"] != "" && $_REQUEST["brand"] != "" && $_REQUEST["desc"] != "" && $_REQUEST["stock"] != "" && $_REQUEST["price"] != "") {
        $query = $koneksi->prepare("INSERT into list_product (name,price,stock,description,brand_name,image) values(?,?,?,?,?,?)");
        $query->bind_param("siisss", $_REQUEST["name"], $_REQUEST["price"], $_REQUEST["stock"], $_REQUEST["desc"], $_REQUEST["brand"], $_SESSION["image"]);
        $query->execute();

        foreach ($hasil as $key => $value) {
            if (isset($_REQUEST["c" . $key + 1])) {
                $insert = $koneksi->prepare("INSERT into product_category (product_id,category_id) values (?,?)");
                $temp = $all_product + 1;
                $temp2 = $key + 1;
                $insert->bind_param("ii", $temp, $temp2);
                $insert->execute();
            }
        }
        $berhasil = 2; //Berhasil
    } else {
        $berhasil = 1; //field ada yang kosong
    }
}

//ADD KATEGORI ACTION
if (isset($_REQUEST["addC"])) {
    $_SESSION["index"] = 2;
    if ($_REQUEST["name_category"]!="") {
        $query = $koneksi->prepare("INSERT INTO list_category (nama) VALUES (?)");
        $query->bind_param("s", $_REQUEST["name_category"]);
        $query->execute();

        $berhasil = 3; //BERHASIL ADD CATEGORY
    } else $berhasil = 1;
}

//ADD DISCOUNT ACTION
if (isset($_REQUEST["addDiscount"])) {
    $_SESSION["index"] = 5;
    if ($_REQUEST["productDisc"]!="" && $_REQUEST["disc_name"]!="" && $_REQUEST["disc_number"]!="") {
        $num = intval($_REQUEST["disc_number"]);

        if ($num<1 && $num>100) $berhasil = -1; //NILAI DISCOUNT INVALID
        else {
            //INSERT INTO DISCOUNT
            $query = $koneksi->prepare("INSERT INTO discount (discount_name, product_id, discount_value) VALUES (?,?,?)");
            $query->bind_param("sss", $_REQUEST["disc_name"], $_REQUEST["productDisc"], $_REQUEST["disc_number"]);
            $query->execute();

            $berhasil = 4; //BERHASIL INSERT DISCOUNT
        }
    } else $berhasil = 1; //INPUT KOSONG
}

if ($berhasil != 1) {
    $_SESSION["image"] = "asset/misc/empty.jpg";
}
//UPLOAD PICTURE TO FOLDER PRODUCT
if (isset($_REQUEST["btUpload"])) {
    $_SESSION["index"] = 3;
    $target_dir = "asset/product/";

    $f = $_FILES["fileup"];
    $info = pathinfo($f["name"]);

    $ext = $info["extension"];
    $filename = $info["filename"];

    $sink = $target_dir . $all_product + 1 . "." . $ext;

    $source = $f["tmp_name"];

    if ($f["size"] > 200000) {
        echo "File terlalu besar!";
    } else {
        $_SESSION["image"] = $sink;
        move_uploaded_file($source, $sink);
    }
}

$queryy = $koneksi->prepare("SELECT * from list_product");
$queryy->execute();
$listP = $queryy->get_result()->fetch_all(MYSQLI_ASSOC);

foreach ($listP as $key => $value) {
    if (isset($_REQUEST["btUpload" . $value["product_id"]])) {
        $target_dir = "asset/product/";

        $f = $_FILES["fileup" . $value["product_id"]];
        $info = pathinfo($f["name"]);

        $ext = $info["extension"];
        $filename = $info["filename"];

        $sink = $target_dir . $value["product_id"] . "." . $ext;

        $source = $f["tmp_name"];

        if ($f["size"] > 200000) {
            echo "File terlalu besar!";
        } else {
            move_uploaded_file($source, $sink);
            $upd = $koneksi->prepare("UPDATE list_product set image=? where product_id=?");
            $upd->bind_param("si", $sink, $value["product_id"]);
            $upd->execute();
            $_SESSION["index"] = 4;
            header("Location: admin.php");
        }
    }
}

?>

<body style="overflow: scroll;">
    <!--MODAL LIST-->
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
                        <h4 class="text-light">Field Tidak Boleh Ada Yang Kosong!</h4>
                    </div>
                    </div>
                </div>
                </div>
            ';
        } else if ($berhasil==-1) {
            echo '<div class="modal" id="aler" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body bg-danger p-0">
                        <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-danger d-flex pt-0 justify-content-center  pb-4">
                        <h4 class="text-light">Input Discount Number tidak boleh kurang dari 0 dan lebih dari 100!</h4>
                    </div>
                    </div>
                </div>
                </div>
            ';
        } else if ($berhasil == 2) {
            echo '<div class="modal" id="aler" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body bg-success p-0">
                        <button type="button" onclick="refresh()" class="btn-close float-end m-2 focus" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-success d-flex pt-0 justify-content-center pb-4">
                        <h4 class="text-light">Add Product Berhasil</h4>
                    </div>
                    </div>
                </div>
                </div>
            ';
            header('Refresh: 3; url = admin.php');
            $_SESSION["index"] = 3;
        } else if ($berhasil == 3) {
            echo '<div class="modal" id="aler" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body bg-success p-0">
                        <button type="button" onclick="refresh()" class="btn-close float-end m-2 focus" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-success d-flex pt-0 justify-content-center pb-4">
                        <h4 class="text-light">Add Kategori Berhasil !</h4>
                    </div>
                    </div>
                </div>
                </div>
            ';
            header('Refresh: 3; url = admin.php');
            $_SESSION["index"] = 6;
        } else if ($berhasil==4) {
            echo '<div class="modal" id="aler" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body bg-success p-0">
                        <button type="button" onclick="refresh()" class="btn-close float-end m-2 focus" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-success d-flex pt-0 justify-content-center pb-4">
                        <h4 class="text-light">Add Discount Berhasil !</h4>
                    </div>
                    </div>
                </div>
                </div>
            ';
            header('Refresh: 3; url = admin.php');
            $_SESSION["index"] = 5;
        }
    }
    ?>
    <!--MODAL-->
    <div class="modal" id="delaler" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-danger p-0">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-danger d-flex pt-0 justify-content-center pb-4">
                    <h4 class="text-light">Deleted !</h4>
                </div>
            </div>
        </div>
    </div>
    <!--SIDEBAR -->
    <div class="row">
        <div class="col-3 bg-light d-flex flex-column align-items-center p-0 shadow" style="height: 100vh;">
            <a href=""><img src="asset/logo.png" class="klik mb-5" alt="" width="240px" height="120px"></a>
            <div class="tombol mt-xxl-5 py-2 d-flex justify-content-center" style="width: 99%;" onclick="update()" id="update">
                <h2>Update</h2>
            </div>
            <div class="tombol mt-2 py-2 d-flex justify-content-center" style="width: 99%;" onclick="history()" id="history">
                <h2>History</h2>
            </div>
            <div class="tombol mt-2 py-2 d-flex justify-content-center" style="width: 99%;" onclick="addKategori()" id="addKategori">
                <h2>Add Category</h2>
            </div>
            <div class="tombol mt-2 py-2 d-flex justify-content-center" style="width: 99%;" onclick="addProduct()" id="addProduct">
                <h2>Add Product</h2>
            </div>
            <div class="tombol mt-2 py-2 d-flex justify-content-center" style="width: 99%;" onclick="listProduct()" id="listProduct">
                <h2>List Product</h2>
            </div>
            <div class="tombol mt-2 py-2 d-flex justify-content-center" style="width: 99%;" onclick="addDiscount()" id="addDiscount">
                <h2>Add Discount</h2>
            </div>
            <div class="tombol mt-2 py-2 d-flex justify-content-center" style="width: 99%;" onclick="listDiscount()" id="listDiscount">
                <h2>List Discount</h2>
            </div>
            <div class="tombol bg-danger mt-2 py-2 d-flex justify-content-center" style="width: 99%;">
                <a href="index.php" style="text-decoration: none;">
                    <h2 class="text-white">Sign Out</h2>
                </a>
            </div>
        </div>
        <!--CONTENT -->
        <div class="col-9 p-0" id="box">
            
        </div>
    </div>
</body>

</html>
<script>
    function update() {
        //HIGHTLIGHT BUTTON DI SIDEBAR
        $("#update").addClass("bg-purple text-gold");
        $("#history").removeClass("bg-purple text-gold");
        $("#addKategori").removeClass("bg-purple text-gold");
        $("#addProduct").removeClass("bg-purple text-gold");
        $("#listProduct").removeClass("bg-purple text-gold");
        $("#addDiscount").removeClass("bg-purple text-gold");
        $("#listDiscount").removeClass("bg-purple text-gold");
    }

    function history() {
        //HIGHTLIGHT BUTTON DI SIDEBAR
        $("#update").removeClass("bg-purple text-gold");
        $("#history").addClass("bg-purple text-gold");
        $("#addKategori").removeClass("bg-purple text-gold");
        $("#addProduct").removeClass("bg-purple text-gold");
        $("#listProduct").removeClass("bg-purple text-gold");
        $("#addDiscount").removeClass("bg-purple text-gold");
        $("#listDiscount").removeClass("bg-purple text-gold");
    }

    function addKategori() {
        //HIGHTLIGHT BUTTON DI SIDEBAR
        $("#update").removeClass("bg-purple text-gold");
        $("#history").removeClass("bg-purple text-gold");
        $("#addKategori").addClass("bg-purple text-gold");
        $("#addProduct").removeClass("bg-purple text-gold");
        $("#listProduct").removeClass("bg-purple text-gold");
        $("#addDiscount").removeClass("bg-purple text-gold");
        $("#listDiscount").removeClass("bg-purple text-gold");
        $.post("kontroler.php", {
            action: "addKategori"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    function addProduct() {
        //HIGHTLIGHT BUTTON DI SIDEBAR
        $("#update").removeClass("bg-purple text-gold");
        $("#history").removeClass("bg-purple text-gold");
        $("#addKategori").removeClass("bg-purple text-gold");
        $("#addProduct").addClass("bg-purple text-gold");
        $("#listProduct").removeClass("bg-purple text-gold");
        $("#addDiscount").removeClass("bg-purple text-gold");
        $("#listDiscount").removeClass("bg-purple text-gold");
        $.post("kontroler.php", {
            action: "addProduct"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    function listProduct() {
        //HIGHTLIGHT BUTTON DI SIDEBAR
        $("#update").removeClass("bg-purple text-gold");
        $("#history").removeClass("bg-purple text-gold");
        $("#addKategori").removeClass("bg-purple text-gold");
        $("#addProduct").removeClass("bg-purple text-gold");
        $("#listProduct").addClass("bg-purple text-gold");
        $("#addDiscount").removeClass("bg-purple text-gold");
        $("#listDiscount").removeClass("bg-purple text-gold");
        $.post("kontroler.php", {
            action: "listProduct"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    //EDIT PRODUCT
    function editProduct(index) {
        $.post("kontroler.php", {
            action: "editProduct",
            id: index
        }, function(data, status) {
            $("#div" + index).html(data);
        });
    }

    //DELETE PRODUCT
    function deleteProduct(index) {
        $.post("kontroler.php", {
            action: "deleteProduct",
            id: index
        }, function(data, status) {
            $("#box").html(data);
            $("#delaler").modal("show");
        });
    }

    //SAVE EDIT PRODUCT
    function saveEditProduct(index) {
        var tempNama = $("#name" + index).val();
        var tempBrand = $("#brand" + index).val();
        var tempDesc = $("#desc" + index).val();
        var tempStock = $("#stock" + index).val();
        var tempPrice = $("#price" + index).val();
        $.post("kontroler.php", {
            action: "saveEditProduct",
            id: index,
            name: tempNama,
            brand: tempBrand,
            desc: tempDesc,
            stock: tempStock,
            price: tempPrice
        }, function(data, status) {
            $("#div" + index).html(data);
        });
    }

    function addDiscount() {
        //HIGHTLIGHT BUTTON DI SIDEBAR
        $("#update").removeClass("bg-purple text-gold");
        $("#history").removeClass("bg-purple text-gold");
        $("#addKategori").removeClass("bg-purple text-gold");
        $("#addProduct").removeClass("bg-purple text-gold");
        $("#listProduct").removeClass("bg-purple text-gold");
        $("#addDiscount").addClass("bg-purple text-gold");
        $("#listDiscount").removeClass("bg-purple text-gold");
        //SHOW ADD DISCOUNT MENU
        $.post("kontroler.php", {
            action: "addDiscount"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    function listDiscount() {
        //HIGHTLIGHT BUTTON DI SIDEBAR
        $("#update").removeClass("bg-purple text-gold");
        $("#history").removeClass("bg-purple text-gold");
        $("#addKategori").removeClass("bg-purple text-gold");
        $("#addProduct").removeClass("bg-purple text-gold");
        $("#listProduct").removeClass("bg-purple text-gold");
        $("#addDiscount").removeClass("bg-purple text-gold");
        $("#listDiscount").addClass("bg-purple text-gold");
        $.post("kontroler.php", {
            action: "listDiscount"
        }, function(data, status) {
            $("#box").html(data);
        });
    }

    //DELETE DISCOUNT
    function deleteDiscount(index) {
        $.post("kontroler.php", {
            action: "deleteDiscount",
            id: index
        }, function(data, status) {
            $("#box").html(data);
            $("#delaler").modal("show");
        });
    }
    
    //EDIT DISCOUNT
    function editDiscount(index) {
        $.post("kontroler.php", {
            action: "editDiscount",
            id: index
        }, function(data, status) {
            $("#div" + index).html(data);
        });
    }

    //SAVE EDIT DISCOUNT
    function saveEditDiscount(index) {
        var tempNama = $("#name" + index).val();
        var tempProduct = $("#product" + index).val();
        var tempValue = $("#value" + index).val();
        $.post("kontroler.php", {
            action: "saveEditDiscount",
            id: index,
            name: tempNama,
            product : tempProduct,
            value : tempValue
        }, function(data, status) {
            $("#div" + index).html(data);
        });
    }

    $(document).ready(function() {
        $("#aler").modal("show");
    });
</script>
<?php
//GO TO ADD PRODUCT MENU AFTER ADDING PRODUCT
if ($_SESSION["index"] == 3) {
?>
    <script>
        addProduct();
    </script>
<?php
//GO TO LIST PRODUCT MENU AFTER EDITING / DELETING
}else if($_SESSION["index"]==4){
?>
    <script>
        listProduct();
    </script>
<?php
//GO TO ADD DISCOUNT MENU AFTER ADDING DISCOUNT
} else if ($_SESSION["index"]==5) {
?>
    <script>
        addDiscount();
    </script>
<?php    
} else if ($_SESSION["index"]==6) {
?>
    <script>
        addKategori();
    </script>
<?php  
}
?>