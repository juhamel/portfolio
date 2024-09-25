<?php

class Model{
	private $mysqli;
	public function __construct(){
	  	 $db_config = include 'util/db_config.php';
		 $this->mysqli = new mysqli($db_config['server'],$db_config['login'],$db_config['password'],$db_config['database']);
		 if($this->mysqli->connect_error){
			throw new Exception("Connection failed: ".$mysqli->connect_error);
		 }
	}


	public function postTagsDB($newID){
    	try{
		$query = "INSERT INTO article_tags (id) VALUES ($newID)";
		if($this->mysqli->query($query) === TRUE){
			echo "insert succesfull";
		}else{
			throw new Exception("Insert failed ". $query . "<br>".$mysqli->error);
		}
	}catch(Exception $e){
		echo "Error: ". $e->getMessage();
	}
    }

    public function editTagsDB($id, $tags_array){
	try{

		$query = "UPDATE article_tags SET tag_0=?,tag_1=?,tag_2=?,tag_3=?,tag_4=? WHERE id=?";
		$prepQuery = $this->mysqli->prepare($query);
		$prepQuery->bind_param("sssssi",$tags_array['tag_0'],$tags_array['tag_1'],$tags_array['tag_2'],$tags_array['tag_3'],$tags_array['tag_4'],$id);


            	if($prepQuery->execute()){
                	echo "succesfully edited";
            	}
            	else{
                	throw new Exception("Error: ".$query."<br>".$prepQuery->error);
            	}
            	$prepQuery->close();
        }catch (Exception $e){
           	echo "Error: ".$e->getMessage();
        }
    }

    public function getRequestedTags($tagID){
	    try{
		$query = "SELECT tag_0,tag_1,tag_2,tag_3,tag_4 FROM article_tags WHERE id=$tagID";

		$result = $this->mysqli->query($query);
		if($result){
			$data = $result->fetch_assoc();
			$result->free();
			return $data;
		}
		else{
			throw new Exception("Fetching Data failed: ".$this->mysqli->error);
			return null;
		}
	}catch(Exception $e){
		echo "Error: ".$e->getMessage();
	}
}




    public function loadArticlesFromDB(){
        try {

                $query = "SELECT * FROM articles";

                $result = $this->mysqli->query($query);

                if ($result) {
                    $data = array();
                    while ($row = $result->fetch_assoc()) {
                            $data[] = $row;
                    }

                    $result->free();
                }
                else{
                    throw new Exception("Error: " . $query . "<br>" . $this->mysqli->error);
                }
                return $data;
        }catch (Exception $e) {
                echo "Error: " . $e->getMessage();
        }
    }

    public function postToDB($name,$content){
        try{

            $name = $this->mysqli->real_escape_string($name);
            $content = $this->mysqli->real_escape_string($content);

            $query = "INSERT INTO articles (name,content) VALUES (?,?)";
            $prepQuery = $this->mysqli->prepare($query);
            $prepQuery->bind_param("ss",$name,$content);


            if($prepQuery->execute()){
                echo "new article created";
            }
            else{
                throw new Exception("Error :".$query."<br>". $prepQuery->error);
            }
            $prepQuery->close();
        }catch (Exception $e) {
            echo "Error: ". $e->getMessage();
            return null;
        }
    }

    public function deleteArticleFromDB($id){
        try{

            $query = "DELETE FROM articles WHERE id=?";
            $prepQuery = $this->mysqli->prepare($query);
            $prepQuery->bind_param("i",$id);

            if($prepQuery->execute()){
                echo "article deleted";
            }
            else{
                throw new Exception("Error: ".$query."<br>".$prepQuery->error);
            }
            $prepQuery->close();
        }catch (Exception $e){
            echo "Error: ".$e->getMessage();
            return null;
        }
    }

    public function editDBContents($id, $newName, $newContent){
        try{


            $newName = $this->mysqli->real_escape_string($newName);
            $newContent = $this->mysqli->real_escape_string($newContent);

            $query = "UPDATE articles SET name=?, content=? WHERE id=?";
            $prepQuery = $this->mysqli->prepare($query);
            $prepQuery->bind_param("ssi",$newName,$newContent,$id);

            if($prepQuery->execute()){
                echo "article updated";
            }
            else{
                throw new Exception("Error: ".$query."<br>". $prepQuery->error);
            }
            $prepQuery->close();
       
        }catch (Exception $e) {
            echo "Error: ". $e->getMessage();
            return null;
        }
    }
}

