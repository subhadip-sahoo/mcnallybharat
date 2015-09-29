<?php
/* Template Name: Business Query */
session_start();
$err_msg = '';
$suc_msg = '';
if(isset($_POST['bq_submit'])){
//    echo '<pre>';
//    print_r($_POST);
    if(empty($_POST['Company_Name'])){
        $err_msg = 'Company name is required.';
    }
    else if(empty($_POST['Designation'])){
        $err_msg = 'Designation is required.';
    }
    else if(empty($_POST['Contact_No'])){
        $err_msg = 'Contact No is required.';
    }
    else if(empty($_POST['Subject'])){
        $err_msg = 'Subject is required.';
    }
    else if(empty($_POST['Name_of_Person'])){
        $err_msg = 'Name of Person is required.';
    }
    else if(empty($_POST['Email_Address'])){
        $err_msg = 'Email Address is required.';
    }
    else if(filter_var($_POST['Email_Address'], FILTER_VALIDATE_EMAIL) == FALSE){
        $err_msg = 'Please enter a vilid email address.';
    }
    else if(empty($_POST['Postal_Address'])){
        $err_msg = 'Postal Address is required.';
    }
    else if(empty($_POST['Interested_in'])){
        $err_msg = 'Please select the product that you have intersted in.';
    }
    if($err_msg == ''){
        if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
            $msg_body = '';
            foreach ($_POST as $key => $value) {
                if($key == 'security_code' || $key == 'hidden_data_rel' || $key == 'bq_submit'){
                    continue;
                }
//                if($key == 'Interested_in'){
//                    if(!empty($_POST['sub_products'])){
//                        $msg_body .= $_POST['Interested_in']." > ".$_POST['sub_products']."<br/>";
//                    }else{
//                        $msg_body .= str_replace('_', ' ', $key).": ".$value."<br/>";
//                    }
//                }else{
//                    $msg_body .= str_replace('_', ' ', $key).": ".$value."<br/>";
//                }
                $msg_body .= str_replace('_', ' ', $key).": ".$value."<br/>";
            }
            $to = get_option('admin_email');
            $from = $_POST['Email_Address'];
            $from_name = $_POST['Name_of_Person'];
            $headers = "From: $from_name <$from>\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = $_POST['Subject'];
            
            wp_mail( $to, $subject, $msg_body, $headers );
            
            $to = $_POST['Email_Address'];
            $from = get_option('admin_email');
            $from_name = "McNally Sayaji Engineering Limited";
            $headers = "From: $from_name <$from>\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = 'Business Query Reply';
            $msg = 'Thank you for writing to McNally Sayaji Engineering Limited. The request submitted by you is important to us and will be addressed at the earliest.<br/><br/>';
            $msg .= 'If we could be of further assistance, please feel free to reach us at mse.corp@mbecl.co.in.<br/><br/>';
            $msg .= 'The details posted by you are as given below.<br/><br/>';
            $msg .= $msg_body;
            $msg .= '<br/>Regards,<br/>';
            $msg .= 'Team McNally Sayaji Engineering Limited';
            
            wp_mail( $to, $subject, $msg, $headers );
            unset($_POST);
            $suc_msg = 'Your request has been submitted successfully.';
        }else{
            $err_msg = 'Security code does not match.';
        }
    }
}
get_header();
global $post;
?>
<script type="text/javascript">
(function($){
    $.fn.mbe_ucwords = function() {
        return this.each(function(){
          var val = $(this).text();
              var newVal = '';
          val = val.split(' ');

          for(var c=0; c < val.length; c++) {
            newVal += val[c].substring(0,1).toUpperCase() + val[c].substring(1,val[c].length).toLowerCase() + (c+1==val.length ? '' : ' ');
          }
          $(this).text(newVal);
        });
    }
    $(function(){
        $('.frn-con ul').hide();
        $('div.product_forms_content').hide();
        $('input[type=radio][name=Interested_in]').change(function(){
            $('.frn-con ul').slideUp();
            $('div.product_forms_content input, div.product_forms_content textarea').attr('disabled', 'disabled');
            $('div.product_forms_content').hide();
            if($(this).siblings().hasClass('frn-con') == true){
                $(this).siblings('.frn-con').children('ul').slideDown();
            }else{
                var related_form = $(this).data('rel');
                $('#hidden_data_rel').val(related_form);
                $('div#'+ related_form +' input, div#' + related_form + ' textarea').removeAttr('disabled');
                $('div#'+ related_form +'').show();
            }
        });
        $('.frn-con ul li a').click(function(){
            $(this).parent().siblings().children('ul').slideUp();
            $('div.product_forms_content input, div.product_forms_content textarea').attr('disabled', 'disabled');
            $('div.product_forms_content').hide();
            if($(this).next('ul').is(':visible') == true){
                $(this).next('ul').slideUp();
            }else {
                $(this).next('ul').slideDown();
                var related_form = $(this).data('rel');
                $('#hidden_data_rel').val(related_form);
                $('div#'+ related_form +' input, div#' + related_form + ' textarea').removeAttr('disabled');
                $('div#'+ related_form +'').show();
//                var master_parent = $(this).parent().parent().siblings()[0];
//                var current_item = $(this).text();
//                console.log(master_parent);
//                if(master_parent.toString().indexOf('href') != -1){
//                    var sub_product = $('#sub_products').val();
//                    sub_product = sub_product + ' > ' + current_item;
//                    $('#sub_products').val('').val(sub_product);
//                }else{
//                    $('#sub_products').val('').val(current_item);
//                }
            }
        });
        
        <?php if(isset($_POST['bq_submit'])): ?>
            $('div.product_forms_content input, div.product_forms_content textarea').attr('disabled', 'disabled');
            $('input[type=radio][name=Interested_in]').each(function(){
                if($(this).val() === '<?php echo $_POST['Interested_in'];?>'){
                    $(this).attr('checked', 'checked');
                    if($(this).siblings().hasClass('frn-con') == true){
                        $(this).siblings('.frn-con').children('ul').slideDown();
                    }
                }
            });
            
            var related_form = "<?php echo $_POST['hidden_data_rel'];?>";
            $('div#'+ related_form +' input, div#' + related_form + ' textarea').removeAttr('disabled');
            $('div#'+ related_form +'').show();
        <?php endif; ?>   
        
        $('.frn-con a').mbe_ucwords();
    });
})(jQuery);
</script> 
<div class="main_contaner">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2 class="page-title"><?php the_title(); ?></h2>
        <div class="page-con clearfix"> 
            <div class="screen-reader-response"></div>
            
            <?php if(!empty($err_msg)):?>
            <p style="color: red;"><?php echo $err_msg; ?></p>
            <?php endif;?>
            
            <?php if(!empty($suc_msg)):?>
            <p style="color: green;"><?php echo $suc_msg; ?></p>
            <?php endif;?>
            
            <form name="bq_form" id="bq_form" action="" method="POST">
                <dl>
                    <dt>Company Name*</dt>
                    <dd>
                        <input type="text" name="Company_Name" value="<?php echo (isset($_POST['Company_Name'])) ? $_POST['Company_Name'] : ''?>" class="form-control" required/>
                    </dd>
                </dl>
                <dl>
                    <dt>Designation* </dt>
                    <dd>
                        <input type="text" name="Designation" value="<?php echo (isset($_POST['Designation'])) ? $_POST['Designation'] : ''?>" class="form-control" required/>
                    </dd>
                </dl>
                <dl>
                    <dt>Contact No* </dt>
                    <dd>
                        <input type="text" name="Contact_No" value="<?php echo (isset($_POST['Contact_No'])) ? $_POST['Contact_No'] : ''?>" class="form-control" required/>
                    </dd>
                </dl>
                <dl>
                    <dt>Subject*</dt>
                    <dd>
                        <textarea name="Subject" cols="40" rows="10" class="form-control" required><?php echo (isset($_POST['Subject'])) ? $_POST['Subject'] : ''?></textarea>
                    </dd>
                </dl>
                <dl>
                    <dt>Name of the Person*</dt>
                    <dd>
                        <span class="wpcf7-form-control-wrap name-of-person">
                            <input required type="text" name="Name_of_Person" value="<?php echo (isset($_POST['Name_of_Person'])) ? $_POST['Name_of_Person'] : ''?>" class="form-control" />
                        </span>
                    </dd>
                </dl>
                <dl>
                    <dt>Email Address*</dt>
                    <dd>
                        <span class="wpcf7-form-control-wrap email">
                            <input required type="email" name="Email_Address" value="<?php echo (isset($_POST['Email_Address'])) ? $_POST['Email_Address'] : ''?>" class="form-control" />
                        </span>
                    </dd>
                </dl>
                <dl>
                    <dt>Postal Address *</dt>
                    <dd>
                        <span class="wpcf7-form-control-wrap postal-address">
                            <textarea required name="Postal_Address" cols="40" rows="10" class="form-control"><?php echo (isset($_POST['Postal_Address'])) ? $_POST['Postal_Address'] : ''?></textarea>
                        </span>
                    </dd>
                </dl>
                <dl class="tick-dl">
                    <dt>Please tick the product you are interested in *:</dt>
                    <dd>
                        <div class="radio-left product_forms">
                            <span class="wpcf7-form-control-wrap Interested_in">
                                <span class="wpcf7-form-control wpcf7-checkbox checkbox checkbox-inline">
                                    <span class="wpcf7-list-item first">
                                        <input type="radio" name="Interested_in" value="Crushing Equipment" class="radio-btn" required/>&nbsp;
                                        <span class="wpcf7-list-item-label radio-btn">Crushing Equipment</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_crusher">SINGLE ROLL CRUSHER</a></li>
                                                    <li><a href="javascript:void(0);">DOUBLE ROLL CRUSHER</a>
                                                        <ul>
                                                            <li><a href="javascript:void(0);" data-rel="sizing_crusher">SMOOTH</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="sizing_crusher">CORRUGATED</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="sizing_crusher">TOOTHED</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_crusher">TRIPLE ROLL CRUSHER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">HEAVY DUTY IMPACTOR</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">GENERAL DUTY IMPACTOR (EK SERIES)</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">SWING HAMMER REVERSIBLE IMPACTOR</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">REVERSIBLE HAMMER MILL</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">ONE WAY HAMMER MILL</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">RING GRANULATOR</a></li>
                                                    <li><a href="javascript:void(0);">JAW CRUSHER</a>
                                                        <ul>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">SINGLE TOGGLE  JAW CRUSHER</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">DOUBLE TOGGLE  JAW CRUSHER</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">CONE CRUSHER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">COKE CUTTER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">ROTARY BREAKER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">CHAIN MILL</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">LUMP LOOSENER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">SINGLE ROLL LUMP BREAKER  </a></li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="wpcf7-list-item">
                                            <input type="radio" name="Interested_in" value="Screening Equipment" required/>&nbsp;
                                            <span class="wpcf7-list-item-label">Screening Equipment</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="vibrating_screen">CIRCULAR MOTION VIBRATING SCREEN</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="vibrating_screen">LINEAR MOTION VIBRATING SCREEN</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">ROLLER SCREEN</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">LIVE ROLL GRIZZLY</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">HIGH PARTICLE ACCELERATION SCREEN</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">BANANA SCREEN</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">SCREENING FEEDER</a></li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="wpcf7-list-item">
                                            <input type="radio" name="Interested_in" value="Grinding Equipment" required/>&nbsp;
                                            <span class="wpcf7-list-item-label">Grinding Equipment</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="grinding_mill">BALL MILL</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="grinding_mill">ROD MILL</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="grinding_mill">VIBRATING TUBE MILL</a></li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="wpcf7-list-item">
                                            <input type="radio" name="Interested_in" value="Feeding Equipment" required/>&nbsp;
                                            <span class="wpcf7-list-item-label">Feeding Equipment</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_apron_feeder">APRON FEEDER </a></li>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_reciprocating_feeder">RECIPROCATING FEEDER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_grizzly_vibratory_feeder">VIBRATORY FEEDER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_disc_feeder">DISC FEEDER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_grizzly_vibratory_feeder">GRIZZLY FEEDER </a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">BELT FEEDER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">PADDLE FEEDER</a></li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="wpcf7-list-item">
                                            <input type="radio" name="Interested_in" value="Material Handling Equipment" required/>&nbsp;
                                            <span class="wpcf7-list-item-label">Material Handling Equipment</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="travelling_tripper">WAGON TIPPLER </a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">SIDE ARM CHARGER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">STACKER RECLAIMER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">BUCKET ELEVATOR</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="travelling_tripper">TRIPPER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">BELT CONVEYOR & COMPONENTS</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">SCREW CONVEYOR</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">GRAVITY ROLLER CONVEYOR</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">POWERED ROLLER CONVEYOR</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">EOT CRANE</a></li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="wpcf7-list-item">
                                            <input type="radio" name="Interested_in" value="Ash Handling Equipment" required/>&nbsp;
                                            <span class="wpcf7-list-item-label">Ash Handling Equipment</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">TRANSPORTER VESSEL</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">AIR RECEIVER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">CLINKER CRUSHER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">MIXER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">SCRAPER CHAIN CONVEYOR BAG FILTER</a></li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="wpcf7-list-item">
                                            <input type="radio" name="Interested_in" value="Process Plant Equipment" required/>&nbsp;
                                            <span class="wpcf7-list-item-label">Process Plant Equipment</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="pump">SLURRY PUMP</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="pump">FLOTATION CELL</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="pump">COLUMN FLOTATION CELL </a></li>
                                                    <li><a href="javascript:void(0);" data-rel="thickener">THICKENERS </a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">CETRIFUGAL GRAVITY CONCENTRATOR</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">MAGNETIC SEPARATOR</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">FILTERS</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_scrubber">ROTARY SCRUBBER </a></li>                                                    
                                                </ul>
                                            </div>
                                        </span>                                        
                                        <span class="wpcf7-list-item">
                                            <input type="radio" name="Interested_in" value="Equipment For Steel Plant" required/>&nbsp;
                                            <span class="wpcf7-list-item-label">Equipment For Steel Plant</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);">EQUIPMENT FOR BILLET & BLOOM CASTER</a>
                                                        <ul>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">ALL TYPES OF ROLLER TABLES</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">TAIL END PINCH ROLL</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">BILLET LIFTING DEVICE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">TURN OVER COOLING BED</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">PUSHER ONTO ROLLER TABLE (MULTI STEP PUSHER)</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">DUMMY BAR STORAGE UNIT</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">CUTTING EQUIPMENT ( CROP DISCHARGE  BUCKET, CROP COLLECTION ETC)</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">TUNDISH DESKULLING MACHINE, TUNDISH NOZZLE FIXING</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">TUNDIAH HANDLING TRAVERSE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">MACHINE SUPPORT STRUCTURE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">TUNDISH RELINING / COOLING STAND,TUNDISH TILTING DEVISE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">STRAND GUIDE EQUIPMENT</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="javascript:void(0);">EQUIPMENT FOR CONVERTER</a>
                                                        <ul>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">EMERGENCY LADLES, TEEMING LADLES</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">LADLE TRANSFER CAR, SCRAP BOX TRANSFER CARS</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">SCRUBBING TOWER COMPRISING OF SHELL AND INTERNAL CHANNELS, SEPARATOR, SEAL POTS, MANHOLES, QUENCHER VENTURI THROAT ETC. FOR WET GAS CLEANING OF BOF-GCP</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">HOOD TRAVERSE CARRIAGE</a></li>
                                                        </ul>            
                                                    </li>
                                                    <li><a href="javascript:void(0);">EQUIPMENT FOR BLAST FURNACE </a>
                                                        <ul>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">BLEEDER VALVE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">DISTRIBUTION ROCKER</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">DISMANTLING DEVICE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">DEWATERING DRUM AND SUPPORTING STRUCTURE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">PROFILE METER</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">IN BURDEN PROBE</a></li>
                                                        </ul>            
                                                    </li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="wpcf7-list-item">
                                            <input required type="radio" name="Interested_in" value="Wheel & Skid Mounted Crushing Plant" data-rel="sizing_a_skid_mounted_crushing_plant"/>&nbsp;
                                            <span class="wpcf7-list-item-label">Wheel &amp; Skid Mounted Crushing Plant</span>
                                        </span>
                                        <span class="wpcf7-list-item last">
                                            <input required type="radio" name="Interested_in" value="Construction Equipment" />&nbsp;
                                            <span class="wpcf7-list-item-label">Construction Equipment</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="asphalt_batching_plant">ASPHALT BATCHING PLANT</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="concrete_batching_plant">CONCRETE BATCHING PLANT</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="dry_motot_mixing_plant">DRY MORTAR MIXING PLANT</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="mobile_concrete_batching_plant">MOBILE CONCRETE BATCHING PLANT</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="sizing_wheel_mounted_crushing_screening_plant">WHEEL & SKID MOUNTED AGGREGATE CRUSHING & SCREENING PLANT </a></li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="wpcf7-list-item last">
                                            <input required type="radio" name="Interested_in" value="Job Shop" />&nbsp;
                                            <span class="wpcf7-list-item-label">Job Shop</span>
                                            <div class="frn-con">
                                                <ul>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">PRESURE VESSEL</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">HEAT EXCHANGER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">ROTARY KILN</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">DRYER & COOLER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">SCRUBBER</a></li>
                                                    <li><a href="javascript:void(0);" data-rel="other_query">OTHER EQUIPMENT</a></li>
                                                    <li><a href="javascript:void(0);">Port Handling Equipment</a>
                                                        <ul>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">BARGE UNLOADER</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">CONTAINER HANDLING CRANE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">BULK HANDLING CRANE</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">SHIPYARD CRANE</a></li>
                                                        </ul>            
                                                    </li>
                                                    <li><a href="javascript:void(0);">Opencast Mining Equipment</a>
                                                        <ul>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">BUCKET WHEEL EXCAVATOR</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">CRAWLER MOUNTED SPREADER</a></li>
                                                            <li><a href="javascript:void(0);" data-rel="other_query">SHIFTABLE CONVEYOR</a></li>
                                                        </ul>            
                                                    </li>
                                                </ul>
                                            </div>
                                        </span>
<!--                                        <span class="wpcf7-list-item">
                                            <input required type="radio" name="Interested_in" value="Other" data-rel="other_query"/>&nbsp;
                                            <span class="wpcf7-list-item-label">Other</span>
                                        </span>-->
                                    </span>
                                </span>
                                <br style="clear:both" />
                            </div>
                            <div class="form-right product_forms">
                                <div class="product_forms_content" id="sizing_crusher">
                                    <dl>
                                        <dt>Preference for the type of Crusher</dt>
                                        <dd>
                                            <input type="text" name="Preference_for_the_type_of_Crusher" value="<?php echo (isset($_POST['Preference_for_the_type_of_Crusher'])) ? $_POST['Preference_for_the_type_of_Crusher'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Material to be crushed</dt>
                                        <dd>
                                            <input type="text" name="Material_to_be_crushed" value="<?php echo (isset($_POST['Material_to_be_crushed'])) ? $_POST['Material_to_be_crushed'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density of Material (t/m³)</dt>
                                        <dd>
                                            <input type="text" name="Bulk_Density_of_Material_(t/m³)" value="<?php echo (isset($_POST['Bulk_Density_of_Material_(t/m³)'])) ? $_POST['Bulk_Density_of_Material_(t/m³)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity (Rated/Designed), tph</dt>
                                        <dd>
                                            <input type="text" name="Capacity_(Rated/Designed)" value="<?php echo (isset($_POST['Capacity_(Rated/Designed)'])) ? $_POST['Capacity_(Rated/Designed)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Compressive strength of material (MPa)</dt>
                                        <dd>
                                            <input type="text" name="Compressive_strength_of_material_(MPa)" value="<?php echo (isset($_POST['Compressive_strength_of_material_(MPa)'])) ? $_POST['Compressive_strength_of_material_(MPa)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bond Work Index / Hard groove Index</dt>
                                        <dd>
                                            <input type="text" name="Bond_Work_Index_/_Hard_groove_Index" value="<?php echo (isset($_POST['Bond_Work_Index_/_Hard_groove_Index'])) ? $_POST['Bond_Work_Index_/_Hard_groove_Index'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture content (%)</dt>
                                        <dd>
                                           <input type="text" name="Moisture_content_(%)" value="<?php echo (isset($_POST['Moisture_content_(%)'])) ? $_POST['Moisture_content_(%)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Feed Size (Top size and 80% passing), mm</dt>
                                        <dd>
                                            <input type="text" name="Feed_Size_(Top_size_and_80%_passing),_mm" value="<?php echo (isset($_POST['Feed_Size_(Top_size_and_80%_passing),_mm'])) ? $_POST['Feed_Size_(Top_size_and_80%_passing),_mm'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Product size (80% passing)/ Separation size (For Rotary Breaker Only), mm</dt>
                                        <dd>
                                            <input type="text" name="Product_size_(80% passing)_/_Separation_size_(For_Rotary_Breaker_Only,_mm" value="<?php echo (isset($_POST['Product_size_(80% passing)_/_Separation_size_(For_Rotary_Breaker_Only,_mm'])) ? $_POST['Product_size_(80% passing)_/_Separation_size_(For_Rotary_Breaker_Only,_mm'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Open / Closed circuit</dt>
                                        <dd>
                                            <input type="text" name="Open_/_Closed_circuit" value="<?php echo (isset($_POST['Open_/_Closed_circuit'])) ? $_POST['Open_/_Closed_circuit'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Provide flow sheet/layout, if possible</dt>
                                        <dd>
                                            <input type="text" name="Provide_flow_shee/layout,_if_possible" value="<?php echo (isset($_POST['Provide_flow_shee/layout,_if_possible'])) ? $_POST['Provide_flow_shee/layout,_if_possible'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>% of Product size in feed</dt>
                                        <dd>
                                            <input type="text" name="%_of_Product_size_in_feed" value="<?php echo (isset($_POST['%_of_Product_size_in_feed'])) ? $_POST['%_of_Product_size_in_feed'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="vibrating_screen">
                                    <dl>
                                        <dt>Material to be Screened</dt>
                                        <dd>
                                            <input type="text" name="Material_to_be_Screened" value="<?php echo (isset($_POST['Material_to_be_Screened'])) ? $_POST['Material_to_be_Screened'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density of Material (t/m³)</dt>
                                        <dd>
                                            <input type="text" name="Bulk_Density_of_Material_(t/m³)" value="<?php echo (isset($_POST['Bulk_Density_of_Material_(t/m³)'])) ? $_POST['Bulk_Density_of_Material_(t/m³)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity  (Rated/ Design), tph</dt>
                                        <dd>
                                            <input type="text" name="Capacity_(Rated_/_Design),_tph" value="<?php echo (isset($_POST['Capacity_(Rated_/_Design),_tph'])) ? $_POST['Capacity_(Rated_/_Design),_tph'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture content in Feed (%)</dt>
                                        <dd>
                                             <input type="text" name="Moisture_content_in_Feed_(%)" value="<?php echo (isset($_POST['Moisture_content_in_Feed_(%)'])) ? $_POST['Moisture_content_in_Feed_(%)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Feed Size Analysis</dt>
                                        <dd>
                                            <input type="text" name="Feed_Size_Analysis" value="<?php echo (isset($_POST['Feed_Size_Analysis'])) ? $_POST['Feed_Size_Analysis'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Preference of screening decks (Perforated plate/ PU / Woven wire mesh / wedge wire/ Rubber/ Stainless Steel) <b>(For Circular /Linear Motion Screen)</b></dt>
                                        <dd>
                                           <input type="text" name="Preference_of_screening_decks" value="<?php echo (isset($_POST['Preference_of_screening_decks'])) ? $_POST['Preference_of_screening_decks'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl><dl>
                                        <dt>Separation Size/ sizes ,mm </dt>
                                        <dd>
                                             <input type="text" name="Separation_Size/_sizes_,mm" value="<?php echo (isset($_POST['Separation_Size/_sizes_,mm'])) ? $_POST['Separation_Size/_sizes_,mm'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of screening process(Dry or Wet) <b>(For Circular /Linear Motion Screen)</b></dt>
                                        <dd>
                                             <input type="text" name="Type_of_screening_process" value="<?php echo (isset($_POST['Type_of_screening_process'])) ? $_POST['Type_of_screening_process'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Preferred Type of screen (Circular motion/ Linear motion/ Flip Flow)</dt>
                                        <dd>
                                           <input type="text" name="Preferred_Type_of_screen" value="<?php echo (isset($_POST['Preferred_Type_of_screen'])) ? $_POST['Preferred_Type_of_screen'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Desired screening efficiency</dt>
                                        <dd>
                                            <input type="text" name="Desired_screening_efficiency" value="<?php echo (isset($_POST['Desired_screening_efficiency'])) ? $_POST['Desired_screening_efficiency'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type Of Feeding</dt>
                                        <dd>
                                            <input type="text" name="Type_Of_Feeding" value="<?php echo (isset($_POST['Type_Of_Feeding'])) ? $_POST['Type_Of_Feeding'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Provide flow sheet/layout drawing, if available</dt>
                                        <dd>
                                            <input type="text" name="Provide_flow_sheet/layout_drawing,_if_available" value="<?php echo (isset($_POST['Provide_flow_sheet/layout_drawing,_if_available'])) ? $_POST['Provide_flow_sheet/layout_drawing,_if_available'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="grinding_mill">
                                    <dl>
                                        <dt>Material to be ground</dt>
                                        <dd>
                                            <input type="text" name="Material_to_be_ground" value="<?php echo (isset($_POST['Material_to_be_ground'])) ? $_POST['Material_to_be_ground'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Specific Gravity of material</dt>
                                        <dd>
                                            <input type="text" name="Specific_Gravity_of_material" value="<?php echo (isset($_POST['Specific_Gravity_of_material'])) ? $_POST['Specific_Gravity_of_material'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bond Work Index (Kwh/st) or (Kwh/Mt)</dt>
                                        <dd>
                                            <input type="text" name="Bond_Work_Index_(Kwh/st)_or_(Kwh/Mt)" value="<?php echo (isset($_POST['Bond_Work_Index_(Kwh/st)_or_(Kwh/Mt)'])) ? $_POST['Bond_Work_Index_(Kwh/st)_or_(Kwh/Mt)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture content (%) in case of dry grinding</dt>
                                        <dd>
                                            <input type="text" name="Moisture_content_(%)_in_case_of_dry_grinding" value="<?php echo (isset($_POST['Moisture_content_(%)_in_case_of_dry_grinding'])) ? $_POST['Moisture_content_(%)_in_case_of_dry_grinding'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>80% passing feed size</dt>
                                        <dd>
                                            <input type="text" name="80%_passing_feed_size" value="<?php echo (isset($_POST['80%_passing_feed_size'])) ? $_POST['80%_passing_feed_size'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>80% passing product size</dt>
                                        <dd>
                                            <input type="text" name="80%_passing_product_size" value="<?php echo (isset($_POST['80%_passing_product_size'])) ? $_POST['80%_passing_product_size'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl><dl>
                                        <dt>Fresh feed rate, tph </dt>
                                        <dd>
                                           <input type="text" name="Fresh_feed_rate,_tph" value="<?php echo (isset($_POST['Fresh_feed_rate,_tph'])) ? $_POST['Fresh_feed_rate,_tph'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of grinding circuit (open / closed)</dt>
                                        <dd>
                                            <input type="text" name="Type_of_grinding_circuit_(open_/_closed)" value="<?php echo (isset($_POST['Type_of_grinding_circuit_(open_/_closed)'])) ? $_POST['Type_of_grinding_circuit_(open_/_closed)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Name of liquid in case of wet grinding</dt>
                                        <dd>
                                            <input type="text" name="Name_of_liquid_in_case_of_wet_grinding" value="<?php echo (isset($_POST['Name_of_liquid_in_case_of_wet_grinding'])) ? $_POST['Name_of_liquid_in_case_of_wet_grinding'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Specific gravity of liquid in case of wet grinding</dt>
                                        <dd>
                                            <input type="text" name="Specific_gravity_of_liquid_in_case_of_wet_grinding" value="<?php echo (isset($_POST['Specific_gravity_of_liquid_in_case_of_wet_grinding'])) ? $_POST['Specific_gravity_of_liquid_in_case_of_wet_grinding'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Provide flow sheet, if possible</dt>
                                        <dd>
                                            <input type="text" name="Provide_flow_sheet,_if_possible" value="<?php echo (isset($_POST['Provide_flow_sheet,_if_possible'])) ? $_POST['Provide_flow_sheet,_if_possible'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="sizing_apron_feeder">
                                    <dl>
                                        <dt>Material Handled</dt>
                                        <dd>
                                            <input type="text" name="Material_Handled" value="<?php echo (isset($_POST['Material_Handled'])) ? $_POST['Material_Handled'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Lump Size (Maximum), mm</dt>
                                        <dd>
                                            <input type="text" name="Lump_Size_(Maximum),_mm" value="<?php echo (isset($_POST['Lump_Size_(Maximum),_mm'])) ? $_POST['Lump_Size_(Maximum),_mm'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density of material (t/m³)</dt>
                                        <dd>
                                            <input type="text" name="Bulk_Density_of_material_(t/m³)" value="<?php echo (isset($_POST['Bulk_Density_of_material_(t/m³)'])) ? $_POST['Bulk_Density_of_material_(t/m³)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Rated Capacity, tph</dt>
                                        <dd>
                                            <input type="text" name="Rated_Capacity,_tph" value="<?php echo (isset($_POST['Rated_Capacity,_tph'])) ? $_POST['Rated_Capacity,_tph'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture Content (%)</dt>
                                        <dd>
                                            <input type="text" name="Moisture_Content_(%)" value="<?php echo (isset($_POST['Moisture_Content_(%)'])) ? $_POST['Moisture_Content_(%)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Hopper Opening ( L X W  ) at Top & Bottom.</dt>
                                        <dd>
                                            <input type="text" name="Hopper_Opening_(_L_X_W_)_at_Top_&_Bottom" value="<?php echo (isset($_POST['Hopper_Opening_(_L_X_W_)_at_Top_&_Bottom'])) ? $_POST['Hopper_Opening_(_L_X_W_)_at_Top_&_Bottom'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl><dl>
                                        <dt>Location</dt>
                                        <dd>
                                            <input type="text" name="Location" value="<?php echo (isset($_POST['Location'])) ? $_POST['Location'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Inclination</dt>
                                        <dd>
                                            <input type="text" name="Inclination" value="<?php echo (isset($_POST['Inclination'])) ? $_POST['Inclination'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Height of Fall</dt>
                                        <dd>
                                            <input type="text" name="Height_of_Fall" value="<?php echo (isset($_POST['Height_of_Fall'])) ? $_POST['Height_of_Fall'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Center to Center Distance</dt>
                                        <dd>
                                            <input type="text" name="Center_to_Center_Distance" value="<?php echo (isset($_POST['Center_to_Center_Distance'])) ? $_POST['Center_to_Center_Distance'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Provide flow sheet, if possible</dt>
                                        <dd>
                                            <input type="text" name="Provide_flow_sheet,_if_possible" value="<?php echo (isset($_POST['Provide_flow_sheet,_if_possible'])) ? $_POST['Provide_flow_sheet,_if_possible'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Technical Requirement of PAN Material , Type of chain, Type of Drive- Electromechanical / Hydraulic /any specific requirement </dt>
                                        <dd>
                                            <input type="text" name="Technical_Requirement_of_PAN_Material" value="<?php echo (isset($_POST['Technical_Requirement_of_PAN_Material'])) ? $_POST['Technical_Requirement_of_PAN_Material'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Dribble Conveyor required or not</dt>
                                        <dd>
                                            <input type="text" name="Dribble_Conveyor_required_or_not" value="<?php echo (isset($_POST['Dribble_Conveyor_required_or_not'])) ? $_POST['Dribble_Conveyor_required_or_not'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="sizing_reciprocating_feeder">
                                    <dl>
                                        <dt>Material Handled</dt>
                                        <dd>
                                            <input type="text" name="Material_Handled" value="<?php echo (isset($_POST['Material_Handled'])) ? $_POST['Material_Handled'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Lump Size (Maximum), mm</dt>
                                        <dd>
                                            <input type="text" name="Lump_Size_(Maximum),_mm" value="<?php echo (isset($_POST['Lump_Size_(Maximum),_mm'])) ? $_POST['Lump_Size_(Maximum),_mm'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density of material (t/m³)</dt>
                                        <dd>
                                            <input type="text" name="Bulk_Density_of_material_(t/m³)" value="<?php echo (isset($_POST['Bulk_Density_of_material_(t/m³)'])) ? $_POST['Bulk_Density_of_material_(t/m³)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity (Designed & Rated), tph</dt>
                                        <dd>
                                            <input type="text" name="Capacity_(Designed_&_Rated),_tph" value="<?php echo (isset($_POST['Capacity_(Designed_&_Rated),_tph'])) ? $_POST['Capacity_(Designed_&_Rated),_tph'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture Content (%)</dt>
                                        <dd>
                                            <input type="text" name="Moisture_Content_(%)" value="<?php echo (isset($_POST['Moisture_Content_(%)'])) ? $_POST['Moisture_Content_(%)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Hopper Opening ( L X W  ) at Top & Bottom. OR Hopper Load </dt>
                                        <dd>
                                            <input type="text" name="Hopper_Opening_(_L_X_W_)_at_Top_&_Bottom_OR_Hopper_Load" value="<?php echo (isset($_POST['Hopper_Opening_(_L_X_W_)_at_Top_&_Bottom_OR_Hopper_Load'])) ? $_POST['Hopper_Opening_(_L_X_W_)_at_Top_&_Bottom_OR_Hopper_Load'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl><dl>
                                        <dt>Technical Requirement of Type of DRIVE - Electromechanical/ Hydraulic </dt>
                                        <dd>
                                            <input type="text" name="Technical_Requirement_of_Type_of_DRIVE_-_Electromechanical/_Hydraulic" value="<?php echo (isset($_POST['Technical_Requirement_of_Type_of_DRIVE_-_Electromechanical/_Hydraulic'])) ? $_POST['Technical_Requirement_of_Type_of_DRIVE_-_Electromechanical/_Hydraulic'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="sizing_grizzly_vibratory_feeder">
                                    <dl>
                                        <dt>Material to be Handled</dt>
                                        <dd>
                                            <input type="text" name="Material_to_be_Handled" value="<?php echo (isset($_POST['Material_to_be_Handled'])) ? $_POST['Material_to_be_Handled'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density of material (t/m³)</dt>
                                        <dd>
                                            <input type="text" name="Bulk_Density_of_material_(t/m³)" value="<?php echo (isset($_POST['Bulk_Density_of_material_(t/m³)'])) ? $_POST['Bulk_Density_of_material_(t/m³)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity  Design/Rated ,tph</dt>
                                        <dd>
                                            <input type="text" name="Capacity_Design/Rated,_tph" value="<?php echo (isset($_POST['Capacity_Design/Rated,_tph'])) ? $_POST['Capacity_Design/Rated,_tph'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture content in Feed (%)</dt>
                                        <dd>
                                            <input type="text" name="Moisture_content_in_Feed_(%)" value="<?php echo (isset($_POST['Moisture_content_in_Feed_(%)'])) ? $_POST['Moisture_content_in_Feed_(%)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Lump Size (Maximum), mm </dt>
                                        <dd>
                                            <input type="text" name="Lump_Size_(Maximum),_mm" value="<?php echo (isset($_POST['Lump_Size_(Maximum),_mm'])) ? $_POST['Lump_Size_(Maximum),_mm'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Separation Size & % passing (For Grizzly Feeder)</dt>
                                        <dd>
                                            <input type="text" name="Separation_Size_&_%_passing_(For_Grizzly_Feeder)" value="<?php echo (isset($_POST['Separation_Size_&_%_passing_(For_Grizzly_Feeder)'])) ? $_POST['Separation_Size_&_%_passing_(For_Grizzly_Feeder)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Preference of  MOC of Deck /Grizzly</dt>
                                        <dd>
                                            <input type="text" name="Preference_of_MOC_of_Deck_/Grizzly" value="<?php echo (isset($_POST['Preference_of_MOC_of_Deck_/Grizzly'])) ? $_POST['Preference_of_MOC_of_Deck_/Grizzly'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type Of Feeding</dt>
                                        <dd>
                                            <input type="text" name="Type_Of_Feeding" value="<?php echo (isset($_POST['Type_Of_Feeding'])) ? $_POST['Type_Of_Feeding'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Location</dt>
                                        <dd>
                                            <input type="text" name="Location" value="<?php echo (isset($_POST['Location'])) ? $_POST['Location'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="sizing_disc_feeder">
                                    <dl>
                                        <dt>Material Handled</dt>
                                        <dd>
                                            <input type="text" name="Material_Handled" value="<?php echo (isset($_POST['Material_Handled'])) ? $_POST['Material_Handled'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Feed Size</dt>
                                        <dd>
                                            <input type="text" name="Feed_Size" value="<?php echo (isset($_POST['Feed_Size'])) ? $_POST['Feed_Size'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity TPH</dt>
                                        <dd>
                                            <input type="text" name="Capacity_TPH" value="<?php echo (isset($_POST['Capacity_TPH'])) ? $_POST['Capacity_TPH'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density </dt>
                                        <dd>
                                            <input type="text" name="Bulk_Density" value="<?php echo (isset($_POST['Bulk_Density'])) ? $_POST['Bulk_Density'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture</dt>
                                        <dd>
                                            <input type="text" name="Moisture" value="<?php echo (isset($_POST['Moisture'])) ? $_POST['Moisture'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Fixed Speed/Variable Speed</dt>
                                        <dd>
                                            <input type="text" name="Fixed_Speed/Variable_Speed" value="<?php echo (isset($_POST['Fixed_Speed/Variable_Speed'])) ? $_POST['Fixed_Speed/Variable_Speed'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Open / closed circuit</dt>
                                        <dd>
                                            <input type="text" name="Open_/_closed_circuit" value="<?php echo (isset($_POST['Open_/_closed_circuit'])) ? $_POST['Open_/_closed_circuit'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Provide flow sheet/layout, if possible</dt>
                                        <dd>
                                            <input type="text" name="Provide_flow_sheet/layout,_if_possible" value="<?php echo (isset($_POST['Provide_flow_sheet/layout,_if_possible'])) ? $_POST['Provide_flow_sheet/layout,_if_possible'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="travelling_tripper">
                                    <dl>
                                        <dt>Belt width </dt>
                                        <dd>
                                            <input type="text" name="Belt_width" value="<?php echo (isset($_POST['Belt_width'])) ? $_POST['Belt_width'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity (Rated / Design)</dt>
                                        <dd>
                                            <input type="text" name="Capacity_(Rated_/_Design)" value="<?php echo (isset($_POST['Capacity_(Rated_/_Design)'])) ? $_POST['Capacity_(Rated_/_Design)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Material Handled</dt>
                                        <dd>
                                            <input type="text" name="Material_Handled" value="<?php echo (isset($_POST['Material_Handled'])) ? $_POST['Material_Handled'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Lump Size</dt>
                                        <dd>
                                            <input type="text" name="Lump_Size" value="<?php echo (isset($_POST['Lump_Size'])) ? $_POST['Lump_Size'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Tripper inclination</dt>
                                        <dd>
                                            <input type="text" name="Tripper_inclination" value="<?php echo (isset($_POST['Tripper_inclination'])) ? $_POST['Tripper_inclination'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Tripper Travel</dt>
                                        <dd>
                                            <input type="text" name="Tripper_Travel" value="<?php echo (isset($_POST['Tripper_Travel'])) ? $_POST['Tripper_Travel'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Top of belt from Floor </dt>
                                        <dd>
                                            <input type="text" name="Top_of_belt_from_Floor" value="<?php echo (isset($_POST['Top_of_belt_from_Floor'])) ? $_POST['Top_of_belt_from_Floor'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Top of rail from Floor</dt>
                                        <dd>
                                            <input type="text" name="Top_of_rail_from_Floor" value="<?php echo (isset($_POST['Top_of_rail_from_Floor'])) ? $_POST['Top_of_rail_from_Floor'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Rail size </dt>
                                        <dd>
                                            <input type="text" name="Rail_size" value="<?php echo (isset($_POST['Rail_size'])) ? $_POST['Rail_size'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Rail CRS</dt>
                                        <dd>
                                            <input type="text" name="Rail_CRS" value="<?php echo (isset($_POST['Rail_CRS'])) ? $_POST['Rail_CRS'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Top of Discharge Pulley from Floor</dt>
                                        <dd>
                                            <input type="text" name="Top_of_Discharge_Pulley_from_Floor" value="<?php echo (isset($_POST['Top_of_Discharge_Pulley_from_Floor'])) ? $_POST['Top_of_Discharge_Pulley_from_Floor'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Discharge & Bend Pulley Diameter </dt>
                                        <dd>
                                            <input type="text" name="Discharge_&_Bend_Pulley_Diameter" value="<?php echo (isset($_POST['Discharge_&_Bend_Pulley_Diameter'])) ? $_POST['Discharge_&_Bend_Pulley_Diameter'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Shaft diameter at Bearing of above</dt>
                                        <dd>
                                            <input type="text" name="Shaft_diameter_at_Bearing_of_above" value="<?php echo (isset($_POST['Shaft_diameter_at_Bearing_of_above'])) ? $_POST['Shaft_diameter_at_Bearing_of_above'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Face width of above</dt>
                                        <dd>
                                            <input type="text" name="Face_width_of_above" value="<?php echo (isset($_POST['Face_width_of_above'])) ? $_POST['Face_width_of_above'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bearing CRS of above</dt>
                                        <dd>
                                            <input type="text" name="Bearing_CRS_of_above" value="<?php echo (isset($_POST['Bearing_CRS_of_above'])) ? $_POST['Bearing_CRS_of_above'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of Discharge (1-way/2-way/3-way) </dt>
                                        <dd>
                                            <input type="text" name="Type_of_Discharge_(1-way/2-way/3-way)" value="<?php echo (isset($_POST['Type_of_Discharge_(1-way/2-way/3-way)'])) ? $_POST['Type_of_Discharge_(1-way/2-way/3-way)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of Gate, if provided in Discharge Chute</dt>
                                        <dd>
                                            <input type="text" name="Type_of_Gate,_if_provided_in_Discharge_Chute" value="<?php echo (isset($_POST['Type_of_Gate,_if_provided_in_Discharge_Chute'])) ? $_POST['Type_of_Gate,_if_provided_in_Discharge_Chute'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>C/C distance of Bunker slot</dt>
                                        <dd>
                                            <input type="text" name="C/C_distance_of_Bunker_slot" value="<?php echo (isset($_POST['C/C_distance_of_Bunker_slot'])) ? $_POST['C/C_distance_of_Bunker_slot'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Cross section of Discharge Chute </dt>
                                        <dd>
                                            <input type="text" name="Cross_section_of_Discharge_Chute" value="<?php echo (isset($_POST['Cross_section_of_Discharge_Chute'])) ? $_POST['Cross_section_of_Discharge_Chute'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Width of Bunker slot </dt>
                                        <dd>
                                            <input type="text" name="Width_of_Bunker_slot" value="<?php echo (isset($_POST['Width_of_Bunker_slot'])) ? $_POST['Width_of_Bunker_slot'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Width of Bunker sealing Belt</dt>
                                        <dd>
                                           <input type="text" name="Width_of_Bunker_sealing_Belt" value="<?php echo (isset($_POST['Width_of_Bunker_sealing_Belt'])) ? $_POST['Width_of_Bunker_sealing_Belt'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Idler Roll dia</dt>
                                        <dd>
                                            <input type="text" name="Idler_Roll_dia" value="<?php echo (isset($_POST['Idler_Roll_dia'])) ? $_POST['Idler_Roll_dia'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Idler Height</dt>
                                        <dd>
                                            <input type="text" name="Idler_Height" value="<?php echo (isset($_POST['Idler_Height'])) ? $_POST['Idler_Height'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Belt Tension at Discharge Pulley at two extremities of travel</dt>
                                        <dd>
                                            <input type="text" name="Belt_Tension_at_Discharge_Pulley_at_two_extremities_of_travel" value="<?php echo (isset($_POST['Belt_Tension_at_Discharge_Pulley_at_two_extremities_of_travel'])) ? $_POST['Belt_Tension_at_Discharge_Pulley_at_two_extremities_of_travel'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Power feeding arrangement (CRD/Festoon cable)</dt>
                                        <dd>
                                            <input type="text" name="Power_ feeding_arrangement_(CRD/Festoon_cable)" value="<?php echo (isset($_POST['Power_ feeding_arrangement_(CRD/Festoon_cable)'])) ? $_POST['Power_ feeding_arrangement_(CRD/Festoon_cable)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of Rail Clamp</dt>
                                        <dd>
                                           <input type="text" name="Type_of_Rail_Clamp" value="<?php echo (isset($_POST['Type_of_Rail_Clamp'])) ? $_POST['Type_of_Rail_Clamp'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of Brake</dt>
                                        <dd>
                                            <input type="text" name="Type_of_Brake" value="<?php echo (isset($_POST['Type_of_Brake'])) ? $_POST['Type_of_Brake'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Are MOC of components mentioned in NIT? If yes, provide details</dt>
                                        <dd>
                                            <input type="text" name="Are_MOC_of_components_mentioned_in_NIT?_If_yes,_provide_details" value="<?php echo (isset($_POST['Are_MOC_of_components_mentioned_in_NIT?_If_yes,_provide_details'])) ? $_POST['Are_MOC_of_components_mentioned_in_NIT?_If_yes,_provide_details'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>What is the Drive arrangement as per NIT? Provide details</dt>
                                        <dd>
                                            <input type="text" name="What_is_the_ Drive_arrangement_as_per_NIT?_Provide_details" value="<?php echo (isset($_POST['What_is_the_ Drive_arrangement_as_per_NIT?_Provide_details'])) ? $_POST['What_is_the_ Drive_arrangement_as_per_NIT?_Provide_details'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Approved List of Make of Bought-out components</dt>
                                        <dd>
                                            <input type="text" name="Approved_List_of_Make_of_Bought_out_components" value="<?php echo (isset($_POST['Approved_List_of_Make_of_Bought_out_components'])) ? $_POST['Approved_List_of_Make_of_Bought_out_components'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="pump">
                                    <dl>
                                        <dt> Capacity (m3/hr):</dt>
                                        <dd>
                                            <input type="text" name="Capacity_(m3/hr)" value="<?php echo (isset($_POST['Capacity_(m3/hr)'])) ? $_POST['Capacity_(m3/hr)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Total Discharge head (mwc):</dt>
                                        <dd>
                                            <input type="text" name="Total_Discharge_head_(mwc)" value="<?php echo (isset($_POST['Total_Discharge_head_(mwc)'])) ? $_POST['Total_Discharge_head_(mwc)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Specific Gravity of Slurry:</dt>
                                        <dd>
                                            <input type="text" name="Specific_Gravity_of_Slurry" value="<?php echo (isset($_POST['Specific_Gravity_of_Slurry'])) ? $_POST['Specific_Gravity_of_Slurry'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Percent of Solid by weight:</dt>
                                        <dd>
                                            <input type="text" name="Percent_of_Solid_by_weight" value="<?php echo (isset($_POST['Percent_of_Solid_by_weight'])) ? $_POST['Percent_of_Solid_by_weight'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Maximum particle size in slurry (mm/micron):</dt>
                                        <dd>
                                            <input type="text" name="Maximum_particle_size_in_slurry_(mm/micron)" value="<?php echo (isset($_POST['Maximum_particle_size_in_slurry_(mm/micron)'])) ? $_POST['Maximum_particle_size_in_slurry_(mm/micron)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Suction should be flooded:</dt>
                                        <dd>
                                            <input type="text" name="Suction_should_be_flooded" value="<?php echo (isset($_POST['Suction_should_be_flooded'])) ? $_POST['Suction_should_be_flooded'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Any pH value of slurry:</dt>
                                        <dd>
                                            <input type="text" name="Any_pH_value_of_slurry" value="<?php echo (isset($_POST['Any_pH_value_of_slurry'])) ? $_POST['Any_pH_value_of_slurry'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Temperature of slurry:</dt>
                                        <dd>
                                           <input type="text" name="Temperature_of_slurry" value="<?php echo (isset($_POST['Temperature_of_slurry'])) ? $_POST['Temperature_of_slurry'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Viscosity of slurry:</dt>
                                        <dd>
                                           <input type="text" name="Viscosity_of_slurry" value="<?php echo (isset($_POST['Viscosity_of_slurry'])) ? $_POST['Viscosity_of_slurry'] : ''?>" class="form-control"/>>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>What is slurry to be pumped:</dt>
                                        <dd>
                                            <input type="text" name="What_is_slurry_to_be_pumped" value="<?php echo (isset($_POST['What_is_slurry_to_be_pumped'])) ? $_POST['What_is_slurry_to_be_pumped'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Forth Factor:</dt>
                                        <dd>
                                            <input type="text" name="Forth_Factor" value="<?php echo (isset($_POST['Forth_Factor'])) ? $_POST['Forth_Factor'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Sump depth (mm) :</dt>
                                        <dd>
                                            <input type="text" name="Sump_depth_(mm)" value="<?php echo (isset($_POST['Sump_depth_(mm)'])) ? $_POST['Sump_depth_(mm)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Speed (rpm)</dt>
                                        <dd>
                                           <input type="text" name="Speed_(rpm)" value="<?php echo (isset($_POST['Speed_(rpm)'])) ? $_POST['Speed_(rpm)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="sizing_scrubber">
                                    <dl>
                                        <dt>Material to be handled</dt>
                                        <dd>
                                           <input type="text" name="Material_to_be_handled" value="<?php echo (isset($_POST['Material_to_be_handled'])) ? $_POST['Material_to_be_handled'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Specific Gravity of material</dt>
                                        <dd>
                                            <input type="text" name="Specific_Gravity_of_material" value="<?php echo (isset($_POST['Specific_Gravity_of_material'])) ? $_POST['Specific_Gravity_of_material'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density (t/m³)</dt>
                                        <dd>
                                           <input type="text" name="Bulk_Density_(t/m³)" value="<?php echo (isset($_POST['Bulk_Density_(t/m³)'])) ? $_POST['Bulk_Density_(t/m³)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Fresh feed rate (tph)</dt>
                                        <dd>
                                            <input type="text" name="Fresh_feed_rate_(tph)" value="<?php echo (isset($_POST['Fresh_feed_rate_(tph)'])) ? $_POST['Fresh_feed_rate_(tph)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Feed size analysis</dt>
                                        <dd>
                                            <input type="text" name="Feed_size_analysis" value="<?php echo (isset($_POST['Feed_size_analysis'])) ? $_POST['Feed_size_analysis'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Provide flow sheet, if possible</dt>
                                        <dd>
                                            <input type="text" name="Provide_flow_sheet,_if_possible" value="<?php echo (isset($_POST['Provide_flow_sheet,_if_possible'])) ? $_POST['Provide_flow_sheet,_if_possible'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Clay % in feed</dt>
                                        <dd>
                                            <input type="text" name="Clay_%_in_feed" value="<?php echo (isset($_POST['Clay_%_in_feed'])) ? $_POST['Clay_%_in_feed'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Ore Up gradation Desired</dt>
                                        <dd>
                                            <input type="text" name="Ore_Up_gradation_Desired" value="<?php echo (isset($_POST['Ore_Up_gradation_Desired'])) ? $_POST['Ore_Up_gradation_Desired'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="thickener">
                                    <dl>
                                        <dt>Slurry to be handled:</dt>
                                        <dd>
                                            <input type="text" name="Slurry_to_be_handled" value="<?php echo (isset($_POST['Slurry_to_be_handled'])) ? $_POST['Slurry_to_be_handled'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Duty: Continuous/ Intermediate</dt>
                                        <dd>
                                            <input type="text" name="Duty:_Continuous/_Intermediate" value="<?php echo (isset($_POST['Duty:_Continuous/_Intermediate'])) ? $_POST['Duty:_Continuous/_Intermediate'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Sieve analysis  (Minimum 3 size fraction):</dt>
                                        <dd>
                                           <input type="text" name="Sieve_analysis_(Minimum_3_size_fraction)" value="<?php echo (isset($_POST['Sieve_analysis_(Minimum_3_size_fraction)'])) ? $_POST['Sieve_analysis_(Minimum_3_size_fraction)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Dry solids (Tonnes/hr):</dt>
                                        <dd>
                                            <input type="text" name="Dry_solids_(Tonnes/hr)" value="<?php echo (isset($_POST['Dry_solids_(Tonnes/hr)'])) ? $_POST['Dry_solids_(Tonnes/hr)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Specific Gravity of solids:</dt>
                                        <dd>
                                            <input type="text" name="Specific_Gravity_of_solids" value="<?php echo (isset($_POST['Specific_Gravity_of_solids'])) ? $_POST['Specific_Gravity_of_solids'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Specific Gravity of slurry:</dt>
                                        <dd>
                                            <input type="text" name="Specific_Gravity_of_slurry" value="<?php echo (isset($_POST['Specific_Gravity_of_slurry'])) ? $_POST['Specific_Gravity_of_slurry'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Percentage of solid by weight in feed:</dt>
                                        <dd>
                                            <input type="text" name="Percentage_of_solid_by_weight_in_feed" value="<?php echo (isset($_POST['Percentage_of_solid_by_weight_in_feed'])) ? $_POST['Percentage_of_solid_by_weight_in_feed'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>pH of slurry:</dt>
                                        <dd>
                                            <input type="text" name="pH_of_slurry" value="<?php echo (isset($_POST['pH_of_slurry'])) ? $_POST['pH_of_slurry'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Temperature of feed slurry:</dt>
                                        <dd>
                                            <input type="text" name="Temperature_of_feed_slurry" value="<?php echo (isset($_POST['Temperature_of_feed_slurry'])) ? $_POST['Temperature_of_feed_slurry'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity of feed slurry (m3/hr):</dt>
                                        <dd>
                                           <input type="text" name="Capacity_of_feed_slurry_(m3/hr)" value="<?php echo (isset($_POST['Capacity_of_feed_slurry_(m3/hr)'])) ? $_POST['Capacity_of_feed_slurry_(m3/hr)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="sizing_a_skid_mounted_crushing_plant">
                                    <dl>
                                        <dt>Material to be crushed & application e.g. Mines, Power plant etc.</dt>
                                        <dd>
                                            <input type="text" name="Material_to_be_crushed_&_application" value="<?php echo (isset($_POST['Material_to_be_crushed_&_application'])) ? $_POST['Material_to_be_crushed_&_application'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density (t/m³)</dt>
                                        <dd>
                                            <input type="text" name="Bulk_Density_(t/m³)" value="<?php echo (isset($_POST['Bulk_Density_(t/m³)'])) ? $_POST['Bulk_Density_(t/m³)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture - average / max. (%)</dt>
                                        <dd>
                                            <input type="text" name="Moisture_-_average_/_max._(%)" value="<?php echo (isset($_POST['Moisture_-_average_/_max._(%)'])) ? $_POST['Moisture_-_average_/_max._(%)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>If ROM Coal, approx. percentage of Shale and Sandstone</dt>
                                        <dd>
                                            <input type="text" name="If_ROM_Coal,_approx._percentage_of_Shale_and_Sandstone" value="<?php echo (isset($_POST['If_ROM_Coal,_approx._percentage_of_Shale_and_Sandstone'])) ? $_POST['If_ROM_Coal,_approx._percentage_of_Shale_and_Sandstone'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bond Index (kWh/t) or Hard groove Index</dt>
                                        <dd>
                                            <input type="text" name="Bond_Index_(kWh/t)_or_Hard_groove_Index" value="<?php echo (isset($_POST['Bond_Index_(kWh/t)_or_Hard_groove_Index'])) ? $_POST['Bond_Index_(kWh/t)_or_Hard_groove_Index'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Feed analysis or Average feed size, say 80% passing size (mm)</dt>
                                        <dd>
                                            <input type="text" name="Feed_analysis_or_Average_feed_size,_say_80%_passing_size_(mm)" value="<?php echo (isset($_POST['Feed_analysis_or_Average_feed_size,_say_80%_passing_size_(mm)'])) ? $_POST['Feed_analysis_or_Average_feed_size,_say_80%_passing_size_(mm)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Max. Lump size (max. edge/diagonal length) present in feed (mm)</dt>
                                        <dd>
                                            <input type="text" name="Max._Lump_size_(max._edge/diagonal_length)_present_in_feed_(mm)" value="<?php echo (isset($_POST['Max._Lump_size_(max._edge/diagonal_length)_present_in_feed_(mm)'])) ? $_POST['Max._Lump_size_(max._edge/diagonal_length)_present_in_feed_(mm)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Desired product size (mm)</dt>
                                        <dd>
                                            <input type="text" name="Desired_product_size_(mm)" value="<?php echo (isset($_POST['Desired_product_size_(mm)'])) ? $_POST['Desired_product_size_(mm)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Any limitation in fines generation desired </dt>
                                        <dd>
                                            <input type="text" name="Any_limitation_in_fines_generation_desired" value="<?php echo (isset($_POST['Any_limitation_in_fines_generation_desired'])) ? $_POST['Any_limitation_in_fines_generation_desired'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Fresh Feed rate/ Capacity (tph)</dt>
                                        <dd>
                                            <input type="text" name="Fresh_Feed_rate/_Capacity_(tph)" value="<?php echo (isset($_POST['Fresh_Feed_rate/_Capacity_(tph)'])) ? $_POST['Fresh_Feed_rate/_Capacity_(tph)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Feeding method (dumper size, if by dumper)</dt>
                                        <dd>
                                            <input type="text" name="Feeding_method_(dumper_size,_if_by_dumper)" value="<?php echo (isset($_POST['Feeding_method_(dumper_size,_if_by_dumper)'])) ? $_POST['Feeding_method_(dumper_size,_if_by_dumper)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>No. of working shifts/day</dt>
                                        <dd>
                                            <input type="text" name="No._of_working_shifts/day" value="<?php echo (isset($_POST['No._of_working_shifts/day'])) ? $_POST['No._of_working_shifts/day'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Purpose of enquiry (Budgetary, Purchase, Feasibility report etc.)</dt>
                                        <dd>
                                            <input type="text" name="Purpose_of_enquiry_(Budgetary,_ Purchase,_Feasibility_ report_etc.)" value="<?php echo (isset($_POST['Purpose_of_enquiry_(Budgetary,_ Purchase,_Feasibility_ report_etc.)'])) ? $_POST['Purpose_of_enquiry_(Budgetary,_ Purchase,_Feasibility_ report_etc.)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>

                                <div class="product_forms_content" id="sizing_wheel_mounted_crushing_screening_plant">
                                    <dl>
                                        <dt>Material to be crushed & application e.g. construction, Road etc.</dt>
                                        <dd>
                                            <input type="text" name="Material_to_be_crushed_&_application" value="<?php echo (isset($_POST['Material_to_be_crushed_&_application'])) ? $_POST['Material_to_be_crushed_&_application'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bulk Density (t/m³)</dt>
                                        <dd>
                                            <input type="text" name="Bulk_Density_(t/m³)" value="<?php echo (isset($_POST['Bulk_Density_(t/m³)'])) ? $_POST['Bulk_Density_(t/m³)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Moisture - average / max. (%)</dt>
                                        <dd>
                                            <input type="text" name="Moisture_-_average_/_max._(%)" value="<?php echo (isset($_POST['Moisture_-_average_/_max._(%)'])) ? $_POST['Moisture_-_average_/_max._(%)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bond Index (kWh/t) / Hard groove Index/ Compressive strength (MPa)</dt>
                                        <dd>
                                            <input type="text" name="Bond_Index_(kWh/t)_/_Hard_groove_Index/_Compressive_strength_(MPa)" value="<?php echo (isset($_POST['Bond_Index_(kWh/t)_/_Hard_groove_Index/_Compressive_strength_(MPa)'])) ? $_POST['Bond_Index_(kWh/t)_/_Hard_groove_Index/_Compressive_strength_(MPa)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Feed analysis with percentage of product / undersize present in the feed</dt>
                                        <dd>
                                            <input type="text" name="Feed_analysis_with_percentage_of_product_/_undersize_present_in_the_feed" value="<?php echo (isset($_POST['Feed_analysis_with_percentage_of_product_/_undersize_present_in_the_feed'])) ? $_POST['Feed_analysis_with_percentage_of_product_/_undersize_present_in_the_feed'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Max. Lump size (max. edge/diagonal length) present in feed (mm)</dt>
                                        <dd>
                                            <input type="text" name="Max._Lump_size_(max._edge/diagonal_length)_present_in_feed_(mm)" value="<?php echo (isset($_POST['Max._Lump_size_(max._edge/diagonal_length)_present_in_feed_(mm)'])) ? $_POST['Max._Lump_size_(max._edge/diagonal_length)_present_in_feed_(mm)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Desired product size (mm)</dt>
                                        <dd>
                                            <input type="text" name="Desired_product_size_(mm)" value="<?php echo (isset($_POST['Desired_product_size_(mm)'])) ? $_POST['Desired_product_size_(mm)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Fresh feed rate/capacity (tph)</dt>
                                        <dd>
                                            <input type="text" name="Fresh_feed_rate/capacity_(tph)" value="<?php echo (isset($_POST['Fresh_feed_rate/capacity_(tph)'])) ? $_POST['Fresh_feed_rate/capacity_(tph)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Size and percentage of Natural Fines/ Clay, if removal is required</dt>
                                        <dd>
                                            <input type="text" name="Size_and_percentage_of_Natural_Fines/_Clay,_if_removal_is_required" value="<?php echo (isset($_POST['Size_and_percentage_of_Natural_Fines/_Clay,_if_removal_is_required'])) ? $_POST['Size_and_percentage_of_Natural_Fines/_Clay,_if_removal_is_required'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Feeding method (dumper size, if by dumper)</dt>
                                        <dd>
                                            <input type="text" name="Feeding_method_(dumper_size,_if_by_dumper)" value="<?php echo (isset($_POST['Feeding_method_(dumper_size,_if_by_dumper)'])) ? $_POST['Feeding_method_(dumper_size,_if_by_dumper)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>No. of working shifts/day</dt>
                                        <dd>
                                            <input type="text" name="No._of_working_shifts/day" value="<?php echo (isset($_POST['No._of_working_shifts/day'])) ? $_POST['No._of_working_shifts/day'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Purpose of enquiry (Budgetary, Purchase, Feasibility report etc.)</dt>
                                        <dd>
                                            <input type="text" name="Purpose_of_enquiry_(Budgetary,_Purchase,_Feasibility_report_etc.)" value="<?php echo (isset($_POST['Purpose_of_enquiry_(Budgetary,_Purchase,_Feasibility_report_etc.)'])) ? $_POST['Purpose_of_enquiry_(Budgetary,_Purchase,_Feasibility_report_etc.)'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="product_forms_content" id="asphalt_batching_plant">
                                    <dl>
                                        <dt>Type of plant required – Stationary or mobile</dt>
                                        <dd>
                                            <input type="text" name="Type_of_plant_required" value="<?php echo (isset($_POST['Type_of_plant_required'])) ? $_POST['Type_of_plant_required'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity (Stationary Plant)  – 160/240 TPH</dt>
                                        <dd>
                                            <input type="text" name="Capacity_Stationary_plant" value="<?php echo (isset($_POST['Capacity_Stationary_plant'])) ? $_POST['Capacity_Stationary_plant'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Capacity (Mobile Plant) – 90-120 TPH</dt>
                                        <dd>
                                            <input type="text" name="Capacity_Mobile_Plant" value="<?php echo (isset($_POST['Capacity_Mobile_Plant'])) ? $_POST['Capacity_Mobile_Plant'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>No. of Aggregate Hopper –  4 / 5 / 6</dt>
                                        <dd>
                                            <input type="text" name="No_of_Aggregate_Hopper" value="<?php echo (isset($_POST['No_of_Aggregate_Hopper'])) ? $_POST['No_of_Aggregate_Hopper'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Aggregate Hopper Capacity – 15 / 20  / 30 Cum</dt>
                                        <dd>
                                            <input type="text" name="Aggregate_Hopper_Capacity" value="<?php echo (isset($_POST['Aggregate_Hopper_Capacity'])) ? $_POST['Aggregate_Hopper_Capacity'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bitumen Tank Capacity – 30000 / 40000 / 50000 Ltr</dt>
                                        <dd>
                                            <input type="text" name="Bitumen_Tank_Capacity" value="<?php echo (isset($_POST['Bitumen_Tank_Capacity'])) ? $_POST['Bitumen_Tank_Capacity'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Diesel oil tank Capacity -10000 / 30000 Ltr </dt>
                                        <dd>
                                            <input type="text" name="Diesel_oil_tank_Capacity" value="<?php echo (isset($_POST['Diesel_oil_tank_Capacity'])) ? $_POST['Diesel_oil_tank_Capacity'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Heavy oil tank capacity – 30000 / 50000 Ltr</dt>
                                        <dd>
                                            <input type="text" name="Heavy_oil_tank_capacity" value="<?php echo (isset($_POST['Heavy_oil_tank_capacity'])) ? $_POST['Heavy_oil_tank_capacity'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Burner – Dual /single ( LDO / Fuel oil )</dt>
                                        <dd>
                                            <input type="text" name="Burner" value="<?php echo (isset($_POST['Burner'])) ? $_POST['Burner'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>
                                
                                <div class="product_forms_content" id="concrete_batching_plant">
                                    <dl>
                                        <dt>Plant Capacity – 60/90/120/150/200 Cum/ Hr</dt>
                                        <dd>
                                            <input type="text" name="Plant_Capacity" value="<?php echo (isset($_POST['Plant_Capacity'])) ? $_POST['Plant_Capacity'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Application – Building  / Road / Railway / Pavement / Dam</dt>
                                        <dd>
                                            <input type="text" name="Application" value="<?php echo (isset($_POST['Application'])) ? $_POST['Application'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>No. of Aggregate Hopper – 3 / 4 / 5  </dt>
                                        <dd>
                                            <input type="text" name="No_of_Aggregate_Hopper" value="<?php echo (isset($_POST['No_of_Aggregate_Hopper'])) ? $_POST['No_of_Aggregate_Hopper'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Aggregate Hopper Capacity – 15 / 20  / 30 Cum</dt>
                                        <dd>
                                            <input type="text" name="Aggregate_Hopper_Capacity" value="<?php echo (isset($_POST['Aggregate_Hopper_Capacity'])) ? $_POST['Aggregate_Hopper_Capacity'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of Aggregate Feeding Conveyor -  Flat Belt / Trough Belt / Chevron Belt / Skip</dt>
                                        <dd>
                                            <input type="text" name="Type_of_Aggregate_Feeding_Conveyor" value="<?php echo (isset($_POST['Type_of_Aggregate_Feeding_Conveyor'])) ? $_POST['Type_of_Aggregate_Feeding_Conveyor'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of Mixer – Twin Shaft / Twin Shaft Spiral</dt>
                                        <dd>
                                            <input type="text" name="Type_of_Mixer" value="<?php echo (isset($_POST['Type_of_Mixer'])) ? $_POST['Type_of_Mixer'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="product_forms_content" id="dry_motot_mixing_plant">
                                    <dl>
                                        <dt>Capacity  of Plant – 10 / 20 /  30 /50 TPH</dt>
                                        <dd>
                                            <input type="text" name="Capacity_of_Plant" value="<?php echo (isset($_POST['Capacity_of_Plant'])) ? $_POST['Capacity_of_Plant'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Annual Requirement in Tons</dt>
                                        <dd>
                                            <input type="text" name="Annual_Requirement_in_Tons" value="<?php echo (isset($_POST['Annual_Requirement_in_Tons'])) ? $_POST['Annual_Requirement_in_Tons'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>What kind of Mortar to be manufactured – General ( Masonry, Plaster Ground ) and Special ( Tile Adhesive, Tile Grout,  Water proof, Decorative mortar )</dt>
                                        <dd>
                                            <input type="text" name="What_kind_of_Mortar_to_be_manufactured" value="<?php echo (isset($_POST['What_kind_of_Mortar_to_be_manufactured'])) ? $_POST['What_kind_of_Mortar_to_be_manufactured'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of plant – Station  / Tower /  Stair / Customized</dt>
                                        <dd>
                                            <input type="text" name="Type_of_plant" value="<?php echo (isset($_POST['Type_of_plant'])) ? $_POST['Type_of_plant'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Finished product packing mode – Bags / Bulker</dt>
                                        <dd>
                                            <input type="text" name="Finished_product_packing_mode" value="<?php echo (isset($_POST['Finished_product_packing_mode'])) ? $_POST['Finished_product_packing_mode'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of fuel to be used to dry the sand – LDO / Fuel Oil / Coal / natural gas</dt>
                                        <dd>
                                            <input type="text" name="Type_of_fuel_to_be_used_to_dry_the_sand" value="<?php echo (isset($_POST['Type_of_fuel_to_be_used_to_dry_the_sand'])) ? $_POST['Type_of_fuel_to_be_used_to_dry_the_sand'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="product_forms_content" id="mobile_concrete_batching_plant">
                                    <dl>
                                        <dt>Plant Capacity  – 50 /75/100 Cum/ Hr</dt>
                                        <dd>
                                            <input type="text" name="Plant_Capacity" value="<?php echo (isset($_POST['Plant_Capacity'])) ? $_POST['Plant_Capacity'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Application – Building  / Road / Railway / pavement / Dam</dt>
                                        <dd>
                                            <input type="text" name="Application" value="<?php echo (isset($_POST['Application'])) ? $_POST['Application'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Aggregate Hoppers – 4 bin system / 2 bin system</dt>
                                        <dd>
                                            <input type="text" name="Aggregate_Hoppers" value="<?php echo (isset($_POST['Aggregate_Hoppers'])) ? $_POST['Aggregate_Hoppers'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Aggregate Hopper capacity –  7.5 / 15 Cum</dt>
                                        <dd>
                                            <input type="text" name="Aggregate_Hopper_capacity" value="<?php echo (isset($_POST['Aggregate_Hopper_capacity'])) ? $_POST['Aggregate_Hopper_capacity'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Type of Mixer – Twin Shaft / Twin Shaft Spiral</dt>
                                        <dd>
                                            <input type="text" name="Type_of_Mixer" value="<?php echo (isset($_POST['Type_of_Mixer'])) ? $_POST['Type_of_Mixer'] : ''?>" class="form-control"/>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="product_forms_content" id="other_query">
                                    <dl>
                                        <dt>Query</dt>
                                        <dd>
                                            <textarea name="query" cols="40" rows="10" class="form-control"/><?php echo (isset($_POST['query'])) ? $_POST['query'] : ''?></textarea>
                                        </dd>
                                    </dl>
                                </div>
                                <br style="clear:both" />
                            </div>
                            <br style="clear:both" />
                        </dd>
                    </dl>
                    <dl class="space-dl-none">
                        <dt>Enter Image Verification Code *</dt>
                        <dd>
                            <img class="" width="72" height="24" alt="captcha" src="<?php echo get_template_directory_uri();?>/captcha/CaptchaSecurityImages.php?width=100&height=40&characters=5" />
                        </dd>
                    </dl>
                    <dl class="space-dl-none">
                        <dt></dt>
                        <dd>
                            <input type="text" name="security_code" id="security_code" value="" class="form-control"/>
                        </dd>
                    </dl>
                    <dl class="space-dl-none">
                        <dt></dt>
                        <dd>
                            <input type="hidden" name="hidden_data_rel" id="hidden_data_rel" value="<?php echo (isset($_POST['hidden_data_rel'])) ? $_POST['hidden_data_rel'] : ''?>"/>
                            <!--<input type="hidden" name="sub_products" id="sub_products" value="<?php // echo (isset($_POST['sub_products'])) ? $_POST['sub_products'] : ''?>"/>-->
                            <input type="submit" name="bq_submit" value="Submit" class="btn" /> 
                            <input type="reset" value="Reset" class="btn">
                        </dd>
                    </dl>
                </form>
            </div>
        <div class="clr"></div>
    </article>
</div>
<div class="clr"></div>
<?php get_footer();?>