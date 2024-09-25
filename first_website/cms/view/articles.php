<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Article List</title>
    <link rel="stylesheet" href="view/css/articles_stylesheet.css">
</head>

<body>
<?php
	echo '<script>let jsArticleArray = ' . json_encode($articleDB) . ';</script>';
	echo '<script>let jsTagArray = '.json_encode($fullTagList).';</script>';
?>

    <h1>Article List</h1>

	<div id= "articlesBox">
		<ul id="articlesList"></ul>
		<div class="utility">
			<div id="navigation" class="pagination-container"></div>
			<!-- ArtList and Nav are getting filled in pagination.js -->
	
			<div id=createArticle>	
				<button id="createDialogButton">Create Article</button>
			</div>
			<div id=searchTags>
				<label for="TagSearchInput">Search Tags:</label>
				<input type="text" id="TagSearchInput" name="TagSearchInput">
				<div id="autocomplete">
					<div id="recommendations"></div>
					<button type="button" id="resetTagFilter">Reset Filters</button>
				</div>
							
			</div>

			<dialog class="createDialog" id="createDialog">
				<form name="createNewArticle" action="https://webik.ms.mff.cuni.cz/~73984481/cms/uploadArticle" onsubmit="return validateName('CreationArticleNameInput')" method="post">
					<label for="CreationArticleNameInput">Name:</label>
					<input type="text" name="CreationArticleNameInput" id="CreationArticleNameInput" maxlength="32" required><br>
					<input type="submit" value="Create" id="submitNewArticle" disabled>
				</form>
				<button id="closeDialogButton">Cancel</button>
			</dialog>
		</div>
	</div>
	<script src="view/js/deleteArticle.js"></script>
	<script src="view/js/articleDialog.js"></script>
	<script src="view/js/pagination.js"></script>
	<script src="view/js/validation.js"></script>
	<script src="view/js/searchtags.js"></script>
</body>
</html>

