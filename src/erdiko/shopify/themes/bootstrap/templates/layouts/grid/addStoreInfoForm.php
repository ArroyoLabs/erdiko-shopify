<div><h><b><u>Store Metafields:</u></b></h>
<p>Add the Store Metafields using the following form</p></div>
<div style="border: 2px solid; width: 550px; padding: 10px; margin-top: 29px; margin-left: 264px;">
	<form name = "editMetaDataForm" method ="get" action="/shop/setStoreMetafields">
		
		<table>
			
			<tr>
				<td>Meta Data Key : </td>
     			<td><input type = "text" name = "key" > </input></td>
			</tr>
			<tr>
				<td>Meta Data Value : </td>
     			<td><input type = "text" name ="value"> </input></td>
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
					<input type = "submit" value = "Save" style="width: 70px;"> 
					</input>
				</td>
			</tr>
		</table>
	</form>
</div>