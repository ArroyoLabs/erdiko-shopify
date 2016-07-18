<?php

namespace erdiko\shopify\tests;


require_once 'ErdikoTestCase.php';


class ProductTest extends ErdikoTestCase
{
	protected $pModel = null;

	public function setUp(){
		$this->pModel= new \erdiko\shopify\models\Product;
	}

	public function testProducts(){
		$data=$this->pModel->getProducts();
		$this->assertTrue(!empty($data),"product data is empty");

		foreach($data as $product){
			$this->assertTrue(!empty($product['id']));
			$this->assertTrue(!empty($product['title']));
		}
	}

}