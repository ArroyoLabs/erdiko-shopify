<div class="container-fluid">
      <div class="row">
        <div role="main">
        	
        	<?php
        	echo Erdiko::getView('shopify/grid/addNewKeyButton',null,$this->_viewRootFolder);
        		$data = $data->getData();
        		if(count($data)>0) {
        			$keys=$data['keys'];
        		
        		
					for($i=0; $i<count($keys); $i++)
					{
					
					$item = array(
					'size' => count($data),
					'details' => array(
							'serial_num'=>$i+1,
							'key'=>$data['keys'][$i],
							'value' => $data['values'][$data['keys'][$i]],
							'edit' =>"showEditStoreMetafields?id=".$data["id"][$data['keys'][$i].'_id']."&key=".$data['keys'][$i]."&value=".$data['values'][$data['keys'][$i]]."&value_type=".$data['value_type'][$data['keys'][$i]],
							'delete'=>"deleteStoreMetafields?id=".$data["id"][$data['keys'][$i].'_id'],
							)
					);
					
					if($i==0){
						echo Erdiko::getView('shopify/grid/tableHead', $item, $this->_viewRootFolder);
					}

					echo Erdiko::getView('shopify/grid/storeInfoRow', $item, $this->_viewRootFolder);
			
					
					}
				
					$newData['delete']=$data['delete_link'];
					$newData['edit']=$data['edit_link'];
					echo Erdiko::getView('shopify/grid/changeStoreInfo', $newData, $this->_viewRootFolder);

        		}
        		

			?>
			
        </div>
  	</div>
</div>