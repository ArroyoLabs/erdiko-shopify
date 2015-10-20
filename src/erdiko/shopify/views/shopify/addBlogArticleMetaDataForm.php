<div><h><b><u>Article Metafields:</u></b></h>
<p>Add the Article Metafields using the following form</p></div>
<div style="border: 2px solid; width: 550px; padding: 10px; margin-top: 29px; margin-left: 264px;">
	<form name = "addBlogArticleMetaDataForm" method ="get" action="/shop/addBlogArticleMetaField">
		<input type="hidden" name="blog_id" value="<?php echo $data['blog_id'] ?>" />
		<table>
			<tr>
				<td>Article ID : </td>
     			<td><input type="text" name="article_id" value="<?php echo $data['article_id'] ;?>"/></td> 
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