document.getElementById("tagDialogButton").addEventListener("click",function(){
	console.log("button pressed");
	document.getElementById("editTagDialog").style.display ="block";
});
document.getElementById("closeTagDialog").addEventListener("click",function(){
	document.getElementById("editTagDialog").style.display = "none";
});
