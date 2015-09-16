<?php
/**
 * Customer model
 * Shopify API, https://docs.shopify.com/api/product
 *
 * @category    shopify
 * @copyright   Copyright (c) 2015, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\shopify\models;

class Customer extends ShopifyAbstract
{
    /**
     * Get customers
     */
    public function getCustomers($options = array())
    {
        return $this->getShopify()->call('GET', '/admin/customers.json', $options);
    }
}