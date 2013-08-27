<?php  
class ControllerModuleGoogleAnalytics extends Controller {
	protected function index() {

		$this->data['google_analytics_code']='';

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['google_analytics_code'] = str_replace('http', 'https', html_entity_decode($this->config->get('google_analytics_code')));
		} else {
			$this->data['google_analytics_code'] = html_entity_decode($this->config->get('google_analytics_code'));
		}
		

		if($this->data['google_analytics_code']!=''){
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/google_analytics.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/google_analytics.tpl';
			} else {
				$this->template = 'default/template/module/google_analytics.tpl';
			}

			$this->data['js_scripts']=array();
			if (isset($this->request->get['route'])){
				if($this->request->get['route']=='checkout/checkout'){
					$this->data['js_scripts'][]='catalog/view/javascript/google_analytics_checkout.js';
				}

			}


			$this->render();	
		}
		
	}


	public function OrderTracker(){

		$ordertracker=array();

		$ordertracker['google_analytics_code'] = html_entity_decode($this->config->get('google_analytics_code'));

		$this->load->model('account/address');
		$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);		
		

		$taxtotal=0;
		foreach($this->cart->getTaxes() as $tax=>$value){
			$taxtotal += $value;
		}


		$ordertracker['orderID'] = $this->session->data['order_id'];
		$ordertracker['storename'] = $this->config->get('config_name');
		$ordertracker['total'] = $this->cart->getTotal() + $this->session->data['shipping_method']['cost'];
		$ordertracker['tax'] = $taxtotal;
		$ordertracker['shipping'] = $this->session->data['shipping_method']['cost'];
		$ordertracker['city'] = $shipping_address['city'];
		$ordertracker['state'] = $shipping_address['zone_code'];
		$ordertracker['country'] = $shipping_address['country'];


		$this->load->model('catalog/product');
		$this->load->model('catalog/category');

		foreach ($this->cart->getProducts() as $product) {
			$category_name='';
			$categories=$this->model_catalog_product->getCategories($product['product_id']);
	

			foreach($categories as $cat){
				$category = $this->model_catalog_category->getCategory($cat['category_id']);
				$category_name  .= ($category_name==''?'':' > '). $category['name'];
			}
			

			$ordertracker['products'][]=array(
	        	'sku'=>$product['product_id'],
	        	'product_name'=>$product['name'],
	        	'category'=>$category_name,
	        	'unit_price'=>$product['price'],
	        	'quantity'=>$product['quantity']
				);
		}

		echo json_encode($ordertracker);
		
	}
}
?>