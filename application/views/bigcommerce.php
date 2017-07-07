<h1>App Installation in progress...</h1>
<?php
	print_r($data);
?>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url: 'https://login.bigcommerce.com/oauth2/token',
			headers: {"Content-Type": "application/x-www-form-urlencoded", "Access-Control-Allow-Origin": "*"},
			type: 'POST',
			crossDomain: true,
			data: {client_id: 'mwshyzp578qge171a6csxn4st4836si', 
						client_secret: 'gxx32k0karuq1yb1k2j03zz5xpoewgh',
						code: "<?php echo $data['code']; ?>",
						scope: "<?php echo $data['scope']; ?>",
						grant_type: 'authorization_code',
						redirect_uri: 'https://shopify.shoptradeonline.com/shoptradeapp/bigcommerce/get_app_install',
						context: "<?php echo $data['context']; ?>"
					},
			dataType: 'json',
			error: function(jqXHR, textStatus, errorThrown){
				console.log('Ajax error', errorThrown);
				console.log('Ajax jqXHR', jqXHR.responseJSON.message);
				console.log('Ajax jqXHR', jqXHR);
				console.log('Ajax text status', textStatus);

				/*if (jqXHR.status == 403){
					console.log('Invalid API Key, Back To Login Form');
					chrome.storage.local.remove("ktcapiak", function() {})
					checkLogout();
					$('#apiak_msg').text(jqXHR.responseJSON.message);
				} else if (jqXHR.status == 429) {
					console.log('Credit limit exceeded');

					//display the credit limit exceeded message
					$.get(chrome.extension.getURL('/html/credit_limit.html'), function(data) {
						$('#initial-state').html('');
						$('#social-data').html('');
						$('#credit-limit').html(data).fadeIn();
						$('#usr_crd_sh_st').text(0);
			    		$('.credit-button').fadeIn();
			    		$('.credit-button').addClass('credit-button-pink');
			    		loaderHide();
					});
				}*/
			},
			success: function(response){
				console.log('Response', response);
			}
		});
	});
</script>