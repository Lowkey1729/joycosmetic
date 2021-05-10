<?php
include '../../includes/cfg.php';

$connection = $pinnaview->is_loggedin();

 $userid = $_SESSION['user_id'];
 $info = $pinnaview->get_user_details($userid);
if (!$connection) {
  header("location: ../../");
}
if(!isset($_GET['s']) || in_array($_GET['s'],array("airtime","data","electricity","cable")) == false){
$_GET['s'] = 'airtime';
}

if($_GET['s'] == 'airtime'){
    $serviceDescription = 'Buy airtime';
}else if($_GET['s'] == 'data'){
    $serviceDescription = 'Buy data';
}else if($_GET['s'] == 'electricity'){
    $serviceDescription = "Pay electricity bills";
}else if($_GET['s'] == 'cable'){
    $serviceDescription =  "Cable TV";
}
$con = $pinnaview->database();
 $info = $pinnaview->get_user_details($userid);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
        name="viewport">
    <meta name="theme-color" content="#0D0C48">
    <title>Dashboard &mdash; PinnaView</title>
    <link rel="stylesheet" href="../pinna/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../pinna/modules/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../pinna/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../pinna/css/style.css">
    <!-- Facebook Pixel Code -->
    <script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '827112748047925');
    fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=827112748047925&ev=PageView
&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body>
    <?php
 include("../head.php");
 ?>
    <div class="main-content">
        <section class="section">
            <h3 class="section-header">
                <div> <?php echo $serviceDescription?></div>
            </h3>
            <div class="row">

                <div class="col-lg-5 col-md-12 col-12 col-sm-12">

                    <div class="card" style="padding:0 5px">

                        <div class="card-body">

                            <div class="row">
                                <div id="display-msg"></div>
                                <style>
                                #service-dropdown,
                                select,
                                input {
                                    width: 100%;
                                    padding: 5px;
                                    margin-bottom: 10px
                                }

                                #airtime-form,
                                #data-form,
                                .data-form,
                                #electricity-form,
                                #cable-form {
                                    width: 100%
                                }

                                #display-msg {
                                    padding: 5px 8px;
                                    margin: 5px 0;
                                    '
width: 100%;
                                    font-size: 15px
                                }
                                </style>
                                <input type="text"
                                    value="Wallet balance: ₦<?php echo number_format($info['wallet'],2) ?>" disabled />
                                <?php
                if($_GET['s'] == 'airtime' ){
                    ?>
                                <div style="padding:5px">
                                    Note: Type the phone number in this pattern 08102675393. Leave no space in between.
                                    Thanks.
                                </div>
                                <?php
                    $vquery = mysqli_query($con,"select * from vendors where operator = '9mobile' and service ='vtu' ");
                    $result = mysqli_fetch_assoc($vquery);
                    $vendor = $result['vendor'];
                    ?>
                                <form id="airtime-form">
                                    <Select name="network" class="form-control" id="network-selection">
                                        <option value="">Select your network</option>


                                        <option value="airtel">AIRTEL</option>
                                        <?php if($vendor=='vtpass'): ?>
                                        <option value="etisalat">9MOBILE</option>
                                        <?php else: ?>
                                        <option value="9mobile">9MOBILE</option>
                                        <?php endif; ?>

                                        <option value="glo">Glo</option>
                                        <option value="mtn">MTN</option>
                                    </Select>
                                    <input type="text" class="form-control" id="airtime-phone-number"
                                        name="airtime-phone-number" placeholder="Enter your phone number" />
                                    <input type="number" class="form-control" id="airtime-amount" name="airtime-amount"
                                        placeholder="Enter the amount" />
                                    <input type="text" disabled class="form-control" id="paying-airtime-amount"
                                        name="-paying-airtime-amount" placeholder="Amount to pay (Discount)" />
                                    <input type="hidden" name="service" value="airtime" />
                                    <button id="buy-airtime-btn" class="form-control ">Buy</button>
                                </form>


                                <?php
                }else if($_GET['s'] == 'data' ){
                    ?>
                                <style>
                                .data-form {
                                    display: none
                                }
                                </style>
                                <div style="padding:5px">
                                    Note: Type the phone number in this pattern 08102675393. Leave no space in between.
                                    Thanks.
                                </div>
                                <!------
                    <div style="padding:5px">
                 First MTN SME data transaction attracts additional ₦15/gb (billed daily).
                    </div>

                    ------>
                                <br>
                                <br>
                                <br>
                                <?php
                    $vquery = mysqli_query($con,"select * from vendors where operator = 'glo' and service ='data' ");
                    $result = mysqli_fetch_assoc($vquery);
                    $vendor = $result['vendor'];

                    $vquery1 = mysqli_query($con,"select * from vendors where operator = '9mobile' and service ='data' ");
                    $result1 = mysqli_fetch_assoc($vquery1);
                    $vendor1 = $result1['vendor'];

                    $vquery2 = mysqli_query($con,"select * from vendors where operator = 'airtel' and service ='data' ");
                    $result2 = mysqli_fetch_assoc($vquery2);
                    $vendor2 = $result2['vendor'];

                    $vquery3 = mysqli_query($con,"select * from vendors where operator = 'mtn' and service ='data' ");
                    $result3 = mysqli_fetch_assoc($vquery3);
                    $vendor3 = $result3['vendor'];
                    ?>


                                <Select name="network" id="data-network-selection" class="form-control">
                                    <option value="">Select your network</option>



                                    <?php if($vendor=='vtpass'): ?>
                                    <option value="glo-data">GLO</option>
                                    <?php else: ?>
                                    <option value="glo">GLO</option>
                                    <?php  endif; ?>

                                    <?php if($vendor1=='vtpass'): ?>
                                    <option value="etisalat-data">9MOBILE</option>
                                    <?php else: ?>
                                    <option value="9mobile">9MOBILE</option>
                                    <?php  endif; ?>

                                    <?php if($vendor2=='vtpass'): ?>
                                    <option value="airtel-data">AIRTEL</option>
                                    <?php else: ?>
                                    <option value="airtel">AIRTEL</option>
                                    <?php endif; ?>


                                    <?php if($vendor3=='vtpass'): ?>
                                    <option value="mtn-data">MTN SME Data</option>
                                    <option value="mtn_d">MTN Direct Data</option>
                                    <?php else: ?>
                                    <option value="mtn">MTN SME Data</option>
                                    <option value="mtn_d">MTN Direct Data</option>
                                    <?php endif; ?>




                                </Select>

                                <form id="mtn-data-form" class="data-form">
                                    <div id="mtn-data-options" class="data-options">
                                        <select class="form-control" id="select-data-plan" name="data-plan-code">
                                            <option value="">Select data plan</option>
                                            <?php

                    $vquery = mysqli_query($con,"select * from vendors where operator = 'mtn' and service ='data' ");
                    $result = mysqli_fetch_assoc($vquery);
                    $vendor = $result['vendor'];
                    if($vendor=='pinnaview'){
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'MTN Data SME' AND vendor='pinnaview' ORDER BY price ASC");
                    }
                    elseif($vendor=="smart-recharge")
                    {
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'MTN DATA SME' AND vendor='smartrecharge' ORDER BY price ASC");
                    }elseif($vendor=="clubconnect"){
                         $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'MTN DATA SME'  AND vendor='clubconnect' ORDER BY price ASC");
                    }

                    while($row = mysqli_fetch_assoc($sql)){
                      $price = $row['price'];
                      $value = $row['value'];
                      $code = $row['code']
                    ?>
                                            <option value="<?php echo $code; ?>">
                                                <?php echo $value."MB - ₦". number_format($price)?> </option>
                                            <?php
                    }
                    ?>
                                        </select>
                                    </div>
                                    <input type="number" class="form-control" id="data-phone-number"
                                        name="data-phone-number" placeholder="Enter your phone number" />
                                    <input type="hidden" name="service" value="data" />
                                    <?php if($vendor=="vtpass"): ?>
                                    <input type="hidden" name="network" value="mtn-data" />
                                    <?php else: ?>
                                    <input type="hidden" name="network" value="mtn" />
                                    <input type="hidden" name="name" value="MTN DATA SME" />
                                    <?php endif; ?>
                                </form>

                                <form id="mtn_d-data-form" class="data-form">
                                    <div id="mtn-data-options" class="data-options">
                                        <select class="form-control" id="select-data-plan" name="data-plan-code">
                                            <option value="">Select data plan</option>
                                            <?php
                    $vquery = mysqli_query($con,"select * from vendors where operator = 'mtn-direct' and service ='data' ");
                    $result = mysqli_fetch_assoc($vquery);
                    $vendor = $result['vendor'];
                    if($vendor == "smart-recharge")
                    {
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'MTN Direct Data' AND vendor='smartrecharge' ORDER BY price ASC ");
                    }
                    elseif($vendor=="clubconnect"){
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'MTN DATA ' AND vendor='clubconnect' ORDER BY price ASC");
                    }
                    elseif($vendor=="vtpass"){
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'MTN DATA ' AND vendor='vtpass' ORDER BY price ASC");
                    }
                    while($row = mysqli_fetch_assoc($sql)){
                      $price = $row['price'];
                      $value = $row['value'];
                      $code = $row['code']
                    ?>
                                            <option value="<?php echo $code; ?>">
                                                <?php echo $value." - ₦". number_format($price)?> </option>
                                            <?php
                    }
                    ?>
                                        </select>
                                    </div>
                                    <input type="number" class="form-control" id="data-phone-number"
                                        name="data-phone-number" placeholder="Enter your phone number" />
                                    <input type="hidden" name="service" value="data" />
                                    <?php if($vendor=="vtpass"): ?>
                                    <input type="hidden" name="network" value="mtn-data" />
                                    <?php else: ?>
                                    <input type="hidden" name="network" value="mtn-direct" />
                                    <input type="hidden" name="name" value="MTN DATA" />
                                    <?php endif; ?>

                                </form>

                                <form id="glo-data-form" class="data-form">
                                    <div id="glo-data-options" class="data-options">
                                        <select class="form-control" id="select-data-plan" name="data-plan-code">
                                            <option value="">Select data plan</option>
                                            <?php
                    $vquery = mysqli_query($con,"select * from vendors where operator = 'glo' and service ='data' ");
                    $result = mysqli_fetch_assoc($vquery);
                    $vendor = $result['vendor'];
                    if($vendor == 'smart-recharge' || $vendor=='pinnaview'){
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'GLO Data SME' ORDER BY price ASC");
                    }
                    elseif($vendor=="vtpass")
                    {
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'Glo Data' AND vendor='vtpass' ORDER BY price ASC");
                    }elseif($vendor=='pinnaview'){
                         $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'GLO GIFT DATA' AND vendor='pinnaview' ORDER BY price ASC");
                    }
                    elseif($vendor=='clubconnect'){
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'GLO DATA' AND vendor='clubconnect' ORDER BY price ASC");
                   }

                    while($row = mysqli_fetch_assoc($sql)){
                      $price = $row['price'];
                      $value = $row['value'];
                      $code = $row['code']
                    ?>
                                            <option value="<?php echo $code; ?>">
                                                <?php echo $value." - ₦". number_format($price)?> </option>
                                            <?php
                    }
                    ?>
                                        </select>
                                    </div>
                                    <input type="number" class="form-control" id="data-phone-number"
                                        name="data-phone-number" placeholder="Enter your phone number" />
                                    <input type="hidden" name="service" value="data" />
                                    <?php if($vendor=="vtpass"): ?>
                                    <input type="hidden" name="network" value="glo-data" />
                                    <?php else: ?>
                                    <input type="hidden" name="network" value="glo" />
                                    <input type="hidden" name="name" value="GLO DATA" />
                                    <?php endif; ?>
                                </form>

                                <!-- Airtel data selection -->
                                <form id="airtel-data-form" class="data-form">
                                    <div id="airtel-data-options" class="data-options">
                                        <select class="form-control" id="select-data-plan" name="data-plan-code">
                                            <option value="">Select data plan</option>
                                            <?php

                    $vquery = mysqli_query($con,"select * from vendors where operator = 'airtel' and service ='data' ");
                    $result = mysqli_fetch_assoc($vquery);
                    $vendor = $result['vendor'];
                    if($vendor == 'smart-recharge' || $vendor=="pinnaview"){
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'AIRTEL Data SME' ORDER BY price ASC");
                    }
                    elseif($vendor=="vtpass")
                    {
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'Airtel Data' AND vendor='vtpass' ORDER BY price ASC");
                    }elseif($vendor=="clubconnect"){
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = 'AIRTEL DATA' AND vendor='clubconnect' ORDER BY price ASC");
                    }

                    while($row = mysqli_fetch_assoc($sql)){
                      $price = $row['price'];
                      $value = $row['value'];
                      $code = $row['code']
                    ?>


                                            <option value="<?php echo $code; ?>">
                                                <?php echo $value." - ₦". number_format($price)?> </option>
                                            <?php
                    }
                    ?>
                                        </select>
                                    </div>
                                    <input type="number" class="form-control" id="data-phone-number"
                                        name="data-phone-number" placeholder="Enter your phone number" />
                                    <input type="hidden" name="service" value="data" />
                                    <?php if($vendor=="vtpass"): ?>
                                    <input type="hidden" name="network" value="airtel-data" />
                                    <?php else: ?>
                                    <input type="hidden" name="network" value="airtel" />
                                    <input type="hidden" name="name" value="AIRTEL DATA" />
                                    <?php endif; ?>
                                </form>

                                <form id="9mobile-data-form" class="data-form">
                                    <div id="9mobile-data-options" class="data-options">
                                        <select class="form-control" id="select-data-plan" name="data-plan-code">
                                            <option value="">Select data plan</option>
                                            <?php
                     $vquery = mysqli_query($con,"select * from vendors where operator = '9mobile' and service ='data' ");
                    $result = mysqli_fetch_assoc($vquery);
                    $vendor = $result['vendor'];
                    if($vendor == 'smart-recharge'){
                       $sql = mysqli_query($con,"SELECT * FROM products WHERE name = '9MOBILE Data SME' ORDER BY price ASC");
                    }
                    elseif($vendor=="vtpass")
                    {
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = '9mobile Data' AND vendor='vtpass' ORDER BY price ASC");
                    }
                    elseif($vendor=="pinnaview"){
                       $sql = mysqli_query($con,"SELECT * FROM products WHERE name = '9MOBILE GIFT DATA' ORDER BY price ASC");
                    }
                    elseif($vendor=="clubconnect")
                    {
                        $sql = mysqli_query($con,"SELECT * FROM products WHERE name = '9mobile DATA' AND vendor='clubconnect' ORDER BY price ASC");
                    }


                    while($row = mysqli_fetch_assoc($sql)){
                      $price = $row['price'];
                      $value = $row['value'];
                      $code = $row['code']
                    ?>
                                            <option value="<?php echo $code; ?>">
                                                <?php echo $value." - ₦". number_format($price)?> </option>
                                            <?php
                    }
                    ?>
                                        </select>
                                    </div>
                                    <input type="text" class="form-control" id="data-phone-number"
                                        name="data-phone-number" placeholder="Enter your phone number" />
                                    <input type="hidden" name="service" value="data" />
                                    <?php if($vendor=="vtpass"): ?>
                                    <input type="hidden" name="network" value="etisalat-data" />
                                    <?php else: ?>
                                    <input type="hidden" name="network" value="9mobile" />
                                    <input type="hidden" name="name" value="9mobile DATA" />
                                    <?php endif; ?>

                                </form>

                                <button id="buy-data-btn" class="form-control buy-data-btn">Buy</button>



                                <?php
                }else if($_GET['s'] == 'electricity'){
                    $vquery = mysqli_query($con,"select * from vendors where service ='electricity' ");
                    $result = mysqli_fetch_assoc($vquery);
                    $vendor = $result['vendor'];
                  ?>

                                <form id="electricity-form">
                                    <select name="electricity-company" id="electricity-company" class="form-control">
                                        <?php if($vendor =="smart-recharge"): ?>
                                        <option value="">Select electricity Company</option>
                                        <option value="aedc">Abuja Distribution Company</option>
                                        <option value="knedc">Kaduna Distribution Company</option>
                                        <option value="kedc">Kano Distribution Company</option>
                                        <option value="yedc">Yola Distribution Company</option>
                                        <option value="jedc">Jos Distribution Company</option>
                                        <option value="ibedc">Ibadan Distribution Company</option>
                                        <option value="ikedc">Ikeja Distribution Company</option>
                                        <option value="ekedc">Eko Distribution Company</option>
                                        <option value="bedc">Benin Distribution Company</option>
                                        <option value="eedc">Enugu Distribution Company</option>
                                        <option value="phed">Port Harcourt Distribution Company</option>
                                        <?php elseif($vendor =="vtpass"): ?>
                                        <option value="">Select electricity Company</option>
                                        <option value="aedc">Abuja Distribution Company</option>
                                        <option value="knedc">Kaduna Distribution Company</option>
                                        <option value="kedc">Kano Distribution Company</option>
                                        <option value="jedc">Jos Distribution Company</option>
                                        <option value="ibedc">Ibadan Distribution Company</option>
                                        <option value="ikedc">Ikeja Distribution Company</option>
                                        <option value="ekedc">Eko Distribution Company</option>
                                        <option value="phedc">Port Harcourt Distribution Company</option>
                                        <?php elseif($vendor=="clubconnect"): ?>
                                        <option value="">Select electricity Company</option>
                                        <option value="aedc">Abuja Distribution Company</option>
                                        <option value="kaedc">Kaduna Distribution Company</option>
                                        <option value="kedc">Kano Distribution Company</option>
                                        <option value="jedc">Jos Distribution Company</option>
                                        <option value="ibedc">Ibadan Distribution Company</option>
                                        <option value="ikedc">Ikeja Distribution Company</option>
                                        <option value="ekedc">Eko Distribution Company</option>
                                        <option value="eedc">Enugu Distribution Company</option>
                                        <option value="phedc">Port Harcourt Distribution Company</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($vendor =="vtpass"): ?>

                                    <input type="number" class="form-control" name="phone"
                                        placeholder="Enter your Phone number">
                                    <?php endif; ?>
                                    <select name="meter-type" id="meter-type" class="form-control">
                                        <option value="">Select your meter type</option>
                                        <option value="prepaid">Prepaid</option>
                                        <option value="postpaid">Postpaid</option>
                                    </select>
                                    <input type="text" name="meter-number" id="meter-number"
                                        placeholder="Enter your meter number" class="form-control" />
                                    </select>
                                    <input type="number" name="electricity-bill" id="electricity-bill"
                                        placeholder="Amount" class="form-control" />
                                    <input type="text" id="total-electricity-bill" disabled placeholder="Total Amount"
                                        class="form-control" />
                                    <input type="hidden" name="service" value="electricity" />
                                </form>
                                <button id="verify-meter" class="form-control">Verify meter</button>
                                <button id="pay-electricity-bill" class="form-control">Pay</button>
                                <?php
                }else if($_GET['s'] == 'cable'){
                ?>
                                <form id="cable-form">
                                    <select name="cable-network" id="cable-network" class="form-control">
                                        <option value="">Select your cable network</option>
                                        <option value="dstv">DSTV</option>
                                        <option value="gotv">GOTV</option>
                                        <option value="startimes">STARTIMES</option>
                                    </select>
                                    <input type="hidden" name="service" value="cable" />
                                    <input type="text" name="smart-card-no" id="smart-card-no"
                                        placeholder="Smart card number" class="form-control" />

                                </form>
                                <button id="verify-sc" class="form-control">Verify smart card</button>
                                <button id="pay-cable-bill" class="form-control">Pay</button>
                                <?php
                }
                ?>


                            </div>

                        </div>

                    </div>

                </div>
                <?php
         if($_GET['s'] == 'data' ){
         ?>

                <div class="col-lg-5 col-md-12 col-12 col-sm-12">

                    <div class="card" style="padding:0 5px">
                        <div class="card-header">How to check your data balance</div>
                        <div class="card-body">
                            <ul>
                                <li> MTN - *461*4# (SME)</li>
                                <li> Etisalat - *228# </li>
                                <li> GLO - *127*0# </li>
                                <li> AirTel - *140# </li>
                            </ul>

                        </div>
                    </div>

                    <?php
         }
                  ?>
                </div>
                <?php
          include '../../footer.php';
          ?>



        </section>
    </div>

    </div>
    </div>
    <style>
    .bag {
        color: white;
        font-size: 15px;
        text-align: center;
    }

    .iconx {
        font-size: 20px;
    }
    </style>

    <script src="../pinna/modules/jquery.min.js"></script>
    <script src="../pinna/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../pinna/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../pinna/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
    <script src="../pinna/js/scripts.js"></script>
    <script src="../pinna/js/custom.js"></script>
    <script>
    $(document).ready(function() {
        $("#buy-data-btn,#electricity-bill,#pay-electricity-bill,.cable-bill,#pay-cable-bill,#total-electricity-bill")
            .hide()
        $(document).on("click", ".buy-data-btn", function(e) {
            e.preventDefault();
            $that = $(this);
            let active = $(".data-form:visible").attr("id");
            if ($(`#${active} #network-selection`).val() == "") {
                $("#display-msg").html("Select your network")
            } else if ($(`#${active} #select-data-plan`).val() == "") {
                $("#display-msg").html("Select your data plan")
            } else if ($(`#${active} #data-phone-number`).val() == "") {
                $("#display-msg").html("Enter a valid phone number")
            } else {
                let form = $(".data-form:visible").attr("id")
                let data = $(`#${form}`).serialize();
                $that.attr("disabled", true);
                $that.html("Processing...")
                $.ajax({
                    url: "process/",
                    method: "POST",
                    data: data,
                    complete: function() {
                        $that.removeAttr("disabled");
                        $that.html("Buy")
                    },
                    success: function(data) {
                        if (data == "low-balance") {
                            $("#display-msg").html(
                                "Insufficient balance, fund your wallet.")
                        } else if (data == "request-failed") {
                            $("#display-msg").html("Request failed, try again.")
                        } else if (data == "successful") {
                            $("#display-msg").html("Data recharge successfull")
                            $(`#${form}`).val("");
                            window.location.href = "success/";

                        } else {
                            $("#display-msg").html(data);
                        }

                    }
                })
            }

        })

        function round(value, precision) {
            var multiplier = Math.pow(10, precision || 0);
            return Math.round(value * multiplier) / multiplier;
        }

        function airtimeRate() {
            if ($("#airtime-amount").val() != "" && $("#network-selection").val() != "") {
                let network = $("#network-selection").val();
                let airtime = $("#airtime-amount").val();
                let totalAmount;
                if (network == "mtn") {
                    totalAmount = (97.0 / 100) * airtime;
                } else if (network == "glo") {
                    totalAmount = (93.7 / 100) * airtime;
                } else if (network == "airtel") {
                    totalAmount = (96.5 / 100) * airtime;
                } else if (network == "9mobile") {
                    totalAmount = (96.5 / 100) * airtime;
                } else if (network == "etisalat") {
                    totalAmount = (96.5 / 100) * airtime;
                }
                $("#paying-airtime-amount").val(`₦${round(totalAmount,1)}`);

            }
        }
        $(document).on("change", "#network-selection", function() {
            airtimeRate()
        })
        $(document).on("keyup", "#airtime-amount", function() {
            airtimeRate()
        })
        $(document).on("click", "#buy-airtime-btn", function(e) {
            e.preventDefault();
            $("#display-msg").html("");
            $that = $(this);
            if ($("#network-selection").val() == "") {
                $("#display-msg").html("Select your network")
            } else if ($("#airtime-phone-number").val() == "" || $("#airtime-phone-number").val()
                .length != 11) {
                $("#display-msg").html("Enter a valid phone number")
            } else if ($("#airtime-amount").val() == "") {
                $("#display-msg").html("Enter the amount of airtime.")
            } else if (Number($("#airtime-amount").val()) < 50) {
                $("#display-msg").html("Airtime ammount too low, min. is NGN50")
            } else {
                let data = $("#airtime-form").serialize();
                $that.attr("disabled", true);
                $that.html("Processing...")
                $.ajax({
                    url: "process/",
                    method: "POST",
                    data: data,
                    complete: function() {
                        $that.removeAttr("disabled");
                        $that.html("Buy")
                    },
                    success: function(data) {
                        if (data == "low-balance") {
                            $("#display-msg").html(
                                "Insufficient balance, fund your wallet.")
                        } else if (data == "request-failed") {
                            $("#display-msg").html("Request failed, try again.")
                        } else if (data == "successful") {
                            $("#display-msg").html("Recharge successful");
                            window.location.href = "success/";
                            $("#airtime-form input").val('')
                        } else {
                            $("#display-msg").html(data);
                        }
                    }
                })
            }
        })
        $(document).on("change", "#data-network-selection", function() {

            let val = $(this).val();
            $('.data-form').hide();

            if (val == 'etisalat-data') {
                val = '9mobile';
            } else if (val == 'mtn-data') {
                val = 'mtn';
            } else if (val == 'airtel-data') {
                val = 'airtel';
            } else if (val == 'glo-data') {
                val = 'glo';
            }

            if (val == "") {
                $('.data-form').hide();
                $("#buy-data-btn").hide()
            } else {
                $('#' + val + '-data-form').show()
                $(`#buy-data-btn`).show()
            }


        })
        $(document).on("click", "#pay-electricity-bill", function() {
            $that = $(this);
            $("#display-msg").html("")
            if ($("#electricity-bill").val() == "") {
                $("#display-msg").html("Enter the amount you want to pay.")
            } else {
                $("#electricity-company,#meter-type,#meter-number").removeAttr("disabled")

                let data = $("#electricity-form").serialize();
                $that.attr("disabled", true);
                $that.html("Processing...");
                $.ajax({
                    url: "process/",
                    method: "POST",
                    data: data,
                    complete: function() {
                        $that.removeAttr("disabled");
                        $that.html("Pay")
                    },
                    success: function(data) {
                        if (data == "low-balance") {
                            $("#display-msg").html(
                                "Insufficient balance, fund your wallet.")
                        } else if (data == "request-failed") {
                            $("#display-msg").html("Payment failed, please try again.")
                        } else {
                            $("#display-msg").html("Payment successful. Token:" + " " +
                                data);
                            $("#meter-name").remove()
                            $("#electricity-form input").val("");
                            $("#display-msg").html(data)
                            window.location.href = `success/?token=${data}`;
                        }

                    }
                })
            }

        })
        $(document).on("keyup", "#electricity-bill", function() {
            if ($("#electricity-bill").val() != "") {
                let bill = Number($("#electricity-bill").val()) + 50;

                $("#total-electricity-bill").val(`₦${round(bill,1)}`);

            }
        })
        $(document).on("click", "#verify-meter", function() {
            $("#display-msg").html("");
            $that = $(this);
            if ($("#electricity-company").val() == "") {
                $("#display-msg").html("Select your electricity company")
            } else if ($("#meter-type").val() == "") {
                $("#display-msg").html("Select your meter type.")
            } else if ($("#meter-number").val() == "") {
                $("#display-msg").html("Enter your meter number.")
            } else {
                let data = $("#electricity-form").serialize();
                $that.attr("disabled", true);
                $that.html("Verifying...");
                $.ajax({
                    url: "verify/",
                    method: "POST",
                    data: data,
                    complete: function() {
                        $that.removeAttr("disabled");
                        $that.html("Verify")
                    },
                    success: function(data) {
                        if (data == "request-failed") {
                            $("#display-msg").html("Verification failed.")
                        } else {
                            $('#display-msg').html(data);
                            $("#electricity-company,#meter-type,#meter-number").attr(
                                "disabled", true)
                            $(`<input type="text" value="${data}" id="meter-name" disabled/> class="form-control"`)
                                .insertAfter("#meter-number");
                            $("#verify-meter").hide()
                            $("#electricity-bill,#pay-electricity-bill,#total-electricity-bill")
                                .show()
                        }

                    }
                })
            }
        })
        $(document).on("change", "#cable-network", function() {
            $(".cable-bill").remove();
            <?php
 $vquery = mysqli_query($con,"select * from vendors where  service ='cable' ");
 $result = mysqli_fetch_assoc($vquery);
 $vendor = $result['vendor'];

?>
            <?php if($vendor=="smart-recharge"): ?>
            let dstvPackage = `
              <select name="amount" id="dstv-package" class="form-control cable-bill cable-amount">
                  <option value="">Select DSTV package</option>

                  <option value="custom">DSTV Custom </option>
                  <option value="1850">DSTV Padi - 1,850</option>
                  <option value="2600"> DSTV Yanga - 2,600</option>
                  <option value="4500"> DSTV Confam - 4,570</option>
                  <option value="6900">DSTV Compact - 7,865</option>
                  <option value="10800">DSTV Compact Plus - 12,289</option>
                  <option value="16100">DSTV Premium - 18,300</option>
                </select>`;
            let gotvPackage = `<select name="amount" id="gotv-package" class="form-control cable-bill cable-amount">
                  <option value="">Select GOTV package</option>
                   <option value="custom"> Gotv Custom </option>
                   <option value="725">Gotv Smallie - 725</option>

                  <option value="1630">Gotv Jinja - 1,630</option>
                  <option value="2473">Gotv Jolli - 2,473</option>
                  <option value="3250">Gotv max - 3,588</option>
                </select>`;

            let startimesPackage = `<select name="amount" id="startime-package" class="form-control cable-bill cable-amount">
            <option value="">Select STARTIMES package</option>
                  <option value="custom"> Custom </option>
                  <option value="890"> Nova - 890</option>
                  <option value="1290">Basic - 1,590</option>
                  <option value="1890">Smart - 2,090</option>
                  <option value="2590">Classic - 2,590</option>
                  <option value="3790">Super - 4,090</option>
                </select>`;
            <?php elseif($vendor=="vtpass"): ?>
            let dstvPackage = `
              <select name="variation_code" id="dstv-package" class="form-control cable-bill cable-amount">
                  <option value="">Select DSTV package </option>
                  <option value="custom">DSTV Custom </option>
                  <option value="dstv-padi">DSTV Padi - 1,850</option>
                  <option value="dstv-yanga">DStv Yanga N2,565</option>
                  <option value="dstv-confam"> Dstv Confam N4,615</option>
                  <option value="dstv79">DStv  Compact N7900</option>
                  <option value="dstv3">DStv Premium N18,400</option>
                  <option value="dstv6">DStv Asia N6,200</option>
                  <option value="dstv7">DStv Compact Plus N12,400</option>
                  <option value="dstv9">DStv Premium-French N25,550</option>
                  <option value="dstv10">DStv Premium-Asia N20,500</option>
                  <option value="confam-extra">DStv Confam + ExtraView N7,115</option>
                  <option value="yanga-extra">DStv Yanga + ExtraView N5,065</option>
                  <option value="padi-extra">DStv Padi + ExtraView N4,350</option>
                  <option value="com-asia">DStv Compact + Asia N14,100</option>
                  <option value="dstv30">DStv Compact + Extra View N10,400</option>
                  <option value="com-frenchtouch">DStv Compact + French Touch N10,200</option>
                  <option value="dstv33">DStv Premium - Extra View N20,900</option>
                  <option value="dstv40">DStv Compact Plus - Asia N18,600</option>
                  <option value="com-frenchtouch-extra">DStv Compact + French Touch + ExtraView N12,700</option>
                  <option value="com-asia-extra">DStv Compact + Asia + ExtraView N16,600</option>
                  <option value="dstv43">DStv Compact Plus + French Plus N20,500</option>
                  <option value="complus-frenchtouch">DStv Compact Plus + French Touch N14,700</option>
                  <option value="dstv45">DStv Compact Plus - Extra View N14,900</option>
                  <option value="complus-french-extraview">DStv Compact Plus + FrenchPlus + Extra View N23,000</option>
                  <option value="dstv47">DStv Compact + French Plus N16,000</option>
                  <option value="dstv48">DStv Compact Plus + Asia + ExtraView N21,100</option>
                  <option value="dstv61">DStv Premium + Asia + Extra View N23,000</option>
                  <option value="dstv62">DStv Premium + French + Extra View N28,000</option>
                  <option value="hdpvr-access-service">DStv HDPVR Access Service N2,500</option>
                  <option value="frenchplus-addon">DStv French Plus Add-on N8,100</option>
                  <option value="asia-addon">DStv Asian Add-on N6,200</option>
                  <option value="frenchtouch-addon">DStv French Touch Add-on N2,300</option>
                  <option value="extraview-access">ExtraView Access N2,500</option>
                  <option value="french11">DStv French 11 N3,260</option>
                </select>`;
            let gotvPackage = `<select name="variation_code" id="gotv-package" class="form-control cable-bill cable-amount">
                  <option value="">Select GOTV package</option>
                   <option value="custom"> Gotv Custom </option>
                   <option value="gotv-smallie">GOtv Smallie - monthly N800</option>

                  <option value="gotv-max">GOtv Max N3,600</option>
                  <option value="gotv-jolli">GOtv Jolli N2,460</option>
                  <option value="gotv-jinja">GOtv Jinja N1,640</option>
                  <option value="gotv-smallie-3months">GOtv Smallie - quarterly N2,100</option>
                  <option value="gotv-smallie-1year">GOtv Smallie - yearly N6,200</option>
                </select>`;

            let startimesPackage = `<select name="variation_code" id="startime-package" class="form-control cable-bill cable-amount">
                 <option value="">Select STARTIMES package</option>
                  <option value="custom"> Custom </option>
                  <option value="nova">Nova - 900 Naira - 1 Month</option>
                  <option value="basic">Basic - 1,700 Naira - 1 Month</option>
                  <option value="smart">Smart - 2,200 Naira - 1 Month</option>
                  <option value="super">Super - 4,200 Naira - 1 Month</option>
                  <option value="nova-weekly">Nova - 300 Naira - 1 Week</option>
                  <option value="basic-weekly">Basic - 600 Naira - 1 Week</option>
                  <option value="smart-weekly">Smart - 700 Naira - 1 Week</option>
                  <option value="classic-weekly">Classic - 1200 Naira - 1 Week</option>
                  <option value="super-weekly">Super - 1,500 Naira - 1 Week</option>
                  <option value="nova-daily">Nova - 90 Naira - 1 Day</option>
                  <option value="basic-daily">Basic - 160 Naira - 1 Day</option>
                  <option value="smart-daily">Smart - 200 Naira - 1 Day</option>
                  <option value="classic-daily">Classic - 320 Naira - 1 Day</option>
                  <option value="super-daily">Super - 400 Naira - 1 Day</option>


                </select>`;
            <?php elseif($vendor=="clubconnect"): ?>
            let dstvPackage = `
              <select name="type" id="dstv-package" class="form-control cable-bill cable-amount">
                  <option value="">Select DSTV package</option>

                  <option value="custom">DSTV Custom </option>
                  <option value="dstv-padi">DStv Padi N1,850</option>
                  <option value="dstv-yanga">DStv Yanga N2,565</option>
                  <option value="dstv-confam">	Dstv Confam N4,615</option>
                  <option value="dstv79">DStv Compact N7900</option>
                  <option value="dstv3">DStv Premium N18,400</option>
                  <option value="dstv6">DStv Asia N6,200</option>
                  <option value="dstv7">DStv Compact Plus N12,400</option>
                  <option value="dstv9">DStv Premium-French N25,550</option>
                  <option value="dstv10">DStv Premium-Asia N20,500</option>
                  <option value="confam-extra">DStv Confam + ExtraView N7,115</option>
                  <option value="yanga-extra">DStv Yanga + ExtraView N5,065</option>
                  <option value="padi-extra">DStv Padi + ExtraView N4,350</option>
                  <option value="com-asia">DStv Compact + Asia N14,100</option>
                  <option value="dstv30">DStv Compact + Extra View N10,400</option>
                  <option value="com-frenchtouch">DStv Compact + French Touch N10,200</option>
                  <option value="dstv33">DStv Premium - Extra View N20,900</option>
                  <option value="dstv40">DStv Compact Plus - Asia N18,600</option>
                  <option value="com-frenchtouch-extra">DStv Compact + French Touch + ExtraView N12,700</option>
                  <option value="com-asia-extra">DStv Compact + Asia + ExtraView N16,600</option>
                  <option value="dstv43">DStv Compact Plus + French Plus N20,500</option>
                  <option value="complus-frenchtouch">DStv Compact Plus + French Touch N14,700</option>
                  <option value="dstv45">DStv Compact Plus - Extra View N14,900</option>
                  <option value="complus-french-extraview">DStv Compact Plus + FrenchPlus + Extra View N23,000</option>
                  <option value="dstv47">DStv Compact + French Plus N16,000</option>
                  <option value="dstv48">DStv Compact Plus + Asia + ExtraView N21,100</option>
                  <option value="dstv61">DStv Premium + Asia + Extra View N23,000</option>
                  <option value="dstv62">DStv Premium + French + Extra View N28,000</option>
                  <option value="hdpvr-access-service">DStv HDPVR Access Service N2,500</option>
                  <option value="frenchplus-addon">DStv French Plus Add-on N8,100</option>
                  <option value="asia-addon">DStv Asian Add-on N6,200</option>
                  <option value="frenchtouch-addon">DStv French Touch Add-on N2,300</option>
                  <option value="extraview-access">ExtraView Access N2,500</option>
                  <option value="french11">DStv French 11 N3,260</option>
                </select>`;
            let gotvPackage = `<select name="type" id="gotv-package" class="form-control cable-bill cable-amount">
                  <option value="">Select GOTV package</option>
                   <option value="custom"> Gotv Custom </option>
                   <option value="gotv-max">GOtv Max N3,600</option>

                  <option value="gotv-jolli">GOtv Jolli N2,460</option>
                  <option value="gotv-jinja">GOtv Jinja N1,640</option>
                  <option value="gotv-smallie">GOtv Smallie - monthly N800</option>
                  <option value="gotv-smallie-3months">GOtv Smallie - quarterly N2,100</option>
                  <option value="gotv-smallie-1year">GOtv Smallie - yearly N6,200</option>
                </select>`;

            let startimesPackage = `<select name="type" id="startime-package" class="form-control cable-bill cable-amount">
            <option value="">Select STARTIMES package</option>
                  <option value="custom"> Custom </option>
                  <option value="nova">Nova - 900 Naira - 1 Month</option>
                  <option value="basic">Basic - 1,700 Naira - 1 Month</option>
                  <option value="smart">Smart - 2,200 Naira - 1 Month</option>
                  <option value="classic">Classic - 2,500 Naira - 1 Month</option>
                  <option value="super">Super - 4,200 Naira - 1 Month</option>
                  <option value="nova-weekly">Nova - 300 Naira - 1 Week</option>
                  <option value="basic-weekly">Basic - 600 Naira - 1 Week</option>
                  <option value="smart-weekly">Smart - 700 Naira - 1 Week</option>
                  <option value="classic-weekly">Classic - 1200 Naira - 1 Week</option>
                  <option value="super-weekly">Super - 1,500 Naira - 1 Week</option>
                  <option value="basic-daily">Basic - 160 Naira - 1 Day</option>
                  <option value="smart-daily">Smart - 200 Naira - 1 Day</option>
                  <option value="classic-daily">Classic - 320 Naira - 1 Day</option>
                  <option value="super-daily">Super - 400 Naira - 1 Day</option>

                </select>`;
            <?php endif;?>
            let c = $("#cable-network").val();
            if (c == "gotv") {
                $(`#cable-form`).append(`${gotvPackage}`);
            } else if (c == "dstv") {
                $(`#cable-form`).append(`${dstvPackage}`);
            } else if (c == "startimes") {
                $(`#cable-form`).append(`${startimesPackage}`);
            }

        })
        $(document).on("change", "#cable-network", function() {
            $("#custom-amount").remove();
            $("#to-c").remove()
        })
        $(document).on("change", ".cable-amount", function() {
            let value = $(this).val();
            if (value == "custom") {
                $(".cable-amount").hide();
                let customElement =
                    `<input type="number" name="amount" id="custom-amount" placeholder="Enter custom amount" class="form-control "/>`;
                $(customElement).insertAfter(".cable-amount")
                $(`<input type="text" value="" id="to-c" placeholder="Amount to pay:" disabled/> class="form-control"`)
                    .insertAfter("#custom-amount");
            } else {
                $("#custom-amount").remove();
                $("#to-c").remove()
            }
        })
        $(document).on("keyup", "#custom-amount", function() {
            let p = Number($(this).val());
            let pp = p + 50;
            $("#to-c").val(`Total Amount: NGN${pp}`)
        })
        $(document).on("click", "#verify-sc", function() {
            $("#display-msg").html("");

            $that = $(this);
            if ($("#cable-network").val() == "") {
                $("#display-msg").html("Select your cable tv")
            } else if ($("#smart-card-no").val() == "") {
                $("#display-msg").html("Enter your smart card number.")
            } else if ($(".cable-bill").val() == "") {
                $("#display-msg").html("Select your package.")
            } else if ($("#custom-amount").val() == "") {
                $("#display-msg").html("Enter your custom amount.")
            } else if (Number($("#custom-amount").val()) < 1) {
                $("#display-msg").html("Enter a valid amount amount.")
            } else {
                let data = $("#cable-form").serialize();
                $that.attr("disabled", true);
                $that.html("Verifying...");
                $.ajax({
                    url: "verify/",
                    method: "POST",
                    data: data,
                    complete: function() {
                        $that.removeAttr("disabled");
                        $that.html("Verify smart card")
                    },
                    success: function(data) {
                        if (data == "request-failed") {
                            $("#display-msg").html("Verification failed.")
                        } else {
                            $("#cable-network,#smart-card-no").attr("disabled", true)
                            $(`<input type="text" value="${data}" id="sc-name" disabled/> class="form-control"`)
                                .insertAfter("#smart-card-no");
                            $("#verify-sc").hide()
                            $(".cable-bill,#pay-cable-bill").show();

                        }

                    }
                })
            }
        })
        $(document).on("click", "#pay-cable-bill", function() {
            $that = $(this);
            $("#display-msg").html("")
            if ($(".cable-bill").val() == "") {
                $("#display-msg").html("Enter the amount you want to pay.")
            } else if ($("#custom-amount").val() == "") {
                $("#display-msg").html("Enter your custom amount.")
            } else if (Number($("#custom-amount").val()) < 1) {
                $("#display-msg").html("Enter a valid amount amount.")
            } else {
                $("#cable-network,#smart-card-no").removeAttr("disabled")

                let data = $("#cable-form").serialize();
                $that.attr("disabled", true);
                $that.html("Processing...");
                $.ajax({
                    url: "process/",
                    method: "POST",
                    data: data,
                    complete: function() {
                        $that.removeAttr("disabled");
                        $that.html("Pay")
                    },
                    success: function(data) {
                        if (data == "low-balance") {
                            $("#display-msg").html(
                                "Insufficient balance, fund your wallet.")
                        } else if (data == "request-failed") {
                            $("#display-msg").html("Payment failed, please try again.")
                        } else {
                            $("#display-msg").html(data);
                            $("#sc-name").remove()
                            $("#cable-form input").val("");
                            window.location.href = "success/";
                        }
                    }
                })
            }

        })
    })
    </script>
</body>

</html>

<?php
$con = $pinnaview->database();
mysqli_close($con);
?>
