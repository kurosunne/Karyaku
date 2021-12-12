<?php
require_once("koneksi.php");
$berhasil = 0;

if (isset($_SESSION["active"])) {
    if ($_SESSION["active"] != "admin") {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}

$queri = $koneksi->prepare("SELECT * from list_category");
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
            if (isset($_REQUEST["c" . ($key + 1)])) {
                //echo '<script>alert("A")</script>';
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
    if ($_REQUEST["name_category"] != "") {
        $query = $koneksi->prepare("INSERT INTO list_category (nama) VALUES (?)");
        $query->bind_param("s", $_REQUEST["name_category"]);
        $query->execute();

        $berhasil = 3; //BERHASIL ADD CATEGORY
    } else $berhasil = 1;
}

//ADD DISCOUNT ACTION
if (isset($_REQUEST["addDiscount"])) {
    $_SESSION["index"] = 5;
    if ($_REQUEST["productDisc"] != "" && $_REQUEST["disc_name"] != "" && $_REQUEST["disc_number"] != "") {
        $num = intval($_REQUEST["disc_number"]);

        if ($num < 1 && $num > 100) $berhasil = -1; //NILAI DISCOUNT INVALID
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

    $sink = $target_dir . ($all_product + 1) . "." . $ext;
    //echo '<script>alert("'.$sink.'")</script>';

    $source = $f["tmp_name"];

    $_SESSION["image"] = $sink;
    move_uploaded_file($source, $sink);
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


            move_uploaded_file($source, $sink);
            $upd = $koneksi->prepare("UPDATE list_product set image=? where product_id=?");
            $upd->bind_param("si", $sink, $value["product_id"]);
            $upd->execute();
            $_SESSION["index"] = 4;
            header("Location: admin.php");
        
    }
}

?>

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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

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
        } else if ($berhasil == -1) {
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
        } else if ($berhasil == 4) {
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
    <!--MODAL REJECT ORDER-->
    <div class="modal" id="rejaler" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-danger p-0">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-danger d-flex pt-0 justify-content-center pb-4">
                    <h4 class="text-light">Order Rejected !</h4>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL ACCEPT ORDER-->
    <div class="modal" id="accaler" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-success p-0">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-success d-flex pt-0 justify-content-center pb-4">
                    <h4 class="text-light">Order Accepted !</h4>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL PROBLEM ORDER-->
    <div class="modal" id="probaler" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-danger p-0">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-danger d-flex pt-0 justify-content-center pb-4">
                    <h4 class="text-light">Order Problem ! Stock Missing !</h4>
                </div>
            </div>
        </div>
    </div>
    <!--SIDEBAR -->
    <div class="row">
        <div class="col-3 bg-light d-flex flex-column align-items-center p-0 shadow" style="height: 100vh;">
            <a href=""><img src="asset/logo.png" class="klik mb-5" alt="" width="240px" height="120px"></a>
            <div class="tombol mt-xxl-5 py-2 d-flex justify-content-center bg-purple text-gold" style="width: 99%;" onclick="update()" id="update">
                <h2>Update</h2>
            </div>
            <div class="tombol mt-2 py-2 d-flex justify-content-center" style="width: 99%;" onclick="history()" id="history">
                <h2>Report</h2>
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
                <a href="kontroler.php?action=signOut" style="text-decoration: none;">
                    <h2 class="text-white">Sign Out</h2>
                </a>
            </div>
        </div>
        <!--CONTENT -->
        <div class="col-9 p-0" id="box">
            <?php
            $query = $koneksi->prepare("SELECT h.History_id, h.product_id, p.name as product_name, u.name as u_name, h.date, h.qty, h.order_info, p.stock from history h INNER JOIN list_product p ON p.product_id = h.product_id INNER JOIN list_user u ON u.users_id=h.user_id WHERE h.order_info ='menunggu konfirmasi' OR h.order_info = 'sedang dikirim' ");
            $query->execute();
            $listH = $query->get_result()->fetch_all(MYSQLI_ASSOC);

            // var_dump($listH);

            echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
        <h1 class="my-4">List Order</h1>
        <div style="height: 830px; width:90%; overflow:auto;">';
            foreach ($listH as $key => $value) {
                echo '<div class="my-4 row shadow ';
                if ($value["order_info"] == "menunggu konfirmasi") {
                    echo 'bg-gold';
                } else {
                    echo 'bg-success';
                }
                echo '" style="margin-left:auto; margin-right:auto; width:90%; height:180px; overflow:auto;">
                    <div class="col-12 ';
                if ($value["order_info"] == "sedang dikirim") {
                    echo 'text-light';
                }
                echo '"id="div' . $value["History_id"] . '">
                        <input type="hidden" id="quantity" name="qty_prod" value=' . $value["qty"] . '_' . $value["History_id"] . '>
                        <input type="hidden" id="product_id" name="prod_id" value=' . $value["product_id"] . '_' . $value["History_id"] . '>
                        <h4>Product :  ' . $value["product_name"] . '</h4>
                        <h4>User : ' . $value["u_name"] . '</h4>
                        <h4>Quantity : ' . $value["qty"] . ' piece(s)</h4>
                        <h4>Stock : ' . $value["stock"] . '</h4>
                        <h4>Date : ' . $value["date"] . '</h4>
                        <h4>Order Info : ' . $value["order_info"] . '</h4>';
                if ($value["order_info"] == "menunggu konfirmasi") {
                    echo '<button type="button" onclick="rejectOrder(' . $value["History_id"] . ')" class="btn btn-danger float-end mb-2 mx-3"> Reject </button>
                            <button type="button" onclick="acceptOrder(' . $value["History_id"] . ')" class="btn btn-success float-end mb-2"> Accept </button>';
                }
                echo '</div>
                </div>';
            }
            echo '</div>
    </div>';
            ?>
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
        $.post("kontroler.php", {
            action: "updateAdmin"
        }, function(data, status) {
            $("#box").html(data);
        });
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
        $.post("kontroler.php", {
            action: "report"
        }, function(data, status) {
            $("#box").html(data);
        });
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
            product: tempProduct,
            value: tempValue
        }, function(data, status) {
            $("#div" + index).html(data);
        });
    }

    //REJECT ORDER
    function rejectOrder(index) {
        $.post("kontroler.php", {
            action: "rejectOrder",
            id: index
        }, function(data, status) {
            $("#box").html(data);
            $("#rejaler").modal("show");
        });
    }

    //ACCEPT ORDER
    function acceptOrder(index) {
        $.post("kontroler.php", {
            action: "acceptOrder",
            id: index
        }, function(data, status, response) {
            if (data == "1") {
                $("#accaler").modal("show");
                update();
            } else if (data == "0") {
                $("#probaler").modal("show");
            }
        });
    }

    function tahun() {
        $.post("kontroler.php", {
            action: "tahun",
            thn: $("#tahun").val()
        }, function(data, status) {
            $("#chartt").html(data);
        });
    }
    
    //REPORT PRODUCT SALES
    function displayProduct() {
        // alert($("#d_month_product option:selected").val());
        if ($("#d_month_product option:selected").val()=="") {
            // alert("test");
            $.ajax({
                type: "post",
                url: "print.php",
                data: {
                    action: "product_sales"
                },
                success: function (response) {
                    $("#tb_pr_sal").html(response);
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "print.php",
                data: {
                    action: "product_sales",
                    month_product: $("#d_month_product option:selected").val()
                },
                success: function (response) {
                    $("#tb_pr_sal").html(response);
                }
            });
        }
    }

    //REPORT CATEGORY SALES
    function displayCategory() {
        if ($("#d_month_cat option:selected").val()=="") {
            $.ajax({
                type: "post",
                url: "print.php",
                data: {
                    action: "category_sales"
                },
                success: function (response) {
                    $("#tb_cat_sal").html(response);
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "print.php",
                data: {
                    action: "category_sales",
                    month_cat: $("#d_month_cat option:selected").val()
                },
                success: function (response) {
                    $("#tb_cat_sal").html(response);
                }
            });
        }
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
} else if ($_SESSION["index"] == 4) {
?>
    <script>
        listProduct();
    </script>
<?php
    //GO TO ADD DISCOUNT MENU AFTER ADDING DISCOUNT
} else if ($_SESSION["index"] == 5) {
?>
    <script>
        addDiscount();
    </script>
<?php
} else if ($_SESSION["index"] == 6) {
?>
    <script>
        addKategori();
    </script>
<?php
}
?>