<div style="border: 2px solid; width: 550px; padding: 10px; margin-top: 29px; margin-left: 264px;">
     <form name = "editStoreInfoForm" method ="get" action="/shop/editStoreInfo">

        	<table>
        	<?php
        		$data = $data->getData(); 
        		$keys=$data['keys'];
        		$nonEmpty=count($keys);
        		
				for($i=0; $i<count($keys); $i++)
				{
					
					$item = array(
					'size' => count($data),
					'details' => array(
							'serial_num'=>$i+1,
							'key'=>$data['keys'][$i],
							'value' => $data['values'][$data['keys'][$i]],
							
							)
					);
				echo Erdiko::getView('shopify/grid/storeInfoFormInput', $item, $this->_viewRootFolder);	
				}
				
			?>
			<input type="hidden" name="num_val" value="<?php echo count($keys); ?>"/>
			<tr>
				<td></td>
				<td>
					<input type = "submit" value = "Edit" style="width: 70px;"> 
					</input>
				</td>
			</tr>
			</table>

		</form>	
</div>