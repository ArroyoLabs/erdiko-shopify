<div class="container-fluid">
      <div class="row">
        <div role="main">
        	<?php
        		$data = $data->getData(); // temporary hack

				for($i=0; $i<count($data); $i++)
				{
					$item = array(
					'size' => count($data),
					'details' => array(
							'name' => $data[$i]['title'],
							'image' => $data[$i]['image']['src'],
							'url' => "#",
							'product_id' => $data[$i]['id']
							)
					);
					//echo $this->_viewRootFolder;
					echo Erdiko::getView('shopify/grid/item', $item, $this->_viewRootFolder);
				}
			?>
        </div>
  	</div>
</div>

