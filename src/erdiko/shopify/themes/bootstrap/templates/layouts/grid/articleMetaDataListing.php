<div class="container-fluid">
      <div class="row">
        <div role="main">
        	<?php
        		$data = $data->getData(); 
        		$articleID=$_GET['article_id'];
        		$blogID=$_GET['blog_id'];
        		$tempData=array("article_id"=>$articleID,"blog_id"=>$blogID);
        		echo Erdiko::getView('shopify/grid/addNewBlogArticleMetaField',$tempData,$this->_viewRootFolder);
				echo "</br></br>";
				for($i=0; $i<count($data); $i++)
				{
					$item = array(
					'size' => count($data),
					'details' => array(
							'serial_num'=>$i+1,
							'key'=>$data[$i]['key'],
							'value' => $data[$i]['value'],
							'edit' => "/shop/showBlogArticleEdit?article_id=".$articleID."&id=".$data[$i]['id']."&key=".$data[$i]['key']."&value=".$data[$i]['value']."&value_type=".$data[$i]['value_type'],
							'delete'=>"/shop/deleteBlogArticleMetaField?article_id=".$articleID."&id=".$data[$i]['id']
							)
					);
					if($i==0){
						echo Erdiko::getView('shopify/grid/tableHead', $item, $this->_viewRootFolder);
					}
					echo Erdiko::getView('shopify/grid/rowitem', $item, $this->_viewRootFolder);
				}
			?>
        </div>
  	</div>
</div>