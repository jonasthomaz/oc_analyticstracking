// Checkout
$('#button-account').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Account');
});

// Login
$('#button-login').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Login');
});

// Register
$('#button-register').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Register');
});

// Payment Address	
$('#button-payment-address').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Payment Address');
});


// Shipping Address			
$('#button-shipping-address').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Shipping Address');
});


// Guest
$('#button-guest').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Ghest');
});


// Guest Shipping
$('#button-guest-shipping').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Guest Shipping');
});

//Shipping Method
$('#button-shipping-method').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Shipping Method');
});


//Payment Method
$('#button-payment-method').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Payment Method');
});


//Confirmando pedido
$('#button-confirm').live('click', function() {
	GoogleAnalytics_CheckoutEvent('Order Processsed');
	sendGoogleAnalytics();	
});


function GoogleAnalytics_CheckoutEvent(action){
	/*
	 * Constroi Evento do checkout
	 * permite acompanhar funil de abandono no Checkout
	 */
	_gaq.push(['_trackEvent', 'checkout', action, 'checkout']);
}

function sendGoogleAnalytics() {
	$.getJSON(
		"/index.php?route=module/google_analytics/OrderTracker",
		function(data){

			var pageTracker = _gat._getTracker(data.google_analytics_code);			
	    
		    pageTracker._trackPageview();

			pageTracker._addTrans(
				data.orderID,
				data.storename,
				data.total,
				data.tax,
				data.shipping,
				data.city,
				data.state,
				data.country
		    );


			$.each(data.products,function(indice,product){
				pageTracker._addItem(
	    			data.oderID,
	        		product.sku,
	        		product.product_name,
	        		product.category,
	        		product.unit_price,
	        		product.quantity
	    		);
			});

			pageTracker._trackTrans();
		}
	);
}