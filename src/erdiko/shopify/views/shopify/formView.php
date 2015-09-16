<div style="border: 2px solid; width: 550px; padding: 10px; margin-top: 29px; margin-left: 264px;">
	<form name = "addMetaDataForm" method ="get" action="/shopify/createProductMetaField">
		<table>
			<tr>
				<td>Product ID : </td>
     			<td><input type="text" name="product_id" value="<?php echo $data ;?>"/></td> 
			</tr>
			<tr>
				<td>Meta Data Key : </td>
     			<td><input type = "text" name = "key"> </input></td>
			</tr>
			<tr>
				<td>Meta Data Value : </td>
     			<td><input type = "text" name = "value"> </input></td>
			</tr>
			<tr>	
				<td>Meta Data Value Type : </td>
				<td>
					<select name="value_type" size="1">
						<option value="string">string</option>
						<option value="integer">integer</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type = "submit" value = "Submit" style="width: 70px;"> 
					</input>
				</td>
			</tr>
		</table>
	</form>
</div>