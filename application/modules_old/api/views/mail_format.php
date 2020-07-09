<style type="text/css">
	body,th {
		font-family:Helvetica-light;
		font-size:14px;
	}
	td{
		font-family:Helvetica-light;
		font-size:13px;

	}
	p{
		font-family:Arial, Helvetica, sans-serif;
		font-size:14px;
	}	
	body, td, input, textarea, select{
		font-weight: bolder !important;
	}
</style>

<?php 





$subtotal = 0;

if($arr_order_details['order']){$pre_total = 0; foreach($arr_order_details['order'] as $order){

	?>

<table border="0" width="100%">
	<thead>
		<tr align="left">
			<th> <?= $this->lang->line('text_order_booking_msg_2') ?> <?= $order->id ?>).</th>
		<th> <?php echo "bestillingen var booket på :-";?> <?= $order->station_name ?>).</th>
		</tr>
		<tr>
			<td>
				Navn: <?= $order->customer_name; ?>
			</td>
		</tr>
		<tr>
			<td>
				Telefon:<?= $order->mobile; ?>
			</td>
		</tr>
		<tr>
			<td>
				E-post:<?= $order->email; ?>
			</td>
		</tr>
		
		
		<tr>
			<td>
				<?
					$strAddress = '';
					if (isset($order->street_no) && !empty($order->street_no))
					{
						$strAddress = "Street# ".$order->street_no;
					}
					if (isset($order->houseno) && !empty($order->houseno))
					{
						$strAddress .= ' Flat # '.$order->houseno;
					}
					if (isset($order->company) && !empty($order->company))
					{
						$strAddress .= ' '.$order->company;
					}
					if (isset($order->address) && !empty($order->address))
					{
						$strAddress .= ' '.$order->address;
					}
					if (isset($order->postcode) && !empty($order->postcode))
					{
						$strAddress .= ' '.$order->postcode;
					}
					if (isset($order->city) && !empty($order->city))
					{
						$strAddress .= ', '.$order->city;
					}
				 	echo $strAddress; ?>
			</td>
		</tr>
		<tr>
			<td>
				
		<b>bestillings-type</b>: <?php  echo $order->type?>
		
			</td>
			<td>
			    			
		<b>Schedule date/time</b>:   <?php  if(isset( $order->delivery_date) && !empty ($order->delivery_date)){
                        $date= $order->delivery_date;
                        $time= $order->delivery_time;
                  echo  $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
           }
           else echo 'ASAP';
           ?>
			</td>
		</tr>
		<th width="15%">Order Note</th>
                    <th width="15%"><?php if(isset($order->delivery_note) && !empty($order->delivery_note)){echo $order->delivery_note;}else{echo 'N/A';}?></th>
                    </tr>
	</thead>
</table>
<br/>
<table border="1" width="100%" style="border-collapse: collapse;">
	<thead>
		<tr align="center" bgcolor="#ccc">
			<th width="5%" align="center" height="25">#</th>
			<th width="40%" align="left" height="25"><?= $this->lang->line('text_product') ?></th>
			<th width="10%" align="center"><?= $this->lang->line('text_price') ?></th>
			<th width="10%" align="center"><?= $this->lang->line('text_quantity') ?></th>
			<th width="20%" align="center"><?= $this->lang->line('text_total') ?></th> 
		</tr>
	</thead>
	<tbody>
		<?php $count = 0;foreach($arr_order_details['order_detail'][$order->id]['product'] as $order_detail_product){
			$count++; $product_total = $product_add_on_total = 0;
			$subtotal += $order_detail_product['product_price'];
			?>
			<tr height="35">	
				<td align="center"><?=$count?>.</td>
				<td align="left"> &nbsp;
				  <?php echo $order_detail_product['product_name'];
                        if ($order_detail_product['specs_label'] != '0')
                            echo ' '.$order_detail_product['specs_label']; ?>
					<?php 
					if(isset($arr_order_details['order_detail'][$order->id]['add_on'][$order_detail_product['stock_id']])){
						foreach($arr_order_details['order_detail'][$order->id]['add_on'][$order_detail_product['stock_id']] as $order_detail_add_on){
							$product_add_on_total += ($order_detail_add_on['product_price'] * $order_detail_add_on['quantity']);
							$subtotal += $order_detail_add_on['product_price'];
							echo '<div class="name"> >>> <small>'.$order_detail_add_on['product_name'].' ( kr. '.$order_detail_add_on['quantity'].' X '.$order_detail_add_on['product_price'].' )</small></div>';
						}}

						if ($order_detail_product['comments'] != '0')
							echo '<div><small>'.$order_detail_product['comments'].'<small></div>';
						?>

					</td>
					<td align="center"><?php echo $order_detail_product['product_price']?></td>
					<td align="center"><?php echo $order_detail_product['quantity']?></td>
					<td align="center"><?php echo $product_total = $order_detail_product['total_product_price'];?></td>
				</tr>
				<tr bgcolor=""><td colspan="5" height="1"></td></tr>
				<?php } ?>
				<?php if($order->discount > 0) : ?>
				<tr> 
					<td colspan="4" align="right" height="25"><strong><?= $this->lang->line("text_discount") ?>:</strong></td>
					<td align="center"><?= $order->discount; ?></td>
				</tr>
				<?php endif; ?>
				  <?php  if($order->subtotal != $order->total_price) : ?>
				<tr> 
					<td colspan="4" align="right" height="25"><strong><?= $this->lang->line('text_amount') ?>:</strong></td>
					<td align="center"><?= $order->subtotal; ?></td>
				</tr>
				 <?php endif; ?>

			
                <?php if(isset($Charges) && !empty($Charges)){
                    foreach($Charges as $row){?>
                <tr>
					<td colspan="4" align="right" height="25"><strong><?=$row['charges_name']?> </strong><span><?=$row['charges_type']?></span></td>
					<td align="center"><?=$row['charges_amount']?></td>
				</tr>
                <?}}?>
                 <?php if(isset($Discounts) && !empty($Discounts)){
                    foreach($Discounts as $row){?>
                <tr>
					<td colspan="4" align="right" height="25"><strong><?=$row['discount_name']?> </strong><span><?=$row['discount_type']?></span></td>
					<td align="center"><?=$row['discount_amount']?></td>
				</tr>
                <?}}?> 
               
				<tr>    
					<td colspan="4" align="right" height="25"><strong><?= $this->lang->line('text_total_cost') ?>:</strong></td>
					<td align="center"><?= $order->total_price ?></td>
				</tr>
				
				<?php if(isset($Taxes) && !empty($Taxes)){
                    foreach($Taxes as $row){?>
                <tr>
					<td colspan="4" align="right" height="25"><strong><?=$row['tax_name']?> </strong><span><?=$row['tax_type']?></span></td>
					<td align="center"><?=$row['tax_amount']?></td>
				</tr>
                <?}}?>
            	
				<tr>
					<td colspan="5" align="right" height="25"><strong>
						<?php
							//print'this $order_type ====>>'.$order_type;
							//print'<br>this $order->accepted_or_rejected_time ====>>'.$order->accepted_or_rejected_time;
							//exit;
							// if ($order_type == DELIVERY) 
							 {
							//print'this order_type=====>>>';exit;
								if (isset($order->accepted_or_rejected_time) && !empty($order->accepted_or_rejected_time))
									$delivery_time = $order->accepted_or_rejected_time;
								else
									$delivery_time = '60-75 min';
								echo 'Levering    Ca. '.$delivery_time.'.';/* else echo 'Hent selv.';*/

							}
						?>

					</strong></td>
				</tr>
			</tbody>
		</table>

		<?php }}?>