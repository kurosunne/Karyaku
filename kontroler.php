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
            echo '<input type="checkbox" class="mt-1 me-1" name="c' . ($key + 1) . '"><label class="me-3 mt-0">'.$value["nama"].'</label>';
        }
        echo    '</div>
                            <button class="btn btn-primary mt-3" name="btAdd" style="height:40px; width:85%;">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }
}
