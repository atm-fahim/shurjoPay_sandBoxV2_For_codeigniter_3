<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chackoutcontroller extends CI_Controller {

    private $username = 'sp_sandbox';
    private $password = 'pyyk97hu&6u6';
     //live
    //private $server_url='https://engine.shurjopayment.com';
    //sandbox
    private $server_url='https://sandbox.shurjopayment.com';

    function __construct() {
        parent::__construct();
        $this->load->library('Shurjopay');
        //$this->load->model('Checkoutmodel');
        
        

    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
//    public function index1() {
//        $data = array();
//        $this->load->view('frontend/Home_vot', $data);
//    }

    public function Checkout() {
        $data = array();
        $orderid =$this->input->post('order_id', true);
        $token=$this->get_token();
        $array = json_decode($token, true);
        $prefix='NOK';
        if(isset($orderid) && !empty($orderid)){
            $tx_id = $prefix.$orderid; 
        }else{
            $tx_id = $prefix . uniqid();
        }
        
         $ip=$this->get_ip();
        $request_data=array(
            'token' => $array['token'],
            'store_id' => $array['store_id'],
            'prefix' => $prefix,                              
            'currency' => $this->input->post('currency', true),
            'return_url' => $this->input->post('return_url', true),
            'cancel_url' => $this->input->post('cancel_url', true),
            'amount' => $this->input->post('amount', true),                
            // Order information
            'order_id' => $tx_id,
            'discsount_amount' => $this->input->post('discsount_amount', true),
            'disc_percent' => $this->input->post('disc_percent', true),
            // Customer information
            'client_ip' => $ip,                
            'customer_name' => $this->input->post('customer_name', true),
            'customer_phone' => $this->input->post('customer_phone', true),
            'email' => $this->input->post('email', true),
            'customer_address' => $this->input->post('customer_address', true),                
            'customer_city' => $this->input->post('customer_city', true),
            'customer_state' => $this->input->post('customer_state', true),
            'customer_postcode' => $this->input->post('customer_postcode', true),
            'currency' => $this->input->post('currency', true),
            'return_url' => $this->input->post('return_url', true),
            'cancel_url' => $this->input->post('cancel_url', true),
            'customer_country' => $this->input->post('customer_country', true),
            'value1' => $this->input->post('value1', true),
            'value2' => $this->input->post('value2', true),
            'value3' => $this->input->post('value3', true),
            'value4' => $this->input->post('value4', true)
        );
        $requestbodyJson = json_encode($request_data);
        $response=$this->shurjopay->sendPayment($requestbodyJson);
        //seve the response in your database
        $get_spyurl = json_decode($response, true);
        if(isset($get_spyurl['checkout_url']) && !empty($get_spyurl['checkout_url'])){
         echo '<script language="javascript">';
                     echo 'window.location.href = "'.$get_spyurl['checkout_url'].'"';
          echo '</script>';
        }else{
            echo $response;
        }
    }

    public function response() {
        $actual_link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $query_str = parse_url($actual_link, PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        $orderid = $query_params['order_id'];
        $curl = curl_init();
        $token=$this->get_token();
        //echo $token;exit;
        $array = json_decode($token, true);
            curl_setopt_array($curl, [
              CURLOPT_URL => $this->server_url."/api/verification",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "{\n\"order_id\":\"".$orderid."\"\n}",
              CURLOPT_HTTPHEADER => [
                "Authorization: Bearer ". $array['token'],
                "Content-Type: application/json"
              ],
            ]);
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }
    }

    public function ipn_hook()
    {
        // DB::enableQueryLog();
        $actual_link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $query_str = parse_url($actual_link, PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        $orderid = $query_params['order_id'];

          $curl = curl_init();
          $token=$this->get_token();
          $array = json_decode($token, true);
              curl_setopt_array($curl, [
                CURLOPT_URL => $this->server_url."/api/verification",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\"order_id\":\"".$orderid."\"\n}",
                CURLOPT_HTTPHEADER => [
                  "Authorization: Bearer ". $array['token'],
                  "Content-Type: application/json"
                ],
              ]);
              
              $response = curl_exec($curl);
              $err = curl_error($curl);
              curl_close($curl);
              if ($err) {
                echo "cURL Error #:" . $err;
              } else {
                $data=json_decode($response);
              }
      

        // dd(DB::getQueryLog());
        if( count($data) > 0 )
        {
            foreach($data as $key => $val)
            {
              if($val->sp_code==1000){
                $is_data_chk = $this->Checkoutmodel->id_info($orderid);
                $update_datadata = [
                  "order_id" => $val->invoice_no,
                  "currency"=> $val->currency,
                  "amount"=> $val->full_amount,
                  "payable_amount"=> $val->payable_amount,
                  "discsount_amount"=> $val->discsount_amount,
                  "disc_percent"=> $val->disc_percent,
                  "card_holder_name"=> $val->card_holder_name,
                  "card_number"=> $val->card_number,
                  "phone_no"=> $val->customer_phone_no,
                  "bank_trx_id"=> $val->bank_trx_id,
                  "invoice_no"=> $val->invoice_no,
                  "bank_status"=> $val->bank_status,
                  "customer_order_id"=> $val->customer_order_id,
                  "sp_code"=> $val->sp_code,
                  "sp_massage"=> $val->sp_massage,
                  "value1"=> $val->value1,
                  "value2"=> $val->value2,
                  "value3"=> $val->value3,
                  "value4"=> $val->value4,
                  "transaction_status"=> $val->bank_message,
                  "method"=> $val->method_name,
                  "date_time"=> $val->created_at
              ];
            if(isset($is_data_chk->order_id) && !empty($is_data_chk->order_id)){
              $this->Checkoutmodel->update_by_invoiceno($is_data_chk->order_id,$update_datadata);
            }else{
              $this->Checkoutmodel->update_or_save_by_invoiceno($order_id='',$update_datadata);
              
            }
            /* 
            *write this code using Checkoutmodel
            ============model================
            public function id_info($orderid) {
                    $this->db->select('order_id');
                    $this->db->from('student_info');
                    $this->db->where('order_id', $orderid);
                    $query_result = $this->db->get();
                    $result = $query_result->row();
                    return $result;
              }
              //===============================================
                update_or_save_by_invoiceno($order_id,$update_datadata){
                  if ($officer_category_id) {
                  $this->db->where('OderId', $order_id);
                   $this->db->update('student_info', $update_datadata);
                  }else{
                    $this->db->insert('student_info', $update_datadata);
                  }
                   
                }
            */
              }
                
            } 
        }    

    }

    public function canceled() {
        $actual_link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $query_str = parse_url($actual_link, PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        $orderid = $query_params['order_id'];
        $curl = curl_init();
        $token=$this->get_token();
        //echo $token;exit;
       $order_id=['order_id'=>$orderid];
        $array = json_decode($token, true);
            curl_setopt_array($curl, [
              CURLOPT_URL => $this->server_url."/api/verification",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($order_id),
              CURLOPT_HTTPHEADER => [
                "Authorization: Bearer ". $array['token'],
                "Content-Type: application/json"
              ],
            ]);
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }
    }

    public function get_token(){
		$curl = curl_init();
		$request_credential = array(
            'username' => $this->username,
            'password' => $this->password
        );
		$requestbodyJson = json_encode($request_credential);
    //echo $requestbodyJson;exit;
		curl_setopt_array($curl, [
		  CURLOPT_URL => $this->server_url."/api/get_token",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $requestbodyJson,
		  CURLOPT_HTTPHEADER => [
			"Content-Type: application/json"
		  ],
		]);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
         //seve the response in your database
		  return $response;
		}
}
public function get_ip(){
  $this->CI = & get_instance();

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
}
}