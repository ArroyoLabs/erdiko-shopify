<?php
/**
 * Shopify API Exception
 * 
 * Original class borrowed from ohShopify by cmcdonaldca, 
 * https://github.com/cmcdonaldca/ohShopify.php
 * @copyright	Copyright (c) 2015, Arroyo Labs, www.arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\shopify\models;

class ShopifyApiException extends \Exception
{
	protected $method;
	protected $path;
	protected $params;
	protected $response_headers;
	protected $response;
	
	public function __construct($method, $path, $params, $response_headers, $response)
	{
		$this->method = $method;
		$this->path = $path;
		$this->params = $params;
		$this->response_headers = $response_headers;
		$this->response = $response;
		
		parent::__construct($response_headers['http_status_message'], $response_headers['http_status_code']);
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getPath() {
		return $this->path;
	}

	public function getParams() 
	{
		return $this->params;
	}

	public function getResponseHeaders() {
		return $this->response_headers;
	}

	public function getResponse() {
		return $this->response;
	}
}