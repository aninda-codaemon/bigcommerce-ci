<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	    <title>Bootstrap 101 Template</title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/style.css">
	</head>
	<body>
		<div class="container custom-container">
		    <div class="row">
		        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-top-20 padding-0">
		            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-0">
		                <h3 class="product-title">Order Fraud Check</h3>
		            </div>
		            <?php
		            	//echo '<pre>';print_r($all_orders);

		            ?>

		            <div id="order_data_container" >

			            <table class="table table-box table-striped" >
				            <thead class="table-head">
				                <tr>
				                    <th>Date</th>
				                    <th>Order ID</th>
				                    <th>Billing Details</th>
				                    <th>Shipping Details</th>
				                    <th>Status</th>
				                    <th>Total</th>
				                    <th>Action</th>
				                </tr>
				            </thead>

			              	<tbody class="table-body" >
			              		<?php 
			              			if($lastid == 0) {
	                                	foreach ($all_orders as $order) { 
	                            ?>
				                <tr>
				                    <td><?php echo date("M d, h:sa", strtotime($order['order_create_date'])) ?></td>
				                    <td><?php echo $order['increment_id']; ?></td>
				                    <td>
				                    	<?php echo $order['billing_firstname'] . ' ' . $order['billing_lastname'] . '<br>'; ?>
				                    	<?php
	                                    	echo $order['billing_street'] . ', ' . $order['billing_city'] . '<br>' . $order['billing_region'] . ', ' . $order['billing_country_id'] . ' - ' . $order['billing_postcode'];
	                                    ?>
				                    </td>
				                    <td>
				                    	<?php echo $order['shipping_firstname'] . ' ' . $order['shipping_lastname'] . '<br>'; ?>
				                    	<?php
	                                    	echo $order['shipping_street'] . ', ' . $order['shipping_city'] . '<br>' . $order['shipping_region'] . ', ' . $order['shipping_country_id'] . ' - ' . $order['shipping_postcode'];
	                                    ?>
				                    </td>			                    
				                    <td class="position-rel">
				                    	<span class="blue-bar"></span>
				                    	<?php
				                    		$order_description = json_decode(unserialize($order['order_description']), true);

	                                        //print_r(json_decode(unserialize($order['order_description']), true));
	                                        $fullfill = is_null($order_description['status']) ? 'unfulfilled' : $order_description['status'];
	                                        if($fullfill == 'processing') {
	                                            $color = 'red';
	                                        } else if($fullfill == 'partial') {
	                                            $color = 'grey';
	                                        } else if($fullfill == 'unfulfilled') {
	                                            $color = 'yellow';
	                                        }else if($fullfill == 'complete') {
	                                            $color = 'green';
	                                        }
	                                    ?>
				                    	<?php echo $order_description['status'] ?>
				                    </td>
				                    <td><?php echo $order['base_currency_code'] . $order['base_grand_total'] ?></td>
				                    <td class="text-center">
				                    	<?php
	                                        //echo '<pre>';print_r($order);

	                                        $b_address = $order['billing_street'].' '.$order['billing_city'].' '.$order['billing_region'].' '.$order['billing_postcode'].' '.$order['billing_country_id'];
	                                        $s_address = $order['shipping_street'].' '.$order['shipping_city'].' '.$order['shipping_region'].' '.$order['shipping_postcode'].' '.$order['shipping_country_id'];

	                                        // $check_link = 'https://www.knowthycustomer.com/f/generate/fraud?billing_first_name='.((isset($order['b_first_name']) && !empty($order['b_first_name']))?$order['b_first_name']:'Not Available').'&billing_middle_name=&billing_last_name='.((isset($order['b_last_name']) && !empty($order['b_last_name']))?$order['b_last_name']:'Not Available').'&billing_address='.((isset($b_address) && !empty($b_address))?$b_address:'Not Available').'&billing_ip_address='.$ip_address.'&billing_email='.((isset($order['contact_email']) && !empty($order['contact_email']))?$order['contact_email']:'Not Available').'&billing_phone='.((isset($order['contact_email']) && !empty($order['b_phone']))?$order['b_phone']:'Not Available').'&shipping_first_name='.((isset($order['s_first_name']) && !empty($order['s_first_name']))?$order['s_first_name']:'Not Available').'&shipping_middle_name=&shipping_last_name='.((isset($order['s_last_name']) && !empty($order['s_last_name']))?$order['s_last_name']:'Not Available').'&shipping_address='.((isset($s_address) && !empty($s_address))?$s_address:'Not Available').'&shipping_email='.((isset($order['contact_email']) && !empty($order['contact_email']))?$order['contact_email']:'Not Available').'&shipping_phone='.((isset($order['s_phone']) && !empty($order['s_phone']))?$order['s_phone']:'Not Available');
	                                        $check_link = 'https://www.knowthycustomer.com/f/generate/fraud?billing_first_name='.$order['billing_firstname'].'&billing_middle_name=&billing_last_name='.((isset($order['billing_lastname']) && !empty($order['billing_lastname']))?$order['billing_lastname']:'Not Available').'&billing_address='.((isset($b_address) && !empty(trim($b_address)))?$b_address:'Not Available').'&billing_ip_address='.$ip_address.'&billing_email='.$order['billing_email'].'&billing_phone='.$order['billing_telephone'].'&shipping_first_name='.$order['shipping_firstname'].'&shipping_middle_name=&shipping_last_name='.$order['shipping_lastname'].'&shipping_address='.$s_address.'&shipping_email='.$order['shipping_email'].'&shipping_phone='.$order['shipping_telephone'];
	                                    ?>
				                    	<button onclick="opennewtab('<?php echo $check_link; ?>')">Run Fraud Check</button>
				                    </td>
				                </tr>
				                <?php } ?>
	                                <!--<tr class="display-none" id="lastid"><td><?php echo $lastordernew = $order['increment_id'];?></td></tr>
	                                <tr class="display-none" id="pagecount"><td><?=$count?></td></tr>-->
	                            <?php } ?>

			              	</tbody>

			            </table>

			            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-0">
			                <ul class="pager custom-pager">
			                	<?php if ($current_page > 1){ ?>
			                    	<li class="pull-left"><a data-href="<?php echo ($current_page - 1); ?>" href="javascript: void(0)" id="prevpage" class="page-link" >Previous</a></li>
			                    <?php } ?>
			                    <?php
	                                //echo $total_page.' '.$next_page;
	                                if ($next_page <= $total_page){
	                            ?>
			                    	<li class="pull-right"><a data-href="<?php echo ($next_page); ?>" href="javascript: void(0)" id="nextpage" class="page-link" >Next</a></li>
			                    <?php } ?>
			                </ul>
			            </div>

		        	</div>

		        </div>		  

		    </div>    
		</div>
	</body>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script>
            
            $(document).on('click', '.page-link', function(e){
                e.stopImmediatePropagation();
                console.log($(this).attr('data-href'));
                var page = $(this).attr('data-href');
                
                var response = JSON.parse($.ajax({
                                    url: '<?php echo base_url(); ?>bigcommerce/ajax_get_order_page',
                                    type: 'POST',
                                    data: {'page': page},
                                    dataType: 'json',
                                    async: false
                                }).responseText);

                console.log(response);
                $('#order_data_container').html(response.page_data);
            });

            function opennewtab(url){
                var win = window.open(url, '_blank');
            }
        </script>
</html>