<?php
include 'controller_class.php';

class invalidInputController{
	public function doYourWork($null,$model){
		echo 'Your input values were invalid. Please try again';
		echo '<a href="https://webik.ms.mff.cuni.cz/~73984481/cms/articles">Get back to the article list </a>';
	}
}

