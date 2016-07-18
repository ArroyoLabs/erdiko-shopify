<div class="container-fluid">
      <div class="row">
        <div role="main">
        	<?php
        		$data = $data->getData(); 
        		//$blog_id=$_GET['blog_id'];
        		$blog_id=$data[count($data)-1];
        		array_pop($data);
        		//echo Erdiko::getView('shopify/grid/addNewBlogMetaField',$blog_id,$this->_viewRootFolder);
				for($i=0; $i<count($data); $i++)
				{
					$item = array(
					'size' => count($data),
					'details' => array(
							'serial_num'=>$i+1,
							'title'=>$data[$i]['title'],
							'id'=>$data[$i]['id'],
							'content' => 'showArticleContent?blog_id='.$blog_id."&article_id=".$data[$i]['id'],
							'metafields'=>'blogArticleMetafields?blog_id='.$blog_id."&article_id=".$data[$i]['id']
							)
					);
					if($i==0){
						echo Erdiko::getView('shopify/grid/blogTableHead', $item, $this->_viewRootFolder);
					}
					
					echo Erdiko::getView('shopify/grid/articleRow', $item, $this->_viewRootFolder);
				}
			?>
        </div>
  	</div>
</div>