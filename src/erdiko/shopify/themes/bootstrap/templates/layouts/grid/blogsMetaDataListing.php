<div class="container-fluid">
      <div class="row">
        <div role="main">
        <h><b><u>Blog Metafields:</u></b></h>
        	<?php
        		$data = $data->getData(); 
        		$blog_id=$_GET['blog_id'];
        		echo Erdiko::getView('shopify/grid/addNewBlogMetaField',$blog_id,$this->_viewRootFolder);
				echo "</br></br>";
				for($i=0; $i<count($data); $i++)
				{
					$item = array(
					'size' => count($data),
					'details' => array(
							'serial_num'=>$i+1,
							'key'=>$data[$i]['key'],
							'value' => $data[$i]['value'],
							'edit' => "/shop/showBlogEdit?blog_id=".$blog_id."&id=".$data[$i]['id']."&key=".$data[$i]['key']."&value=".$data[$i]['value']."&value_type=".$data[$i]['value_type'],
							'delete'=>"/shop/deleteBlogMetaData?blog_id=".$blog_id."&id=".$data[$i]['id']
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