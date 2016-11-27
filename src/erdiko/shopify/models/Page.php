<?php

namespace erdiko\shopify\models;

class Page extends ShopifyAbstract
{
	protected $namespace="erdiko";

	/**
	 * returns a constant namespace
	 */
    public function getNamespace()
    {
		return $this->namespace;
	}

	/**
	 * get all the store pages
	 */
    public function getPages($sinceId = null)
    {
		return $this->getShopify()->call('GET', '/admin/pages.json', array("since_id" => $sinceId));
	}


	/**
	 * get a particular page
	 */
    public function getPage($pageID, $args = array())
    {	
		 return $this->getShopify()->call('GET', '/admin/pages/' . $pageID . '.json', $args);
	}


	/**
	 * get page count for a store 
	 */
    public function getPageCount()
    {
		return $this->getShopify()->call('GET', '/admin/pages/count.json');
	}

}
