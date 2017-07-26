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