function validateName(DOMelementID){
	console.log("we got here");
	const inputName = document.getElementById(DOMelementID).value;
	if(typeof inputName === "string"){
		if(inputName.trim()===""){
			alert("Article Name cannot be empty");
			return false;
		}
		else if(inputName.length > 32){
			alert("Name length must be between 1 and 32 characters");
			return false;
		}
		else{
			return true;
		}
	}
	else{
		alert("Input type must be string!");
		return false;
	}
}

function validateContent(DOMelementID){
	const inputContent = document.getElementById(DOMelementID).value;
	if(typeof inputContent === "string"){
		if(inputContent.length > 1024){
			alert("Content maximum length is 1024 characters");		
			return false;
		}
		else{
			return true;
		}
	}
	else{
		alert("Input type must be string!");
		return false;
	}	
}

function validateEdit(nameID,contentID){
	console.log(nameID, contentID)
	let resultName = validateName(nameID.id);
	let resultContent = validateContent(contentID.id);

	return resultName && resultContent;
}

