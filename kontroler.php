<?php
require_once("koneksi.php");
//ERROR MESSAGE
error_reporting(-1);
ini_set("display_errors", "1");
ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

if (isset($_REQUEST["action"])) {
    //SIGN OUT
    if ($_REQUEST["action"] == "signOut") {
        unset($_SESSION["active"]);
        header("Location: index.php");
    }

    //MENU ADD KATEGORI
    if ($_REQUEST["action"] == "addKategori") {
        echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
            <h1 class="my-4">Add Category</h1>
            <div style="height: 500px; width:100%" class="row ms-4">
                <div class="col-11">
                    <form action="" method="post">
                        <input class="mt-4" type="text" placeholder="Category Name" style="border-radius: 5px; height:40px; width:100%;" name="name_category">
                        <button class="btn btn-primary mt-3" name="addC" style="height:40px; width:100%;">Add</button>
                    </form>
                </div>
            </div>
            </div>';
    }

    if ($_REQUEST["action"] == "report") {
        echo '<div class="d-flex flex-column align-items-center">
        <h1 class="my-4">Report</h1>
    </div>
    <div class="d-flex align-items-center">
        <p style="margin-left: 150px;">Tahun : </p><input id="tahun" onchange="tahun()" type="number" min="2021" value="2021" onKeyDown="return false" class="mb-3 ms-5">
    </div>';
        $data = array();
        for ($i = 1; $i <= 12; $i++) {
            $queri = $koneksi->prepare("SELECT  SUM(h.qty*lp.price) as 'total' from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.order_info='completed' and MONTH(h.date)=? and YEAR(h.date)=?");
            $tahun = 2021;
            $queri->bind_param("ii", $i, $tahun);
            $queri->execute();
            $temp = $queri->get_result()->fetch_row();
            if ($temp[0] == null) {
                $temp[0] = 0;
            }
            array_push($data, $temp);
        }
        echo '<div id="chartt"><script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {
                    role: "style"
                }],
                ["Januari", ' . $data[0][0] . ', "gold"],
                ["Februari", ' . $data[1][0] . ', "cyan"],
                ["Maret", ' . $data[2][0] . ', "gold"],
                ["April", ' . $data[3][0] . ', "cyan"],
                ["Mei", ' . $data[4][0] . ', "gold"],
                ["Juni", ' . $data[5][0] . ', "cyan"],
                ["Juli", ' . $data[6][0] . ', "gold"],
                ["Agustus", ' . $data[7][0] . ', "cyan"],
                ["September", ' . $data[8][0] . ', "gold"],
                ["Oktober", ' . $data[9][0] . ', "cyan"],
                ["November", ' . $data[10][0] . ', "gold"],
                ["Desember", ' . $data[11][0] . ', "cyan"]
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                title: "Report Total Penghasilan Kotor Sepanjang Tahun",
                width: 1500,
                height: 600,
                bar: {
                    groupWidth: "80%"
                },
                legend: {
                    position: "none"
                },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options);
        }
    </script>
    <div id="columnchart_values" style="width: 1500px; height: 600px;"></div></div>';
    echo "<div class='row'><h4 class='ml-3'>List of Product Sales</h4> </div>
        <div class='row'>
            <div class='col-5'>
                <input type='hidden' name='p_action' value='product_sales'>
                <select name='month_product' id='d_month_product'>
                    <option style='display:none' disabled selected value> -- Month -- </option>
                    <option value='1'>January</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select><br>
                <button class='btn btn-primary mt-3' name='btProduct' style='height:40px;' onclick='displayProduct()'>Print</button>
            </div>
        </div>
        <div class='row'>
            <div id='tb_pr_sal'></div>
        </div>
        <div class='row'>
            <div id='chart_pr_sal'></div>
        </div>
        ";
    echo "<div class='row'><h4 class='ml-3'>List of Category Sales</h4> </div>
        <div class='row'>
            <div class='col-5'>
                <input type='hidden' name='p_action' value='product_sales'>
                <select name='month_cat' id='d_month_cat'>
                    <option style='display:none' disabled selected value> -- Month -- </option>
                    <option value='1'>January</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select><br>
                <button class='btn btn-primary mt-3' name='btCategory' style='height:40px;' onclick='displayCategory()'>Print</button>
            </div>
        </div>
        <div class='row'>
            <div id='tb_cat_sal'></div>
        </div>
        <div class='row'>
            <div id='chart_cat_sal'></div>
        </div>
    ";
    }

    //Report Tahun
    if ($_REQUEST["action"] == "tahun") {
        $data = array();
        for ($i = 1; $i <= 12; $i++) {
            $queri = $koneksi->prepare("SELECT  SUM(h.qty*lp.price) as 'total' from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.order_info='completed' and MONTH(h.date)=? and YEAR(h.date)=?");
            $tahun = $_REQUEST["thn"];
            $queri->bind_param("ii", $i, $tahun);
            $queri->execute();
            $temp = $queri->get_result()->fetch_row();
            if ($temp[0] == null) {
                $temp[0] = 0;
            }
            array_push($data, $temp);
        }
        echo '<script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {
                    role: "style"
                }],
                ["Januari", ' . $data[0][0] . ', "gold"],
                ["Februari", ' . $data[1][0] . ', "cyan"],
                ["Maret", ' . $data[2][0] . ', "gold"],
                ["April", ' . $data[3][0] . ', "cyan"],
                ["Mei", ' . $data[4][0] . ', "gold"],
                ["Juni", ' . $data[5][0] . ', "cyan"],
                ["Juli", ' . $data[6][0] . ', "gold"],
                ["Agustus", ' . $data[7][0] . ', "cyan"],
                ["September", ' . $data[8][0] . ', "gold"],
                ["Oktober", ' . $data[9][0] . ', "cyan"],
                ["November", ' . $data[10][0] . ', "gold"],
                ["Desember", ' . $data[11][0] . ', "cyan"]
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                title: "Report Total Penghasilan Kotor Sepanjang Tahun",
                width: 1500,
                height: 600,
                bar: {
                    groupWidth: "80%"
                },
                legend: {
                    position: "none"
                },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options);
        }
    </script>
    <div id="columnchart_values" style="width: 1500px; height: 600px;"></div>';
    }

    //MENU ADD PRODUCT
    if ($_REQUEST["action"] == "addProduct") {
        $queri = $koneksi->prepare("select * from list_category");
        $queri->execute();
        $hasil = $queri->get_result()->fetch_all(MYSQLI_ASSOC);
        echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
            <h1 class="my-4">Add Product</h1>
            <div style="height: 500px; width:100%" class="row">
                <div class="col-4">
                    <img src="' . $_SESSION["image"] . '" alt="" style="width: 90%;" class="mt-5 mx-5 shadow" style="border-radius: 10px;">
                    <form class="mx-5" action="" method="post" enctype="multipart/form-data">
                        Pilih File: <input type="file" name="fileup" id=""><br>
                        <input type="submit" value="Upload" name="btUpload">
                    </form>
                </div>
                <div class="col-8">
                    <div class="d-flex flex-column mt-5" style="width:100%;">
                        <form action="" method="POST">
                            <input class="mt-4" type="text" placeholder="Product Name" style="border-radius: 5px; height:40px; width:85%;" name="name">
                            <input class="mt-4" type="text" placeholder="Product Brand" style="border-radius: 5px; height:40px; width:85%;" name="brand">
                            <textarea class="mt-4" type="textbox" placeholder="Product Description" style="border-radius: 5px; width:85%; border:2px solid black;" rows="5" name="desc"></textarea>
                            <input class="mt-4" type="number" placeholder="Product Stock" style="border-radius: 5px; height:40px; width:85%;" name="stock">
                            <input class="mt-4" type="number" placeholder="Product Price" style="border-radius: 5px; height:40px; width:85%;" name="price">
                            <h4>Categories : </h4>
                            <div class="d-flex flex-wrap">';
        foreach ($hasil as $key => $value) {
            echo '<input type="checkbox" class="mt-1 me-1" name="c' . ($key + 1) . '"><label class="me-3 mt-0">' . $value["nama"] . '</label>';
        }
        echo    '</div>
                            <button class="btn btn-primary mt-3" name="btAdd" style="height:40px; width:85%;">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }

    //MENU EDIT PRODUCT
    if ($_REQUEST["action"] == "editProduct") {
        $id = $_REQUEST["id"];
        $data = $koneksi->prepare("SELECT * from list_product where product_id=?");
        $data->bind_param("i", $id);
        $data->execute();
        $dataGet = $data->get_result()->fetch_assoc();
        echo '<input class="mt-4" type="text" placeholder="Product Name" id="name' . $id . '" value="' . $dataGet["name"] . '" style="border-radius: 5px; height:40px; width:85%;" name="name">
        <input class="mt-4" type="text" placeholder="Product Brand" value="' . $dataGet["brand_name"] . '" id="brand' . $id . '" style="border-radius: 5px; height:40px; width:85%;" name="brand">
        <textarea class="mt-4" type="textbox" placeholder="Product Description"  id="desc' . $id . '" style="border-radius: 5px; width:85%; border:2px solid black;" rows="5" name="desc">' . $dataGet["description"] . '</textarea>
        <input class="mt-4" type="number" placeholder="Product Stock" value="' . $dataGet["stock"] . '" id="stock' . $id . '" style="border-radius: 5px; height:40px; width:85%;" name="stock">
        <input class="mt-4" type="number" placeholder="Product Price" value="' . $dataGet["price"] . '" id="price' . $id . '" style="border-radius: 5px; height:40px; width:85%;" name="price"> <br>
        <button type="button" class="btn btn-primary my-3 float-end" onclick="saveEditProduct(' . $id . ')">Apply</button>';
    }

    //MENU ADD DISCOUNT
    if ($_REQUEST["action"] == "addDiscount") {
        $query = $koneksi->prepare("SELECT * from list_product");
        $query->execute();
        $listP = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
            <h1 class="my-4">Add Discount</h1>
            <div style="height: 500px; width:100%" class="row ms-4">
                <div class="col-11">
                    <form action="" method="post">
                        <select class="form-select" id="product_list" name="productDisc">';
        foreach ($listP as $key => $value) {
            echo '<option value="' . $value["product_id"] . '">' . $value["name"] . '</option>';
        }
        echo            '</select>
                        <input class="mt-4" type="name" placeholder="Discount Name" style="border-radius: 5px; height:40px; width:100%;" name="disc_name">
                        <input class="mt-4" type="number" placeholder="Discount Percentage" style="border-radius: 5px; height:40px; width:100%;" name="disc_number">
                        <button class="btn btn-primary mt-3" name="addDiscount" style="height:40px; width:100%;">Add</button>
                    </form>
                </div>
            </div>
            </div>';
    }

    //MENU LIST DISCOUNT
    if ($_REQUEST["action"] == "listDiscount") {
        $_SESSION["index"] = 1;
        $query = $koneksi->prepare("SELECT d.discount_id, d.discount_name, d.discount_value, p.name from discount d INNER JOIN list_product p ON p.product_id = d.product_id");
        $query->execute();
        $listD = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
        <h1 class="my-4">List Product</h1>
        <div style="height: 830px; width:90%; overflow:auto;">';
        foreach ($listD as $key => $value) {
            echo '<div class="my-4 row shadow" style="margin-left:auto; margin-right:auto; width:90%; height:180px; overflow:auto;">
                    <div class="col-12" id="div' . $value["discount_id"] . '">
                        <h4>Name :  ' . $value["discount_name"] . '</h4>
                        <h4>Product : ' . $value["name"] . '</h4>
                        <h4>Discount: ' . $value["discount_value"] . '%</h4>
                        <button type="button" onclick="deleteDiscount(' . $value["discount_id"] . ')" class="btn btn-danger float-end mb-2 mx-3"> Delete </button>
                        <button type="button" onclick="editDiscount(' . $value["discount_id"] . ')" class="btn btn-secondary float-end mb-2"> Edit </button>
                    </div>
                </div>';
        }
        echo '</div>
    </div>';
    }

    //MENU DELETE DISCOUNT
    if ($_REQUEST["action"] == "deleteDiscount") {
        $delete = $koneksi->prepare("DELETE from discount where discount_id=?");
        $delete->bind_param("i", $_REQUEST["id"]);
        $delete->execute();

        $queryy = $koneksi->prepare("SELECT * from discount");
        $queryy->execute();
        $listD = $queryy->get_result()->fetch_all(MYSQLI_ASSOC);

        echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
        <h1 class="my-4">List Product</h1>
        <div style="height: 830px; width:90%; overflow:auto;">';
        foreach ($listD as $key => $value) {
            echo '<div class="my-4 row shadow" style="margin-left:auto; margin-right:auto; width:90%; height:180px; overflow:auto;">
                    <div class="col-12" id="div' . $value["discount_id"] . '">
                        <h4>Name :  ' . $value["discount_name"] . '</h4>
                        <h4>Product : ' . $value["name"] . '</h4>
                        <h4>Discount: ' . $value["discount_value"] . '%</h4>
                        <button type="button" onclick="deleteDiscount(' . $value["discount_id"] . ')" class="btn btn-danger float-end mb-2 mx-3"> Delete </button>
                        <button type="button" onclick="editDiscount(' . $value["discount_id"] . ')" class="btn btn-secondary float-end mb-2"> Edit </button>
                    </div>
                </div>';
        }
        echo '</div>
    </div>';
    }

    //MENU EDIT DISCOUNT
    if ($_REQUEST["action"] == "editDiscount") {
        $id = $_REQUEST["id"];
        $data = $koneksi->prepare("SELECT d.discount_name, d.discount_value, p.name from discount d, list_product p where d.discount_id=? AND p.product_id = d.product_id");
        $data->bind_param("i", $id);
        $data->execute();
        $dataGet = $data->get_result()->fetch_assoc();
        echo '<input class="mt-4" type="text" placeholder="Discount Name" id="name' . $id . '" value="' . $dataGet["discount_name"] . '" style="border-radius: 5px; height:40px; width:85%;" name="name">
        <input class="mt-4" disabled type="text" placeholder="Product Name" value="' . $dataGet["name"] . '" id="product' . $id . '" style="border-radius: 5px; height:40px; width:85%;" name="product">
        <input class="mt-4" type="number" placeholder="Discount Value" value="' . $dataGet["discount_value"] . '" id="value' . $id . '" style="border-radius: 5px; height:40px; width:85%;" name="value"> <br>
        <button type="button" class="btn btn-primary my-3 float-end" onclick="saveEditDiscount(' . $id . ')">Apply</button>';
    }

    //EDIT DISCOUNT ACTION & RESULT
    if ($_REQUEST["action"] == "saveEditDiscount") {
        $id = $_REQUEST["id"];
        $name = $_REQUEST["name"];
        $value = $_REQUEST["value"];
        $product = $_REQUEST["product"];

        $update = $koneksi->prepare("UPDATE discount set discount_name=?, discount_value=?  where discount_id=?");
        $update->bind_param("sii", $name, $value, $id);
        $update->execute();

        $select = $koneksi->prepare("SELECT * from discount where discount_id=?");
        $select->bind_param("i", $id);
        $select->execute();
        $value = $select->get_result()->fetch_assoc();

        echo '<h4>Discount Name : ' . $value["discount_name"] . '</h4>
        <h4 style="white-space: pre-line">Product :' . $product . '</h4>
        <h4>Discount Value : ' . $value["discount_value"] . '</h4>
        <button type="button" class="btn btn-danger float-end mb-2 mx-3"> Delete </button>
        <button type="button" onclick="editProduct(' . $value["product_id"] . ')" class="btn btn-secondary float-end mb-2"> Edit </button>';
    }

    //EDIT PRODUCT ACTION & RESULT
    if ($_REQUEST["action"] == "saveEditProduct") {
        $id = $_REQUEST["id"];
        $name = $_REQUEST["name"];
        $brand = $_REQUEST["brand"];
        $desc = $_REQUEST["desc"];
        $stock = $_REQUEST["stock"];
        $price = $_REQUEST["price"];

        $update = $koneksi->prepare("UPDATE list_product set name=?, price=?, stock=?, description=?, brand_name=? where product_id=?");
        $update->bind_param("siissi", $name, $price, $stock, $desc, $brand, $id);
        $update->execute();

        $select = $koneksi->prepare("SELECT * from list_product where product_id=?");
        $select->bind_param("i", $id);
        $select->execute();
        $value = $select->get_result()->fetch_assoc();
        echo '<h4>Name : ' . $value["name"] . '</h4>
        <h4 style="white-space: pre-line">Desc :' . $value["description"] . '</h4>
        <h4>Stock : ' . $value["stock"] . '</h4>
        <h4>Price : Rp . ' . number_format($value["price"], 2, ',', '.') . '</h4>
        <button type="button" class="btn btn-danger float-end mb-2 mx-3"> Delete </button>
        <button type="button" onclick="editProduct(' . $value["product_id"] . ')" class="btn btn-secondary float-end mb-2"> Edit </button>';
    }

    //MENU LIST PRODUCT
    if ($_REQUEST["action"] == "listProduct") {
        $_SESSION["index"] = 1;
        $queryy = $koneksi->prepare("SELECT * from list_product");
        $queryy->execute();
        $listP = $queryy->get_result()->fetch_all(MYSQLI_ASSOC);

        echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
        <h1 class="my-4">List Product</h1>
        <div style="height: 830px; width:90%; overflow:auto;">';
        foreach ($listP as $key => $value) {
            echo '<div class="my-4 row shadow" style="margin-left:auto; margin-right:auto; width:90%; height:270px; overflow:auto;">
                    <div class="col-3 d-flex flex-column align-items-center" style="height: 100%;">
                        <img src="' . $value["image"] . '" alt="" width="200px" height="200px" class="mt-1 shadow">
                        <form class="" action="" method="post" enctype="multipart/form-data" style="width: 200px;">
                            <input type="file" name="fileup' . $value["product_id"] . '" id=""> <br>
                            <input type="submit" value="Upload" name="btUpload' . $value["product_id"] . '">
                        </form>
                    </div>
                    <div class="col-9" id="div' . $value["product_id"] . '">
                        <h4>Name :  ' . $value["name"] . '</h4>
                        <h4 style="white-space: pre-line">Desc : ' . $value["description"] . '</h4>
                        <h4>Stock : ' . $value["stock"] . '</h4>
                        <h4>Price : Rp . ' . number_format($value["price"], 2, ',', '.') . '</h4>
                        <button type="button" onclick="deleteProduct(' . $value["product_id"] . ')" class="btn btn-danger float-end mb-2 mx-3"> Delete </button>
                        <button type="button" onclick="editProduct(' . $value["product_id"] . ')" class="btn btn-secondary float-end mb-2"> Edit </button>
                    </div>
                </div>';
        }
        echo '</div>
    </div>';
    }

    //DELETE PRODUCT ACTION & RESULT
    if ($_REQUEST["action"] == "deleteProduct") {
        $delete = $koneksi->prepare("DELETE from list_product where product_id=?");
        $delete->bind_param("i", $_REQUEST["id"]);
        $delete->execute();

        $delete2 = $koneksi->prepare("DELETE from product_category where product_id=?");
        $delete2->bind_param("i", $_REQUEST["id"]);
        $delete2->execute();

        $queryy = $koneksi->prepare("SELECT * from list_product");
        $queryy->execute();
        $listP = $queryy->get_result()->fetch_all(MYSQLI_ASSOC);

        echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
        <h1 class="my-4">List Product</h1>
        <div style="height: 830px; width:90%; overflow:auto;">';
        foreach ($listP as $key => $value) {
            echo '<div class="my-4 row shadow" style="margin-left:auto; margin-right:auto; width:90%; height:270px; overflow:auto;">
                    <div class="col-3 d-flex flex-column align-items-center" style="height: 100%;">
                        <img src="' . $value["image"] . '" alt="" width="200px" height="200px" class="mt-1 shadow">
                        <form class="" action="" method="post" enctype="multipart/form-data" style="width: 200px;">
                            <input type="file" name="fileup' . $value["product_id"] . '" id=""> <br>
                            <input type="submit" value="Upload" name="btUpload' . $value["product_id"] . '">
                        </form>
                    </div>
                    <div class="col-9" id="div' . $value["product_id"] . '">
                        <h4>Name : ' . $value["name"] . '</h4>
                        <h4 style="white-space: pre-line">Desc : ' . $value["description"] . '</h4>
                        <h4>Stock : ' . $value["stock"] . '</h4>
                        <h4>Price : Rp . ' . number_format($value["price"], 2, ',', '.') . '</h4>
                        <button type="button" onclick="deleteProduct(' . $value["product_id"] . ')" class="btn btn-danger float-end mb-2 mx-3"> Delete </button>
                        <button type="button" onclick="editProduct(' . $value["product_id"] . ')" class="btn btn-secondary float-end mb-2"> Edit </button>
                    </div>
                </div>';
        }
        echo '</div>
    </div>';
    }

    //MENU UPDATE ADMIN
    if ($_REQUEST["action"] == "updateAdmin") {
        // $_SESSION["index"] = 1;
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
    }

    //REJECT ORDER
    if ($_REQUEST["action"] == "rejectOrder") {
        $id = $_REQUEST["id"];
        $name = "Gagal";

        $update = $koneksi->prepare("UPDATE history set order_info=? where History_id=?");
        $update->bind_param("si", $name, $id);
        $update->execute();

        $query = $koneksi->prepare("SELECT h.History_id, h.product_id, p.name as product_name, u.name as u_name, h.date, h.qty, h.order_info from history h INNER JOIN list_product p ON p.product_id = h.product_id INNER JOIN list_user u ON u.users_id=h.user_id WHERE h.order_info ='menunggu konfirmasi' OR h.order_info = 'sedang dikirim' ");
        $query->execute();
        $listH = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        echo '<div style="width: 100%; height:100%;" class="d-flex flex-column align-items-center">
        <h1 class="my-4">List Order</h1>
        <div style="height: 830px; width:90%; overflow:auto;">';
        foreach ($listH as $key => $value) {
            echo '<div class="my-4 row shadow" style="margin-left:auto; margin-right:auto; width:90%; height:180px; overflow:auto;">
                    <div class="col-12" id="div' . $value["History_id"] . '">
                    <input type="hidden" id="quantity" name="qty_prod" value=' . $value["qty"] . '_' . $value["History_id"] . '>
                    <input type="hidden" id="product_id" name="prod_id" value=' . $value["product_id"] . '_' . $value["History_id"] . '>
                        <h4>Product :  ' . $value["product_name"] . '</h4>
                        <h4>User : ' . $value["u_name"] . '</h4>
                        <h4>Quantity : ' . $value["qty"] . ' piece(s)</h4>
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
    }

    //ACCEPT ORDER
    if ($_REQUEST["action"] == "acceptOrder") {
        $id = $_REQUEST["id"];

        $query = $koneksi->prepare("SELECT * FROM history WHERE History_id = ? ");
        $query->bind_param("i", $id);
        $query->execute();
        $listH = $query->get_result()->fetch_row();

        // var_dump($listH);

        $qty = $listH[4];
        $product_id = $listH[1];

        $query = $koneksi->prepare("SELECT * FROM list_product WHERE product_id = ? ");
        $query->bind_param("i", $product_id);
        $query->execute();
        $listP = $query->get_result()->fetch_row();

        // var_dump($listP);

        $stock = $listP[3];

        // var_dump($qty);
        // var_dump($stock);

        if ($qty > $stock) {
            //PROBLEM WITH STOCK
            echo "0";
        } else {
            //ORDER ACCEPTED
            echo "1";

            $update = $koneksi->prepare("UPDATE list_product set stock = stock - ? where product_id=?");
            $update->bind_param("ii", $qty, $product_id);
            $update->execute();

            $name = "sedang dikirim";
            $update = $koneksi->prepare("UPDATE history set order_info=? where History_id=?");
            $update->bind_param("si", $name, $id);
            $update->execute();
        }
    }

    if ($_REQUEST["action"] == "append") {
        $sub = $_REQUEST["price"] * $_REQUEST["qty"];
        echo "Rp. " . number_format($sub, 2, ',', '.');
    }

    //ADD WISHLIST
    if ($_REQUEST["action"] == "addWishlist") {
        $item = $_REQUEST["item"];

        $cek = $koneksi->prepare("SELECT * from wishlist where product_id=? and user_id=?");
        $cek->bind_param("ii", $item, $_SESSION["active"]["users_id"]);
        $cek->execute();
        $res = $cek->get_result()->fetch_all(MYSQLI_ASSOC);

        if (count($res) == 0) {
            $add = $koneksi->prepare("INSERT into wishlist(product_id,user_id) values(?,?)");
            $add->bind_param("ii", $item, $_SESSION["active"]["users_id"]);
            $add->execute();
        }
    }

    //REMOVE FROM WISHLIST
    if ($_REQUEST["action"] == "removeWishlist") {
        $item = $_REQUEST["item"];

        $cek = $koneksi->prepare("DELETE from wishlist where product_id=? and user_id=?");
        $cek->bind_param("ii", $item, $_SESSION["active"]["users_id"]);
        $cek->execute();

        $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating' FROM list_product lp, wishlist w where lp.product_id=w.product_id and w.user_id=? order by rating desc");
        $query->bind_param("i", $_SESSION["active"]["users_id"]);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($hasil as $key => $value) {
            echo '<div class=" col-xxl-3 col-xl-4 col-lg-6 mb-xl-0 mb-xxl-0 mb-md-5">
                    <a href="detail.php?id=' . $value["product_id"] . '&nama=' . $value["name"] . '" style="klik text-decoration:none; color:black;">
                        <div style="width: 90%; height:90%" class="shadow d-flex flex-column">
                            <img src="' . $value["image"] . '" alt="" width="100%">
                            <div style="height: 100px;" class="mt-0 mb-2">
                                <p class="my-0 ms-1">' . $value["name"], '</p>
                            </div>
                            <div>
                                <img class="float-start ms-2" src="asset/Misc/star.png" alt="" height="25px">
                                <p class="float-start mx-2">' . $value["rating"] . '/5</p>
                                <p class="float-end mx-2">Rp. ' . number_format($value["price"], 2, ',', '.') . '</p>
                            </div>
                        </div>
                    </a>
                    <button class="btn btn-danger mt-3" onclick="removeWishlist(' . $value["product_id"] . ')" style="width: 90%;">Remove</button>
                </div>';
        }
    }

    //ADD CART
    if ($_REQUEST["action"] == "addCart") {
        $item = $_REQUEST["item"];
        $qty = $_REQUEST["quantity"];

        $cek = $koneksi->prepare("SELECT * from cart where product_id=? and user_id=?");
        $cek->bind_param("ii", $item, $_SESSION["active"]["users_id"]);
        $cek->execute();
        $res = $cek->get_result()->fetch_all(MYSQLI_ASSOC);

        if (count($res) == 0) {
            $add = $koneksi->prepare("INSERT into cart(product_id,user_id,qty) values(?,?,?)");
            $add->bind_param("iii", $item, $_SESSION["active"]["users_id"], $qty);
            $add->execute();
        } else {
            $add = $koneksi->prepare("UPDATE cart SET qty = qty + ? WHERE product_id = ? AND user_id = ?");
            $add->bind_param("iii", $qty, $item, $_SESSION["active"]["users_id"]);
            $add->execute();
        }
    }

    //REMOVE FROM CART
    if ($_REQUEST["action"] == "removeCart") {
        $item = $_REQUEST["item"];

        $cek = $koneksi->prepare("DELETE from cart where product_id=? and user_id=?");
        $cek->bind_param("ii", $item, $_SESSION["active"]["users_id"]);
        $cek->execute();

        $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating', c.* FROM list_product lp, cart c where lp.product_id=c.product_id and c.user_id=? order by rating desc");
        $query->bind_param("i", $_SESSION["active"]["users_id"]);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($hasil as $key => $value) {
            echo '<div class=" col-xxl-3 col-xl-4 col-lg-6 mb-xl-0 mb-xxl-0 mb-md-5">
                    <a href="detail.php?id=' . $value["product_id"] . '&nama=' . $value["name"] . ' style="klik text-decoration:none; color:black;">
                    <div style="width: 90%; height:90%" class="shadow d-flex flex-column">
                        <img src="' . $value["image"] . '" alt="" width="100%">
                        <div style="height: 50px;" class="mt-0 mb-2">
                            <p class="my-0 ms-1">' . $value["name"] . '</p>
                        </div>
                        <div class="mt-0 mb-0">
                            <p class="float-start ms-2">' . $value["qty"] . '</p>
                        </div>
                        <div>
                            <img class="float-start ms-2" src="asset/Misc/star.png" alt="" height="25px">
                            <p class="float-start mx-2">' . $value["rating"] . '/5</p>
                            <p class="float-end mx-2">Rp.' . number_format($value["price"], 2, ',', '.') . '</p>
                        </div>
                    </div>
                </a>
                <button class="btn btn-danger mt-3" onclick="removeCart(' . $value['product_id'] . ')" style="width: 90%;">Remove</button>
            </div>';
        }
    }

    if ($_REQUEST["action"] == "cartChange") {
        $item = $_REQUEST["item"];
        $qty = $_REQUEST["qty"];

        $quey = $koneksi->prepare("UPDATE cart set qty=? where cart_id=?");
        $quey->bind_param("ii", $qty, $item);
        $quey->execute();

        $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating', c.* FROM list_product lp, cart c where lp.product_id=c.product_id and c.user_id=? order by rating desc");
        $query->bind_param("i", $_SESSION["active"]["users_id"]);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $amount = 0;
        $item_details = array();

        foreach ($hasil as $key => $value) {
            $diskon = $koneksi->prepare("SELECT * from discount where product_id=?");
            $diskon->bind_param("i", $value["product_id"]);
            $diskon->execute();
            $resdiskon = $diskon->get_result()->fetch_all(MYSQLI_ASSOC);
            if (count($resdiskon) > 0) {
                $tempHarga = $value["price"] - ($resdiskon[0]["discount_value"] / 100 * $value["price"]);
                $amount += $tempHarga * $value["qty"];
            } else {
                $amount += $value["price"] * $value["qty"];
            }
            $teeeemp = 0;
            if (count($resdiskon) > 0) {
                $tempHarga = $value["price"] - ($resdiskon[0]["discount_value"] / 100 * $value["price"]);
                $teeeemp = $tempHarga;
            } else {
                $teeeemp = $value['price'];
            }
            $item1_details = array(
                'id' => $value["product_id"],
                'price' => $teeeemp,
                'quantity' => $value['qty'],
                'name' => $value["name"]
            );
            array_push($item_details, $item1_details);
        }
        $arr = array(
            "amount" => $amount,
            "data" => $item_details
        );
        echo json_encode($arr);
    }

    if ($_REQUEST["action"] == "allList") {
        $query = $koneksi->prepare("SELECT *, (h.qty*lp.price) as 'total', lp.name as namaProduk from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.user_id=? order by h.History_id desc");
        $query->bind_param("i", $_SESSION["active"]["users_id"]);
        $query->execute();
        $data = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($data as $key => $value) {
            echo '<div style="width: 100%;" class="shadow p-2 row my-2">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <img src="' . $value["image"] . '" class="shadow " width="100%" alt="">
                    </div>
                    <div class="col-xxl-10 col-md-9 col-xxs-8" >
                        <p class="mx-2 mb-0">' . $value["namaProduk"] . '</p>
                        <p class="mx-2 mb-0">Quantity : ' . $value["qty"] . '</p>
                        <p class="mx-2 mb-0">Price : ' . number_format($value["price"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0">Total : ' . number_format($value["total"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0" style="color: ';
            if ($value["order_info"] == "completed") {
                echo "green";
            } else if ($value["order_info"] == "sedang dikirim") {
                echo "blue";
            } else if ($value["order_info"] == "menunggu konfirmasi") {
                echo "#FDB827";
            } else {
                echo "red";
            }
            echo '">Order Info : ' . $value["order_info"] . '</p>
                    </div>';

            if ($value["order_info"] == "completed" && $value["rate"] == 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="review.php?id=' . $value["History_id"] . '"><button class="btn btn-primary">Review</button></a></div>';
            }
            if ($value["order_info"] == "completed"  && $value["rate"] != 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="#"><button class="btn btn-secondary">Reviewed</button></a></div>';
            }
            if ($value["order_info"] == "sedang dikirim") {
                echo '<div class="col-1"><div style="height:70%;"></div><button onclick="selesai(' . $value["History_id"] . ')" class="btn btn-success">Selesai</button></div>';
            }
            echo '</div>';
        }
    }

    if ($_REQUEST["action"] == "menunggu") {
        $query = $koneksi->prepare("SELECT *, (h.qty*lp.price) as 'total', lp.name as namaProduk from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.user_id=? and h.order_info=? order by h.History_id desc");
        $stat = "menunggu konfirmasi";
        $query->bind_param("is", $_SESSION["active"]["users_id"], $stat);
        $query->execute();
        $data = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($data as $key => $value) {
            echo '<div style="width: 100%;" class="shadow p-2 row my-2">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <img src="' . $value["image"] . '" class="shadow " width="100%" alt="">
                    </div>
                    <div class="col-xxl-10 col-md-9 col-xxs-8" >
                        <p class="mx-2 mb-0">' . $value["namaProduk"] . '</p>
                        <p class="mx-2 mb-0">Quantity : ' . $value["qty"] . '</p>
                        <p class="mx-2 mb-0">Price : ' . number_format($value["price"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0">Total : ' . number_format($value["total"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0" style="color: ';
            if ($value["order_info"] == "completed") {
                echo "green";
            } else if ($value["order_info"] == "sedang dikirim") {
                echo "blue";
            } else if ($value["order_info"] == "menunggu konfirmasi") {
                echo "#FDB827";
            } else {
                echo "red";
            }
            echo '">Order Info : ' . $value["order_info"] . '</p>
                    </div>';

            if ($value["order_info"] == "completed"  && $value["rate"] == 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="review.php?id=' . $value["History_id"] . '"><button class="btn btn-primary">Review</button></a></div>';
            }
            if ($value["order_info"] == "completed"  && $value["rate"] != 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="#"><button class="btn btn-secondary">Reviewed</button></a></div>';
            }
            if ($value["order_info"] == "sedang dikirim") {
                echo '<div class="col-1"><div style="height:70%;"></div><button onclick="selesai(' . $value["History_id"] . ')" class="btn btn-success">Selesai</button></div>';
            }
            echo '</div>';
        }
    }

    if ($_REQUEST["action"] == "dikirim") {
        $query = $koneksi->prepare("SELECT *, (h.qty*lp.price) as 'total', lp.name as namaProduk from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.user_id=? and h.order_info=? order by h.History_id desc");
        $stat = "sedang dikirim";
        $query->bind_param("is", $_SESSION["active"]["users_id"], $stat);
        $query->execute();
        $data = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($data as $key => $value) {
            echo '<div style="width: 100%;" class="shadow p-2 row my-2">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <img src="' . $value["image"] . '" class="shadow " width="100%" alt="">
                    </div>
                    <div class="col-xxl-10 col-md-9 col-xxs-8" >
                        <p class="mx-2 mb-0">' . $value["namaProduk"] . '</p>
                        <p class="mx-2 mb-0">Quantity : ' . $value["qty"] . '</p>
                        <p class="mx-2 mb-0">Price : ' . number_format($value["price"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0">Total : ' . number_format($value["total"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0" style="color: ';
            if ($value["order_info"] == "completed") {
                echo "green";
            } else if ($value["order_info"] == "sedang dikirim") {
                echo "blue";
            } else if ($value["order_info"] == "menunggu konfirmasi") {
                echo "#FDB827";
            } else {
                echo "red";
            }
            echo '">Order Info : ' . $value["order_info"] . '</p>
                    </div>';

            if ($value["order_info"] == "completed"  && $value["rate"] == 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="review.php?id=' . $value["History_id"] . '"><button class="btn btn-primary">Review</button></a></div>';
            }
            if ($value["order_info"] == "completed"  && $value["rate"] != 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="#"><button class="btn btn-secondary">Reviewed</button></a></div>';
            }
            if ($value["order_info"] == "sedang dikirim") {
                echo '<div class="col-1"><div style="height:70%;"></div><button onclick="selesai(' . $value["History_id"] . ')" class="btn btn-success">Selesai</button></div>';
            }
            echo '</div>';
        }
    }

    if ($_REQUEST["action"] == "completed") {
        $query = $koneksi->prepare("SELECT *, (h.qty*lp.price) as 'total', lp.name as namaProduk from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.user_id=? and h.order_info=? order by h.History_id desc");
        $stat = "completed";
        $query->bind_param("is", $_SESSION["active"]["users_id"], $stat);
        $query->execute();
        $data = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($data as $key => $value) {
            echo '<div style="width: 100%;" class="shadow p-2 row my-2">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <img src="' . $value["image"] . '" class="shadow " width="100%" alt="">
                    </div>
                    <div class="col-xxl-10 col-md-9 col-xxs-8" >
                        <p class="mx-2 mb-0">' . $value["namaProduk"] . '</p>
                        <p class="mx-2 mb-0">Quantity : ' . $value["qty"] . '</p>
                        <p class="mx-2 mb-0">Price : ' . number_format($value["price"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0">Total : ' . number_format($value["total"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0" style="color: ';
            if ($value["order_info"] == "completed") {
                echo "green";
            } else if ($value["order_info"] == "sedang dikirim") {
                echo "blue";
            } else if ($value["order_info"] == "menunggu konfirmasi") {
                echo "#FDB827";
            } else {
                echo "red";
            }
            echo '">Order Info : ' . $value["order_info"] . '</p>
                    </div>';

            if ($value["order_info"] == "completed"  && $value["rate"] == 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="review.php?id=' . $value["History_id"] . '"><button class="btn btn-primary">Review</button></a></div>';
            }
            if ($value["order_info"] == "completed"  && $value["rate"] != 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="#"><button class="btn btn-secondary">Reviewed</button></a></div>';
            }
            if ($value["order_info"] == "sedang dikirim") {
                echo '<div class="col-1"><div style="height:70%;"></div><button onclick="selesai(' . $value["History_id"] . ')" class="btn btn-success">Selesai</button></div>';
            }
            echo '</div>';
        }
    }

    if ($_REQUEST["action"] == "gagal") {
        $query = $koneksi->prepare("SELECT *, (h.qty*lp.price) as 'total', lp.name as namaProduk from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.user_id=? and h.order_info=? order by h.History_id desc");
        $stat = "gagal";
        $query->bind_param("is", $_SESSION["active"]["users_id"], $stat);
        $query->execute();
        $data = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($data as $key => $value) {
            echo '<div style="width: 100%;" class="shadow p-2 row my-2">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <img src="' . $value["image"] . '" class="shadow " width="100%" alt="">
                    </div>
                    <div class="col-xxl-10 col-md-9 col-xxs-8" >
                        <p class="mx-2 mb-0">' . $value["namaProduk"] . '</p>
                        <p class="mx-2 mb-0">Quantity : ' . $value["qty"] . '</p>
                        <p class="mx-2 mb-0">Price : ' . number_format($value["price"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0">Total : ' . number_format($value["total"], 2, ',', '.') . '</p>
                        <p class="mx-2 mb-0" style="color: ';
            if ($value["order_info"] == "completed") {
                echo "green";
            } else if ($value["order_info"] == "sedang dikirim") {
                echo "blue";
            } else if ($value["order_info"] == "menunggu konfirmasi") {
                echo "#FDB827";
            } else {
                echo "red";
            }
            echo '">Order Info : ' . $value["order_info"] . '</p>
                    </div>';

            if ($value["order_info"] == "completed"  && $value["rate"] == 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="review.php?id=' . $value["History_id"] . '"><button class="btn btn-primary">Review</button></a></div>';
            }
            if ($value["order_info"] == "completed"  && $value["rate"] != 0) {
                echo '<div class="col-1"><div style="height:70%;"></div><a href="#"><button class="btn btn-secondary">Reviewed</button></a></div>';
            }
            if ($value["order_info"] == "sedang dikirim") {
                echo '<div class="col-1"><div style="height:70%;"></div><button onclick="selesai(' . $value["History_id"] . ')" class="btn btn-success">Selesai</button></div>';
            }
            echo '</div>';
        }
    }

    if ($_REQUEST["action"] == "selesai") {
        $id = $_REQUEST["id"];
        $modif = $koneksi->prepare("UPDATE history set order_info=? where history_id=?");
        $stat = "completed";
        $modif->bind_param("si", $stat, $id);
        $modif->execute();
    }

    if ($_REQUEST["action"] == "ganti") {
        $star = $_REQUEST["qty"];
        for ($i = 0; $i < $star; $i++) {
            echo '<img src="asset/Misc/star.png" alt="">';
        }
        for ($i = 0; $i < 5 - $star; $i++) {
            echo '<img src="asset/Misc/stargray.png" alt="">';
        }
    }
}
