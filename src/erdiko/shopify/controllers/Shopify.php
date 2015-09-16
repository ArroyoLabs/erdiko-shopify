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

	/**
	 * Create Metafield for a product
	 */
	public function getCreateProductMetaField()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$productID=$_GET['product_id'];
		$args=array(
			"metafield"=>array("namespace" => "inventory",
    		"key" => $_GET['key'],
    		"value"=> $_GET['value'],
    		"value_type" =>$_GET['value_type'])
			);

		$metafield->setProductMetaField($productID,$args);
	}

	/**
	 * Get Metafields of a product
	 */
	public function getProductMetaFields()
	{
		$metafield = new \erdiko\shopify\models\Metafield;	
		$productID=$_GET['product_id'];
		$data=$metafield->getProductMetaFields($productID);
		$this->setTitle('Shopify: Metafields');
		$this->setContent( $this->getLayout('grid/metaDataListing', $data, dirname(__DIR__)) );
	}

	/**
	 * Edit Metafield of a product
	 */
	public function getEditProductMetaField()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$productID=$_GET['product_id'];
		$metaFieldID=$_GET['id'];
		$args=array(
			"metafield"=>array(
			"id" => $_GET['id'],
    		"value"=> $_GET['value'],
    		"value_type"=>$_GET['value_type'])
			);
		$data=$metafield->updateProductMetaField($productID,$metaFieldID,$args);
	}

	/**
	 * Delete Metafield of a product
	 */
	public function getDeleteProductMetaData(){
		$metafield = new \erdiko\shopify\models\Metafield;
		$productID=$_GET['product_id'];
		$metaFieldID=$_GET['id'];
		$metafield->deleteProductMetaField($productID,$metaFieldID,array());
	}

	/**
	 * Show the userform to edit the Metafields
	 */
	public function getShowEdit(){
		$data=array(
			"product_id"=>$_GET['product_id'],
			"id"=>$_GET['id'],
			"key"=>$_GET['key'],
			"value"=>$_GET['value'],
			"value_type"=>$_GET['value_type']);
		$this->setTitle('Edit Meta Data Fields');
		$this->setContent( $this->getView('shopify/editForm',$data, dirname(__DIR__)) );
	}

	/**
	 * Show the userform to add Metafield of a product
	 */
	public function getShowForm(){
		$data=$_GET['product_id'];
		$this->setTitle('Create New Meta Field');
		$this->setContent($this->getView('shopify/formView',$data,dirname(__DIR__)));
	}

}