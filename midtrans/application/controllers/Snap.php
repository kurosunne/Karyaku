<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
class Snap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-LgeD2CDZdUd7ylEVlREoqyZ5', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
    }

    public function index()
    {
    	$this->load->view('checkout_snap');
    }

	/*
    public function token()
    {
		
		// Required
		$transaction_details = array(
		  'order_id' => rand(),
		  'gross_amount' => 94000, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
		  'id' => 'a1',
		  'price' => 18000,
		  'quantity' => 3,
		  'name' => "Apple"
		);

		// Optional
		$item2_details = array(
		  'id' => 'a2',
		  'price' => 20000,
		  'quantity' => 2,
		  'name' => "Orange"
		);

		// Optional
		$item_details = array ($item1_details, $item2_details);

		// Optional
		$billing_address = array(
		  'first_name'    => "Andri",
		  'last_name'     => "Litani",
		  'address'       => "Mangga 20",
		  'city'          => "Jakarta",
		  'postal_code'   => "16602",
		  'phone'         => "081122334455",
		  'country_code'  => 'IDN'
		);

		// Optional
		$shipping_address = array(
		  'first_name'    => "Obet",
		  'last_name'     => "Supriadi",
		  'address'       => "Manggis 90",
		  'city'          => "Jakarta",
		  'postal_code'   => "16601",
		  'phone'         => "08113366345",
		  'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		  'first_name'    => "Andri",
		  'last_name'     => "Litani",
		  'email'         => "andri@litani.com",
		  'phone'         => "081122334455",
		  'billing_address'  => $billing_address,
		  'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 2
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }
	*/

	public function token()
    {
        // Required
        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => (int)$this->input->post('amount'), // no decimal allowed for creditcard
        );

        $cart_item = json_decode($this->input->post('cart_item'), TRUE);
        // echo "<pre>";
        // var_dump($cart_item);
        // var_dump($this->input->post('amount'));
        // echo "</pre>";
        $item_details = array ();
        foreach($cart_item as $key => $value){
            $item1_details = array(
                'id' => ($key+1),
                'price' => (int)$value['price'],
                'quantity' => (int)$value['quantity'],
                'name' => $value['name']
            );

            $item_details[] = $item1_details;
        }

        $user = json_decode($this->input->post('user'), TRUE);

        // Optional
        $customer_details = array(
          'first_name'    => $user['first_name'],
          'last_name'     => "",
          'email'         => $user['email']
        );

        // Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 5
        );

        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

        error_log(json_encode($transaction_data));
        $snapToken = $this->midtrans->getSnapToken($transaction_data);

        error_log($snapToken);
        echo $snapToken;
    }

	/*
    public function finish()
    {
    	$result = json_decode($this->input->post('result_data'));
    	echo 'RESULT <br><pre>';
    	var_dump($result);
    	echo '</pre>' ;

    }
	*/

	public function finish()
    {
		$result = json_decode($this->input->post('result_data')); 
		$userid = $this->input->post('userid'); 

		if (isset($result->va_numbers[0]->bank)){
			$bank = $result->va_numbers[0]->bank;
		}
		else{
			$bank = '-';
		}
		
		if (isset($result->va_numbers[0]->va_number)){
			$va_number = $result->va_numbers[0]->va_number;
		}
		else{
			$va_number = '-';
		}
		
		
		if (isset($result->bill_key)){
			$bill_key = $result->bill_key;
		}
		else{
			$bill_key = '-';
		}
		
		if (isset($result->biller_code)){
			$biller_code = $result->biller_code;
		}
		else{
			$biller_code = '-';
		}

		$data = [
			'status_code' => $result->status_code,
			'status_message' => $result->status_message,
			'transaction_id' => $result->transaction_id,
			'order_id' => $result->order_id,
			'gross_amount' => $result->gross_amount,
			'payment_type' => $result->payment_type,
			'transaction_time' => $result->transaction_time,
			'transaction_status' => $result->transaction_status,
			'bank' => $bank,
			'va_number' => $va_number,
			'fraud_status' => $result->fraud_status,
			'pdf_url' => $result->pdf_url,
			'finish_redirect_url' => $result->finish_redirect_url,
			'bill_key' => $bill_key,
			'biller_code' => $biller_code,
		];
		$simpan = $this->db->insert('payment', $data);
	
		$user = json_decode($this->input->post('user'), TRUE);
		$_SESSION["active"] = $user["akun"];

    	$this->data['finish'] = json_decode($this->input->post('result_data')); 
		
		require_once("koneksi.php");

		$ssss = $koneksi->prepare("SELECT * from cart where user_id=?");
		$ssss->bind_param("i",$_SESSION["active"]["users_id"]);
		$ssss->execute();
		$hasil = $ssss->get_result()->fetch_all(MYSQLI_ASSOC);

		foreach ($hasil as $key => $value) {
			$insert = $koneksi->prepare("INSERT into history(product_id,user_id,date,qty,rate,review,order_info) values(?,?,?,?,?,?,?)");
			$date=date("Y-m-d");
			$rate=0;
			$review="";
			$order="menunggu konfirmasi";
			$insert->bind_param("iisiiss",$value["product_id"],$value["user_id"],$date,$value["qty"],$rate,$review,$order);
			$insert->execute();
		}

		$stmt = $koneksi->prepare("DELETE from cart where user_id=?");
		$stmt->bind_param("i",$_SESSION["active"]["users_id"]);
		$stmt->execute();


		header("Location: ../../../index.php");

    }
}
