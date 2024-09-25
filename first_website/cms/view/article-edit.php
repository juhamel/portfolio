<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Article Edit</title>
    <link rel="stylesheet" href="../view/css/article_edit_stylesheet.css">
</head>

<body>
	<h1> Article Edit </h1>
	<div id=contentBox>
		<div id = editBox>
			<?php echo '<form action="https://webik.ms.mff.cuni.cz/~73984481/cms/doArticleEdit/'.htmlspecialchars($currentArticle["id"],ENT_HTML5).'" id="editForm" onsubmit="return validateEdit('."ArticleNameInput".','."ArticleContentInput".')"  method="post">';?>
				<label for="ArticleNameInput">Name</label><br>
				<?php echo '<input type="text" name="ArticleNameInput" id="ArticleNameInput" value="'.$currentArticle["name"].'" maxlength="32">';?>
				<button id = "tagDialogButton" type="button">Edit Tags</button>
				<dialog id="editTagDialog" class="editTagDialog">
						<?php $index = 1;
						foreach($tagArray as $key => $value){
							$key = htmlspecialchars($key,ENT_HTML5);							 
							if(isset($value)) $value = htmlspecialchars($value,ENT_HTML5);
							echo '<label for="'.$key.'Input">Tag '.$index.'</label>';
							echo '<input type="text" name="tagInput['.$key.']" id="'.$key.'Input" value="'.$value.'" maxlength="32"><br>';
							$index+=1;
						}?>
						<button type="button" id="closeTagDialog">Close Dialog</button>
				</dialog>
				<label for="ArticleContentInput">Content</label>			
				<?php echo '<textarea name="ArticleContentInput" id="ArticleContentInput" maxlength="1024">'.$currentArticle["content"].'</textarea><br>';?>
				<div id="submitDiv">
				<button type="submit" id="submitEdit" name="submitEdit">Save</button>
				<a href='https://webik.ms.mff.cuni.cz/~73984481/cms/articles' id="backToArtButton">Back to Articles</a>
				</div>
			</form>
		</div>	
	</div>
	<script src="../view/js/validation.js"></script>
	<script src="../view/js/tagDialog.js"></script>
</body>
</html>
