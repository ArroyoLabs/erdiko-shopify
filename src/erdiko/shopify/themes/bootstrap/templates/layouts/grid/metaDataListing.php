<div class="container-fluid">
      <div class="row">
        <div role="main">
        	<?php
        		$data = $data->getData(); // temporary hack
        		$product_id=$_GET['product_id'];
        		echo Erdiko::getView('shopify/grid/addNewMetaField',$product_id,$this->_viewRootFolder);
				for($i=0; $i<count($data); $i++)
				{
					$item = array(
					'size' => count($data),
					'details' => array(
							'serial_num'=>$i+1,
							'key'=>$data[$i]['key'],
							'value' => $data[$i]['value'],
							'edit' => "/shopify/showEdit?product_id=".$product_id."&id=".$data[$i]['id']."&key=".$data[$i]['key']."&value=".$data[$i]['value']."&value_type=".$data[$i]['value_type'],
							'delete'=>"/shopify/deleteProductMetaData?product_id=".$product_id."&id=".$data[$i]['id']
							)
					);
				
					echo Erdiko::getView('shopify/grid/rowitem', $item, $this->_viewRootFolder);
				}
			?>
        </div>
  	</div>
</div>