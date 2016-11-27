<?php
/**
 * ShopifyApiException
 * API exception
 * Original from ohShopify by cmcdonaldca, https://github.com/cmcdonaldca/ohShopify.php
 *
 * @category 	shopify
 * @copyright	Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\shopify;

class ShopifyApiException extends \Exception
{
	protected $method;
	protected $path;
	protected $params;
	protected $response_headers;
	protected $response;
	
	function __construct($method, $path, $params, $response_headers, $response)
	{
		$this->method = $method;
		$this->path = $path;
		$this->params = $params;
		$this->response_headers = $response_headers;
		$this->response = $response;
		
		parent::__construct($response_headers['http_status_message'], $response_headers['http_status_code']);
	}

	function getMethod()
	{
		return $this->method;
	}

	function getPath() 
	{
		return $this->path;
	}

	function getParams() 
	{
		return $this->params;
	}
	
	function getResponseHeaders() 
	{
		return $this->response_headers;
	}

	function getResponse()
	{
		return $this->response;
	}
}