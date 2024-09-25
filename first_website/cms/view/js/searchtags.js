let tagSearchInput = document.getElementById("TagSearchInput");
tagSearchInput.addEventListener("input", function(){
	let searchString = tagSearchInput.value;
	console.log(tagSearchInput.value);
	let autocompleteDiv = document.getElementById("recommendations");
	autocompleteDiv.style.display = 'block';

	while (autocompleteDiv.firstChild) {
        	autocompleteDiv.removeChild(autocompleteDiv.firstChild);
    	}

	const filteredTags = jsTagArray.filter(item => item[0].toLowerCase().includes(searchString.toLowerCase()));
	console.log(filteredTags);
	filteredTags.forEach(item=> {	
		const autoRecommendation = document.createElement('div');
		autoRecommendation.id = item[0];
		autoRecommendation.textContent = item[0];
		autoRecommendation.addEventListener('click', function(){
			tagSearchInput.value = item[0];
			autocompleteDiv.style.display = 'none';

			const input_event = new Event('input');
			tagSearchInput.dispatchEvent(input_event);
		});
		if(!document.getElementById(item)) autocompleteDiv.appendChild(autoRecommendation);
	});
	

	let filteredTagIds = [];
	for(let filteredItem of filteredTags){
		if(!filteredTagIds.includes(filteredItem[1])){
			filteredTagIds.push(filteredItem[1]);
		}
	}	
	console.log(filteredTagIds);
	let filteredArticleList = jsArticleArray.filter(item => filteredTagIds.includes(item['id']));
		
	paginize(filteredArticleList);
});


document.getElementById("resetTagFilter").addEventListener("click",function(){
	paginize(jsArticleArray);
	tagSearchInput.value = null;
	let autocompleteDiv = document.getElementById("recommendations");
    	while(autocompleteDiv.firstChild){
		autocompleteDiv.removeChild(autocompleteDiv.firstChild);
	}
});
