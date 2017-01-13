<?php
/**
 * Blog
 *
 * @package     erdiko/shopify/models
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */

namespace erdiko\shopify\models;

class Blog extends ShopifyAbstract
{
	protected $namespace="erdiko";

	/**
	 * returns a constant namespace
	 */

	public function getNamespace(){
		return $this->namespace;
	}

	/**
	 * get all the blogs
	 */
	public function getBlogs(){
		return $this->getShopify()->call('GET', '/admin/blogs.json', array());
	}


	/**
	 * modify a particular blog
	 */
	public function modifyBlog($blogID,$args=array()){	
		 return $this->getShopify()->call('GET', '/admin/blogs/'.$blogID.'.json', $args);
	}


	/**
	 * get blog articles of a particular blog
	 */
	public function getBlogArticles($blogID){
		return $this->getShopify()->call('GET', '/admin/blogs/'.$blogID.'/articles.json', array());
	}

	/**
	 * get article of a particular blog
	 */
	public function getArticle($blogID,$articleID){
		return $this->getShopify()->call('GET', '/admin/blogs/'.$blogID.'/articles/'.$articleID.'.json', array());
	}

	/**
	 * get blog by blog name
	 */
	public function getBlogIDByName($blogName){
		$data = $this->getShopify()->call('GET', '/admin/blogs.json', array());
		for($i=0; $i<count($data); $i++)
		{
			if(strcmp($blogName,$data[$i]['title'])==0)
			{
				return $data[$i]['id'];
			}
		}
	}

}