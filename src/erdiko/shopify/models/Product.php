<?php
/**
 * Product model
 * Shopify API, https://docs.shopify.com/api/product
 *
 * @package     erdiko/shopify/models
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
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