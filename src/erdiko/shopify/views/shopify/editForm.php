<div style="border: 2px solid; width: 550px; padding: 10px; margin-top: 29px; margin-left: 264px;">
	<form name = "editMetaDataForm" method ="get" action="/shopify/editProductMetaField">
		<input type="hidden" name="product_id" value="<?php echo $data['product_id'] ?>" />
		<table>
			<tr>
				<td>Meta data ID :</td>
				<td><input type="text" name="id" value="<?php echo $data['id'] ;?>"/></td>
			</tr>
			<tr>
				<td>Meta Data Key : </td>
     			<td><input type = "text" name = "key" value="<?php echo $data['key'];?>"> </input></td>
			</tr>
			<tr>
				<td>Meta Data Value : </td>
     			<td><input type = "text" name = "value" value="<?php echo $data['value'];?>"> </input></td>
			</tr>
			<tr>	
				<td>Meta Data Value Type : </td>
				<td>
					<select name="value_type" size="1">
						<option selected value="<?php echo $data['value_type'];?>" ><?php echo $data['value_type'];?></option>
						<option value="string">string</option>
						<option value="integer">integer</option>
					</select>
				</td>
			</tr>
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