<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>User Registration</title>
        <?php $this->load->view('common/front_css'); ?>
    </head>
    <body>
        <header class="custom-head">
            <article>
                <div class="columns four">
                    <div class="logo-image align-left">
                        <img src="<?php echo base_url(); ?>public/img/img_logo_with_text.png" alt="" width="200em">
                    </div>
                </div>
                <div class="columns eight align-right">
                    <p class="text-contact text-Navy">Need assistance? Call <span class="text-Teal">1-844-823-2869</span> or email <a href="mailto:support@knowthycustomer.com" class="text-Teal">support@knowthycustomer.com</a>
                    </p>
                </div>
            </article> 
        </header>
        <section class="full-width">
            <article>
                <div class="card blue-bg">
                    <div class="columns">
                        <form class="form-horizontal" id="signup_user" action="signup_user" method="post">
                            <h2 class="text-Teal align-center">Ship with More Confidence</h2>
                            <p class="text-white align-center" style="margin:auto; width:80%;">Know more about who you're shipping to before you ship. Create your free KnowThyCustomer account below to view fraud reports for your Shopify orders.</p>
                            <article class="margin-top-1">
                                <?php
                                    $tmp = explode(' ', $store_info['store_username']);
                                    $store_info['first_name'] = $tmp[0];
                                    $store_info['last_name'] = $tmp[1];
                                ?>
                                <div class="columns six text-white">
                                    <div class="row">
                                        <label class="text-white">First Name</label>
                                        <input id="fn" name="fn" type="text" value="<?= $store_info['first_name'] ?>" class="form-control input-md" data-bvalidator="alpha,required" data-bvalidator-msg="First name is required and only letters are allowed.">
                                        <input id="userid" name="userid" type="hidden" value="<?= $store_info['id'] ?>" class="display-none form-control input-md" >
                                    </div>
                                    <div class="row">
                                        <label class="text-white">Email Address</label>
                                        <input id="email" name="email" type="text" value='<?= $store_info['store_email'] ?>' class="form-control input-md" data-bvalidator="email,required" data-bvalidator-msg="Email is required.">
                                    </div>
                                    <div class="row">
                                        <label class="text-white">Company</label>
                                        <input id="cmpny" name="cmpny" type="text" placeholder="Company name" class="form-control input-md" data-bvalidator="required" data-bvalidator-msg="Enter your company name.">
                                    </div>
                                </div>

                                <div class="columns six text-white">
                                    <div class="row">
                                        <label class="text-white">Last Name</label>
                                        <input id="ln" name="ln" type="text" value='<?= $store_info['last_name'] ?>' class="form-control input-md" data-bvalidator="alpha,required" data-bvalidator-msg="Last name is required and only letters are allowed.">
                                    </div>
                                    <div class="row">
                                        <label class="text-white">Phone Number</label>
                                        <input id="phone" name="phone" type="text" placeholder="123-456-7899" class="form-control input-md" data-bvalidator="regex[^\(\d{3}\) ?\d{3}( |-)?\d{4}|^\d{3}( |-)?\d{3}( |-)?\d{4}],required" data-bvalidator-msg="Phone number is required.">
                                    </div>
                                    <div class="row">
                                        <label class="text-white">Job Title</label>
                                        <input id="jobt" name="jobt" type="text" placeholder="Job title" class="form-control input-md" data-bvalidator="required" data-bvalidator-msg="Enter your job title.">
                                    </div>
                                </div>
                            </article>
                            <article class="margin-top-1">
                                <div class="columns one text-white">
                                    <div class="row">
                                        <label class="text-white">
                                            <input id="tos" type="checkbox" name="tos" value="1" data-bvalidator="required,required"  data-bvalidator-msg="You must agree with our Terms of Service to create an account."> 
                                        </label>
                                    </div>
                                </div>
                                <div class="columns eleven text-white">
                                    <div class="row">
                                        <p class="text-white text-terms">By clicking the checkbox you represent that you are over 18 years of age and agree to accept our <span class="text-Teal">Terms of Service</span> and <span class="text-Teal">Privacy Policy</span>. You agree that you will not use any information about an individual obtained from KnowThyCustomer as a factor in determining an individual's eligibility for employment; tenancy; educational admission or benefits; personal credit, loans, or insurance; or for any other purpose prohibited by our <span class="text-Teal">Terms of Service</span>. For more information about whether a use of information falls under one of these categories, please contact us at <a href="mailto:support@knowthycustomer.com" class="text-Teal">support@knowthycustomer.com</a></p>
                                    </div>
                                </div>
                            </article>
                            <article class="margin-top-1">
                                <div class="columns six text-white">
                                    <div class="row">
                                        <label class="text-white">Create Password</label>
                                        <input id="pwd" name="pwd" type="password" placeholder="Password" class="form-control input-md" data-bvalidator="minlength[8],required" data-bvalidator-msg="Enter your new password. Minimum length is 8 characters.">
                                    </div>
                                </div>
                                <div class="columns six text-white">
                                    <div class="row">
                                        <label class="text-white">Confirm Password</label>
                                        <input id="rpwd" name="rpwd" type="password" placeholder="Re-enter password" class="form-control input-md" data-bvalidator="equalto[pwd],required" data-bvalidator-msg="This password must match.">
                                    </div>
                                </div>
                            </article>
                            <article class="align-right margin-top-2">
                                <div class="columns">
                                    <button class="btn-Teal" id="form_submit_btn">Create Your Account</button>
                                </div>
                            </article>
                        </form>
                    </div>
                    <div class="columns margin-top-5">
                        <h2 class="text-Teal align-center">Why sign up for KnowThyCustomer?</h2>
                        <article>
                            <div class="columns six">
                                <img src="<?php echo base_url(); ?>public/img/dashboard.png" style="width:100%">
                            </div>
                            <div class="columns six">
                                <h6 class="customer-heading ">We scan your order for over 20 fraud indicators including:</h6>
                                <ul class="customer-list">
                                    <li>Name matches address</li>
                                    <li>Address is valid</li>
                                    <li>Name matches phone</li>
                                    <li>Phone is associated with address</li>
                                    <li>Phone is valid</li>
                                    <li>Name matches email</li>
                                    <li>Email is valid</li>
                                    <li>Age of email</li>
                                    <li>Social media tied to email</li>
                                    <li>Distance of IP address to billing address</li>
                                    <li>IP address is a known proxy</li>
                                </ul>
                                <h6 class="customer-heading margin-top-2">Other KnowThyCustomer account benefits include:</h6>
                                <ul class="customer-list">
                                    <li>Person, property, phone and email reports</li>
                                    <li>Updated contact info for past customers</li>
                                    <li>Build custom audiences for marketing</li>
                                    <li>Find contact info for sales leads</li>
                                </ul>
                            </div>
                        </article>
                    </div>
                </div>
            </article>
        </section>
        <?php $this->load->view('common/footer_js'); ?>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>-->
        <script>
            $(document).ready(function () {
                var optionsBootstrap = {
                    position: {x: 'left', y: 'top'},
                    offset: {x: 15, y: -10},
                };
                $('#signup_user').bValidator(optionsBootstrap);
            });
        </script>
    </body>    
</html>