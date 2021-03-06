<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Order List</title>
        <?php $this->load->view('common/front_css'); ?>
    </head>
    <body>
        <header class="custom-head">
            <article>
                <div class="columns four">
                    <div class="logo-image align-left">
                        <img src="<?php echo base_url();?>public/img/img_logo_with_text.png" alt="" width="200em">
                    </div>
                </div>
                <div class="columns eight align-right">
                    <div class="btn-visit">
                        <button class="btn-Teal" onclick="opennewtab('https://www.knowthycustomer.com/')">Visit KnowThyCustomer <i class="fa fa-share-square-o" aria-hidden="true"></i></button>
                    </div>
                </div>
            </article>
        </header>
        <section class="full-width">
            <article class="">
                <p class="T-margin-2">Click the "Run Fraud Check" button to view fraud indicators for any of your orders below. Your KnowThyCustomer Fraud Check will open in a new browser tab.</p>

            </article>
        </section>
        <section class="full-width" id="mainframe">
            <article>
                <div class="columns has-sections card">
                    <ul class="tabs">
                        <li class="active"><a href="#">All Orders</a></li>
                    </ul>

                    <div class="card-section" id="order_data_container" >
                        
                        <table class="table-customer" id="order_list">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Customer</th>                                    
                                    <th>Payment Status</th>
                                    <th>Fulfillment Status</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($lastid == 0) {
                                 foreach ($all_orders as $order) { ?>                    
                                    <tr>
                                        <td><a href="javascript: void(0)" >#<?php echo $order['increment_id']; ?></a></td>
                                        <td><?= date("M d, h:sa", strtotime($order['order_create_date'])) ?></td>
                                        <td>
                                            <address>
                                                <strong>
                                                    <?php echo $order['customer_firstname'] . ' ' . $order['customer_lastname']; ?>
                                                    <!--<a class="red-text" target="_blank" href="https://www.knowthycustomer.com/f/search/person?age=&city=&fn=<?= $order['customer']['first_name'] ?>&ln=<?= $order['customer']['last_name'] ?>&mn=&state=&address=&phone=&email=&ip="><?php echo $order['customer']['first_name'] . ' ' . $order['customer']['last_name']; ?></a>-->
                                                </strong>
                                                <br><span class="font-normal">
                                                <?php
                                                    echo $order['shipping_street'] . ', ' . $order['shipping_city'] . '<br>' . $order['shipping_region'] . ', ' . $order['shipping_country_id'] . ' - ' . $order['shipping_postcode'];
                                                ?></span>
                                            </address>
                                        </td>

                                        <td>
                                            <?php 

                                                $order_description = json_decode(unserialize($order['order_description']), true);
                                                
                                                $color = '';
                                                $pay_txt = '';
                                                $payment = $order_description['total_due'];

                                                if($payment == 0) {
                                                    $color = 'green';
                                                    $pay_txt = 'Paid';
                                                } else if($payment == 'partially_refunded') {
                                                    $color = 'yellow';
                                                } else if($payment < $order['base_grand_total']) {
                                                    $color = 'grey';
                                                    $pay_txt = 'Partially Paid';
                                                } else if($payment == 'pending') {
                                                    $color = 'orange';
                                                } else if($payment == 'refunded') {
                                                    $color = 'blue';
                                                } else if($payment == $order['base_grand_total']) {
                                                    $color = 'red';
                                                    $pay_txt = 'Payment Due';
                                                } else if($payment == 'voided') {
                                                    $color = 'lightblue';
                                                }
                                            ?>
                                            <span class="tag <?=$color?>"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$pay_txt?></span>
                                        <td>
                                            <?php
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
                                            <span class="tag <?=$color?>"><?=$fullfill?></span>
                                        </td>
                                        <td><?= $order['base_grand_total'] ?></td>
                                        <td>
                                            <?php
                                                //echo '<pre>';print_r($order);

                                                $b_address = $order['billing_street'].' '.$order['billing_city'].' '.$order['billing_region'].' '.$order['billing_postcode'].' '.$order['billing_country_id'];
                                                $s_address = $order['shipping_street'].' '.$order['shipping_city'].' '.$order['shipping_region'].' '.$order['shipping_postcode'].' '.$order['shipping_country_id'];
                                                // $check_link = 'https://www.knowthycustomer.com/f/generate/fraud?billing_first_name='.((isset($order['b_first_name']) && !empty($order['b_first_name']))?$order['b_first_name']:'Not Available').'&billing_middle_name=&billing_last_name='.((isset($order['b_last_name']) && !empty($order['b_last_name']))?$order['b_last_name']:'Not Available').'&billing_address='.((isset($b_address) && !empty($b_address))?$b_address:'Not Available').'&billing_ip_address='.$ip_address.'&billing_email='.((isset($order['contact_email']) && !empty($order['contact_email']))?$order['contact_email']:'Not Available').'&billing_phone='.((isset($order['contact_email']) && !empty($order['b_phone']))?$order['b_phone']:'Not Available').'&shipping_first_name='.((isset($order['s_first_name']) && !empty($order['s_first_name']))?$order['s_first_name']:'Not Available').'&shipping_middle_name=&shipping_last_name='.((isset($order['s_last_name']) && !empty($order['s_last_name']))?$order['s_last_name']:'Not Available').'&shipping_address='.((isset($s_address) && !empty($s_address))?$s_address:'Not Available').'&shipping_email='.((isset($order['contact_email']) && !empty($order['contact_email']))?$order['contact_email']:'Not Available').'&shipping_phone='.((isset($order['s_phone']) && !empty($order['s_phone']))?$order['s_phone']:'Not Available');
                                                $check_link = 'https://www.knowthycustomer.com/f/generate/fraud?billing_first_name='.$order['billing_firstname'].'&billing_middle_name=&billing_last_name='.((isset($order['billing_lastname']) && !empty($order['billing_lastname']))?$order['billing_lastname']:'Not Available').'&billing_address='.((isset($b_address) && !empty(trim($b_address)))?$b_address:'Not Available').'&billing_ip_address='.$ip_address.'&billing_email='.$order['billing_email'].'&billing_phone='.$order['billing_telephone'].'&shipping_first_name='.$order['shipping_firstname'].'&shipping_middle_name=&shipping_last_name='.$order['shipping_lastname'].'&shipping_address='.$s_address.'&shipping_email='.$order['shipping_email'].'&shipping_phone='.$order['shipping_telephone'];
                                            ?>
                                            
                                            <button class="btn-Blue" onclick="opennewtab('<?php echo $check_link; ?>')">Run Fraud Check <i class="fa fa-share-square-o" aria-hidden="true"></i></button>
                                            
                                            <a target="_blank" href="https://<?php echo str_replace('s/', '-', $store_info['store_context']); ?>.mybigcommerce.com/admin/index.php?ToDo=editOrder&orderId=<?php echo $order['increment_id']; ?>">Edit</a>
                                            <a target="_blank" href="https://<?php echo str_replace('s/', '-', $store_info['store_context']); ?>.mybigcommerce.com/admin/index.php?ToDo=printOrderInvoice&orderId=<?php echo $order['increment_id']; ?>">Print Invoice</a>
                                            <a target="_blank" href="https://<?php echo str_replace('s/', '-', $store_info['store_context']); ?>.mybigcommerce.com/admin/index.php?ToDo=printShipmentPackingSlips&orderId=<?php echo $order['increment_id']; ?>">Print Packing Slip</a>
                                            <!--<a target="_blank" href="https://<?php echo str_replace('s/', '-', $store_info['store_context']); ?>.mybigcommerce.com/admin/index.php?ToDo=viewOrders#">Resend Invoice</a>-->
                                            <a target="_blank" href="https://<?php echo str_replace('s/', '-', $store_info['store_context']); ?>.mybigcommerce.com/admin/index.php?ToDo=viewOrderMessages&orderId=<?php echo $order['increment_id']; ?>">Send Message</a>
                                            <!--<a target="_blank" href="https://<?php echo str_replace('s/', '-', $store_info['store_context']); ?>.mybigcommerce.com/admin/remote.php?remoteSection=orders&w=viewOrderNotes&orderId=<?php echo $order['increment_id']; ?>">View Notes</a>-->
                                            <!--<a target="_blank" href="https://<?php echo str_replace('s/', '-', $store_info['store_context']); ?>.mybigcommerce.com/admin/index.php?ToDo=viewOrders#">Ship Items</a>-->
                                        </td>
                                    </tr>
                                <?php } ?>
                                    <tr class="display-none" id="lastid"><td><?php echo $lastordernew = $order['increment_id'];?></td></tr>
                                    <tr class="display-none" id="pagecount"><td><?=$count?></td></tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Pagination Options -->
                        <div id="navdiv">                            
                            
                            <p class="display-none" id="ocount"></p>
                            <?php
                                if ($current_page > 1){
                            ?>
                            <button data-href="<?php echo ($current_page - 1); ?>" style="float: left;" class="btn-Blue page-link" id="prevpage">Prev</button>
                            <?php } ?>

                            <?php
                                //echo $total_page.' '.$next_page;
                                if ($next_page <= $total_page){
                            ?>
                            <button data-href="<?php echo ($next_page); ?>" style="text-align:right;" class="btn-Blue page-link" id="nextpage">Next</button>
                            <?php } ?>

                        </div>
                        <!-- Pagination Options -->

                    </div>
                    
                </div>
            </article>
        </section>
        <?php $this->load->view('common/footer_js'); ?>
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
    </body>
</html>