<h3>Generate Reports</h3>

<?php

//path of js
echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');


//Form to get input of client and relative date
echo $this->Form->create('Product');
echo $this->Form->input('client_id', array('options' => $clients,'id'=>'clientDropId'));
echo $this->Form->input('relative_date', array(
								'options' => array(
													'0' => 'Select',
													'1' => 'Last month to date',
													'2' => 'This month',
													'3' => 'This year',
													'4' => 'Last year'),
								'id'=>'dateDropId'
									));
echo $this->Form->input('product_id', array('options' => array('0'=>'select product'),'id'=>'productDropId'));									
echo $this->Form->end('Submit');

?>

<!-- Table to list out reports generated based on criteria -->
<table id="report">
	<thead>
		<th>Invoice num</th>
		<th>Invoice date</th>
		<th>Product</th>
		<th>Qty</th>
		<th>Price</th>
		<th>Total</th>
	</thead>
	<tbody>
		
	</tbody>
</table>


<script type="text/javascript">
  

$(document).ready(function(){
	// on change event of client dropdown
	$("#clientDropId").change(function(){
		   id = $(this).val();
		   $.ajax({ 
			 url: 'products/getProducts',
			 data: {client_id: id},
			 type: 'GET',
			 contentType: "application/json", 
			 dataType: "json",               
			 success: function(output) {
				populateProductList(output);
			 }
		});
	});
	
	// on change event of client dropdown populating products
	function populateProductList(products) {
		var options = '';
		options += '<option value="0">select product</option>';
		$.each(products, function(index, product) {
			options += '<option value="' + index + '">' + product + '</option>';
		});
		$('#productDropId').html(options);
	}
	
	// on submit event posting criteria details
	$( "#ProductIndexForm" ).submit(function( event ) {
		$('#report tbody').empty();
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
		$.ajax(
		{
			url : formURL,
			type: "POST",
			data : postData,
			dataType: 'json',
			success:function(data)
			{
				generateReport(data);
			},
			error: function(data)
			{
				alert(data);    
			}
		});
		event.preventDefault();
	});
	
	// generating table for reports
	function generateReport(data) {
		var trHTML = '';
		$.each(data,function(i,e){
	        trHTML += '<tr><td>' + e.invoice_num + '</td><td>' + e.invoice_date + '</td><td>' + e.product + '</td><td>' + e.qty + '</td><td>' + e.price + '</td><td>' + e.total + '</td></tr>';
			$('#report tbody').append(trHTML);
		});
	}


});
</script>