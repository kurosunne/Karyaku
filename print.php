<?php
    require_once("koneksi.php");
    // if(isset($_COOKIE["PHPSESSID"])){
    //     header('Set-Cookie: PHPSESSID='.$_COOKIE["PHPSESSID"].'; SameSite=None');
    // }
    error_reporting(-1);
    ini_set("display_errors", "1");
    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");
    if (!isset($_REQUEST["action"])) header("Location: admin.php");
    else {
        if ($_REQUEST["action"]=="product_sales") {
            if (isset($_REQUEST["month_product"])) {
                // var_dump($_REQUEST["month_product"]);
                $month = $_REQUEST["month_product"];
                $data = $koneksi->prepare("SELECT COALESCE(ROUND(SUM(h.qty*lp.price),0),'0') as 'total', lp.name from list_product lp LEFT JOIN history h ON lp.product_id=h.product_id and h.order_info='completed' and MONTH(h.date)=? GROUP BY lp.product_id ORDER BY total desc");
                $data->bind_param("s", $month);
                $data->execute();
                $res = $data->get_result();
                $dataGet = $res->fetch_all(MYSQLI_ASSOC);

                $dataL = $koneksi->prepare("SELECT COALESCE(ROUND(SUM(h.qty*lp.price),0),'0') as 'total', lp.name from list_product lp LEFT JOIN history h ON lp.product_id=h.product_id and h.order_info='completed' and MONTH(h.date)=? GROUP BY lp.product_id ORDER BY total desc LIMIT 5");
                $dataL->bind_param("s", $month);
                $dataL->execute();
                $resL = $dataL->get_result();
                $dataGetL = $resL->fetch_all(MYSQLI_ASSOC);

                foreach($dataGetL as &$row) {
                    $row["label"] = $row["name"];
                    $row["y"] = $row["total"];

                    unset($row["name"]);
                    unset($row["total"]);
                }
                unset($row);

            } else {
                $data = $koneksi->prepare("SELECT COALESCE(ROUND(SUM(h.qty*lp.price),0),'0') as 'total', lp.name from list_product lp LEFT JOIN history h ON lp.product_id = h.product_id AND h.order_info='completed' GROUP BY lp.product_id ORDER BY total DESC");
                if (!$data) {
                    printf("Error message: %s\n", $koneksi->error);
                }
                $data->execute();
                $res = $data->get_result();
                $dataGet = $res->fetch_all(MYSQLI_ASSOC);

                $dataL = $koneksi->prepare("SELECT COALESCE(ROUND(SUM(h.qty*lp.price),0),'0') as 'total', lp.name from list_product lp LEFT JOIN history h ON lp.product_id = h.product_id AND h.order_info='completed' GROUP BY lp.product_id ORDER BY total DESC LIMIT 5");
                if (!$dataL) {
                    printf("Error message: %s\n", $koneksi->error);
                }
                $dataL->execute();
                $resL = $dataL->get_result();
                $dataGetL = $resL->fetch_all(MYSQLI_ASSOC);

                // var_dump($dataGetL);

                foreach($dataGetL as &$row) {
                    $row["label"] = $row["name"];
                    $row["y"] = $row["total"];

                    unset($row["name"]);
                    unset($row["total"]);
                }
                unset($row);

                // var_dump($dataGetL);
            }
        } else if ($_REQUEST["action"]=="category_sales") {
            if (isset($_REQUEST["month_cat"])) {
                $month = $_REQUEST["month_cat"];
                $data = $koneksi->prepare("SELECT COALESCE(ROUND(SUM(h.qty*lp.price),0),'0') as 'total', c.nama FROM product_category pc LEFT JOIN history h ON pc.product_id = h.product_id AND h.order_info='completed' and MONTH(h.date)=? LEFT JOIN list_category c ON c.category_id = pc.category_id LEFT JOIN list_product lp ON lp.product_id = h.product_id GROUP BY pc.category_id ORDER BY total DESC");
                if (!$data) {
                    printf("Error message: %s\n", $koneksi->error);
                }
                $data->bind_param("s", $month);
                $data->execute();
                $res = $data->get_result();
                $dataGet = $res->fetch_all(MYSQLI_ASSOC);

                $dataL = $koneksi->prepare("SELECT COALESCE(ROUND(SUM(h.qty*lp.price),0),'0') as 'total', c.nama FROM product_category pc LEFT JOIN history h ON pc.product_id = h.product_id AND h.order_info='completed' and MONTH(h.date)=? LEFT JOIN list_category c ON c.category_id = pc.category_id LEFT JOIN list_product lp ON lp.product_id = h.product_id GROUP BY pc.category_id ORDER BY total DESC limit 5");
                if (!$dataL) {
                    printf("Error message: %s\n", $koneksi->error);
                }
                $dataL->bind_param("s", $month);
                $dataL->execute();
                $resL = $dataL->get_result();
                $dataGetL = $resL->fetch_all(MYSQLI_ASSOC);

                foreach($dataGetL as &$row) {
                    $row["label"] = $row["nama"];
                    $row["y"] = $row["total"];

                    unset($row["nama"]);
                    unset($row["total"]);
                }
                unset($row);

            } else {
                $data = $koneksi->prepare("SELECT COALESCE(ROUND(SUM(h.qty*lp.price),0),'0') as 'total', c.nama FROM product_category pc LEFT JOIN history h ON pc.product_id = h.product_id AND h.order_info='completed' LEFT JOIN list_category c ON c.category_id = pc.category_id LEFT JOIN list_product lp ON lp.product_id = h.product_id GROUP BY pc.category_id ORDER BY total DESC");
                if (!$data) {
                    printf("Error message: %s\n", $koneksi->error);
                }
                $data->execute();
                $res = $data->get_result();
                $dataGet = $res->fetch_all(MYSQLI_ASSOC);

                $dataL = $koneksi->prepare("SELECT COALESCE(ROUND(SUM(h.qty*lp.price),0),'0') as 'total', c.nama FROM product_category pc LEFT JOIN history h ON pc.product_id = h.product_id AND h.order_info='completed' LEFT JOIN list_category c ON c.category_id = pc.category_id LEFT JOIN list_product lp ON lp.product_id = h.product_id GROUP BY pc.category_id ORDER BY total DESC LIMIT 5");
                if (!$dataL) {
                    printf("Error message: %s\n", $koneksi->error);
                }
                $dataL->execute();
                $resL = $dataL->get_result();
                $dataGetL = $resL->fetch_all(MYSQLI_ASSOC);

                foreach($dataGetL as &$row) {
                    $row["label"] = $row["nama"];
                    $row["y"] = $row["total"];

                    unset($row["nama"]);
                    unset($row["total"]);
                }
                unset($row);
                // var_dump($dataGetL);
            }
        }
        // var_dump($dataGet);
    }
?>

<?php
    if ($_REQUEST["action"]=="product_sales") {
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($dataGet as $key => $value) {
                            ?>
                                <tr>
                                    <td><?= $key+1?></td>
                                    <td><?=$value["name"] ?></td>
                                    <td>Rp <?=intval($value["total"]) ?></td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
            <script>
                var chart = new CanvasJS.Chart("chart_pr_sal", {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme : "light1",
                    title:{
                        text: "Top 5 Selling Product"
                    },
                    axisY:{
                        includeZero: true
                    },
                    data: [{
                        type: "column",
                        indexLabelFontColor: "#5A5757",
                        indexLabelPlacement: "outside",   
                        dataPoints: <?php echo json_encode($dataGetL, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();
            </script>
        <?php
    } else if ($_REQUEST["action"]=="category_sales") {
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($dataGet as $key => $value) {
                            ?>
                                <tr>
                                    <td><?= $key+1?></td>
                                    <td><?=$value["nama"] ?></td>
                                    <td>Rp <?=intval($value["total"]) ?></td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
            <script>
                var chart = new CanvasJS.Chart("chart_cat_sal", {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme : "light1",
                    title:{
                        text: "Top 5 Selling Category"
                    },
                    axisY:{
                        includeZero: true
                    },
                    data: [{
                        type: "column",
                        indexLabelFontColor: "#5A5757",
                        indexLabelPlacement: "outside",   
                        dataPoints: <?php echo json_encode($dataGetL, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();
            </script>
        <?php
    }
?>