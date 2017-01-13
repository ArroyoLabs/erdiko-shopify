<?php
/**
 * Metafield model
 * Shopify API, https://docs.shopify.com/api/metafield
 *
 * @package     erdiko/shopify/models
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
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
    //newly added

     /**
     * Update store level Metafield
     */
    public function updateMetaField($metaFieldID,$args){
        return $this->getShopify()->call('PUT', '/admin/metafields/'.$metaFieldID.'.json', $args);
    }

    /**
     * Delete store level Metafield
     */
    public function deleteMetaField($metaFieldID){
        return $this->getShopify()->call('DELETE', '/admin/metafields/'.$metaFieldID.'.json', array());
    }

    // newly added ends

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

    
    /** Newly added**/

    /**
     * Set blog level Metafield
     */
    public function setBlogMetaField($blogID,$args)
    {

        return $this->getShopify()->call('PUT', '/admin/blogs/'.$blogID.'.json', $args);
    }

    /**
     * Get blog level Metafields
     */
    public function getBlogMetaFields($blogID){ 
        return $this->getShopify()->call('GET', '/admin/blogs/'.$blogID.'/metafields.json',array());
    }

    /**
     * Update blog level Metafield
     */
    public function updateBlogMetaField($blogID,$metaFieldID,$args){
        return $this->getShopify()->call('PUT', '/admin/blogs/'.$blogID.'/metafields/'.$metaFieldID.'.json', $args);
    }

    /**
     * Delete blog level Metafield
     */
    public function deleteBlogMetaField($blogID,$metaFieldID,$args){
        return $this->getShopify()->call('DELETE', '/admin/blogs/'.$blogID.'/metafields/'.$metaFieldID.'.json', $args);
    }


    /**
     * Set blog article level Metafield
     */
    public function setBlogArticleMetaField($blogID,$articleID,$args=array()){
        return $this->getShopify()->call('PUT', '/admin/blogs/'.$blogID.'/articles/'.$articleID.'.json', $args);
    }


    /**
     * Get blog article level Metafields
     */
    public function getBlogArticleMetaFields($articleID){ 
        return $this->getShopify()->call('GET', '/admin/articles/'.$articleID.'/metafields.json',array());
    }

    /**
     * Update blog level Metafield
     */
    public function updateBlogArticleMetaField($articleID,$metaFieldID,$args){
        return $this->getShopify()->call('PUT', '/admin/articles/'.$articleID.'/metafields/'.$metaFieldID.'.json', $args);
    }

    /**
     * Delete blog article level Metafield
     */
    public function deleteBlogArticleMetaField($articleID,$metaFieldID,$args=array()){
        return $this->getShopify()->call('DELETE', '/admin/articles/'.$articleID.'/metafields/'.$metaFieldID.'.json', $args);
    }

    public function getArticleInfo($articleID,$blogID){
        $data=$this->getBlogArticleMetaFields($articleID);

        $newData=array();

        $src_id=0;
        $url_id=0;
        $title_id=0;
        $src="";
        $title="";
        $url="";
        for($i=0;$i<count($data);$i++){
            if(!strcmp($data[$i]['key'],"src"))
            {
                
                $newData["src"]=array(
                    'value'=>$data[$i]['value'],
                    'id'=>$data[$i]['id']
                    );
                $src_id=$data[$i]['id'];
                $src=$data[$i]['value'];

                
            } 
            else if(!strcmp($data[$i]['key'],"url"))
            {
                
                $newData["url"]=array(
                    'value'=>$data[$i]['value'],
                    'id'=>$data[$i]['id']
                    );
                $url_id=$data[$i]['id'];
                $url=$data[$i]['value'];
            } 
            else if(!strcmp($data[$i]['key'],"title"))
            {
                
                $newData["title"]=array(
                    'value'=>$data[$i]['value'],
                    'id'=>$data[$i]['id']
                    );
                $title_id=$data[$i]['id'];
                $title=$data[$i]['value'];

            }
        }
       
        if(count($data)==3){

           $newData["edit_link"]="/shop/showEditArticleInfo?article_id=".$articleID."&src_id=".$src_id."&url_id=".$url_id."&title_id=".$title_id."&src=".$src."&url=".$url."&title=".$title;
           $newData["delete_link"]="/shop/deleteArticleInfo?article_id=".$articleID."&src_id=".$src_id."&url_id=".$url_id."&title_id=".$title_id;

         
        }
        $newData["add_link"]="/shop/showAddArticleInfo?blog_id=".$blogID."&article_id=".$articleID;
        
        return $newData;
    }


    /**
     * get all the store metafields (modified the data structure)
     */
    public function getStoreInfo(){
        $data=$this->getMetafields(array());
        $newData=array();
        $valuesArray=array();
        $idArray=array();
        $valType=array();
        for($i=0;$i<count($data);$i++){
            $keysArray[$i]=$data[$i]['key'];
            $valuesArray[$data[$i]['key']]=$data[$i]['value'];
            $idArray[$data[$i]['key']."_id"]=$data[$i]['id'];
            $valType[$data[$i]['key']]=$data[$i]['value_type'];
        }
        if(count($data)!=0){
        $queryArray=array_merge($valuesArray,$idArray);
        $query=http_build_query($queryArray);

        $newData['keys']=$keysArray;
        $newData['values']=$valuesArray;
        $newData['id']=$idArray;
        $newData['value_type']=$valType;
        $newData['edit_link']="/shop/showEditStoreInfo?".$query;
        $newData['add_link']="/shop/showAddStoreInfo";
        $newData['add_key_link']="/shop/addStoreKey";
        $newData['delete_link']="/shop/deleteStoreInfo?".$query;


        }
        return $newData;
    }
}
