<div><h><b><u>News Article Metafields:</u></b></h>
<p>Edit the News Article Metafields using the following form</p></div>
<div style="border: 2px solid; width: 550px; padding: 10px; margin-top: 29px; margin-left: 264px;">
	<form name = "editArticleInfo" method ="get" action="/shop/editArticleInfo?">
		<h2>Article Info</h2>
		
		<input type="hidden" name="article_id" value="<?php echo $data['article_id'] ;?>"/>

		<input type="hidden" name="src_id" value="<?php echo $data['src_id'] ;?>"/> 

		<input type="hidden" name="url_id" value="<?php echo $data['url_id'] ;?>"/>
		<input type="hidden" name="title_id" value="<?php echo $data['title_id'] ;?>"/>
		<table>
			<tr>

				<td>News Source : </td>
     			<td><input type="text" title="The source of the press mention" name="src" value="<?php echo $data['src'] ;?>"></input></td> 
			</tr>
			<tr>
				<td>Source URL : </td>
     			<td><input type = "text" title="Link to the article"  name = "url" value="<?php echo $data['url'] ;?>"> </input></td>
			</tr>
			<tr>
				<td>Title: </td>
     			<td><input type = "text" title="Title of the article" name = "title" value="<?php echo $data['title'] ;?>"> </input></td>

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