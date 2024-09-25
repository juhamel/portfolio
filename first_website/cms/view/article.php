<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Article Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../view/css/article_detail_stylesheet.css"> 
</head>

<body>
	<h1> Article Detail </h1>
	<div id=articleBox>
		<?php
		$title = htmlspecialchars($currentArticle['name'],ENT_HTML5);
		 echo "<h1>$title</h1>"; ?>	
		<div id=tagBox>
			<?php foreach($tagArray as $key => $value){
				echo '<span class="badge rounded-pill bg-success">'.$value,'</span>';
			}?>
		</div>
		<div id = contentBox>
			<?php 
				if(isset($currentArticle['content'])) $content = htmlspecialchars($currentArticle['content'],ENT_HTML5);
			 echo "<p>$content</p>"; ?>
		</div>
	</div>
	<div id=buttonBox>
		<a href='https://webik.ms.mff.cuni.cz/~73984481/cms/articles' id="backToArticles" class="button">Back to Articles</a>
		<?php
		$id = $currentArticle['id'];
		echo '<a href="https://webik.ms.mff.cuni.cz/~73984481/cms/article-edit/'.$id.'" id="editButton" class="button">Edit</a>';
		?>
	</div>
</body>
</html>
	
