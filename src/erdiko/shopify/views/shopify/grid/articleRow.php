<div>
	<table>
	<col width="50">
    <col width="130">
    <col width="130">
     <col width="130">
     <col width="130">
		<tr>
			<td>
				<p>
					<?php echo $data['details']['serial_num']; ?>
				</p> 
			</td>
			<td>
				<p>
					<?php echo $data['details']['id']; ?>
				</p> 
			</td>
			<td>
				<p>
					<?php echo $data['details']['title']; ?>
				</p>
			</td>
			<td>
				<p>
					<a href="<?php echo $data['details']['content']; ?>">Show Content</a>
				</p>
			</td>
			<td>
				<p>
					<a href="<?php echo $data['details']['metafields']; ?>">Show Metafields</a>
				</p>
			</td>
			
		</tr>
	</table>
</div>