<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Router{
	private $routes=[];

    //adds a new page to the router
	public function addPage($url,$controller){
		$this->routes[$url] = $controller;
	}

    //routes the url to the correct controller
	public function route($url) {
            //loops through all the routes and checks if the url matches the pattern
        	foreach ($this->routes as $pattern => $controller) {
                    //if the pattern matches the url, return the controller and the articleID
            		if (preg_match($pattern, $url, $articleIDs)) {
                                //returns the controller and the articleID[1] if it exists
                      		//has to be articleIDs[1] since articleIDs[0] is e.g. "articles/10" and not only "10"
                		return [$controller, $articleIDs[1]??null];
            		}
        	}
        	return null;
    	}
}

//setup router and load urls for different controllers
//(\d+) => expects one or more digit in string
$router = new Router();
$router->addPage('#articles#','articlesController');
$router->addPage('#uploadArticle#','uploadController');
$router->addPage('#deleteArticle/(\d+)#','deleteController');
$router->addPage('#article/(\d+)#','articleController');
$router->addPage('#article-edit/(\d+)#','editController');
$router->addPage('#doArticleEdit/(\d+)#','doEditController');
$router->addPage('#invalidInput#','invalidInputController');

include 'model/model.php';
$model = new Model();

//get url
$url = $_GET['page'];

//route to the correct controller
$currentPage = $router->route($url);
if($currentPage){
	//gets routing data from $currentPages
	[$controllerName,$articleID]= $currentPage;
	include "controller/$controllerName.php";
	$controller = new $controllerName();
	$controller->doYourWork($articleID,$model);
}
else{
	echo 'This URL does not exist<br>';
    echo '<a href="https://webik.ms.mff.cuni.cz/~73984481/cms/articles">Go to article list</a>';
}


