<?php

class ProductsController extends AppController {
// ...

	public $uses = array('Product', 'Invoice','Client','InvoicesProduct');
	
	public $helpers = array('Form', 'Html','Session','Js');
	
	var $components = array('RequestHandler');

    public function index() {
		if ($this->request->is('post')) {
				if ($this->request->is('ajax')) {
					$data = $this->request->data;
					
					//retrieving data based on relative date,client
					if($data['Product']['relative_date'] == 1){
						$clients = $this->Invoice->find('all',array(
											'conditions' => array(
												'Invoice.client_id' => $data['Product']['client_id'],
												'date(Invoice.invoice_date) BETWEEN ? AND ?' => array(date ('Y-m-d', strtotime ( 'first day of -1 month')), date ('Y-m-d'))
											)
											,'recursive' => '2'
											));
					} else if($data['Product']['relative_date'] == 2) {
						$clients = $this->Invoice->find('all',array('conditions' => array(
											'Invoice.client_id' => $data['Product']['client_id'],
											'date(Invoice.invoice_date) BETWEEN ? AND ?' => array(date ('Y-m-d', strtotime ( 'first day of this month')), date ('Y-m-d', strtotime ( 'last day of this month')))
											),'recursive' => '2'));
					} else if($data['Product']['relative_date'] == 3) {
						$clients = $this->Invoice->find('all',array('conditions' => array(
											'Invoice.client_id' => $data['Product']['client_id'],
											'date(Invoice.invoice_date) BETWEEN ? AND ?' => array(date('Y-m-d',strtotime("1/1 this year")), date('Y-m-d',strtotime("12/31 this year")))
											),'recursive' => '2'));
					} else {
						$clients = $this->Invoice->find('all',array('conditions' => array(
											'Invoice.client_id' => $data['Product']['client_id'],
											'date(Invoice.invoice_date) BETWEEN ? AND ?' => array(date('Y-m-d',strtotime("1/1 last year")), date('Y-m-d',strtotime("12/31 last year")))
											),'recursive' => '2'));
					}
					
					$product_details = array();
					$i = 1;	
					foreach($clients as $client) {
						$product_details[$i]['invoice_date'] = $client['Invoice']['invoice_date'];
						$product_details[$i]['invoice_num'] = $client['Invoice']['invoice_num'];
						foreach($client['Product'] as $pr) {
							$product_details[$i]['product'] = $pr['product_description'];
							$product_details[$i]['qty'] = $pr['InvoicesProduct']['qty'];
							$product_details[$i]['price'] = $pr['InvoicesProduct']['price'];
							$product_details[$i]['total'] = $pr['InvoicesProduct']['qty'] * $pr['InvoicesProduct']['price'];
						}
						$i++;
					}
				
				echo json_encode($product_details);exit;
			}
		}
		
		//retrieving clients for dropdown selection
		$clients = $this->Client->find('list', array(
        'fields' => array('Client.client_id', 'Client.client_name')));
		array_unshift($clients, "select client");
		$this->set('clients', $clients);
    }
	
	//retrieving products based on client
	public function getProducts() {
		if ($this->request->is('ajax')) {
			$client_id = $this->request->query('client_id');
			
			$this->autoRender = false;
			
			$this->layout = 'ajax';
			
			$products = $this->Product->find('list', array(
            'conditions' => array('Product.client_id = ' => $client_id),
			'fields' => array('product_id','product_description')
			));
			
		
			echo json_encode($products); // This template would be in app/View/Project/json/
			exit;
		}
        
		
    }
// ...
}