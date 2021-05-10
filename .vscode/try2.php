<?php
session_start();
include '../../includes/cfg.php';
$con = $pinnaview->database();
if($_POST['service'] == 'electricity'){
if($vendor =="smart-recharge")
{
$electricity_company = $_POST['electricity-company'];
$meter_type = $_POST['meter-type'];
$meter_number = $_POST['meter-number'];

$vquery = mysqli_query($con,"select * from vendors where  service ='cable' ");
 $result = mysqli_fetch_assoc($vquery);
 $vendor = $result['vendor'];

$headers = array( 'Content-Type: application/json');
$ch = curl_init();

curl_setopt( $ch,CURLOPT_URL, 'https://smartrecharge.ng/api/v2/electric/?api_key=0f572421&meter_number='.$meter_number.'&product_code='.$electricity_company.'_'.$meter_type.'_custom&task=verify');
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
$result = curl_exec($ch );
$resultJson = json_decode($result);

if($resultJson->text_status == "VERIFICATION SUCCESSFUL"){
    $_SESSION['customer-e'] =  $resultJson->data->name;
    echo $resultJson->data->name;
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

           $username = "ayodeleajisegiri@gmail.com";
           $password = "Jesusanu9309!";
           $encoded =  base64_encode($username.":".$password);
           $generate_id = substr(str_shuffle(md5(time())), 0, 10);
           $url = "https://vtpass.com/api/merchant-verify?billersCode=$meter_number&serviceID=$electricity_company&type=$meter_type";

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


           if($response['code'] === "000" && !isset($response['content']['error']))
           {
            $_SESSION['customer-e'] =  $response['content']['Customer_Name'];
            echo $response['content']['Customer_Name'];
            exit;
           }
           else
           {
             echo  $response['content']['errors'];
             exit;
           }
}
elseif($vendor =="clubconnect")
{
    if($electricity_company === "aedc")
{
    $electricity_company = "03";
}
elseif($electricity_company === "kaedc")
{
    $electricity_company ="08";
}
elseif($electricity_company === "kedc")
{
    $electricity_company = "04";
}
elseif($electricity_company === "eedc")
{
   $electricity_company = "09";
}
elseif($electricity_company === "jedc")
{
   $electricity_company = "06";
}
elseif($electricity_company === "ibedc")
{
    $electricity_company = "07";
}
elseif($electricity_company === "ikedc")
{
    $electricity_company = "02";
}
elseif($electricity_company === "ekedc")
{
 $electricity_company   = "01";
}
elseif($electricity_company === "phedc")
{
  $electricity_company  = "05";
}
$url ="https://www.nellobytesystems.com/APIVerifyElectricityV1.asp?UserID=CK13617693&APIKey=5DC3EDIY1O864SSIUGL49CGXMOD81I638123805EMY9364UGK7125SG55GF7S56N&ElectricCompany=".$electricity_company."&MeterNo=".$meter_number;
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


    $_SESSION['customer-e'] =  $response['customer_name'];
    echo $response['customer_name'];
}
}else if($_POST['service'] == 'cable'){
if($vendor=="smart-recharge")
{
    $cable_tv = $_POST['cable-network'];
    if($cable_tv == "gotv"){
        $productCode = "gotv_jolli";
    }else if($cable_tv == "dstv"){
        $productCode = "dstv_yanga";
    }else if($cable_tv == "startimes"){
        $productCode  = "startimes_nova";
    }
    $smart_card = $_POST['smart-card-no'];

    $headers = array( 'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://smartrecharge.ng/api/v2/tv/?api_key=0f572421&smartcard_number='.$smart_card.'&product_code='.$productCode.'&task=verify');
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    $result = curl_exec($ch );
    $resultJson = json_decode($result);

    if($resultJson->text_status == "VERIFICATION SUCCESSFUL"){
    if($cable_tv == "gotv" || $cable_tv == "dstv"){
       $_SESSION['customer-c'] =  $resultJson->data->name;
       echo strtoupper($resultJson->data->name);
    }else if($cable_tv == "startimes"){
        $_SESSION['customer-c'] =  $resultJson->data->name;
        echo strtoupper($resultJson->data->name);
    }

    }else{
        echo "request-failed";
    }
}
elseif($vendor=="vtpass")
{
    $serviceID = $_POST['cable-network'];
    if($cable_tv == "gotv"){
        $productCode = "gotv_jolli";
    }else if($cable_tv == "dstv"){
        $productCode = "dstv_yanga";
    }else if($cable_tv == "startimes"){
        $productCode  = "startimes_nova";
    }
       $smart_card = trim($_POST['smart-card-no']);
       $username = "ayodeleajisegiri@gmail.com";
       $password = "Jesusanu9309!";
       $encoded =  base64_encode($username.":".$password);
       $generate_id = substr(str_shuffle(md5(time())), 0, 10);
       $url = "https://vtpass.com/api/merchant-verify?billersCode=$smart_card&serviceID=$serviceID";

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

        //   echo $result;
        //   exit;


    if($response['code'] === "000"){
       $_SESSION['customer-c'] =  $response['content']['Customer_Name'];
       echo strtoupper($response['content']['Customer_Name']);
        exit;

    }else{
        echo "request-failed";
        exit;
    }
}
elseif($vendor=="clubconnect")
{
    $cable_tv = $_POST['cable-network'];
    if($cable_tv == "gotv"){
        $productCode = "02";
    }else if($cable_tv == "dstv"){
        $productCode = "01";
    }else if($cable_tv == "startimes"){
        $productCode  = "03";
    }
    $smart_card = $_POST['smart-card-no'];



	        $url = "https://www.nellobytesystems.com/APIVerifyCableTVV1.0.asp?UserID=CK13617693&APIKey=5DC3EDIY1O864SSIUGL49CGXMOD81I638123805EMY9364UGK7125SG55GF7S56N&cabletv=".$productCode."&Smartcardno=".$smart_card;

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




    if($cable_tv == "gotv" || $cable_tv == "dstv"){
       $_SESSION['customer-c'] =  $response['customer_name'];
       echo strtoupper($response['customer_name']);
    }else if($cable_tv == "startimes"){
        $_SESSION['customer-c'] =  $response['customer_name'];
        echo strtoupper($response['customer_name']);
    }
}
}
?>
