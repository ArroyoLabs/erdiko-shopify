<div>
<?php if(count($data)>1) {	?>	
	<h><b><u> Article Metafields </u></b></h>
	<table>
	<col width="130">
    <col width="130">
    
     

		<tr>
			<td>
				<p>

					News Source :

				</p>
			</td>

			<td>
				<p>

					<?php echo $data['src']['value']; ?>

				</p> 
			</td>
		</tr>
		<tr>
			<td>
				<p>

					Source URL :

				</p>
			</td>

			<td>
				<p>
					<?php echo $data['url']['value']; ?>
				</p> 
			</td>
		</tr>
		<tr>
			<td>
				<p>

					Title :
				</p>
			</td>

			<td>
				<p>
					<?php echo $data['title']['value']; ?>
				</p> 
			</td>
		</tr>
		<tr>
			<td>
				<p>
					<a href="<?php echo $data['edit_link']; ?>">EDIT</a>
				</p>
			</td>
			<td>
				<p>
					<a href="<?php echo $data['delete_link']; ?>">DELETE</a>
				</p>
			</td>
			
			
		</tr>
		
	</table>
	<?php } else{ ?>
				
		<p> Article Info is empty.Please click <a href="<?php echo $data['add_link']; ?>">here</a> to add info</p>
				
	<?php } ?>
</div>