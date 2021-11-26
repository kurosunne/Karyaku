<!--punya-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart | Karyaku</title>
  <?php
  require_once("./application/controllers/head.php");
  ?>
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<SB-Mid-client-38oOCo7vkXtCsA9G>"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<?php
require_once("./application/controllers/koneksi.php");
require_once("./application/controllers/header.php");
if (isset($_SESSION["active"])) {
  if ($_SESSION["active"] == "admin") {
    header("Location: ../../index.php");
  }
} else {
  header("Location: ../../login.php");
}

$id = $_SESSION["active"]["users_id"];
?>

<body>
  <div class="modal" id="cartSuccess" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body bg-danger p-0">
          <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-danger d-flex pt-0 justify-content-center pb-4">
          <h4 class="text-light">Item Deleted !</h4>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div style="width: 100%;" class="row mt-3" id="box">
      <div class="col-9 row">
        <?php
        $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating', c.* FROM list_product lp, cart c where lp.product_id=c.product_id and c.user_id=? order by rating desc");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $amount = 0;
        $item_details = array();

        foreach ($hasil as $key => $value) {
          $diskon = $koneksi->prepare("SELECT * from discount where product_id=?");
          $diskon->bind_param("i", $value["product_id"]);
          $diskon->execute();
          $resdiskon = $diskon->get_result()->fetch_all(MYSQLI_ASSOC);
          if(count($resdiskon) > 0){
            $tempHarga = $value["price"] - ($resdiskon[0]["discount_value"] / 100 * $value["price"]);
            $amount += $tempHarga * $value["qty"];
          }else{
            $amount += $value["price"] * $value["qty"];
          }
          $item1_details = array(
            'id' => $value["product_id"],
            'price' => $value['price'],
            'quantity' => $value['qty'],
            'name' => $value["name"]
          );
          array_push($item_details, $item1_details);
        ?>
          <div class=" col-xxl-4 col-xl-6 col-lg-12 mb-xl-0 mb-xxl-0 mb-md-5">
            <a href="../../detail.php?id=<?= $value["product_id"] ?>&nama=<?= $value["name"] ?>" class="klik" style="text-decoration:none; color:black;">
              <div style="width: 90%;" class="shadow d-flex flex-column">
                <img src="../../<?= $value["image"] ?>" alt="" width="100%">
                <div style="height: 50px;" class="mt-0 mb-2">
                  <p class="my-0 ms-1"><?= $value["name"] ?></p>
                </div>
                <div class="mt-0 mb-0">
                  <p class="float-start ms-2"><?= $value["qty"] ?></p>
                </div>
                <div>
                  <?= count($resdiskon) > 0 ? "<p class='float-end mx-2 mt-0 my-0' style='color:grey; text-decoration:line-through; ?>;''>Rp. " . number_format($value["price"], 2, ',', '.') . "</p>" : '' ?>
                  <div style="clear: both;"></div>
                  <img class="float-start ms-2" src="../../asset/Misc/star.png" alt="" height="25px">
                  <p class="float-start mx-2"><?= $value["rating"] ?>/5</p>
                  <?php
                  if (count($resdiskon) > 0) {
                    $tempHarga = $value["price"] - ($resdiskon[0]["discount_value"] / 100 * $value["price"]);
                  }
                  ?>
                  <?= count($resdiskon) > 0 ? "<p class='float-end mx-2 mb-0'>Rp. " . number_format($tempHarga, 2, ',', '.') . "</p>" : '<p class="float-end mx-2" >Rp. ' . number_format($value["price"], 2, ',', '.') . '</p>' ?>
                </div>
              </div>
            </a>
            <button class="btn btn-danger mt-2" onclick="removeCart(<?= $value['product_id'] ?>)" style="width: 90%;">Remove</button>
          </div>
        <?php
        }
        ?>
      </div>
      <div class="col-3">
        <div style="width: 100%;  border-radius:10px;" class="shadow p-2">
          <h4>Total : Rp. <?= number_format($amount, 2, ',', '.') ?></h4>
          <div class="d-flex justify-content-center" style="width: 100%;">
            <?php
            $u = array(
              'first_name' => $_SESSION["active"]["name"],
              'email' => $_SESSION["active"]["email"]
            );
            ?>
            <input type="hidden" id="user" name="user" value='<?= json_encode($u) ?>'>
            <input type="hidden" id="cart_item" name="cart_item" value='<?= json_encode($item_details) ?>'>
            <input type="hidden" id="amount" name="amount" value='<?= $amount ?>'>
            <button class="btn btn-primary" id="pay-button" style="width: 90%; ">Check Out</button>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!--punya-->

  <form id="payment-form" method="post" action="<?= site_url() ?>/snap/finish">
    <input type="hidden" name="result_type" id="result-type" value=""></div>
    <input type="hidden" name="result_data" id="result-data" value=""></div>
  </form>

  <script type="text/javascript">
    $('#pay-button').click(function(event) {
      event.preventDefault();
      var cart_item = $("#cart_item").val();
      var amount = $("#amount").val();
      var user = $("#user").val();

      $.ajax({
        method: 'POST',
        url: './snap/token',
        data: {
          cart_item: cart_item,
          amount: amount,
          user: user
        },
        cache: false,
        success: function(data) {
          //location = data;
          console.log('token = ' + data);

          var resultType = document.getElementById('result-type');
          //var userid = document.getElementById('userid').value;
          var resultData = document.getElementById('result-data');

          // console.log(resultType);
          // console.log(resultData);
          // console.log(userid);

          function changeResult(type, data) {
            $("#result-type").val(type);
            $("#result-data").val(JSON.stringify(data));
            //$("#userid").val(userid);
            //resultType.innerHTML = type;
            //resultData.innerHTML = JSON.stringify(data);
          }

          snap.pay(data, {
            onSuccess: function(result) {
              changeResult('success', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            },
            onPending: function(result) {
              changeResult('pending', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            },
            onError: function(result) {
              changeResult('error', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            }
          });
        }
      });
    });
  </script>

  <script>
    function removeCart(index) {
      $.post("kontroler.php", {
        action: "removeCart",
        item: index
      }, function(data, status) {
        $("#cartSuccess").modal("show");
        $("#box").html(data);
      });
    }
  </script>

</body>

</html>