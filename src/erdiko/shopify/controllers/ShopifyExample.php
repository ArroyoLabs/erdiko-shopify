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

use erdiko\shopify\Shopify;

/**
 * ShopifyExample Class  extends \erdiko\shopify\Shopify
 */
class ShopifyExample extends \erdiko\core\Controller
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

		$this->cacheObj = \Erdiko::getCache();
		// \Erdiko::log(null, "GET: ".print_r($_GET, true));

		if(isset($_GET['code']))
		{
			$this->cacheObj->put('shopify_code', $_GET['code']);
			$this->cacheObj->put('shopify_shop', $_GET['shop']);
		}

		if(!$this->cacheObj->has('shopify_code'))
		{
			$shop = $this->returnSite();
			//var_dump($shop);
			$this->cacheObj->put('shopify_shop', $shop);
			$this->shopify = new Shopify($shop, "", $this->returnApiKey(), $this->returnSecret());
        	// get the URL to the current page
        
      		$pageURL = 'http';
	       	// if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
	        $pageURL .= "://";
	        if ($_SERVER["SERVER_PORT"] != "80") {
	            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	        } else {
	            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	        }

	        // Redirect to Shopfy to get authorization
	        header("Location: " . $this->shopify->getAuthorizeUrl($this->returnScope(), $pageURL)); 
	    }

		$this->shopify = new Shopify($this->cacheObj->get('shopify_shop'), "", $this->returnApiKey(), $this->returnSecret());

		// Check for an existing token, if not present request one using the code
   		if(empty($this->cacheObj->get('shopify_token')))
    	{
    		$token = $this->shopify->getAccessToken($this->cacheObj->get('shopify_code'));
    		$this->cacheObj->put('shopify_token', $token);
    	}

    	\Erdiko::log(null, "code: ".$this->cacheObj->get('shopify_code'));
    	\Erdiko::log(null, "shop: ".$this->cacheObj->get('shopify_shop'));
    	\Erdiko::log(null, "token: ".$this->cacheObj->get('shopify_token'));

    	// Set the token within shopify so we can use the API
    	$this->shopify->setToken($this->cacheObj->get('shopify_token'));
	}

	/**
	 *	Get the shop URL
	 *
	 *	@return URL
	 **/
	private function returnSite()
	{
        $config = \Erdiko::getConfig('local/shopify');
        return $config['shop']['erdiko'];
	}

	/**
	 *	Get the API Key
	 *
	 *	@return string
	 **/
	private function returnApiKey()
	{
        $config = \Erdiko::getConfig('local/shopify');
        return $config['appInfo']['SHOPIFY_API_KEY'];
	}

	/**
	 *	Get the API Secret
	 *
	 *	@return string
	 **/
	private function returnSecret()
	{
        $config = \Erdiko::getConfig('local/shopify');
        return $config['appInfo']['SHOPIFY_SECRET'];
	}

	/**
	 *	Get the API Scope
	 *
	 *	@return string
	 **/
	private function returnScope()
	{
        $config = \Erdiko::getConfig('local/shopify');
        return $config['appInfo']['SHOPIFY_SCOPE'];
	}


	/**
	 * Index Action
	 */
	public function getIndex()
	{
		$this->setTitle('Shopify Example');
		$this->setContent( $this->getView('shopify/index', null, dirname(__DIR__)) );
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
	 * Get Customer
	 */
	public function getCustomer()
	{
		$data = $this->shopify->call('GET', '/admin/customers.json', array());
		$this->setTitle('Shopify: Customers');
		$this->setContent( $this->getLayout('json', $data) );
	}

	/**
	 * Get Order
	 */
	public function getOrder()
	{
		$data = $this->shopify->call('GET', '/admin/orders.json', array());
		$this->setTitle('Shopify: Orders');
		$this->setContent( $this->getLayout('json', $data) );
	}

	/**
	 * Get Product
	 */
	public function getProduct()
	{
        $data = $this->shopify->call('GET', '/admin/products.json', array());
		$this->setTitle('Shopify: Grid');
		$this->setContent( $this->getLayout('grid/shopify', $data, dirname(__DIR__)) );
	}

}