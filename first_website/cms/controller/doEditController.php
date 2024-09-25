<?php
include 'controller_class.php';


class doEditController extends Controller{
	public function doYourWork($articleID,$model){
		if(isset($_POST['ArticleNameInput']) && isset($_POST['ArticleContentInput']) && isset($_POST['tagInput'])){
			$tagArray = $_POST['tagInput'];
			$tagArray = $this->validateTags($tagArray);
			if($tagArray === "bad input"){
				header('Location: https://webik.ms.mff.cuni.cz/~73984481/cms/invalidInput');
			}
			$newName = $_POST['ArticleNameInput'];
			$newContent = $_POST['ArticleContentInput'];
			if($this->validateName($newName) && $this->validateContent($newContent)){
				$model->editDBContents($articleID,$newName,$newContent);
				$model->editTagsDB($articleID,$tagArray);
				header('Location: https://webik.ms.mff.cuni.cz/~73984481/cms/articles');
			}
			else{
				header('Location: https://webik.ms.mff.cuni.cz/~73984481/cms/invalidInput');
			}
		}
		else{
			header('Location: https://webik.ms.mff.cuni.cz/~73984481/cms/invalidInput');
		}
		
	}
}


