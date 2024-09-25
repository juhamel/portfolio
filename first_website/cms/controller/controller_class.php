<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Controller{
    protected function validateName($nameInput){
	    if(is_string($nameInput) && strlen($nameInput) <= 32 && $nameInput != ""){
		    return true;
	    }
	    else{
		    return false;
	    }
    }


    protected function validateContent($contentInput){
	    if(is_string($contentInput) && strlen($contentInput) <= 1024){
		    return true;
	    }
	    else{
	    	    return false;
	    }
    }


    protected function getTagList($articleDB,$model){
	    $tagList = array();
	    foreach($articleDB as $article){
		    $articleTags = $model->getRequestedTags($article["id"]);
			foreach($articleTags as $tag => $value){
				if($value != null && !in_array($value,$tagList)) array_push($tagList,[$value,$article['id']]);
			}
	    }
	    return $tagList;
     }


    protected function validateTags($tagArray){
	    foreach($tagArray as $key => $value){
		    if(is_string($value) && strlen($value) <= 32){
			    if(!preg_match('/^[a-zA-Z0-9]*$/', $value)) return "bad input";
		    }
		    else return "bad input";
	    }
	    return $tagArray;
    }
   protected function getRequestedArticle($id,$articleDB){
        foreach($articleDB as $article){
            if($article["id"] == $id){
                return $article;
            }
        }
        return "error";
    }
  protected function getNewestID($model){
        $updatedArticleDB = $model->loadArticlesFromDB();
        $lastArticle = end($updatedArticleDB);
        return $lastArticle['id'];
    }
}

