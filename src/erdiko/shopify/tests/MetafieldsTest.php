<?php

namespace erdiko\shopify\tests;


require_once 'ErdikoTestCase.php';


class MetafieldsTest extends ErdikoTestCase
{
	protected $meta =null;

	public function setUp(){
		$this->meta = new \erdiko\shopify\models\Metafield;
	}

	/*
	 * Test function to 
	 *	create a Product metafield and check if it is created
	 *	update the Product metafield and check if it is updated				
	 *	delete the Product metafield and check if it is deleted				
	 */
	public function testProductMetafields(){
		 $product = new \erdiko\shopify\models\Product;

		 $data = $product->getProducts();
		 $this->assertTrue(count($data)>0,"There should be atleast one product to
		 	continue this test");
		 $pId = $data[0]['id'];
		 $this->assertTrue(!empty($pId),"Product id is empty");

		 // create
		 $args=array(
				"metafield"=>array("namespace" => $this->meta-> getNamespace(),
	    		"key" => "test_key",
	    		"value"=> "test_value",
	    		"value_type" =>"string")
				);

		 $resp = $this->meta->setProductMetaField($pId,$args);
		 $this->assertTrue(!empty($resp),"empty response");

		 $metaID = $resp['id'];
		 $this->assertTrue(!empty($metaID),"metafield id is empty");

		 $metaResp = $this->meta->getProductMetaFieldByID($pId,$metaID);
		 
		 $this->assertTrue(strcmp($metaResp['key'],'test_key')==0);
		 $this->assertTrue(strcmp($metaResp['value'],'test_value')==0);
		 $this->assertTrue($metaResp['id']==$metaID);


		 //update
		 $args=array(
				"metafield"=>array(
	    		"id" => $metaID,
	    		"value"=> "test_value_2",
	    		"value_type" =>"string")
				);

		 $resp = $this->meta->updateProductMetaField($pId,$metaID,$args);
		 $this->assertTrue(!empty($resp),"empty response");

		 $metaID = $resp['id'];
		 $this->assertTrue(!empty($metaID),"metafield id is empty");

		 $metaResp = $this->meta->getProductMetaFieldByID($pId,$metaID);
		 
		 $this->assertTrue(strcmp($metaResp['key'],'test_key')==0);
		 $this->assertTrue(strcmp($metaResp['value'],'test_value_2')==0);
		 $this->assertTrue($metaResp['id']==$metaID);


		 // delete
		 $this->meta->deleteProductMetaField($pId,$metaID,array());
		 $pMetaData= $this->meta->getProductMetaFields($pId);
		 foreach($pMetaData as $data){
		 	$this->assertFalse($data['id']==$metaID,"metafield not deleted !");
		 }
   

	}

	/*
	 * Test function to 
	 *	create a Blog metafield and check if it is created
	 *	update the Blog metafield and check if it is updated				
	 *	delete the Blog metafield and check if it is deleted				
	 */
	public function testBlogMetafields(){
		 $blog = new \erdiko\shopify\models\Blog;

		 $data = $blog->getBlogs();
		 $this->assertTrue(count($data)>0,"There should be atleast one blog to
		 	continue this test");
		 $bId = $data[0]['id'];
		 $this->assertTrue(!empty($bId),"Blog id is empty");
		 
		  // create
		 $args = array(
			"blog"=>array(
				"id" => $bId, 
				"metafields"=>array(array(
					"key" => "test_blog_key_1",
        			"value"=> "test_blog_value_1" ,
        			"value_type"=> "string",
        			"namespace" => $this->meta->getNamespace()
					))
				)
			);
		
		 $this->meta->setBlogMetaField($bId,$args);
		 
		 $blogsMeta =$this->meta->getBlogMetaFields($bId);
		 $metaResp ="";
		 $metaID=0;
		 foreach($blogsMeta as $metaResp){
		 	if(strcmp($metaResp['key'],"test_blog_key_1")==0){
		 		$metaID=$metaResp['id'];
		 		$this->assertTrue(strcmp($metaResp['value'],'test_blog_value_1')==0);
		 	}
		 }
		 $this->assertTrue($metaID!=0,"metafield is not set");
		 

		 //update
		 $args=array(
				"metafield"=>array(
	    		"id" => $metaID,
	    		"value"=> "test_value_2",
	    		"value_type" =>"string")
				);

		 $resp = $this->meta->updateBlogMetaField($bId,$metaID,$args);
		 $blogsMeta =$this->meta->getBlogMetaFields($bId);
		 $metaResp ="";
		 $metaID=0;
		 foreach($blogsMeta as $metaResp){
		 	if(strcmp($metaResp['key'],"test_blog_key_1")==0){
		 		$metaID=$metaResp['id'];
		 		$this->assertTrue(strcmp($metaResp['value'],'test_value_2')==0);
		 	}
		 }
		 $this->assertTrue($metaID!=0,"metafield is not set");
		 

		 // delete
		 $this->meta->deleteBlogMetaField($bId,$metaID,array());
		 $bMetaData= $this->meta->getBlogMetaFields($bId);
		 foreach($bMetaData as $data){
		 	$this->assertFalse($data['id']==$metaID,"metafield not deleted !");
		 }
   
	}

	/*
	 * Test function to 
	 *	create a Article metafield and check if it is created
	 *	update the Article metafield and check if it is updated				
	 *	delete the Article metafield and check if it is deleted				
	 */
	public function testArticleMetafields(){
		 
		 $blog = new \erdiko\shopify\models\Blog;

		 $data = $blog->getBlogs();
		 $this->assertTrue(count($data)>0,"There should be atleast one blog to
		 	continue this test");
		 $bId = $data[0]['id'];
		 $this->assertTrue(!empty($bId),"Blog id is empty");

		 $articles = $blog->getBlogArticles($bId);
		 $this->assertTrue(count($data)>0,"There should be atleast one article to
		 	continue this test");
		 $aId = $articles[0]['id'];
		 $this->assertTrue(!empty($aId),"Article id is empty");
		  // create
		 $args = array(
			"article"=>array(
				"id" => $aId, 
				"metafields"=>array(array(
					"key" => "test_article_key",
        			"value"=> "test_article_value" ,
        			"value_type"=> "string",
        			"namespace" => $this->meta->getNamespace()
					))
				)
			);		 

		 $this->meta->setBlogArticleMetaField($bId,$aId,$args);
		 
		 $articlesMeta =$this->meta->getBlogArticleMetaFields($aId);
		 $metaResp ="";
		 $metaID=0;
		 foreach($articlesMeta as $metaResp){
		 	if(strcmp($metaResp['key'],"test_article_key")==0){
		 		$metaID=$metaResp['id'];
		 		$this->assertTrue(strcmp($metaResp['value'],'test_article_value')==0);
		 	}
		 }
		 $this->assertTrue($metaID!=0,"metafield is not set");
		 

		 //update
		 $args=array(
				"metafield"=>array(
	    		"id" => $metaID,
	    		"value"=> "test_article_value_1",
	    		"value_type" =>"string")
				);

		 $resp = $this->meta->updateBlogArticleMetaField($aId,$metaID,$args);
		 $articlesMeta =$this->meta->getBlogArticleMetaFields($aId);
		 $metaResp ="";
		 $metaID=0;
		 foreach($articlesMeta as $metaResp){
		 	if(strcmp($metaResp['key'],"test_article_key")==0){
		 		$metaID=$metaResp['id'];
		 		$this->assertTrue(strcmp($metaResp['value'],'test_article_value_1')==0);
		 	}
		 }
		 $this->assertTrue($metaID!=0,"metafield is not set");
		 
		
		 // delete
		 $this->meta->deleteBlogArticleMetaField($bId,$metaID,array());
		 $articlesMeta= $this->meta->getBlogArticleMetaFields($aId);
		 foreach($articlesMeta as $data){
		 	$this->assertFalse($data['id']==$metaID,"metafield not deleted !");
		 }
   
	}


	/*
	 * Test function to 
	 *	create a Store metafield and check if it is created
	 *	update the Store metafield and check if it is updated				
	 *	delete the Store metafield and check if it is deleted				
	 */
	public function testStoreMetafields(){
		
		 // create
		 $args=array(
				"metafield"=>array("namespace" => $this->meta-> getNamespace(),
	    		"key" => "test_store_key",
	    		"value"=> "test_store_value",
	    		"value_type" =>"string")
				);

		 $resp = $this->meta->setMetafields($args);
		 $this->assertTrue(!empty($resp),"empty response");

		 $metaID = $resp['id'];
		 $this->assertTrue(!empty($metaID),"metafield id is empty");

		 $metaResp = $this->meta->getMetafieldByID($metaID);
		 
		 $this->assertTrue(strcmp($metaResp['key'],'test_store_key')==0);
		 $this->assertTrue(strcmp($metaResp['value'],'test_store_value')==0);
		 $this->assertTrue($metaResp['id']==$metaID);


		 //update
		 $args=array(
				"metafield"=>array(
	    		"id" => $metaID,
	    		"value"=> "test_store_value_1",
	    		"value_type" =>"string")
				);

		 $resp = $this->meta->updateMetaField($metaID,$args);
		 $this->assertTrue(!empty($resp),"empty response");

		 $metaID = $resp['id'];
		 $this->assertTrue(!empty($metaID),"metafield id is empty");

		 $metaResp = $this->meta->getMetafieldByID($metaID);
		 
		 $this->assertTrue(strcmp($metaResp['key'],'test_store_key')==0);
		 $this->assertTrue(strcmp($metaResp['value'],'test_store_value_1')==0);
		 $this->assertTrue($metaResp['id']==$metaID);


		 // delete
		 $this->meta->deleteMetaField($metaID);
		 $pMetaData= $this->meta->getMetafields();
		 foreach($pMetaData as $data){
		 	$this->assertFalse($data['id']==$metaID,"metafield not deleted !");
		 }
   

	}
}
