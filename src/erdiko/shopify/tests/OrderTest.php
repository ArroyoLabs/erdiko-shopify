<?php

namespace erdiko\shopify\tests;


require_once 'ErdikoTestCase.php';


class OrderTest extends ErdikoTestCase{
	protected $orderModel = null;

	public function setUp(){
		$this->orderModel=  new \erdiko\shopify\models\Order;
	}

	public function testOrders(){
		$data = $this->orderModel->getOrders();

		$this->assertTrue(count($data)>0, "Require atleast one order to continue the test");

		$orderID = $data[0]['id'];
		$this->assertTrue(!empty($orderID),"Order ID should not be empty");

		$orderData = $this->orderModel->getOrderByID($orderID);
		$this->assertTrue(!empty($orderData));

		$this->assertTrue($orderData['id']==$orderID);

	}
}