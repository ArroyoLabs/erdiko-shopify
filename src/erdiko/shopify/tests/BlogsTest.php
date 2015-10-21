<?php

namespace erdiko\shopify\tests;


require_once 'ErdikoTestCase.php';


class BlogsTest extends ErdikoTestCase
{
	protected $blog=null;
	public function setUp(){
		$this->blog=new \erdiko\shopify\models\Blog;
	}

	public function testArticle(){
		$data=$this->blog->getBlogs();
		$this->assertTrue(count($data)>0,"There should be atleast one existing blog");
		$blogID = $data[0]['id'];
		
		$this->assertTrue(!empty($blogID),"Not a failure , stopping test due to no existing blogs");

		$articles = $this->blog->getBlogArticles($blogID);
		$articleID = $articles[0]['id'];
		$this->assertTrue(!empty($articleID),"Not a failure , stopping test due to no existing articles");
		$article = $this->blog->getArticle($blogID,$articleID);

		$this->assertTrue($article['id']==$articleID);

	}

	public function testGetBlog(){
		$data=$this->blog->getBlogs();
		$this->assertTrue(count($data)>0,"There should be atleast one existing blog");
		
		$title = $data[0]['title'];
		$this->assertTrue(!empty($title),"title of the blog is empty, so cant run the test");

		$blogID = $this->blog->getBlogIDByName($title);
		$this->assertTrue(!empty($blogID));

		$blogData = $this->blog->getBlog($blogID);
		$this->assertTrue(strcmp($blogData['title'],$title)==0,"titles should be the same");

	}
}