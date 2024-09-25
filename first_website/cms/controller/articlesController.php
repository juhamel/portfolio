<?php

include 'controller_class.php';

class articlesController extends Controller{
	public function doYourWork($null,$model){
		$articleDB = $model->loadArticlesFromDB();
		foreach($articleDB as $article){
			$article["name"] =  htmlspecialchars($article["name"],ENT_HTML5);
			$article["content"] = htmlspecialchars($article["content"],ENT_HTML5);
		}
		$fullTagList = $this->getTagList($articleDB,$model);
		include 'view/articles.php';
	}
}

