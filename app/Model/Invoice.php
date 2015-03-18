<?php

class Invoice extends AppModel {
    var $name = 'Invoice';
	
	public $primaryKey = 'invoice_num';
	
    var $hasAndBelongsToMany = array(
        'Product' => array(
            'className' => 'Product',
            'joinTable' => 'invoices_products',
            'foreignKey' => 'invoice_num',
            'associationForeignKey' => 'product_id'
        ),
    );   
	}