<?php
/**
 * Product model
 * Shopify API, https://docs.shopify.com/api/product
 *
 * @category    shopify
 * @copyright   Copyright (c) 2015, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\shopify\models;

class Product extends ShopifyAbstract
{
    /**
     * Get products
     */
    public function getProducts($options = array())
    {
        return $this->getShopify()->call('GET', '/admin/products.json', $options);
    }
}