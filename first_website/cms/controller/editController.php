<?php
include 'controller_class.php';

class editController extends Controller{
	public function doYourWork($articleID,$model){
        $articlesDB = $model->loadArticlesFromDB();
		$currentArticle = $this->getRequestedArticle($articleID,$articlesDB);
		$tagArray = $model->getRequestedTags($articleID);
		if($tagArray!=null){
			if($currentArticle === "error") include 'view/404error.php';
			else include 'view/article-edit.php';
		}
	}
}


