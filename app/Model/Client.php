<?php

class Client extends AppModel {
	var $name = 'Client';
	
	public $primaryKey = 'client_id';
	
	public $hasMany = array(
		'Product' ,
		'Invoice'
	);
	
	
	
	/*public $belongsTo = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id'
        ),
		'Invoice' => array(
            'className' => 'Invoice',
            'foreignKey' => 'invoice_num'
        )
    ); */
	
}