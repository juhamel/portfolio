<?php
include 'controller_class.php';

class articleController extends Controller{
	public function doYourWork($articleID,$model){
		$articlesDB = $model->loadArticlesFromDB();
		$tagArray = $model->getRequestedTags($articleID);
		if($tagArray != null){
			$currentArticle = $this->getRequestedArticle($articleID,$articlesDB);
			if($currentArticle === "error") include 'view/404error.php';
			else include 'view/article.php';
		}
	}
}

