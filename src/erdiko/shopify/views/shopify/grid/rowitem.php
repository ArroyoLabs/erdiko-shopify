<div>
	<table>
	<col width="130">
    <col width="130">
    <col width="130">
     <col width="80">
		<tr>
			<td>
				<p>
					<?php echo $data['details']['serial_num'].'. '.$data['details']['key']; ?>
				</p> 
			</td>
			<td>
				<p>
					<?php echo $data['details']['value']; ?>
				</p> 
			</td>
			<td>
				<p>
					<a href="<?php echo $data['details']['edit']; ?>">EDIT</a>
				</p>
			</td>
			<td>
				<p>
					<a href="<?php echo $data['details']['delete']; ?>">DELETE</a>
				</p>
			</td>
		</tr>
	</table>
</div>