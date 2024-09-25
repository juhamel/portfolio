<?php
include 'controller_class.php';

class uploadController extends Controller{
	public function doYourWork($null,$model){	
		if(isset($_POST['CreationArticleNameInput'])){
			$newArticleName = $_POST['CreationArticleNameInput'];
			if($this->validateName($newArticleName)){
				$model->postToDB($newArticleName," ");
				$newID = $this->getNewestID($model);
				$model->postTagsDB($newID);
				header('Location: https://webik.ms.mff.cuni.cz/~73984481/cms/article-edit/'.$newID);
			}
			else{
				header('Location: https://webik.ms.mff.cuni.cz/~73984481/cms/invalidInput');
			}
		}	
	}
}

