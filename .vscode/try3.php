<?php
set_time_limit(0);
include '../../../includes/cfg.php';
if(isset($_POST) && !empty($_POST) && isset($_POST['service'])){
    $con = $pinnaview->database();
    $info = $pinnaview->get_user_details($_SESSION['user_id']);

    if($_POST['service'] == "airtime"){
        $network = $_POST['network'];
        $network_2 = $_POST['network'];
        $phone_number = $_POST['airtime-phone-number'];
        $amount = $_POST['airtime-amount'];
        if( $info['wallet'] < $amount){
           echo "low-balance";
           exit;
        }


        switch ($network_2){
            case  "mtn" :
            $bill = (97.0 / 100) * $amount;
            $oc = 1;
            break;
            case "glo" :
            $bill = (93.7 / 100) * $amount;
            $oc = 2;
            break;
            case "9mobile" :
            $bill = (96.5 / 100) * $amount;
            $oc = 3;
            case "etisalat" :
            $bill = (96.5 / 100) * $amount;
            $oc = 3;
            break;
            case "airtel" :
            $bill = (96.5 / 100) * $amount;
            $oc = 4;
            break;
        }

        if($network_2=='etisalat')
        {
            $network_2 = '9mobile';
        }

    	$vquery = mysqli_query($con,"select vendor from vendors where operator = '$network_2' and service ='vtu' ");
	    $result = mysqli_fetch_assoc($vquery);
	    $vendor = $result['vendor'];
	    $now = date("Y-m-d h:i:s A");
	    if($vendor == "smart-recharge"){

            $headers = array( 'Content-Type: application/json');
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://smartrecharge.ng/api/v2/airtime/?api_key=0f572421&product_code='.urlencode($network).'_custom&phone='.urlencode($phone_number).'&amount='.urlencode($amount).'&callback=https://yourdomain.com/callback.php' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            $result = curl_exec($ch );
            curl_close($ch);
            $resultJson = json_decode($result);
            if($resultJson->data->text_status == "COMPLETED" || $resultJson->data->text_status == "PENDING" ){
                echo "successful";
                $trans_id = random_int(99999,999999999);
                $description = ucfirst($network). ' '.'airtime';
                mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','airtime-recharge','$amount','completed','$now','$description','$phone_number')");
                $pinnaview->debit_wallet($bill,$_SESSION['user_id']);

            }else{
                echo "request-failed";
            }
    	}
        elseif($vendor =="vtpass")
        {
            $username = "ayodeleajisegiri@gmail.com";
            $password = "Jesusanu9309!";
            $encoded =  base64_encode($username.":".$password);
            $generate_id = substr(str_shuffle(md5(time())), 0, 10);
            $url = "https://vtpass.com/api/pay?serviceID=".urlencode($network)."&request_id=".urlencode($generate_id)."&amount=".urlencode($amount)."&phone=".urlencode($phone_number);

            //open connection
              $curl = curl_init();
              curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Basic ".$encoded
                ),
                ));

              //execute post
               $result = curl_exec($curl);
               $response = json_decode($result,true);
               $err = curl_error($curl);
               curl_close($curl);
                // echo $result;
                // exit;
            if($response['code']=== "000")
            {
                $trans_id = $response['content']['transactions']['transactionId'];
    	        $description = ucfirst($network). ' Vtpass  '.'airtime';
    	        $pinnaview->debit_wallet($bill,$_SESSION['user_id']);
        	    mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','airtime-recharge via Vtpass','$amount','completed','$now','$description','$phone_number')");
        		echo "successful";
                    exit();
            }
            else
            {
                $trans_id = $response['content']['transactions']['transactionId'];
    	        $description = ucfirst($network). ' Vtpass  '.'airtime';
                mysqli_query($con,"INSERT INTO failed_transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','airtime-recharge via Vtpass','$amount','failed','$now','$description','$phone_number')");
                 echo "request-failed ";
                 echo $result;
            }
        }
        elseif($vendor=="clubconnect")
        {
            $url = "https://www.nellobytesystems.com/APIAirtimeV1.asp?UserID=".urlencode('CK13617693')."&APIKey=".urlencode('5DC3EDIY1O864SSIUGL49CGXMOD81I638123805EMY9364UGK7125SG55GF7S56N')."&MobileNetwork=0".urlencode($oc)."&Amount=".urlencode($amount)."&MobileNumber=".urlencode($phone_number);

            //open connection
        $ch = curl_init();
          curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
           curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects


        //execute post
         $result = curl_exec($ch);
         $response = json_decode($result,true);
          $err = curl_error($ch);
            curl_close($ch);




      if($response['status'] === "ORDER_RECEIVED"){

          $trans_id = random_int(99999,999999999);
          $description = ucfirst($network). ' '.'airtime via Clubconnect';
          mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','airtime-recharge via Clubconnect','$amount','completed','$now','$description','$phone_number')");
          $pinnaview->debit_wallet($bill,$_SESSION['user_id']);
          echo "successful";
          exit();

      }else{
                $trans_id = $response['orderid'];
               $description = ucfirst($network). ' Vtpass  '.'airtime';
                mysqli_query($con,"INSERT INTO failed_transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','airtime-recharge via Vtpass','$amount','failed','$now','$description','$phone_number')");
                 echo "request-failed";

        exit();
      }
        }
        elseif($vendor=="pinnaview"){
    	    $pinnaview->debit_wallet($bill,$_SESSION['user_id']);
    	     $trans_id = random_int(99999,999999999);
    	     $description = ucfirst($network). ' '.'airtime';
    	    mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','airtime-recharge','$amount','completed','$now','$description','$phone_number')");
    	    mysqli_query($con, "INSERT INTO `pinnaview_pends` (user_id,amount,operator_code,phone_number,service) VALUES('{$_SESSION['user_id']}','$amount','$oc','$phone_number','vtu')");
    		echo "successful";
    	}

    }else if($_POST['service'] == "data"){

    $network = $_POST['network'];
    $name = $_POST['name'];
    $network2 = $_POST['network'];
    $data_code = $_POST['data-plan-code'];
    $phone_number = preg_replace('/\s+/', '', $_POST['data-phone-number']);

    if($network2=="etisalat-data")
    {
        $network2 ="9mobile";
    }
    elseif($network2 =="airtel-data")
    {
        $network2 = "airtel";
    }
    elseif($network2 == "glo-data")
    {
        $network2 = "glo";
    }
    elseif($network2 == "mtn-data")
    {
        $network2 = 'mtn';
    }


    $vquery = mysqli_query($con,"select * from vendors where operator = '$network2' and service ='data' ");
    $result = mysqli_fetch_assoc($vquery);
    $vendor = $result['vendor'];
    $pin = $result['pin'];
    if($vendor =="smart-recharge")
    {
        $vendor_1 = "smartrecharge";
    }
    else
    {
        $vendor_1 = $vendor;

    }

    if($vendor =="clubconnect")
    {
        $sql = mysqli_query($con,"SELECT * FROM products WHERE code = '$data_code' AND vendor ='$vendor_1' AND name='$name' ");
    }
    else{
        $sql = mysqli_query($con,"SELECT * FROM products WHERE code = '$data_code' AND vendor ='$vendor_1'");
    }


    $row= mysqli_fetch_assoc($sql);
    $price = $row['price'];
    $value = $row['value'];
    $valuef = $row['value_figure'];
    $now = date("Y-m-d h:i:s A");




    if(($vendor == "pinnaview" || $vendor == "sim-hosting") && $network == 'mtn'){
    $now_d= date("Y-m-d");
    $query = mysqli_query($con,"SELECT * FROM transactions WHERE user_id='{$_SESSION['user_id']}' AND date(date) = '$now_d' AND service = 'data-recharge' ");
    $result = mysqli_fetch_assoc($query);
     if(mysqli_num_rows($query) == 0){
       if($price == 185 || $price == 330){
             $price =  $price + 0;
         }else if($price == 660){
             $price =  660;
         }else if($price == 1650){
             $price = 1650 ;
        }
    }
    }


    if($info['wallet'] < $price){
        echo "low-balance";
        exit;
    }

    if($vendor == "sim-hosting" && $network == 'mtn'){

     echo "successful";
     $trans_id = random_int(99999,999999999);
     $plan1 =   'SMEb '.$phone_number.' 500 '.$pin.' ';
     $plan2 =   'SMEc '.$phone_number.' 1000 '.$pin.' ';
     $plan3 =   'SMEd '.$phone_number.' 2000 '.$pin.' ';
     $plan4 =   'SMEE '.$phone_number.' 5000 '.$pin.' ';

     if($data_code == "data_share_300MB"){
         $msg = $plan1;
     }else if($data_code == "data_share_1gb"){
        $msg = $plan2;
     }else if($data_code == "data_share_2gb"){
        $msg = $plan3;
     }else if($data_code == "data_share_5gb"){
        $msg = $plan4;
     }else{
         echo "request-failed";
         exit;
     }

    $baseurl = "https://ussd.simhosting.ng/api/shortcode/?";
    $shortcode_array = array (
      "shortcode"=> "131",
      "message"=> $msg,
      "servercode" => "SZ1O9W99J2RMV6RRMAUT",
      "token" => "3UofoZgKmXRermCpH3LGm6OjLpHyvEkZspnLTvWUrmQg3yc7nN",
      "refid" => $trans_id
     );
    $params = http_build_query($shortcode_array);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$baseurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $response = curl_exec($ch); curl_close($ch);
    mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','data-recharge','$price','completed','$now','MTN SME Data','$phone_number')");
    $pinnaview->debit_wallet($price,$_SESSION['user_id']);

    }elseif($vendor == "pinnaview"){

     $trans_id = random_int(99999,999999999);
     switch ($network2){
            case  "mtn" :
            $oc = 1;
            break;
            case "glo" :
            $oc = 2;
            break;
            case "9mobile" :
            $oc = 3;
            break;
            case "airtel" :
            $oc = 4;
            break;
        }
     $description = ucfirst($network). ' '.'data';
     mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','data-recharge','$price','completed','$now','$description','$phone_number')");
     mysqli_query($con, "INSERT INTO `pinnaview_pends` (user_id,amount,operator_code,phone_number,service) VALUES('{$_SESSION['user_id']}','$valuef','$oc','$phone_number','data')");
	 $pinnaview->debit_wallet($price,$_SESSION['user_id']);
	 echo "successful";

    }
    elseif($vendor =="smart-recharge"){

    $headers = array( 'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://smartrecharge.ng/api/v2/datashare/?api_key='.urlencode("0f572421").'&product_code='.urlencode($data_code).'&phone='.urlencode($phone_number).'');
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    $result = curl_exec($ch );
    curl_close( $ch );
    $resultJson = json_decode($result);
     $description = ucfirst($network). ' '.'data';
    if($resultJson->data->text_status == "COMPLETED" || $resultJson->data->text_status == "PENDING" ){
        echo "successful";
        $trans_id = random_int(99999,999999999);
        mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Data recharge','$price','completed','$now','Data SME recharge','$phone_number')");
        $pinnaview->debit_wallet($price,$_SESSION['user_id']);
    }else{
        echo "request-failed";
    }

}
elseif($vendor =="vtpass")
{
    $service_id = $_POST['network'];
    $username = "ayodeleajisegiri@gmail.com";
    $password = "Jesusanu9309!";
    $encoded =  base64_encode($username.":".$password);
    $generate_id = substr(str_shuffle(md5(time())), 0, 10);
    $url = "https://vtpass.com/api/pay?serviceID=$service_id&request_id=$generate_id&billersCode=$phone_number&variation_code=$data_code&amount=$price&phone=$phone_number";

    //open connection
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Basic ".$encoded
        ),
        ));

      //execute post
       $result = curl_exec($curl);
       $response = json_decode($result,true);
       $err = curl_error($curl);
       curl_close($curl);

       if($response['code'] === "000")
       {
           $trans_id = random_int(99999,999999999);
           $price = $response['content']['transactions']['amount'];
           mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Data recharge via Vtpass','$price','completed',NOW(),'Data  recharge via Vtpass','$phone_number')");
           $pinnaview->debit_wallet($price,$_SESSION['user_id']);
           echo "successful";
       }
       else{
           $trans_id = random_int(99999,999999999);
           mysqli_query($con,"INSERT INTO failed_transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Data recharge via Vtpass','$price','failed',NOW(),'Data  recharge via Vtpass','$phone_number')");
          echo $response['content']['errors'];
          echo "request-failed";
       }

}
elseif($vendor=="clubconnect")
{
    switch ($network){
        case  "mtn" :
        $oc = 1;
        break;
        case "glo" :
        $oc = 2;
        break;
        case "9mobile" :
        $oc = 3;
        break;
        case "airtel" :
        $oc = 4;
        break;
    }
    $generate_id = substr(str_shuffle(md5(time())), 0, 10);
    $url= "https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=".urlencode('CK13617693')."&APIKey=5DC3EDIY1O864SSIUGL49CGXMOD81I638123805EMY9364UGK7125SG55GF7S56N&MobileNetwork=0".urlencode($oc)."&DataPlan=".urlencode($data_code)."&MobileNumber=".urlencode($phone_number)."&RequestID=".urlencode($generate_id);
            //open connection
        $ch = curl_init();
          curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
           curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects


        //execute post
         $result = curl_exec($ch);
         $response = json_decode($result,true);
          $err = curl_error($ch);
            curl_close($ch);



      if($response['status'] === "ORDER_RECEIVED"){

          $trans_id = random_int(99999,999999999);
          $description = ucfirst($network). ' '.'Data via Clubconnect';
          mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','data-recharge via Clubconnect','$price','completed','$now','$description','$phone_number')");
          $pinnaview->debit_wallet($price,$_SESSION['user_id']);
          echo "successful";
          exit();

      }else{
          $trans_id = random_int(99999,999999999);
           mysqli_query($con,"INSERT INTO failed_transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Data recharge via Clubconnect','$price','failed',NOW(),'Data  recharge via Clubconnect','$phone_number')");


        echo "request-failed";

        exit();
      }
}


    }else if($_POST['service'] == "electricity"){

        $vquery = mysqli_query($con,"select * from vendors where  service ='electricity' ");
        $result = mysqli_fetch_assoc($vquery);
        $vendor = $result['vendor'];
        $electricity_company = $_POST['electricity-company'];
        $meter_type = $_POST['meter-type'];
        $meter_number = $_POST['meter-number'];
        $amount = $_POST['electricity-bill'] + 50;
        $amount2 = $_POST['electricity-bill'];
        if($info['wallet'] < $amount){
            echo "low-balance";
            exit;
        }
    if($vendor=='smart-recharge')
    {
        $headers = array( 'Content-Type: application/json');
        $ch = curl_init();

        curl_setopt( $ch,CURLOPT_URL, 'https://smartrecharge.ng/api/v2/electric/?api_key=0f572421&product_code='.urlencode($electricity_company).'_'.urlencode($meter_type).'_custom&meter_number='.urlencode($meter_number).'&amount='.urlencode($amount2).'');
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec($ch );
        $resultJson = json_decode($result);
        curl_close( $ch );
        if($resultJson->data->text_status == "COMPLETED"){
            $token = $resultJson->data->token;

            $array = array("message"=>"successful","token"=>$token);
            echo $token;
            $trans_id = random_int(99999,999999999);
            mysqli_query($con,"INSERT INTO `utilities_transactions` (transaction_id,customer_name,identifier,token,company)
                            VALUES('$trans_id','{$_SESSION['customer-e']}','$meter_number','$token','$electricity_company')");
            mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Electricity','$amount','completed',NOW(),'Electricity bill payment','$meter_number')");
            $pinnaview->debit_wallet( $amount,$_SESSION['user_id']);
        }else{
            echo "request-failed";
        }
    }
    elseif($vendor=="vtpass")
    {
        //====== Select supposed values for electricity comapany=============
        if($electricity_company === "aedc")
        {
            $electricity_company = "abuja-electric";
        }
        elseif($electricity_company === "knedc")
        {
            $electricity_company ="kaduna-electric";
        }
        elseif($electricity_company === "kedc")
        {
            $electricity_company = "kano-electric";
        }
        elseif($electricity_company === "jedc")
        {
           $electricity_company = "jos-electric";
        }
        elseif($electricity_company === "ibedc")
        {
            $electricity_company= "ibadan-electric";
        }
        elseif($electricity_company === "ikedc")
        {
            $electricity_company = "ikeja-electric";
        }
        elseif($electricity_company === "ekedc")
        {
         $electricity_company   = "eko-electric";
        }
        elseif($electricity_company === "phedc")
        {
          $electricity_company  = "portharcourt-electric";
        }


            $phone = $_POST['phone'];
            $username = "ayodeleajisegiri@gmail.com";
            $password = "Jesusanu9309!";
            $encoded =  base64_encode($username.":".$password);
            $generate_id = substr(str_shuffle(md5(time())), 0, 10);
            $url = "https://vtpass.com/api/pay?request_id=$generate_id&serviceID=".urlencode($electricity_company)."&billersCode=".urlencode($meter_number)."&variation_code=".urlencode($meter_type)."&amount=".urlencode($amount2)."&phone=".urlencode($phone);

            //open connection
              $curl = curl_init();
              curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Basic ".$encoded
                ),
                ));

              //execute post
               $result = curl_exec($curl);
               $response = json_decode($result,true);
               $err = curl_error($curl);
               curl_close($curl);


               if($response['code'] === "000" && $response['content']['transactions']['status']==="delivered")
               {
                $token = $response["purchased_code"];

                $array = array("message"=>"successful","token"=>$token);
                $trans_id = random_int(99999,999999999);
                mysqli_query($con,"INSERT INTO `utilities_transactions` (transaction_id,customer_name,identifier,token,company)
                                VALUES('$trans_id','{$_SESSION['customer-e']}','$meter_number','$token','$electricity_company')");
                mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Electricity','$amount','completed',NOW(),'Electricity bill payment via Vtpass','$meter_number')");
                $pinnaview->debit_wallet( $amount,$_SESSION['user_id']);
               echo $response["purchased_code"];
               }
               elseif($response['code'] === "000" && $response['content']['transactions']['status']!=="delivered")
               {
                   echo "pending";
                   exit();
               }
               else{
                   $trans_id = random_int(99999,999999999);
                mysqli_query($con,"INSERT INTO failed_transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Electricity','$amount','failed',NOW(),'Electricity bill payment via Vtpass','$meter_number')");
                   echo $response['content']['errors'];
                   echo "request-failed";
                   exit();
               }
    }
    elseif($vendor =="clubconnect")
    {
         //====== Select supposed values for electricity comapany=============
         if($electricity_company === "aedc")
         {
             $electricity_company_num = "03";
         }
         elseif($electricity_company === "kaedc")
         {
             $electricity_company_num ="08";
         }
         elseif($electricity_company === "kedc")
         {
             $electricity_company_num = "04";
         }
         elseif($electricity_company === "eedc")
         {
            $electricity_company_num = "09";
         }
         elseif($electricity_company === "jedc")
         {
            $electricity_company_num = "06";
         }
         elseif($electricity_company === "ibedc")
         {
             $electricity_company_num = "07";
         }
         elseif($electricity_company === "ikedc")
         {
             $electricity_company_num = "02";
         }
         elseif($electricity_company === "ekedc")
         {
          $electricity_company_num   = "01";
         }
         elseif($electricity_company === "phedc")
         {
           $electricity_company_num  = "05";
         }



         $url = "https://www.nellobytesystems.com/APIElectricityV1.asp?UserID=".urlencode('CK13617693')."&APIKey=".urlencode('5DC3EDIY1O864SSIUGL49CGXMOD81I638123805EMY9364UGK7125SG55GF7S56N')."&ElectricCompany=".urlencode($electricity_company_num)."&MeterType=".urlencode($meter_type)."&MeterNo=".urlencode($meter_number)."&Amount=".urlencode($amount2);

         $ch = curl_init();

         curl_setopt( $ch,CURLOPT_URL, $url);
         curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
         curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects


               //execute post
                $result = curl_exec($ch);
                $response = json_decode($result,true);
                 $err = curl_error($ch);
                   curl_close($ch);


         if($response['status'] === "ORDER_RECEIVED" && $response["metertoken"] !==null)
         {


             $token = $response["metertoken"];

             $array = array("message"=>"successful","token"=>$token);
             $trans_id = random_int(99999,999999999);
             mysqli_query($con,"INSERT INTO `utilities_transactions` (transaction_id,customer_name,identifier,token,company)
                             VALUES('$trans_id','{$_SESSION['customer-e']}','$meter_number','$token','$electricity_company')");
             mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Electricity','$amount','completed',NOW(),'Electricity bill payment','$meter_number')");
             $pinnaview->debit_wallet( $amount,$_SESSION['user_id']);
            echo $response["metertoken"];
         }
         else if($response['status'] ==="ORDER_COMPLETED"){

             echo 'testing'.$response['metertoken'];
             }
             else{
             echo "request-failed";
         }
    }

    }else if($_POST['service'] == "cable"){
        $vquery = mysqli_query($con,"select * from vendors where  service = 'cable' ");
        $result = mysqli_fetch_assoc($vquery);
        $vendor = $result['vendor'];
        $cable_network = $_POST['cable-network'];
        $smart_card_number = $_POST['smart-card-no'];
        $amount = $_POST['amount'];

        // For smart recharge api to run cable tv
        if($vendor=="smart-recharge")
        {

        if($cable_network == "gotv"){
            if($amount == "410"){
                $productCode = "gotv_lite";
            }else if($amount == "1630"){
               $productCode = "gotv_jinja";
            }else if($amount == "2473"){
                $productCode = "gotv_jolli";
            }else if($amount == "725"){
                $productCode = "gotv_smallie";
            }else if($amount == "3588"){
                $productCode = "gotv_max";
            }else{
                $productCode = "gotv_custom";
            }
        }else if($cable_network == "dstv"){
            if($amount == "1850"){
                $productCode = "dstv_padi";
            }else if($amount == "2600"){
                $productCode = "dstv_yanga";
            }else if($amount == "4500"){
               $productCode = "dstv_confam";
            }else if($amount == "7865"){
                $productCode = "dstv_compact";
            }else if($amount == "12289"){
                $productCode = "dstv_compact_plus";
            } else if($amount == "18300"){
                $productCode = "dstv_premium";
            }else{
                $productCode = "dstv_custom";
            }
        }else if($cable_network == "startimes"){
            if($amount == "890"){
                $productCode = "startimes_nova";
            }else if($amount == "1590"){
               $productCode = "startimes_basic";
            }else if($amount == "2090"){
                $productCode = "startimes_smart";
            }else if($amount == "2590"){
                $productCode = "startimes_classic";
            } else if($amount == "4090"){
                $productCode = "startimes_super";
            }else {
                $productCode = "startimes_custom";
            }
        }
        if($productCode == "gotv_custom" || $productCode == "dstv_custom" || $productCode == "startimes_custom"){
        $bill = $amount + 50;
        }else{
            $bill = $amount;
        }
        if( $info['wallet'] < $bill){
            echo "low-balance";
            exit;
        }
        $headers = array( 'Content-Type: application/json');
        $ch = curl_init();

        curl_setopt( $ch,CURLOPT_URL, 'https://smartrecharge.ng/api/v2/tv/?smartcard_number='.urlencode($smart_card_number).'&product_code='.urlencode($productCode).'&api_key=0f572421');
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec($ch );
        $resultJson = json_decode($result);
         curl_close( $ch );
        if($resultJson->data->text_status == "COMPLETED"){
            echo "successful";
            $trans_id = random_int(99999,999999999);
            mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Cable Tv','$amount','completed',NOW(),'Cable Tv bill payment','$smart_card_number')");
            $pinnaview->debit_wallet($bill,$_SESSION['user_id']);
        }else{
             $trans_id = random_int(99999,999999999);
        mysqli_query($con,"INSERT INTO failed_transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Cable Tv','$amount','failed',NOW(),'Cable Tv bill payment via SmartRecharge','$smart_card_number')");

            echo "request-failed";
        }

    }
    elseif($vendor=="vtpass")
    {
        $service_id = $_POST['cable-network'];
        $variation_code = $_POST['variation_code'];

        if($service_id==="dstv")
        {
        if($variation_code==="dstv-padi")
        {
            $amount = 1850;
        }
        elseif($variation_code==="dstv-yanga"){
            $amount = 2565;
        }
        elseif($variation_code==="dstv-confam"){
            $amount = 4615;
        }
        elseif($variation_code==="dstv79"){
            $amount = 7900;
        }
        elseif($variation_code==="dstv3"){
            $amount = 18400;
        }
        elseif($variation_code==="dstv6"){
            $amount = 6200;
        }
        elseif($variation_code==="dstv7"){
            $amount = 12400;
        }
        elseif($variation_code==="dstv9"){
            $amount = 25550;
        }
        elseif($variation_code==="dstv10"){
            $amount = 20500;
        }
        elseif($variation_code==="confam-extra"){
            $amount = 7115;
        }
        elseif($variation_code==="yanga-extra"){
            $amount = 5065;
        }
        elseif($variation_code==="padi-extra"){
            $amount = 4350;
        }
        elseif($variation_code==="com-asia"){
            $amount = 14100;
        }
        elseif($variation_code==="dstv30"){
            $amount = 10400;
        }
        elseif($variation_code==="com-frenchtouch"){
            $amount = 10200;
        }
        elseif($variation_code==="dstv33"){
            $amount = 20900;
        }
        elseif($variation_code==="dstv40"){
            $amount = 18600;
        }
        elseif($variation_code==="com-frenchtouch-extra"){
            $amount = 12700;
        }
        elseif($variation_code==="com-asia-extra"){
            $amount = 16600;
        }
        elseif($variation_code===""){
            $amount = 5065;
        }
        elseif($variation_code==="dstv43"){
            $amount = 20500;
        }
        elseif($variation_code==="complus-frenchtouch"){
            $amount = 14700;
        }
        elseif($variation_code==="dstv45"){
            $amount = 14900;
        }
        elseif($variation_code==="complus-french-extraview"){
            $amount = 23000;
        }
        elseif($variation_code==="dstv47"){
            $amount = 16000;
        }
        elseif($variation_code==="dstv48"){
            $amount = 21100;
        }
        elseif($variation_code==="dstv61"){
            $amount = 23000;
        }
        elseif($variation_code==="dstv62"){
            $amount = 28050;
        }
        elseif($variation_code==="hdpvr-access-service"){
            $amount = 2500;
        }
        elseif($variation_code==="frenchplus-addon"){
            $amount = 8100;
        }
        elseif($variation_code==="asia-addon"){
            $amount = 6200;
        }
        elseif($variation_code==="frenchtouch-addon"){
            $amount = 2300;
        }
        elseif($variation_code==="extraview-access"){
            $amount = 2500;
        }
        elseif($variation_code==="french11"){
            $amount = 3260;
        }
    }
    elseif($service_id==="gotv")
    {
        if($variation_code==="gotv-smallie")
        {
            $amount = 800;
        }
        elseif($variation_code==="gotv-max"){
            $amount = 3600;
        }
        elseif($variation_code==="gotv-jolli"){
            $amount = 2460;
        }
        elseif($variation_code==="gotv-jinja"){
            $amount = 1640;
        }
        elseif($variation_code==="gotv-smallie-3months"){
            $amount = 2100;
        }
        elseif($variation_code==="gotv-smallie-1year"){
            $amount = 6200;
        }

    }
    elseif($service_id==="startimes")
    {
        if($variation_code==="nova")
        {
            $amount = 900;
        }
        elseif($variation_code==="basic"){
            $amount = 1700;
        }
        elseif($variation_code==="smart"){
            $amount = 2200;
        }
        elseif($variation_code==="classic"){
            $amount = 2500;
        }
        elseif($variation_code==="super"){
            $amount = 4200;
        }
        elseif($variation_code==="nova-weekly"){
            $amount = 300;
        }
        elseif($variation_code==="basic-weekly"){
            $amount = 600;
        }
        elseif($variation_code==="smart-weekly"){
            $amount = 2500;
        }
        elseif($variation_code==="classic-weekly"){
            $amount = 1200;
        }
        elseif($variation_code==="smart-weekly"){
            $amount = 700;
        }
        elseif($variation_code==="super-weekly"){
            $amount = 1500;
        }
        elseif($variation_code==="basic-daily"){
            $amount = 160;
        }
        elseif($variation_code==="nova-daily"){
            $amount = 90;
        }
        elseif($variation_code==="smart-daily"){
            $amount = 200;
        }
        elseif($variation_code==="super-daily"){
            $amount = 400;
        }
        elseif($variation_code==="classic-daily"){
            $amount = 320;
        }



    }


    if($variation_code=="custom" && $service_id =="gotv")
    {
        $variation_code = "gotv-smallie";
    }
    elseif($variation_code == "dstv_custom" && $service_id =="dstv")
    {
        $variation_code = "dstv-padi";
    }
    elseif($variation_code == "startimes_custom" && $service_id =="startimes")
    {
        $variation_code = "nova";
    }

    if($variation_code == "custom"){
    $bill = $amount + 50;

    }else{
        $bill = $amount;
    }



    if( $info['wallet'] < $bill){
      echo "low-balance";
       exit;
    }


        $username = "ayodeleajisegiri@gmail.com";
        $password = "Jesusanu9309!";
        $encoded =  base64_encode($username.":".$password);
        $generate_id = substr(str_shuffle(md5(time())), 0, 10);
        $url = "https://vtpass.com/api/pay?request_id=$generate_id&serviceID=$service_id&variation_code=$variation_code&phone=09010768387&billersCode=$smart_card_number&amount=$amount";

        //open connection
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Basic ".$encoded
            ),
            ));

          //execute post
           $result = curl_exec($curl);
           $response = json_decode($result,true);
           $err = curl_error($curl);
           curl_close($curl);
        //   echo $service_id.'  '.$variation_code. '  '.$result;
        //   exit;


    if($response['code'] === "000" && $response['content']['transactions']['status']==="delivered"){
        $trans_id = random_int(99999,999999999);
        mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Cable Tv','$amount','completed',NOW(),'Cable Tv bill payment via Vtpass','$smart_card_number')");
        $pinnaview->debit_wallet($bill,$_SESSION['user_id']);
        echo "successful";

    }
    elseif($response['code'] === "000" && $response['content']['transactions']['status']!=="delivered")
    {
        echo "pending";
    }
    else{
        $trans_id = random_int(99999,999999999);
        mysqli_query($con,"INSERT INTO failed_transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Cable Tv','$amount','failed',NOW(),'Cable Tv bill payment via Vtpass','$smart_card_number')");
       echo $response['content']['errors'];
       echo "request-failed";
    }
    }
    elseif($vendor == "clubconnect")
    {
        $cable_network = $_POST['cable-network'];
        $smart_card_number = $_POST['smart-card-no'];
        $productCode = $_POST['type'];

        if($cable_network == "gotv"){
            if($productCode == "gotv-max"){
                $amount = "3600";
            }
            elseif($productCode =="gotv-jolli")
            {
                $amount = "2460";
            }
            elseif($productCode ="gotv-jinja")
            {
                $amount = "1640";
            }
            elseif($productCode =="gotv-smallie")
            {
                $amount ="800";
            }elseif($productCode == "gotv-smallie-3months")
            {
                $amount ="2100";
            }elseif($productCode == "gotv-smallie-1year")
            {
                $amount ="6200";
            }
        }else if($cable_network == "dstv"){
            if($productCode == "dstv-padi"){
                $amount = "1850";
            }
            elseif($productCode =="dstv-yanga")
            {
                $amount = "2565";
            }
            elseif($productCode ="dstv-confam")
            {
                $amount = "4615";
            }
            elseif($productCode =="dstv79")
            {
                $amount ="7900";
            }elseif($productCode == "dstv3")
            {
                $amount ="18400";
            }elseif($productCode ="dstv6")
            {
                $amount =6200;
            }
            elseif($productCode =="dstv7")
            {
                $amount = 12400;
            }
            elseif($productCode =="dstv9")
            {
                $amount = 25550;
            }
            elseif($productCode=="dstv10")
            {
                $amount = 20500;
            }
            elseif($productCode=="confam-extra")
            {
                $amount =7115;
            }
            elseif($productCode=="yanga-extra")
            {
                $amount =5065;
            }
            elseif($productCode =="padi-extra")
            {
                $amount =4350;
            }
            elseif($productCode=="com-asia")
            {
                $amount =4100;
            }
            elseif($productCode=="dstv30")
            {
                $amount =10400;
            }
            elseif($productCode=="com-frenchtouch")
            {
                $amount = 10200;
            }
            elseif($productCode=="dstv33")
            {
                $amount =20900;
            }
            elseif($productCode=="dstv40")
            {
                $amount =18600;
            }
            elseif($productCode =="com-frenchtouch-extra")
            {
                $amount =12700;
            }
            elseif($productCode =="com-asia-extra")
            {
                $amount = 16600;
            }
            elseif($productCode =="dstv43")
            {
                $amount = 20500;
            }
            elseif($productCode=="complus-frenchtouch")
            {
                $amount =14700;
            }
            elseif($productCode=="dstv45")
            {
                $amount = 14900;
            }
            elseif($productCode =="complus-french-extraview")
            {
                $amount = 23000;
            }
            elseif($productCode =="dstv47")
            {
                $amount =16000;
            }
            elseif($productCode =="dstv48")
            {
                $amount = 21100;
            }
            elseif($productCode =="dstv61")
            {
                $amount = 23000;
            }
            elseif($productCode =="dstv62")
            {
                $amount =28000;
            }
            elseif($productCode =="hdpvr-access-service")
            {
                $amount = 2500;
            }
            elseif($productCode =="frenchplus-addon")
            {
                $amount = 8100;
            }
            elseif($productCode =="asia-addon")
            {
                $amount =6200;
            }
            elseif($productCode =="frenchtouch-addon")
            {
                $amount = 2300;
            }
            elseif($productCode =="extraview-access")
            {
                $amount =2500;
            }
            elseif($productCode =="french11")
            {
                $amount = 3260;
            }
        }else if($cable_network == "startimes"){
            if($productCode == "nova"){
                $amount = "900";
            }
            elseif($productCode =="basic")
            {
                $amount = "1700";
            }
            elseif($productCode =="smart")
            {
                $amount = "2200";
            }
            elseif($productCode =="classic")
            {
                $amount = "2500";
            }
            elseif($productCode =="super")
            {
                $amount = "4200";
            }
            elseif($productCode =="nova-weekly")
            {
                $amount = "300";
            }
            elseif($productCode =="basic-weekly")
            {
                $amount = "600";
            }
            elseif($productCode =="smart-weekly")
            {
                $amount = "700";
            }
            elseif($productCode =="classic-weekly")
            {
                $amount = "1200";
            }
            elseif($productCode =="super-weekly")
            {
                $amount = "1500";
            }
            elseif($productCode =="nova-daily")
            {
                $amount = "90";
            }
            elseif($productCode =="basic-daily")
            {
                $amount = "160";
            }
            elseif($productCode =="smart-daily")
            {
                $amount = "200";
            }
            elseif($productCode =="classic-daily")
            {
                $amount = "320";
            }
            elseif($productCode =="super-daily")
            {
                $amount = "400";
            }
        }
        if($productCode == "gotv_custom" || $productCode == "dstv_custom" || $productCode == "startimes_custom"){
        $bill = $amount + 50;
        }else{
            $bill = $amount;
        }
        if( $info['wallet'] < $bill){
          echo "low-balance";
           exit;
        }





	        $url = "https://www.nellobytesystems.com/APICableTVV1.asp?UserID=CK13617693&APIKey=5DC3EDIY1O864SSIUGL49CGXMOD81I638123805EMY9364UGK7125SG55GF7S56N&CableTV=".$cable_network."&Package=".$productCode."&SmartCardNo=".$smart_card_number;

			      //open connection
			  $ch = curl_init();
			    curl_setopt($ch,CURLOPT_URL, $url);
			  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			   curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
			     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects


			  //execute post
			   $result = curl_exec($ch);
			   $response = json_decode($result,true);
			    $err = curl_error($ch);
				  curl_close($ch);

        if($response['status'] === "ORDER_RECEIVED"){
            echo "successful";
            $trans_id = random_int(99999,999999999);
            mysqli_query($con,"INSERT INTO transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Cable Tv','$amount','completed',NOW(),'Cable Tv bill payment','$smart_card_number')");
            $pinnaview->debit_wallet($bill,$_SESSION['user_id']);
            echo "successful";
        }else{
             $trans_id = random_int(99999,999999999);
        mysqli_query($con,"INSERT INTO failed_transactions (user_id,transaction_id,service,amount,status,date, description,recipient) VALUES('{$_SESSION['user_id']}','$trans_id','Cable Tv','$amount','failed',NOW(),'Cable Tv bill payment via Clubconnect','$smart_card_number')");


            echo "request-failed";
        }
    }
}
}
mysqli_close($con);
?>
