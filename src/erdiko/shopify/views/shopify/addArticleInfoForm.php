<div><h><b><u>News Artcle Metafields:</u></b></h>
<p>Add the News Article Metafields using the following form</p></div>
<div style="border: 2px solid; width: 550px; padding: 10px; margin-top: 29px; margin-left: 264px;">
	<form name = "addArticleInfo" method ="get" action="/shop/addArticleInfo">
		<h2>Article Info</h2>
		<input type="hidden" name="blog_id" value="<?php echo $data['blog_id'] ;?>"/> 
		<input type="hidden" name="article_id" value="<?php echo $data['article_id'] ;?>"/>
		<table>
			<tr>

				<td>News Source : </td>
     			<td><input title="The source of the press mention" type="text" name="src"/></td> 
			</tr>
			<tr>
				<td>Source URL : </td>
     			<td><input title="Link to the article" type = "text" name = "url"> </input></td>
			</tr>
			<tr>
				<td>Article Title : </td>
     			<td><input title="Title of the article" type = "text" name = "title"> </input></td>

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