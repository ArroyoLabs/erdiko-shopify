<?php
/**
 * Example Shopify Controller
 * Some examples of how to use the shopify API
 *
 * @package     erdiko/shopify/models
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author 		Coleman Tung
 * @author      John Arroyo <john@arroyolabs.com>
 * @author 		Andy Armstrong <andy@arroyolabs.com>
 */

namespace erdiko\shopify\controllers;
use \erdiko\shopify\ShopifyApiException;
use \erdiko\shopify\ShopifyCurlException;

/**
 * ShopifyExample Class  extends \erdiko\shopify\Shopify
 */
class Shopify extends \erdiko\core\Controller
{
	/** Cache Object */
    private $cacheObj;

	/** Shopify Object */
	protected $shopify;

	/** Before */
	public function _before()
	{
		$this->setThemeName('bootstrap');
		$this->prepareTheme();
	}

	/**
	 * Get
	 *
	 * @param mixed $var
	 * @return mixed
	 */
	public function get($var = null)
	{
		if(!empty($var))
		{
			// load action based off of naming conventions
			return $this->_autoaction($var, 'get');

		} else {
			return $this->getIndex();
		}
	}

	/**
	 * Index Action
	 */
	public function getIndex()
	{
		$metafield = new \erdiko\shopify\models\Metafield; // instantiate model to force authentication

		$this->setTitle('Shopify Examples');
		$this->setContent( $this->getView('shopify/index', null, dirname(__DIR__)) );
	}

	/**
	 * Get Metafields
	 */
	public function getMetafields()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$data = $metafield->getMetafields();

		$this->setTitle('Shopify Metafields');
		$this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
	}

	/**
	 * Get Metafields
	 */
	public function getMetafieldsTest()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$meta = array(
			"metafield" => array(
				"namespace" => $metafield->getNamespace(),
    			"key" => "warehouse",
    			"value" => 25,
                "value_type" => "integer"
        ));

		$data = $metafield->setMetafields($meta);

		$this->setTitle('Shopify Metafields');
		$this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
	}

	/**
	 * Get Customers
	 */
	public function getCustomers()
	{
		$customer = new \erdiko\shopify\models\Customer;
		
		$message="";
		$isError=FALSE;

		try {
            $data = $customer->getCustomers();
		} catch(ShopifyApiException $e) {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in getting Customer list :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
        	$isError=TRUE;
        } catch(ShopifyCurlException $e) {
           $message="Error :: Shopify Curl Exception";
           $isError=TRUE;
        } catch (Exception $e) {
           $message=$e->getMessage();
           $isError=TRUE;
        }
       
        if(!$isError) {
            $this->setTitle('Shopify Customers');
            $this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
        } else {
            $this->setContent( $this->getLayout('message', $message) );
        }

	}

	/**
	 * Get Orders
	 */
	public function getOrders()
	{
		$order = new \erdiko\shopify\models\Order;
		
		$message="";
		$isError=FALSE;

        try {
            $data = $order->getOrders();
        } catch(ShopifyApiException $e) {
            $response_headers=$e->getResponseHeaders();
            $message = "Error in getting order list :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
            $isError=TRUE;
        } catch(ShopifyCurlException $e) {
            $message="Error :: Shopify Curl Exception";
            $isError=TRUE;
        } catch (Exception $e) {
            $message=$e->getMessage();
            $isError=TRUE;
        }
       
		
        if(!$isError) {
            $this->setTitle('Shopify Orders');
            $this->setContent($this->getLayout('json', $data, dirname(__DIR__)));
        } else {
        	$this->setContent($this->getLayout('message', $message));
        }
	}

	/**
	 * Get Products
	 */
	public function getProducts()
	{
        $product = new \erdiko\shopify\models\Product;
        try {
            $data = $product->getProducts();
        } catch(ShopifyApiException $e) {
            $response_headers=$e->getResponseHeaders();
            $message = "Error in getting product list :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
            $isError=TRUE;
        } catch(ShopifyCurlException $e) {
            $message="Error :: Shopify Curl Exception";
            $isError=TRUE;
        } catch (Exception $e) {
            $message=$e->getMessage();
            $isError=TRUE;
        }

        if(!$isError) {
            $this->setTitle('Shopify Product Grid');
            $this->setContent( $this->getLayout('grid/shopify', $data, dirname(__DIR__)) );
        } else{

        	$this->setContent( $this->getLayout('message', $message) );
        }
	}

	/**
	 * Create Metafield for a product
	 */
	public function getCreateProductMetaField()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$productID=$_GET['product_id'];
		$args=array(
			"metafield"=>array("namespace" => "inventory",
    		"key" => $_GET['key'],
    		"value"=> $_GET['value'],
    		"value_type" =>$_GET['value_type'])
			);
		$message = "successfully processed the request";
		try{
			$metafield->setProductMetaField($productID,$args);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in adding Product Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
		$this->setContent( $this->getLayout('message', $message) );
		
	}

	/**
	 * Get Metafields of a product
	 */
	public function getProductMetaFields()
	{
		$metafield = new \erdiko\shopify\models\Metafield;	
		$productID=$_GET['product_id'];
		
		$message="";
		$isError=FALSE;

		try{
			$data=$metafield->getProductMetaFields($productID);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in getting product list :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
        	$isError=TRUE;
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
           $isError=TRUE;
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
           $isError=TRUE;
        }
       
		
        if(!$isError){
        	$this->setTitle('Shopify: Metafields');
			$this->setContent( $this->getLayout('grid/metaDataListing', $data, dirname(__DIR__)) );
        } else{

        	$this->setContent( $this->getLayout('message', $message) );
        }
		
	}

	/**
	 * Edit Metafield of a product
	 */
	public function getEditProductMetaField()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$productID=$_GET['product_id'];
		$metaFieldID=$_GET['id'];
		$args=array(
			"metafield"=>array(
			"id" => $_GET['id'],
    		"value"=> $_GET['value'],
    		"value_type"=>$_GET['value_type'])
			);
		$message = "successfully processed the request";
		try{
			$data=$metafield->updateProductMetaField($productID,$metaFieldID,$args);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in editing Product Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
		$this->setContent( $this->getLayout('message', $message) );
	}

	/**
	 * Delete Metafield of a product
	 */
    public function getDeleteProductMetaData()
    {
		$metafield = new \erdiko\shopify\models\Metafield;
		$productID=$_GET['product_id'];
		$metaFieldID=$_GET['id'];
		
		$message = "successfully processed the request";
		try{
			$metafield->deleteProductMetaField($productID,$metaFieldID,array());
		}
        catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in adding Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );
	}

	/**
	 * Show the userform to edit the Metafields
	 */
    public function getShowEdit()
    {
		$data=array(
			"product_id"=>$_GET['product_id'],
			"id"=>$_GET['id'],
			"key"=>$_GET['key'],
			"value"=>$_GET['value'],
			"value_type"=>$_GET['value_type']);
		$this->setTitle('Edit Meta Data Fields');
		$this->setContent( $this->getView('shopify/editForm',$data, dirname(__DIR__)) );
	}

	/**
	 * Show the userform to add Metafield of a product
	 */
    public function getShowForm()
    {
		$data=$_GET['product_id'];
		$this->setTitle('Create New Meta Field');
		$this->setContent($this->getView('shopify/formView',$data,dirname(__DIR__)));
	}

	/**
	 * Get the list of existing blogs
	 */
    public function getBlogs()
    {
		
		$blog = new \erdiko\shopify\models\Blog;
		
		$message="";
		$isError=FALSE;

		try{
			$data = $blog->getBlogs();
		} catch(ShopifyApiException $e) {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in adding Metafield :: "
                        . $response_headers['http_status_code'].":" 
                        . $response_headers['http_status_message'];                
        	$isError = TRUE;
        } catch(ShopifyCurlException $e) {
           $message = "Error :: Shopify Curl Exception";
           $isError = TRUE;
        } catch (Exception $e) {
           $message = $e->getMessage();
           $isError = TRUE;
        }
       
        if(!$isError){
        	$this->setTitle('Shopify Blogs');
            $this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
        } else{

        	$this->setContent( $this->getLayout('message', $message) );
        }

	}

	/**
	 * Add Metafields to a blog
	 */
    public function getAddBlogMetaField()
    {
		 
		$metafield = new \erdiko\shopify\models\Metafield;
		$data = array(
			"blog"=>array(
				"id" => $_GET['blog_id'], 
				"metafields"=>array(array(
					"key" => $_GET['key'],
        			"value"=> $_GET['value'] ,
        			"value_type"=> $_GET['value_type'],
        			"namespace" => $metafield->getNamespace()
					))
				)
			);
		$message = "successfully processed the request";
		try{
			$metafield->setBlogMetaField($_GET['blog_id'],$data);
		}
        catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in adding Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );
	
	}

	/**
	 * Get the blog Metafields
	 */
    public function getBlogMetaFields()
    {
		$metafield = new \erdiko\shopify\models\Metafield;
		$blogID = $_GET['blog_id'];
	
		$message="";
		$isError=FALSE;

		try{
			$data=$metafield->getBlogMetaFields($blogID);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in adding Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
        	$isError=TRUE;
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
           $isError=TRUE;
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
           $isError=TRUE;
        }
       
		
        if(!$isError){
        	$this->setTitle('Shopify Blogs Metafields');
			$this->setContent( $this->getLayout('grid/blogsMetaDataListing', $data, dirname(__DIR__)) );
        } else{

        	$this->setContent( $this->getLayout('message', $message) );
        }
	}

	/**
	 * Edit Metafield of a blog
	 */
	public function getEditBlogMetaField()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$blogID=$_GET['blog_id'];
		$metaFieldID=$_GET['id'];
		$args=array(
			"metafield"=>array(
			"id" => $_GET['id'],
    		"value"=> $_GET['value'],
    		"value_type"=>$_GET['value_type'])
			);

		$message = "successfully processed the request";
		try{
			$metafield->updateBlogMetaField($blogID,$metaFieldID,$args);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in editing Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );

	}

	/**
	 * Delete Metafield of a blog
	 */
    public function getDeleteBlogMetaData()
    {
		$metafield = new \erdiko\shopify\models\Metafield;
		$blogID=$_GET['blog_id'];
		$metaFieldID=$_GET['id'];
		
		$message = "successfully processed the request";
		try{
			$metafield->deleteBlogMetaField($blogID,$metaFieldID,array());
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in deleting Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );
	}

	/**
	 * Show the userform to edit the Blog Metafields
	 */
    public function getShowBlogEdit()
    {
		$data=array(
			"blog_id"=>$_GET['blog_id'],
			"id"=>$_GET['id'],
			"key"=>$_GET['key'],
			"value"=>$_GET['value'],
			"value_type"=>$_GET['value_type']);
		$this->setTitle('Edit Meta Data Fields');
		$this->setContent( $this->getView('shopify/editBlogForm',$data, dirname(__DIR__)) );
	}
	
	/**
	 * Show the userform to add Metafield of a product
	 */
    public function getShowBlogMetaDataAddForm()
    {
		$data=$_GET['blog_id'];
		$this->setTitle('Create New Meta Field');
		$this->setContent($this->getView('shopify/addBlogMetaDataFormView',$data,dirname(__DIR__)));
	}

	/**
	 *
	 */
    private function retrieveBlogArticlesHelper($blogID,$type)
    {
		$blog = new \erdiko\shopify\models\Blog;
		$data=$blog->getBlogArticles($blogID);

		$message="";
		$isError=FALSE;

		try{
			$data = $blog->getBlogArticles($blogID);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in adding Metafield :: "
                . $response_headers['http_status_code'] . ":" 
                . $response_headers['http_status_message'];                
        	$isError=TRUE;
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
           $isError=TRUE;
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
           $isError=TRUE;
        }
       
		
        if(!$isError){
        	$this->setTitle('Blog Articles');
        	array_push($data,$blogID);
        	if(!strcmp($type,"articleInfoPage")){
                $this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
        	} else{
                $this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
			
        	}
        	
        } else{

        	$this->setContent( $this->getLayout('message', $message) );
        }	

	}

	/**
	 * Get All Blog Articles
	 */
    public function getBlogArticles()
    {
		$blogID=$_GET['blog_id'];
		$this->retrieveBlogArticlesHelper($blogID,"blogArticlesPage");		
	}

	/**
	 * Get all the blog article metafields
	 */
    public function getBlogArticleMetafields()
    {
		$blogID = $_GET['blog_id'];
		$articleID = $_GET['article_id'];
		$metafield = new \erdiko\shopify\models\Metafield;
		
		$message="";
		$isError=FALSE;

		try{
			$data=$metafield->getBlogArticleMetaFields($articleID);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in adding Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];                
        	$isError=TRUE;
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
           $isError=TRUE;
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
           $isError=TRUE;
        }
       
		
        if(!$isError){
        	$this->setTitle('Blog Articles Metafields');
			$this->setContent( $this->getLayout('grid/articleMetaDataListing', $data, dirname(__DIR__)) );
        } else{

        	$this->setContent( $this->getLayout('message', $message) );
        }
	}

	/**
	 * Add Metafields to a blog article
	 */
    public function getAddBlogArticleMetaField()
    {
		 
		$metafield = new \erdiko\shopify\models\Metafield;
		$data = array(
			"article"=>array(
				"id" => $_GET['article_id'], 
				"metafields"=>array(array(
					"key" => $_GET['key'],
        			"value"=> $_GET['value'] ,
        			"value_type"=> $_GET['value_type'],
        			"namespace" => $metafield->getNamespace()
					))
				)
			);
		

		$message = "successfully processed the request";
		try{
			$metafield->setBlogArticleMetaField($_GET['blog_id'],$_GET['article_id'],$data);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in deleting Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );
	}

	/**
	 * Edit the blog article metafields
	 */
	public function getEditBlogArticleMetaField()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
	
		$metaFieldID=$_GET['id'];
		$articleID = $_GET['article_id'];
		$args=array(
			"metafield"=>array(
			"id" => $_GET['id'],
    		"value"=> $_GET['value'],
    		"value_type"=>$_GET['value_type'])
			);
		
		$message = "successfully processed the request";
		try{
			$data=$metafield->updateBlogArticleMetaField($articleID,$metaFieldID,$args);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in editing Blog Article Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );
	}
    
    /**
     *
     */   
    public function getAddArticleInfo()
    {
    	
		$metafield = new \erdiko\shopify\models\Metafield;
		$data = array(
			"article"=>array(
				"id" => $_GET['article_id'], 
				"metafields"=>array(array(

					"key" => "src",
        			"value"=> $_GET['src'] ,

        			"value_type"=> "string",
        			"namespace" => $metafield->getNamespace()
					),
				array(
					"key" => "url",
        			"value"=> $_GET['url'] ,
        			"value_type"=> "string",
        			"namespace" => $metafield->getNamespace()
					),
				array(
					"key" => "title",
        			"value"=> $_GET['title'] ,
        			"value_type"=> "string",
        			"namespace" => $metafield->getNamespace()
					))
				)
			);
		
		
		$message = "successfully processed the request";
		try{
			$metafield->setBlogArticleMetaField($_GET['blog_id'],$_GET['article_id'],$data);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in deleting Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );
    }
    
    /**
	 * Delete the blog article metafields
	 */
	public function getDeleteBlogArticleMetaField()
	{
		$metafield = new \erdiko\shopify\models\Metafield;
		$metaFieldID=$_GET['id'];
		$articleID = $_GET['article_id'];
		
		$message = "successfully processed the request";
		try{
			$metafield->deleteBlogArticleMetaField($articleID,$metaFieldID,array());
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in editing Blog Article Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
            $this->setContent( $this->getLayout('message', $message) );
	}

	/**
	 * Show the userform to edit the Blog Metafields
	 */
    public function getShowBlogArticleEdit()
    {
		$data=array(
			"article_id"=>$_GET['article_id'],
			"id"=>$_GET['id'],
			"key"=>$_GET['key'],
			"value"=>$_GET['value'],
			"value_type"=>$_GET['value_type']);
		$this->setTitle('Edit Meta Data Fields');
		$this->setContent( $this->getView('shopify/editBlogArticleMetaFieldForm',$data, dirname(__DIR__)) );
	}

	/**
	 * Show the userform to add Metafield of a blog article
	 */
    public function getShowBlogArticleMetaDataForm()
    {

		$data=array("article_id"=>$_GET['article_id'],
					"blog_id"=>$_GET['blog_id']);
		$this->setTitle('Create New Article Meta Field');
		$this->setContent($this->getView('shopify/addBlogArticleMetaDataForm',$data,dirname(__DIR__)));
	}

	/**
	 * Display article content
	 */
    public function getShowArticleContent()
    {
		$blog = new \erdiko\shopify\models\Blog;
		$blogID=$_GET['blog_id'];
		$articleID=$_GET['article_id'];
		$this->setTitle('Article Content');
		$data=$blog->getArticle($blogID,$articleID);
		$body=array('html'=>$data['body_html'],'title'=>$data['title']);
		$this->setContent($this->getView('shopify/grid/displayData',$body,dirname(__DIR__)));
    }
	
	/**
	 */
    public function getShowArticleInfo()
    {
		$metafield = new \erdiko\shopify\models\Metafield;
		$blogID=$_GET['blog_id'];
		$articleID=$_GET['article_id'];
		$data=$metafield->getArticleInfo($articleID,$blogID);
		$this->setContent($this->getView('shopify/grid/articleInfoView',$data,dirname(__DIR__)));
	}

	/**
     */
    public function getShowAddArticleInfo()
    {
    	$data=array("article_id"=>$_GET['article_id'],
					"blog_id"=>$_GET['blog_id']);
		$this->setTitle('Add Article Info');
		$this->setContent($this->getView('shopify/addArticleInfoForm',$data,dirname(__DIR__)));
    }

    /**
     */
    public function getDeleteArticleInfo()
    {
    	$metafield = new \erdiko\shopify\models\Metafield;
    	$srcID=$_GET['src_id'];
    	$urlID=$_GET['url_id'];
    	$titleID=$_GET['title_id'];
    	$articleID=$_GET['article_id'];

    	
        $message = "successfully processed the request";
		try{

			$metafield->deleteBlogArticleMetaField($articleID,$srcID,$args=array());
    		$metafield->deleteBlogArticleMetaField($articleID,$urlID,$args=array());
        	$metafield->deleteBlogArticleMetaField($articleID,$titleID,$args=array());

		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in editing Blog Article Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );

    }

    /**
     *
     */
    public function getShowEditArticleInfo()
    {
    	$data=array(
    		"src_id"=>$_GET['src_id'],
    		"url_id"=>$_GET['url_id'],
    		"title_id"=>$_GET['title_id'],
			"article_id" => $_GET['article_id'],
			"src"=>$_GET['src'],
			"url"=>$_GET['url'],
			"title"=>$_GET['title']
		);
		$this->setTitle('Edit Article Info');
		$this->setContent($this->getView('shopify/editArticleInfoForm',$data,dirname(__DIR__)));

    }

    /**
     */
    public function getEditArticleInfo()
    {
    	$metafield = new \erdiko\shopify\models\Metafield;
	

		$srcID=$_GET['src_id'];
    	$urlID=$_GET['url_id'];
    	$titleID=$_GET['title_id'];
		$articleID = $_GET['article_id'];
		

		$args_src=array(
			"metafield"=>array(
			"id" => $srcID,
    		"value"=> $_GET['src'],
    		"value_type"=>"string")
			);
		$args_url=array(
			"metafield"=>array(
			"id" => $urlID,
    		"value"=> $_GET['url'],
    		"value_type"=>"string")
			);
		$args_title=array(
			"metafield"=>array(
			"id" => $titleID,
    		"value"=> $_GET['title'],
    		"value_type"=>"string")
			);
		
		$message = "successfully processed the request";
		try{

			$metafield->updateBlogArticleMetaField($articleID,$srcID,$args_src);
			$metafield->updateBlogArticleMetaField($articleID,$urlID,$args_url);
			$metafield->updateBlogArticleMetaField($articleID,$titleID,$args_title);
		}
		catch(ShopifyApiException $e)
        {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in editing Blog Article Metafield :: ".$response_headers['http_status_code'].":".$response_headers['http_status_message'];          
            
        }
        catch(ShopifyCurlException $e)
        {
           $message="Error :: Shopify Curl Exception";
        }
        catch (Exception $e)
        {
           $message=$e->getMessage();
        }
        $this->setContent( $this->getLayout('message', $message) );
    }

    /**
     */
    public function getPages()
    {
		
		$page = new \erdiko\shopify\models\Page;
		
		$message = "";
		$isError = FALSE;

		try{
			$data = $page->getPages();
		} catch(ShopifyApiException $e) {
        	$response_headers=$e->getResponseHeaders();
            $message = "Error in adding Metafield :: "
                        . $response_headers['http_status_code'].":" 
                        . $response_headers['http_status_message'];                
        	$isError = TRUE;
        } catch(ShopifyCurlException $e) {
           $message = "Error :: Shopify Curl Exception";
           $isError = TRUE;
        } catch (Exception $e) {
           $message = $e->getMessage();
           $isError = TRUE;
        }
       
        if(!$isError){
        	$this->setTitle('Shopify Pages');
            $this->setContent( $this->getLayout('json', $data, dirname(__DIR__)) );
        } else{
        	$this->setContent( $this->getLayout('message', $message) );
        }

	}

}
