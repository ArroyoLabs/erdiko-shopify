<?php
/**
 * Shopify Abstract Model - Inherit from this class
 * Acts as a service model to wrap the Shopify API
 * It uses the erdiko\shopify\Shopify library to connect
 *
 * @category    shopify
 * @copyright   Copyright (c) 2015, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\shopify\models;

use erdiko\shopify\Shopify;


abstract class ShopifyAbstract
{
    protected $cacheObj; // Cache Object
    protected $shopify; // Shopify object

    public function __construct()
    {
        $this->setShopifyObjectNew();
    }

    /**
     * getShopify
     * 
     * @return object $shopify
     */
    public function getShopify()
    {
        return $this->shopify;
    }

    /**
     * Get the shopify config settings
     *
     * @return array $config
     */
    private function getConfig()
    {
        $config = \Erdiko::getConfig('local/shopify');
        return $config;
    }

    /**
     * Get the shop URL
     *
     * @return string $shopUri
     */
    public function getShopUri()
    {
        $config = $this->getConfig();
        return $config['shop']['uri'];
    }

    /**
     * Get the shop URL
     *
     * @return string $shopUri
     */
    public function getAppUri()
    {
        $config = $this->getConfig();
        return $config['shop']['app'];
    }

    /**
     * Get the API Key
     *
     * @return string $apiKey
     */
    public function getApiKey()
    {
        $config = $this->getConfig();
        return $config['appInfo']['SHOPIFY_API_KEY'];
    }

    /**
     * Get the API Secret
     *
     * @return string $secret
     */
    public function getSecret()
    {
        $config = $this->getConfig();
        return $config['appInfo']['SHOPIFY_SECRET'];
    }

    /**
     * Get the API Scope
     *
     * @return string $scope
     */
    public function getScope()
    {
        $config = $this->getConfig();
        return $config['appInfo']['SHOPIFY_SCOPE'];
    }

    /**
     * Get the API Scope
     *
     * @return string $token
     */
    public function renewShopifyToken() 
    {
        $token = $this->shopify->getAccessToken($this->cacheObj->get('shopify_code'));
        $this->cacheObj->put('shopify_token', $token);

        return $token;
    }

    /**
     * Get the API Scope
     *
     * @return string $token
     */
    public function setShopifyObjectNew()
    {
        $this->cacheObj = \Erdiko::getCache();

        \Erdiko::log(null, "_GET: ".print_r($_GET, true));

        // If code is present, renew the token
        if(isset($_GET['code'])) {
            \Erdiko::log(null, "if(code)");

            $this->cacheObj->put('shopify_code', $_GET['code']);
            $this->cacheObj->put('shopify_shop', $_GET['shop']);
        }

        if(empty($this->cacheObj->get('shopify_code'))) {

            \Erdiko::log(null, "if(!shopify_code)");

            $shop = $this->getShopUri();
            $this->cacheObj->put('shopify_shop', $shop);
            $this->shopify = new Shopify($shop, "", $this->getApiKey(), $this->getSecret());

            // Redirect to Shopfy to get authorization code
            header("Location: " . $this->shopify->getAuthorizeUrl($this->getScope(), $this->getAppUri()));
            exit();
        }

        // Instantiate shopify object
        $this->shopify = new Shopify($this->cacheObj->get('shopify_shop'), "", $this->getApiKey(), 
            $this->getSecret());

        // Check for an existing token, if not present request one using the shopify_code
        if(empty($this->cacheObj->get('shopify_token'))) {
            \Erdiko::log(null, "if(!shopify_token)");
            $this->renewShopifyToken();
        }
        
        // Set the token within shopify so we can use the API
        $this->shopify->setToken($this->cacheObj->get('shopify_token'));

        \Erdiko::log(null, "code: ".$this->cacheObj->get('shopify_code'));
        \Erdiko::log(null, "shop: ".$this->cacheObj->get('shopify_shop'));
        \Erdiko::log(null, "token: ".$this->cacheObj->get('shopify_token'));        
    }



    /*** DELETE ME ***/



    // old auth...
    public function setShopifyObject()
    {
        $this->cacheObj = \Erdiko::getCache();

        if(isset($_GET['code']))
        {
            $this->cacheObj->put('shopify_code', $_GET['code']);
            $this->cacheObj->put('shopify_shop', $_GET['shop']);
        }

        if(empty($this->cacheObj->get('shopify_code'))) {
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
     *  Get the shop URL
     *
     *  @return URL
     **/
    private function returnSite()
    {
        $config = \Erdiko::getConfig('local/shopify');
        return $config['shop']['erdiko'];
    }

    /**
     *  Get the API Key
     *
     *  @return string
     **/
    private function returnApiKey()
    {
        $config = \Erdiko::getConfig('local/shopify');
        return $config['appInfo']['SHOPIFY_API_KEY'];
    }

    /**
     *  Get the API Secret
     *
     *  @return string
     **/
    private function returnSecret()
    {
        $config = \Erdiko::getConfig('local/shopify');
        return $config['appInfo']['SHOPIFY_SECRET'];
    }

    /**
     *  Get the API Scope
     *
     *  @return string
     **/
    private function returnScope()
    {
        $config = \Erdiko::getConfig('local/shopify');
        return $config['appInfo']['SHOPIFY_SCOPE'];
    }
}