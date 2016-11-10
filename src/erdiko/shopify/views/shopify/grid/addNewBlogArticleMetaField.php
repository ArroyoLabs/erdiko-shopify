<div>
<h><b> To add a new Article Metafield , click the following button:</b></h>
	<form action="/shop/showBlogArticleMetaDataForm" method="get">
		<input type="hidden" name="article_id" value="<?php echo $data['article_id'] ?>" />
		<input type="hidden" name="blog_id" value="<?php echo $data['blog_id'] ?>" />
    	<button type="submit" value="Submit">Add Meta Field</button>
	</form>
</div>