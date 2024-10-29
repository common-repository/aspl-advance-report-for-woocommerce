<?php
if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}
function war_advance_report_dashboard()
{
	?>
	<div class="advance-report" style=" padding:20px; margin: 0px;">
		<h5 style="background-color: white; padding:10px;">Report Dashboard</h5>
		<!-- First Section....... -->
		<div class="first-section container-flude" style="color: white;">
		  	<div class="row" id="sortable" data-par_id="p2">

			  	<!-- Sales -->
			    <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c1">
			    	<div class="block light-blue" style="border-top:5px solid #151965;">
			    		<div class="static_contant">
				    		<h3 style="color:#151965;">Total Sales</h3>
				    		<?php
					    		global $woocommerce;
					    		global $product;
						        $customer_orders = get_posts( array(
						            'numberposts' => -1,
						            'meta_key'    => '_customer_user',
						            'post_type'   => wc_get_order_types(),
						            'post_status' => array_keys( wc_get_order_statuses() ),
						        ) );
						        $final_order_total = 0;
						        $total_order = count($customer_orders);
						        $payment_gateway = [];
						        foreach ($customer_orders as $order) 
						        {      
						     		$order_id = $order->ID;        
						          	$order_data = wc_get_order($order_id);
						          	
						          	// Order total
						        	$order_total = $order_data->get_total();
						        	$final_order_total = $final_order_total + $order_total;

						        	// Order Shipping Total
						        	$order_shipping = $order_data->get_total_shipping();
						        	$final_shipping_total = 0;   	
						          	$final_shipping_total = $final_shipping_total + $order_shipping;

						          	//Order Tax Total
						          	$final_tax_total = '0';
						          	$shipping_tax_total = '0';
						        	$order_tax = $order_data->get_total_tax();
						          	$final_tax_total = $final_tax_total + $order_tax;
						          	//Order Shipping Tax Total
						          	$shipping_tax = $order_data->get_shipping_tax();
						          	$shipping_tax_total = $shipping_tax_total + $shipping_tax;

						          	//Order Payment Gateway
						          	$payment_method = get_post_meta( $order_id, '_payment_method_title', true );

						          	if(array_key_exists($payment_method, $payment_gateway))
						          	{
						          		$old_value = $payment_gateway[$payment_method];
						          		$new_value = $old_value + $order_total;
						          		$payment_gateway[$payment_method] = $new_value;
						          	}
						          	else{
						          		$payment_gateway[$payment_method] = $order_total;
						          	}
						        }		

						        // Function to return user count


						     					
						    ?>
							<p><?php 

							$numberAsString = number_format($final_order_total, 2);

							 echo esc_html(get_woocommerce_currency_symbol().$numberAsString); 
							 ?></p>
						</div>

						<div class="static_img">
							<span style="font-size: 55px; color: #151965;"><i class="fa fa-shopping-cart"></i></span>
					    </div>  
			    	</div>
		        </div>
		        <!-- End Sales -->

		        <!-- Orders -->
		        <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c2">
			    	<div class="block light-blue" style="border-top:5px solid #32407b;" >
			    		<div class="static_contant">
				    		<h3 style="color:#32407b;" >Total Orders</h3>
				    		<p><?php echo esc_html('#'.$total_order); ?></p>
			    		</div>
			    		<div class="static_img">
							<span style="font-size: 55px; color:  #32407b;"><i class="fa fa-truck"></i></span>
			    		</div>
			    	</div>
			    </div>
			    <!-- End Orders -->

			    <!-- Average sales per order -->
			    <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c3">
			    	<div class="block light-blue" style="border-top:5px solid #515585;">
			    		<div class="static_contant">
			    		<h3 style="color:#515585;">Average sales per order</h3>
			    		<p><?php 

			    				if ( ($final_order_total > 0) && ($total_order > 0) ) {
						          	$avg_price = $final_order_total/$total_order;
						          	$numberAsString1 = number_format($avg_price, 2);
				    				echo esc_html(get_woocommerce_currency_symbol().$numberAsString1); ?></p>
				    			<?
			    				}else{
			    					echo esc_html(get_woocommerce_currency_symbol().'0.00');	
			    				}
			    				?>
			    		</div>
			    		<div class="static_img">
							<span style="font-size: 55px; color:  #515585;"><i class="fa fa-chart-line"></i></span>
			    		</div>
			    	</div>
			    </div>
			    <!-- End Average sales per order -->

			    <!-- Total Refund -->
			    <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c4">
			    	<div class="block light-blue" style="border-top:5px solid #46b5d1;" >
			    		<div class="static_contant">
			    		<h3 style="color:#46b5d1;">Total Refund</h3>
			    		<p><?php 

							$filters = array(
							    'post_status' => array( 'wc-completed' ),
							    'post_type' => 'shop_order',
							    'posts_per_page' => 200,
							    'paged' => 1,
							    'orderby' => 'modified',
							    'order' => 'ASC'
							);

							$loop = new WP_Query($filters);
							$add_total = 0;
							$r_item_count =0; 
							while ($loop->have_posts()) {
							    $loop->the_post();
							    $order = new WC_Order($loop->post->ID);

							   $test =  $order->get_total_refunded();
							   $r_item = $order->get_item_count_refunded();
							   $r_item_count = $r_item_count+$r_item;
							   $add_total = $add_total + $test;
							}
							echo esc_html('#'.$r_item_count);
							?><br><?php
							$numberAsString2 = number_format($add_total, 2);

							echo esc_html(get_woocommerce_currency_symbol().$numberAsString2);

			    		 ?></p>
			    		</div>
			    		<div class="static_img">
							<span style="font-size: 55px; color: #46b5d1;"><i class="fa fa-undo"></i></span>
			    		</div>
			    	</div>
			    </div>
			    <!-- End Total Refund -->

			    <!-- Total TAX -->
			    <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c5">
			    	<div class="block light-blue" style="border-top:5px solid #801336;" >
			    		<div class="static_contant">
			    		<h3 style="color:#801336;">Total TAX</h3>
			    		<p><?php
			    		 
						$numberAsString3 = number_format($final_tax_total, 2);

			    		 echo esc_html(get_woocommerce_currency_symbol().$numberAsString3);

			    		  ?></p>
			    		</div>
			    		<div class="static_img"> 
							<span style="font-size: 55px; color: #801336;"><i class="fa fa-money-check"></i></span>
			    		</div>
			    	</div>
			    </div>
			    <!-- End Total TAX -->

			    <!-- Total Products -->
			    <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c6">
			    	<div class="block light-blue" style="border-top:5px solid #ee4540;" >
			    		<div class="static_contant">
				    		<h3 style="color:#ee4540;">Total Products</h3>
				    		<?php 
				    			global $wpdb;
								$sql = "SELECT COUNT(*) AS 'product_count'  FROM {$wpdb->prefix}posts as posts WHERE  post_type='product' AND post_status = 'publish'";
									
				    		 ?>
				    		<p><?php echo esc_html('#'.$wpdb->get_var($sql)); ?></p>
			    		</div>
			    		<div class="static_img">
							<span style="font-size: 55px; color: #ee4540;"><i class="fa fa-boxes"></i></span>
			    		</div>
			    	</div>
			    </div>
			    <!-- End Total Products -->

			    <!-- Total Category-->
			    <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c7">
			    	<div class="block  light-blue" style="border-top:5px solid #c72c41;" >
			    		<div class="static_contant">
				    		<h3 style="color:#c72c41;">Total Category</h3>
						    	<?php 
								  	$taxonomy     = 'product_cat';
								  	$orderby      = 'name';  
								  	$show_count   = 0;      // 1 for yes, 0 for no
								  	$pad_counts   = 0;      // 1 for yes, 0 for no
								  	$hierarchical = 1;      // 1 for yes, 0 for no  
								  	$title        = '';  
								  	$empty        = 0;

								  	$args = array(
								        'taxonomy'     => $taxonomy,
								        'orderby'      => $orderby,
								        'show_count'   => $show_count,
								        'pad_counts'   => $pad_counts,
								        'hierarchical' => $hierarchical,
								        'title_li'     => $title,
								        'hide_empty'   => $empty
								  	);
								 	$all_categories = get_categories( $args );
								 	// echo ;
						     	?>
				    		<p><?php echo esc_html('#'.count($all_categories)); ?></p>
				    	</div>
			    		<div class="static_img">
							<span style="font-size: 55px; color: #c72c41;"><i class="fa fa-list-alt"></i></span>
			    		</div>
			    	</div>
			    </div>
			    <!-- End Total Category-->

			    <!-- Total Registered Customers -->
			    <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c8">
			    	<div class="block light-blue" style="border-top:5px solid #053f5e;">
			    		<div class="static_contant">

				    		<h3 style="color:#053f5e;">Total Registered Customers</h3>
				    		<p><?php $usercount = count_users();
								$result = $usercount['total_users']; 
								echo esc_html('#'.$result); ?></p>
						</div>
			    		<div class="static_img"> 
							<span style="font-size: 55px; color: #053f5e;"><i class="fa fa-user"></i></span>
			    		</div>
			    	</div>
			    </div>
			    <!-- End Total Registered Customers -->

			    <!-- Total Guest Customers -->
				    <!-- <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c9">
				    	<div class="block light-blue" >
				    		<div class="static_contant">
					    		<h3>Total Guest Customers</h3>
					    		<p><?php //echo "#3"; ?></p>
					    	</div>
					    	<div class="static_img">
				    			<img src="<?php //echo plugins_url('../images/static_icon.png', __FILE__);?>">
				    		</div>
				    	</div>
				    </div> -->
			    <!-- End Total Total Guest Customers -->

			    <!-- Total Coupons -->
			    <div class="col-lg-3 col-md-6 col-sm-6" data-col_id="c9">
			    	<div class="block light-blue" style="border-top:5px solid #2d132c;">
			    		<div class="static_contant">
				    		<h3 style="color:#2d132c;">Total Coupons</h3>
				    		<p><?php 
				    			$args = array(
								    'posts_per_page'   => -1,
								    'orderby'          => 'title',
								    'order'            => 'asc',
								    'post_type'        => 'shop_coupon',
								    'post_status'      => 'publish',
								);
								    
								$coupons = get_posts( $args );
								echo esc_html('#'.count($coupons));
				    		 ?></p>
				    	</div>
				    	<div class="static_img">
							<span style="font-size: 55px; color: #2d132c;"><i class="fa fa-tags"></i></span>
			    		</div>
			    	</div>
			    </div>
			    <!-- End Total Coupons -->
		       
		  	</div>
		</div>

		<!-- Second Section ....... -->
		<div class="second-section container-flude">
			<div class="row" id="sortable1" data-par_id="p3">

			<!-- s v1 -->
			 	<div class="col-md-6 this-month" data-col_id="v1">
			 	
			 		<!-- start block Sales This Month done -->
			 		<div class="block" style="border-top: 5px solid #faaaa5;">
			 			<div class="title" style="border-color: #faaaa5;" >Sales This Month</div>
			 			<div class="content" style="display:none;">
				 			<?php 
						 		$current_month_days=date('t');
						 		$today = getdate();
						 		$today_date = date('j');
							    $month_orders = get_posts( array(
										      	'numberposts' => - 1,
									    	   	'meta_key'    => '_customer_user',
									        	'post_type'   => array( 'shop_order' ),
									        	'post_status' => array_keys( wc_get_order_statuses() ),
									        	'date_query' => array(
										            'after' => date('Y-m-d', strtotime('-'.$current_month_days.' days')),
										            'before' => date('Y-m-d', strtotime('today')) 
									       		)
									    		) );
							    for ($i=1; $i <= $today_date; $i++)
							    { 
							    	$single_day_orders = get_posts(array(
									    'meta_key'          => '_customer_user',
									    'post_type'         => array( 'shop_order' ),
									    'post_status'       => array_keys( wc_get_order_statuses() ),
									    'date_query'        => array(
									        array(
									            'year'  => $today['year'],
									            'month' => $today['mon'],
									            'day'   => $i
									        )
									    )
									) );
							    	$single_day_order_total = 0;
							    	foreach ($single_day_orders as $order) 
								    {       
								        $order_id = $order->ID;        
								        $order_data = wc_get_order($order_id);
								          	
								        // Order total
								        $order_total = $order_data->get_total();
								        $single_day_order_total = $single_day_order_total + $order_total;
								    }
								    ?>
								    <div class="row data" data-day="<?php echo esc_attr($i); ?>" data-amount="<?php echo esc_attr(sprintf("%.2f",$single_day_order_total)); ?>">
								    </div>
								    	<div class="col-md-3">
								    		<?php echo esc_html($i); ?>
								    	</div>
								    	<div class="col-md-6">
								    		<?php echo esc_html(get_woocommerce_currency_symbol().sprintf("%.2f",$single_day_order_total)); ?>
								    	</div>
								    <?php
							    }		    		
						 	?>
			 			</div>
				 		<div class="graph">
				 			<canvas id="sale_this_month_chart"/>
				 		</div>
			 		</div>
			 		<!-- end block -->
				
				</div>
			<!-- e v1 -->

			<!-- s v2 -->
				<div class="col-md-6 customer-order-comp" data-col_id="v2">
				
					<!-- customer-order-comp two week  done-->
					<div class="block" style="border-top: 5px solid #37a2eb;">
				 		<div class="title" style="border-color: #37a2eb;">Weekly Gross</div>

				 			<?php 
				 			
							for ($i=0; $i >=0 ; $i--)
				 			{
				 			
								$nd = strtotime("today");
				 				$nstart_week = strtotime("last sunday midnight",$nd);
								$nend_week = strtotime("next saturday",$nd);
								$nstart = date("Y-m-d",$nstart_week);
								$nend = date("Y-m-d",$nend_week);

								$pd = strtotime("-1 week +1 day");
								$pstart_week = strtotime("last sunday midnight",$pd);
								$pend_week = strtotime("next saturday",$pd);
								$pstart = date("Y-m-d",$pstart_week);
								$pend = date("Y-m-d",$pend_week);


									// Function to get all the dates in given range 
									function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
									      
									    $array = array(); 
									      
									    // Variable that store the date interval 
									    // of period 1 day 
									    $interval = new DateInterval('P1D'); 
									  
									    $realEnd = new DateTime($end); 
									    $realEnd->add($interval); 
									  
									    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
									  
									    // Use loop to store date into array 
									    foreach($period as $date) {                  
									        $array[] = $date->format($format);  
									    } 
									  
									    // Return the array elements 
									    return $array; 
									} 
									  
									// Function call with passing the start date and end date 
									$Date = getDatesFromRange($nstart, $nend); 
									$lastDate = getDatesFromRange($pstart, $pend); 
									  
									for ($a=0; $a <= 6 ; $a++) { 
										$date_year = date("Y",strtotime($Date[$a]));
										$date_month = date("m",strtotime($Date[$a]));
										$date_day = date("d",strtotime($Date[$a]));

										$pdate_year = date("Y",strtotime($lastDate[$a]));
										$pdate_month = date("m",strtotime($lastDate[$a]));
										$pdate_day = date("d",strtotime($lastDate[$a]));

										$last_week_orders = get_posts( array(
												      	'numberposts' => - 1,
											    	   	'meta_key'    => '_customer_user',
											        	'post_type'   => array( 'shop_order' ),
											        	'post_status' => array_keys( wc_get_order_statuses()),
											        	'date_query' => array(
												        				// 'post_date' => $datt
												        				'year'=>$pdate_year,
												        				'month'=>$pdate_month,
												        				'day'=>$pdate_day
											       		)
										    		) );

						 				$week_orders = get_posts( array(
												      	'numberposts' => - 1,
											    	   	'meta_key'    => '_customer_user',
											        	'post_type'   => array( 'shop_order' ),
											        	'post_status' => array_keys( wc_get_order_statuses()),
											        	'date_query' => array(
												        				// 'post_date' => $datt
												        				'year'=>$date_year,
												        				'month'=>$date_month,
												        				'day'=>$date_day
											       		)
										    		) );
						 				$last_week_order_total = 0;
								    	foreach ($last_week_orders as $order) 
									    {       
									        $order_id1 = $order->ID;        
									        $order_data1 = wc_get_order($order_id1);
									        $order_total1 = $order_data1->get_total();
									        $last_week_order_total = $last_week_order_total + $order_total1;
									    }


						 				$monthly_order_total = 0;
								    	foreach ($week_orders as $order) 
									    {       
									        $order_id = $order->ID;        
									        $order_data = wc_get_order($order_id);
									        $order_total = $order_data->get_total();
									        $monthly_order_total = $monthly_order_total + $order_total;
									    }
										
						 ?>
						 <div class="wekly-data" monthly_order_total="<?php echo esc_attr(sprintf("%.2f",$monthly_order_total)); ?>" last_week_order_total="<?php echo esc_attr(sprintf("%.2f",$last_week_order_total)); ?>"></div>
						<?php

									}

							}
						  ?>

						<canvas id="week_comp"/>
					</div>
					<!-- end block -->
				
				</div>
			<!-- e v2 -->

			<!-- s v3 -->
				<div class="col-md-6 customer-order-comp" data-col_id="v3">
				
					<!-- customer-order-comp two month done-->
					<div class="block" style="border-top: 5px solid #a8e6cf;">
						<?php 
							for ($i=1; $i >=0 ; $i--)
				 			{
				 				$start_date = array();
				 			 	$month = date("F", strtotime("-".$i." months"));
				 				$start_date = date("Y-m-1", strtotime("-".$i." months"));
				 			 	$month_total_days = date('t' ,strtotime("-".$i." months"));
				 				$end_date = date("Y-m-".$month_total_days, strtotime("-".$i." months"));

				 				$month_orders = get_posts( array(
										      	'numberposts' => - 1,
									    	   	'meta_key'    => '_customer_user',
									        	'post_type'   => array( 'shop_order' ),
									        	'post_status' => array_keys( wc_get_order_statuses() ),
									        	'date_query' => array(
										            'after' => $start_date,
									            	'before' => $end_date 
									       		)
								    		) );
				 				$monthly_order_total = 0;
						    	foreach ($month_orders as $order) 
							    {       
							        $order_id = $order->ID;        
							        $order_data = wc_get_order($order_id);
							        $order_total = $order_data->get_total();
							        $monthly_order_total = $monthly_order_total + $order_total;
							    }
						 ?>
				 		<div class="user-data1" monthly_order_total="<?php echo esc_attr(sprintf("%.2f",$monthly_order_total)); ?>"></div>
						<?php } ?>
				 		<div class="title" style="border-color: #a8e6cf;" >Last Two Month Gross</div>
						<canvas id="six_month_chart2"/>
					</div>
					<!-- end block -->
				
				</div>
			<!-- e v3 -->

			<!-- s v4 -->
				<div class="col-md-6 six-month" data-col_id="v4">
				
					<!-- start block Last 6 Month done-->				
					<div class="block" style="border-top: 5px solid #fed3b6;" >
				 		<div class="title" style="border-color: #fed3b6;">Last 6 Month Gross</div>
				 		<?php
				 			for ($i=5; $i >=0 ; $i--)
				 			{
				 				
				 				$month = date("F", strtotime("-".$i." months"));
				 				$start_date = date("Y-m-1", strtotime("-".$i." months"));
				 				$month_total_days = date('t' ,strtotime("-".$i." months"));
				 				$end_date = date("Y-m-".$month_total_days, strtotime("-".$i." months"));

				 				$month_orders = get_posts( array(
										      	'numberposts' => - 1,
									    	   	'meta_key'    => '_customer_user',
									        	'post_type'   => array( 'shop_order' ),
									        	'post_status' => array_keys( wc_get_order_statuses() ),
									        	'date_query' => array(
										            'after' => $start_date,
									            	'before' => $end_date 
									       		)
								    		) );
				 			
				 				$monthly_order_total = 0;
						    	foreach ($month_orders as $order) 
							    {       
							        $order_id = $order->ID;        
							        $order_data = wc_get_order($order_id);
							          	
							        // Order total
							        $order_total = $order_data->get_total();
							        $monthly_order_total = $monthly_order_total + $order_total;
							    }
				 			
					 					    
						?>
						<div class="data" data-month="<?php echo esc_attr($month); ?>" data-sales="<?php echo esc_attr($monthly_order_total); ?>"></div>
						<?php } ?>
						<canvas id="six_month_chart"/>
				 	</div>
				 	<!-- end block -->
				
				</div>
			<!-- e v4 -->

			<!-- s v5 -->
				<div class="col-md-6 counter_data col-md-offset-6" data-col_id="v5">

					<!-- start block Order Count By Country done-->
					<div class="block country" style="border-top: 5px solid #add8e6;" >
						<div class="title" style="border-color: #add8e6;">Order Count By Country</div>
					    <?php 
								$filters = array(
								    'post_status' => 'any',
								    'post_type' => 'shop_order',
								    'posts_per_page' => 200,
								    'paged' => 1,
								    'orderby' => 'modified',
								    'order' => 'ASC'
								);
								$country_data = array();
								$loop = new WP_Query($filters);
								$collection_cat	= array();
								$cat_name = array();
								$bil_county = array();
								while ($loop->have_posts()) {
								    $loop->the_post();
								    $order = new WC_Order($loop->post->ID);
								    $bil_county[] = $order->get_billing_country();
								   	
									if(!empty($country_data)){
											$val = $country_data[$bil_county] + $order->get_total(); 
											$country_data[$bil_county] = $val;

										}else{
											@$country_data[$bil_county] = $order->get_total();

										}

					     ?>
					   
					      <?php 

 								}
 								$cun_con = array_count_values($bil_county);

								$main_data = array();
								foreach ($cun_con as $key => $value) {

					       ?>
					          <div class="map-data" country="<?php echo esc_attr(sprintf($key)); ?>" country2="<?php echo esc_attr(sprintf("%d",$value)); ?>" >
					      </div>
					      <?php 
								}
					       ?>
					    <div style="width:70%; margin-right: auto; margin-left: auto; padding: 20px 20px;">
					    	<div id="regions_div">
					     	
					     	</div>
					    </div>
					</div>
					<!-- end Block -->

				</div>
			<!-- e v5 -->

			<!-- s v6 -->
				<div class="col-md-6 category_data" data-col_id="v6">
				
					<!-- customer-order-comp two week done-->
					<div class="block" style="border-top: 5px solid #a8e6cf;" >
				 		<div class="title" style="border-color: #a8e6cf;" >Top 5 Categories Order Count</div>
				 		<?php  
								$filters = array(
								    'post_status' => 'any',
								    'post_type' => 'shop_order',
								    'posts_per_page' => 200,
								    'paged' => 1,
								    'orderby' => 'modified',
								    'order' => 'ASC'
								);

								$loop = new WP_Query($filters);
								$collection_cat	= array();
								$cat_name = array();
								// echo "<pre>";
								$product_data = array();
								$product_data1 = array();

								while ($loop->have_posts()) {
								    $loop->the_post();
								    $order_id = $loop->post->ID;
								    $order = new WC_Order($order_id);
								    foreach ($order->get_items() as $key => $lineItem) {
								    	$product_data['order_id'] =  $order_id;
										$product_data['product_id'] =  $lineItem['product_id'];
										$product_data['product_name'] = $lineItem['name'];
										$product_data['product_total'] =   $lineItem['total'] ; 

								        $cat_ids = wp_get_post_terms($lineItem['product_id'], 'product_cat', array('fields'=>'ids'));
										$product_data['product_cat_id'] = $cat_ids['0']; 
										$product_data['cat_name'] = get_the_category_by_ID($product_data['product_cat_id']);  
										$newcat_id = '';
										if(!empty($collection_cat)){
											$val = $collection_cat[$newcat_id] + $lineItem['total']; 
											 $newcat_id= "cat_".$cat_ids['0'];
											$cat_name['name'] = get_the_category_by_ID($cat_ids['0']);

											$collection_cat[$newcat_id] = $val;

										}else{
											$collection_cat[$newcat_id] = $lineItem['total'] ;
										}
								    }
									$product_data1[] = $product_data['cat_name'];

								}
								$product_cat_data1 = array_count_values($product_data1);

								arsort($product_cat_data1);

								$sliced_array = array_slice($product_cat_data1, 0, 5);

								foreach ($sliced_array as $key => $value) {
									# code...
								?>
									<div>
									</div>
									<div class="cat-data1" category1="<?php echo esc_attr(sprintf("%d",$product_cat_data1[$key])); ?>" category_name= "<?php echo esc_attr(sprintf($key)); ?>" ></div>
								<?
								}

								?>
				 		<canvas id=category>
				 	</div>
					<!-- end block -->
										
				</div>
			<!-- e v6 -->

			<!-- s v7 -->
			 	<div class="col-md-6" data-col_id="v7">

			 		<!-- start Block Payment Gateway done -->
			 		<div class="block" style="border-top: 5px solid #dcedc1;"  >
			 			<div class="title" style="border-color: #dcedc1;" >Payment Gateway</div>
					 	<table class="table payment-gateway">
					 		<thead>
					 			<tr>
						 			<td>Payment Method</td>
						 			<td>Amount</td>
						 			<td>Percentage</td>
					 			</tr>
					 		</thead>
					 		<?php
					 		foreach ($payment_gateway as $method => $amount)
					 		{

					 			?>
					 			<tr class="data" data-method="<?php echo esc_attr($method); ?>" data-amount="<?php echo esc_attr($amount); ?>">
						 			<td><?php echo esc_html($method); ?></td>
						 			<td><?php echo esc_html($amount); ?></td>
						 			<td><?php $per = ($amount * 100) / $final_order_total; 
						 					  echo esc_html(sprintf("%.2f", $per).'%');
						 				?>
						 			</td>
					 			</tr>
					 			<?php	
					 		}
					 		?>
					 	</table>
			 			<canvas id="payment_chart"/>
			 		</div>
			 		<!-- end block -->
			 	
			 	</div>
			<!-- e v7 -->

			<!-- s v8 -->
				<div class="col-md-6 user-details" data-col_id="v8">
				
					<!-- start Block Existing New Custome done-->
					<div class="block" style="border-top: 5px solid #a8e6cf;" >
				 		<div class="title" style="border-color: #a8e6cf;" >Existing - New Customer</div>
						<?php
							$blogusers = get_users();
							$new_user = [];
							$old_user = [];
							foreach ( $blogusers as $user )
							{
								
							    $reg_date = esc_html( $user->user_registered );
							   
							    $date1=date_create($reg_date);
								$date2=date("Y-m-d");
								$date2=date_create($date2);
									
								$diff_arr=date_diff($date1,$date2);
									
								$diff = $diff_arr->days;
								if($diff > 10){
									$old_user[] = $user->ID;
								}
								else{
									$new_user[] = $user->ID;
								}
							}
							@$old_user_count = count($old_user);
							$new_user_count = count($new_user);
							$all_user_count = count($blogusers);
							$old_user_per = ($old_user_count * 100) / $all_user_count;
							$new_user_per = ($new_user_count * 100) / $all_user_count;
						?>
						<div class="user-data" data-old-user-per="<?php echo esc_attr(sprintf("%.2f",$old_user_per)); ?>" data-new-user-per="<?php echo esc_attr(sprintf("%.2f",$new_user_per)); ?>">
						</div>
						<canvas id="user_chart"/>
					</div>
					<!-- end block -->
				
				</div>
			<!-- e v8 -->
				
			<!-- s v9 -->
				<div class="col-md-6 counter_data" data-col_id="v9">
					
					<!-- block start Visitor Count done-->
					<div class="block"  style="border-top: 5px solid #fdba9a;" >
						<div class="title" style="border-color: #fdba9a;" >Visitor Count</div>
						<div class="war_table_center">
						<table class="counter_table">
							<tr>
								<th>
									
								</th>
								<th>
										Visitors
								</th>
							</tr>
							<tr>
								<td>Today</td>
								<td>
									<?php 

										global $wpdb;

									    $table_name = $wpdb->prefix . 'advance_report_visit_count';
									    $condition = "DATE(`Time`)=DATE(NOW())";

									    $sql = "SELECT COUNT(*) FROM $table_name WHERE ".$condition;

		    							$count = $wpdb -> get_var($sql);
		   
		    							echo esc_html($count);
									 ?>						
								</td>
							</tr>
							<tr>
								<td>Yesterday:</td>
								<td>
									<?php 
										$condition_y = "DATE(`Time`)=DATE(NOW() - INTERVAL 1 DAY)";
										 $sql = "SELECT COUNT(*) FROM $table_name WHERE ".$condition_y;

		    							$count = $wpdb -> get_var($sql);
		   
		    							echo esc_html($count);

									 ?>
								</td>
							</tr>
							<tr>
								<td>This Week:</td>
								<td>
									<?php 

										$condition_w = "WEEKOFYEAR(`Time`)=WEEKOFYEAR(NOW())";
										 $sql = "SELECT COUNT(*) FROM $table_name WHERE ".$condition_w;

		    							$count = $wpdb -> get_var($sql);
		   
		    							echo esc_html($count);

									 ?>
								</td>
							</tr>
							<tr>
								<td>This Month:</td>
								<td>
									<?php 
										$condition_m = "MONTH(`Time`)=MONTH(NOW())";
										$sql = "SELECT COUNT(*) FROM $table_name WHERE ".$condition_m;

		    							$count = $wpdb -> get_var($sql);
		   
		    							echo esc_html($count);

									 ?>
								</td>
							</tr>
							<tr>
								<td>Total:</td>
								<td>
									<?php 

										$condition_t = "1";
										$sql = "SELECT COUNT(*) FROM $table_name WHERE ".$condition_t;

		    							$count = $wpdb -> get_var($sql);
		   
		    							echo esc_html($count);

									 ?>
								</td>
							</tr>
							
						</table>
					</div>

					</div>
					<!-- block end -->

				</div>
			<!-- e v9 -->

			<!-- s v10 -->
				<div class="col-md-6 counter_data" data-col_id="v10">

					<!-- start block product with unit count done-->
					<div class="block" style="border-top: 5px solid #fed39f;">
						<div class="title" style="border-color: #fed39f;" >Top 5 Product </div>
						<?php 
							global $wpdb;
							$results = $wpdb->get_results("SELECT p.post_title as product, p.ID as p_id, pm.meta_value as total_sales FROM {$wpdb->posts} AS p LEFT JOIN {$wpdb->postmeta} AS pm ON (p.ID = pm.post_id AND pm.meta_key LIKE 'total_sales') WHERE p.post_type LIKE 'product' AND p.post_status LIKE 'publish' order by CAST(total_sales AS INT) desc limit 5", 'ARRAY_A');
							?>
							<div class="war_table_center">
								<table class="counter_table">
								    <tr>
								        <th><?php _e( 'Product Image' ); ?></th>
								        <th><?php _e( 'Product Name' ); ?></th>
								        <th><?php _e( 'Unit sold' ); ?></th>
								    </tr>
								<?php
								foreach ( $results as $result ) {
								    echo "<tr>";

								    $product   = wc_get_product( $result['p_id'] );
									$image_id  = $product->get_image_id();
									$image_url = wp_get_attachment_image_url( $image_id, 'full' );

									echo "<td><img src='".$image_url."' class='war_table_image' style='' alt=' ' ></td>";

								    echo "<td>" . $result['product'] . "</td>";

								    echo "<td>" . $result['total_sales'] . "</td>";
								    echo "</tr>";
								}
								?>
								</table>
							</div>

					</div>
					<!-- end block -->
				</div>
			<!-- e v10 -->

			</div><!-- Row -->
		</div>
		<!-- end Second Section -->
	</div>
	<?php
} // main function close


