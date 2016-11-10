<div class="container">
    <div class="row">
      <div class="col-xs-12">
        	<?php
        		$data = $this->getRegions();

				for($i=0; $i<count($data); $i++)
				{
					$item = array(
					'size' => count($data),
					'details' => array(
							'name' => $data[$i]->title,
							'image' => $data[$i]->image->src,
							'url' => "#"
							)
					);
					echo Erdiko::getView('shopify/grid/item', $item, $this->_viewRootFolder);
				}
			?>
      </div>
    </div>
</div>
