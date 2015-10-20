<div>
	<table>
	<col width="50">
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
					<?php echo $data['details']['key']; ?>
				</p> 
			</td>
		
			<td>
				<p>
					<?php echo $data['details']['value']; ?> 
				</p>
			</td>
			<td>
				<p>
					<a href="<?php echo $data['details']['delete']; ?>" > DELETE </a>
				</p>
			</td>
			<td>
				<p>
					<a href="<?php echo $data['details']['edit']; ?>" > EDIT </a>
				</p>
			</td>
			
		</tr>
	</table>
</div>