<?php
/**
 * Metafield model
 * Shopify API, https://docs.shopify.com/api/metafield
 *
 * @category    shopify
 * @copyright   Copyright (c) 2015, Arroyo Labs, www.arroyolabs.com
 * @author      John Arroyo, john@arroyolabs.com
 */
namespace erdiko\shopify\models;

class Metafield extends ShopifyAbstract
{
    protected $namespace = "erdiko";

    /**
     * getShopify
     * 
     * @return object $shopify
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get store level metafields
     */
    public function getMetafields($options = array())
    {
        return $this->getShopify()->call('GET', '/admin/metafields.json', $options);
    }

    /**
     * Set store level metafields
     */
    public function setMetafields($options = array())
    {
        return $this->getShopify()->call('POST', '/admin/metafields.json', $options);
    }

    /**
     * Set product level Metafield
     */
    public function setProductMetaField($productID,$args){
        
        return $this->getShopify()->call('POST', '/admin/products/'.$productID.'/metafields.json', $args);
    }

    /**
     * Get Product level Metafields
     */
    public function getProductMetaFields($productID){ 
        return $this->getShopify()->call('GET', '/admin/products/'.$productID.'/metafields.json',array());
    }

    /**
     * Update product level Metafield
     */
    public function updateProductMetaField($productID,$metaFieldID,$args){
        return $this->getShopify()->call('PUT', '/admin/products/'.$productID.'/metafields/'.$metaFieldID.'.json', $args);
    }

    /**
     * Delete product level Metafield
     */
    public function deleteProductMetaField($productID,$metaFieldID,$args){
        return $this->getShopify()->call('DELETE', '/admin/products/'.$productID.'/metafields/'.$metaFieldID.'.json', $args);
    }
}