<?php

class Product extends AppModel {
    var $name = 'Product';
	
	public $primaryKey = 'product_id';
 
    var $hasAndBelongsToMany = array(
        'Invoice' => array(
            'className' => 'Invoice',
            'joinTable' => 'invoices_products',
            'foreignKey' => 'product_id',
            'associationForeignKey' => 'invoice_num'
        ),
    );  
}	