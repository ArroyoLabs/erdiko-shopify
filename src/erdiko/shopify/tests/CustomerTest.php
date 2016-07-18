<?php

namespace erdiko\shopify\tests;


require_once 'ErdikoTestCase.php';


class CustomerTest extends ErdikoTestCase
{
	protected $customerModel = null;

	public function setUp(){
		$this->customerModel= new \erdiko\shopify\models\Customer;
	}

	public function testCustomers(){
		$data=$this->customerModel->getCustomers();
		$this->assertTrue(!empty($data),"customers data is empty");

		foreach($data as $customer){
			$this->assertTrue(!empty($customer['id']));
			$this->assertTrue(!empty($customer['first_name']));
			$this->assertTrue(!empty($customer['last_name']));
		}
	}
}