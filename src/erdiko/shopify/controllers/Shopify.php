<?php
/**
 * Example Shopify Controller
 * Some examples of how to use the shopify API
 *
 * @category 	shopify
 * @package   	example
 * @copyright	Copyright (c) 2014, Arroyo Labs, www.arroyolabs.com
 * @author 		Coleman Tung, coleman@arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\shopify\controllers;

/**
 * ShopifyExample Class  extends \erdiko\shopify\Shopify
 */
class Shopify extends \erdiko\core\Controller
{
	/** Cache Object */
	private $cacheObj;
	/** Shopify Object */
	protected $shopify;

	/** Before */
	public function _before()
	{
		$this->setThemeName('bootstrap');
		$this->prepareTheme();
	}

	/**
	 * Get
	 *
	 * @param mixed $var
	 * @return mixed
	 */
	public function get($var = null)
	{
		// error_log("var: $var");
		if(!empty($var))
		{
			// load action based off of naming conventions
			return $this->_autoaction($var, 'get');

		} else {
			return $this->getIndex();
		}
	}

	/**
	 * Index Action
	 */
	public function getIndex()
	{
		$metafield = new \erdiko\shopify\models\Metafield; // instantiate model to force authentication

		$this->setTitle('Shopify Examples');
		$this->setContent( $this->getView('shopify/index', null, dirname(__DIR__)) );
	}

	/**
	 * Get Metafields
	 */
	public function getMetafields()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$data = $metafield->getMetafields();

		$this->setTitle('Shopify Metafields');
		$this->setContent( $this->getLayout('json', $data) );
	}

	/**
	 * Get Metafields
	 */
	public function getMetafieldsTest()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$meta = array(
			"metafield" => array(
				"namespace" => $metafield->getNamespace(),
    			"key" => "warehouse",
    			"value" => 25,
    			"value_type" => "integer")
			);
		$data = $metafield->setMetafields($meta);

		$this->setTitle('Shopify Metafields');
		$this->setContent( $this->getLayout('json', $data) );
	}

	/**
	 * Get Customer
	 */
	public function getCustomers()
	{
		$customer = new \erdiko\shopify\models\Customer;
		$data = $customer->getCustomers();

		$this->setTitle('Shopify Customers');
		$this->setContent( $this->getLayout('json', $data) );
	}

	/**
	 * Get Order
	 */
	public function getOrders()
	{
		$order = new \erdiko\shopify\models\Order;
		$data = $order->getOrders();

		$this->setTitle('Shopify Orders');
		$this->setContent( $this->getLayout('json', $data) );
	}

	/**
	 * Get Product
	 */
	public function getProducts()
	{
        $product = new \erdiko\shopify\models\Product;
		$data = $product->getProducts();

		$this->setTitle('Shopify Product Grid');
		$this->setContent( $this->getLayout('grid/shopify', $data, dirname(__DIR__)) );
	}

}