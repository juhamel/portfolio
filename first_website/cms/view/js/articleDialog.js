//createDialog listener
document.getElementById("createDialogButton").addEventListener('click',function(){
	document.getElementById("createDialog").style.display = "block";	
});

//closeDialog listener
document.getElementById("closeDialogButton").addEventListener('click',function(){
	document.getElementById("createDialog").style.display = "none";
});

//update sumbit button listener
let nameInputField = document.getElementById("CreationArticleNameInput");
nameInputField.addEventListener('input',function(){
    let textInput = nameInputField.value;
    let submitButton = document.getElementById("submitNewArticle");
    if (textInput.trim() !== "") submitButton.disabled = false;
    else submitButton.disabled = true;
});
