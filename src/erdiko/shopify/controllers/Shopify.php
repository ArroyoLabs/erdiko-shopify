<?php
/**
 * Example Shopify Controller
 * Some examples of how to use the shopify API
 *
 * @category 	shopify
 * @package   	example
 * @copyright	Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author 		Coleman Tung, coleman@arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 * @author 		Andy Armstrong, andy@arroyolabs.com
 */

namespace erdiko\shopify\controllers;
use \erdiko\shopify\ShopifyApiException;
use \erdiko\shopify\ShopifyCurlException;

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
		$this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
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
                "value_type" => "integer"
        ));

		$data = $metafield->setMetafields($meta);

		$this->setTitle('Shopify Metafields');
		$this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
	}

	/**
	 * Get Customers
	 */
	public function getCustomers()
	{
		$customer = new \erdiko\shopify\models\Customer;
		
		$message="";
		$isError=FALSE;

		try {
            $data = $customer->getCustomers();
		} catch(ShopifyApiException $e) {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in getting Customer list :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
        	$isError=TRUE;
        } catch(ShopifyCurlException $e) {
           $message="Error :: Shopify Curl Exception";
           $isError=TRUE;
        } catch (Exception $e) {
           $message=$e->getMessage();
           $isError=TRUE;
        }
       
        if(!$isError) {
            $this->setTitle('Shopify Customers');
            $this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
        } else {
            $this->setContent( $this->getLayout('message', $message) );
        }

	}

	/**
	 * Get Orders
	 */
	public function getOrders()
	{
		$order = new \erdiko\shopify\models\Order;
		
		$message="";
		$isError=FALSE;

        try {
            $data = $order->getOrders();
        } catch(ShopifyApiException $e) {
            $response_headers=$e->getResponseHeaders();
            $message = "Error in getting order list :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
            $isError=TRUE;
        } catch(ShopifyCurlException $e) {
            $message="Error :: Shopify Curl Exception";
            $isError=TRUE;
        } catch (Exception $e) {
            $message=$e->getMessage();
            $isError=TRUE;
        }
       
		
        if(!$isError) {
            $this->setTitle('Shopify Orders');
            $this->setContent($this->getLayout('json', $data, dirname(__DIR__)));
        } else {
        	$this->setContent($this->getLayout('message', $message));
        }
	}

	/**
	 * Get Products
	 */
	public function getProducts()
	{
        $product = new \erdiko\shopify\models\Product;
        try {
            $data = $product->getProducts();
        } catch(ShopifyApiException $e) {
            $response_headers=$e->getResponseHeaders();
            $message = "Error in getting product list :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
            $isError=TRUE;
        } catch(ShopifyCurlException $e) {
            $message="Error :: Shopify Curl Exception";
            $isError=TRUE;
        } catch (Exception $e) {
            $message=$e->getMessage();
            $isError=TRUE;
        }

        if(!$isError) {
            $this->setTitle('Shopify Product Grid');
            $this->setContent( $this->getLayout('grid/shopify', $data, dirname(__DIR__)) );
        } else{
            $this->setContent( $this->getLayout('message', $message) );
        }
	}

}
