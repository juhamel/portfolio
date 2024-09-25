<?php
include 'controller_class.php';

class deleteController extends Controller{
	public function doYourWork($deleteID,$model){
		if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
			$deleteResult = $model->deleteArticleFromDB($deleteID);
			if(!$deleteResult==null){
          			echo json_encode(['success'=> true]);
			}
        	} else {
			echo json_encode(['error' => 'Invalid request']);
		}
	}

}

