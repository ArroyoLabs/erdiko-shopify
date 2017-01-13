<?php
/**
 * Order model
 * Shopify API, https://docs.shopify.com/api/product
 *
 * @package     erdiko/shopify/models
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\shopify\models;

class Order extends ShopifyAbstract
{
    /**
     * Get customers
     */
    public function getOrders($options = array())
    {
        return $this->getShopify()->call('GET', '/admin/orders.json', $options);
    }

    public function getOrderByID($orderID)
    {
    	return $this->getShopify()->call('GET', '/admin/orders/'.$orderID.'.json', array());
    }

    public function createOrder($data=array()){
        return $this->getShopify()->call('POST', '/admin/orders.json',$data);
    }
}
