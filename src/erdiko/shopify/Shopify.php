<?php
/**
 * Shopify API connector
 *
 * @category 	shopify
 * @copyright	Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 *
 * Originally taken from ohShopify by cmcdonaldca, 
 * https://github.com/cmcdonaldca/ohShopify.php
 * We made it 
 */
namespace erdiko\shopify;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Shopify {

	public $shop_domain;

	private $token;

	private $api_key;

	private $secret;

	private $last_response_headers = null;

    private $client;

    /**
     * constructor which accepts the domain, token, api key and api secret
     *
     */
    public function __construct($shop_domain, $token, $api_key, $secret) 
    {
		$this->name = "ShopifyClient";
		$this->shop_domain = $shop_domain;
		$this->token = $token;
		$this->api_key = $api_key;
		$this->secret = $secret;
        $this->client = new \GuzzleHttp\Client([
            "base_uri" => "https://{$this->shop_domain}/"
        ]);

        if (class_exists('\\Erdiko')) {
            \Erdiko::log(null, "Connect to {$shop_domain} (Shopify API)");
        }
	}

    /**
     * set the API token for shopify 
     *
     */
	public function setToken($token)
	{
		$this->token = $token;
	}

    /**
     * Get the URL required to request authorization
     *
     */
    public function getAuthorizeUrl($scope, $redirect_url='') 
    {
		$url = "http://{$this->shop_domain}/admin/oauth/authorize?client_id={$this->api_key}&scope=" . urlencode($scope);
		if ($redirect_url != '')
		{
			$url .= "&redirect_uri=" . urlencode($redirect_url);
		}
		return $url;
	}

    /**
     * Once the User has authorized the app, call this with the code to get the access token
     *
     */
    public function getAccessToken($code) 
    {
		// POST to  POST https://SHOP_NAME.myshopify.com/admin/oauth/access_token
		$url = "https://{$this->shop_domain}/admin/oauth/access_token";
		$payload = "client_id={$this->api_key}&client_secret={$this->secret}&code=$code";

		$response = $this->guzzleHttpApiRequest('POST', $url, '', $payload, array());

		if (!empty($response->access_token))
			return $response->access_token;
		return '';
	}

    /**
     *
     *
     */
	public function callsMade()
	{
		return $this->shopApiCallLimitParam(0);
	}

    /**
     *
     *
     */
	public function callLimit()
	{
		return $this->shopApiCallLimitParam(1);
	}

    /**
     *
     *
     */
	public function callsLeft($response_headers)
	{
		return $this->callLimit() - $this->callsMade();
	}

    /**
     *
     *
     */
	public function call($method, $path, $params=array())
	{
        $url        = ltrim($path, '/');

		$query      = in_array($method, array('GET','DELETE')) ? $params : array();
		$payload    = in_array($method, array('POST','PUT')) ? stripslashes(json_encode($params)) : array();

		$request_headers = in_array($method, array('POST','PUT')) ? array("Content-Type: application/json; charset=utf-8", 'Expect:') : array();

        $response = $this->guzzleHttpApiRequest($method, $url, $query='', $payload='', $request_headers=array());

		if (isset($response['errors']) or ($this->last_response_headers['http_status_code'] >= 400))
			throw new ShopifyApiException($method, $path, $params, $this->last_response_headers, $response);

		return (is_array($response) and (count($response) > 0)) ? array_shift($response) : $response;
	}

    /**
     *
     *
     */
    private function guzzleHttpApiRequest($method, $url, $query='', $payload='', $request_headers=array())
    {
        $url = $this->appendQuery($url, $query);

        $curlOpts = array(
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_MAXREDIRS       => 3,
            CURLOPT_USERAGENT       => 'ohShopify-php-api-client',
        );

        try {
        $response = $this->client->request($method, $url, [
                                'headers'       => ['X-Shopify-Access-Token' => $this->token],
                                'curl'          => $curlOpts
                                ]);
        } catch(Guzzle\Http\Exception\ClientException $e) {
            throw new ShopifyGuzzleException($e->getMessage());
        }
    
        $this->last_response_headers = $this->parseHeaders($response);
        $response = (Array)json_decode(trim($response->getBody()->getContents()));

        return $response;
    }

    /**
     *
     *
     */
	private function appendQuery($url, $query)
	{
		if (empty($query)) return $url;
		if (is_array($query)) return "$url?".http_build_query($query);
		else return "$url?$query";
	}

    /**
     *
     *
     */
    private function parseHeaders($response)
	{
		$headers = array();
        $responseHeaders = $response->getHeaders();
        foreach($responseHeaders as $key => $val) {
            $headers[$key] = array_pop($val);
		}
		return $headers;
	}
	
    /**
     * returns http header 
     *
     */
	private function shopApiCallLimitParam($index)
	{
		if ($this->last_response_headers == null)
		{
			throw new Exception('Cannot be called before an API call.');
		}
		$params = explode('/', $this->last_response_headers['http_x_shopify_shop_api_call_limit']);
		return (int) $params[$index];
	}

}
