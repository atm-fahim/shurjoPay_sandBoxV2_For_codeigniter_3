<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <!------ Include the above in your HEAD tag ---------->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- beauty font ROBOTO -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:100' rel='stylesheet' type='text/css'>
    <style>
    .hidden {
        display: none;
    }

    /* Font ROBOTO */
    .roboto {
        font-family: 'Roboto', sans-serif !important;
    }

    /* custom background for panel  */
    .container {
        padding-top: 50px !important;
        background-color: #f5f5f5 !important;
    }

    /* custom background header panel */
    .custom-header-panel {
        //background-color: #004b8e !important;
        border-color: #004b8e !important;
        color: white;
    }

    .no-margin-form-group {
        margin: 0 !important;
    }

    .requerido {
        color: red;
    }

    .btn-orange-md {
        background: #FF791F !important;
        border-bottom: 3px solid #ae4d13 !important;
        color: white;
    }

    .btn-orange-md:hover {
        background: #d86016 !important;
        color: white !important;
    }
    </style>
</head>

<body>

    <div id="container">
        <h1>Welcome to CodeIgniter!</h1>

        <div id="body">
            <form method="post" action="<?php echo base_url('check-out'); ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="panel">
                            <div class="panel-heading custom-header-panel">
                                <!--<h3 class="panel-title roboto">Pay Naw</h3>-->
                                <img src="<?php echo base_url('assets/shurjopay-logo.png'); ?>"
                                    data-holder-rendered="true" />
                            </div>
                            <div class="panel-body">

                                <div class="form-group">

                                    <label class="col-sm-4 control-label" for="name">Order ID<span class="requerido">
                                            *</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control orderid" id="name" name="order_id"
                                            value="<?php echo uniqid(); ?>" required="">
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-sm-4 control-label" for="name">Amount<span class="requerido">
                                            *</span></label>
                                    <div class="col-sm-8">

                                        <input type="text" class="form-control amt" id="name" name="amount" value=""
                                            oninvalid="this.setCustomValidity('Campo requerido')"
                                            oninput="setCustomValidity('')" required="">
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-sm-4 control-label" for="name">Customer Name<span
                                            class="requerido"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control cus_name" id="name" name="customer_name"
                                            value="" oninvalid="this.setCustomValidity('Campo requerido')" required="">
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-sm-4 control-label" for="name">Customer Phone No<span
                                            class="requerido"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="tel" class="form-control cus_phone" name="customer_phone" id="name"
                                            value="" required="">
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-sm-4 control-label" for="name">Customer City <span
                                            class="requerido"> *</span></label>
                                    <div class="col-sm-8">
                                        <input name="customer_city" type="text" class="form-control cus_city" id="name"
                                            value="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="name">Customer Address<span
                                        class="requerido"> *</span></label>
                                <div class="col-sm-8">
                                    <textarea name="customer_address" class="form-control cus_address"
                                        required=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="name">Customer Country<span
                                        class="requerido"> *</span></label>
                                <div class="col-sm-8">
                                    <input name="customer_country" class="form-control customer_country" required=""
                                        value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="name">Customer Post Code<span
                                        class="requerido"> *</span></label>
                                <div class="col-sm-8">
                                    <input name="customer_postcode" class="form-control customer_postcode" required=""
                                        value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="name">Customer Email</label>
                                <div class="col-sm-8">
                                    <input name="customer_state" type="text" class="form-control email" id="name"
                                        value="" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="name">currency<span class="requerido">
                                        *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control currency" name="currency" id="name"
                                        value="BDT" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="name">Return URL<span class="requerido">
                                        *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control return_url" name="return_url" id="name"
                                        value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="name">Cancle URL<span class="requerido">
                                        *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control cancel_url" name="cancel_url" id="name"
                                        value="" required="">
                                </div>
                            </div>

                            <!--Fin datos personales-->
                            <div class="form-group text-center">
                                <input type="submit" id="submit_btn" class="btn btn-success sub" value="Submit">
                                <div id="default" class="btn btn-info default">Default</div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>

    </div>
    </form>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.
        <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
    </p>
    </div>
    <script>
    function getRandomInteger(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }

    $('.default').on('click', function() {
        let amount = getRandomInteger(1, 15);
        $('.amt').val(amount);
        $('.cus_name').val('Abu tayeb md fahim');
        $('.cus_phone').val('01717302935');
        $('.cus_city').val('Dhaka');
        $('.return_url').val('<?php echo base_url('response'); ?>');
        $('.cancel_url').val('<?php echo base_url('canceled'); ?>');
        $('.customer_postcode').val('1212');
        $('.customer_country').val('Bangladesh');
        $('.cus_address').val('Gulshan 1,Dhaka 1212');
        $('.email').val('fahim@shurjopay.com.bd');
    });
    </script>

</body>

</html>