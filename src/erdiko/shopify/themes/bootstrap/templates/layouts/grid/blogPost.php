<div class="container-fluid">
      <div class="row">
        <div role="main">
        	<?php
        		$data = $data->getData(); // temporary hack
        		//$product_id=$_GET['product_id'];
        		//echo Erdiko::getView('shopify/grid/addNewMetaField',$product_id,$this->_viewRootFolder);
				for($i=0; $i<count($data); $i++)
				{
					$item = array(
					'size' => count($data),
					'details' => array(
							'serial_num'=>$i+1,
							'title'=>$data[$i]['title'],
							'metafields'=>'/shop/blogMetaFields?blog_id='.$data[$i]['id'],
							'articles'=>'/shop/blogArticles?blog_id='.$data[$i]['id']
							)
					);
					if($i==0){
						echo Erdiko::getView('shopify/grid/blogListHead', $item, $this->_viewRootFolder);
					}
				
					echo Erdiko::getView('shopify/grid/blogRow', $item, $this->_viewRootFolder);
				}
			?>
        </div>
  	</div>
</div>