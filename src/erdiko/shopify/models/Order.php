<?php
/**
 * Order model
 * Shopify API, https://docs.shopify.com/api/product
 *
 * @category    shopify
 * @copyright   Copyright (c) 2015, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
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
}