<?php
require_once("koneksi.php");
if (isset($_REQUEST["action"])) {
    if ($_REQUEST["action"] == "signOut") {
        unset($_SESSION["active"]);
        header("Location: index.php");
    }

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

    if ($_REQUEST["action"] == "editProduct") {
        $id = $_REQUEST["id"];
        $data = $koneksi->prepare("SELECT * from list_product where product_id=?");
        $data->bind_param("i", $id);
        $data->execute();
        $dataGet = $data->get_result()->fetch_assoc();
        echo '<input class="mt-4" type="text" placeholder="Product Name" id="name' . $id . '" value="' . $dataGet["name"] . '" style="border-radius: 5px; height:40px; width:85%;" name="name">
        <input class="mt-4" type="text" placeholder="Product Brand" value="' . $dataGet["brand_name"] . '" id="brand' . $id . '" style="border-radius: 5px; height:40px; width:85%;" name="brand">
        <textarea class="mt-4" type="textbox" placeholder="Product Description"  id="desc' . $id . '" style="border-radius: 5px; width:85%; border:2px solid black;" rows="5" name="desc">' . $dataGet["description"] . '"</textarea>
        <input class="mt-4" type="number" placeholder="Product Stock" value="' . $dataGet["stock"] . '" id="stock' . $id . '" style="border-radius: 5px; height:40px; width:85%;" name="stock">
        <input class="mt-4" type="number" placeholder="Product Price" value="' . $dataGet["price"] . '" id="price' . $id . '" style="border-radius: 5px; height:40px; width:85%;" name="price"> <br>
        <button type="button" class="btn btn-primary my-3 float-end" onclick="saveEditProduct(' . $id . ')">Apply</button>';
    }

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
}
