async function deleteArticle(deleteID){
	try{
		let result = await fetch('https://webik.ms.mff.cuni.cz/~73984481/cms/deleteArticle/'+deleteID,{
			method: 'DELETE',
			headers: {'Content-Type':'application/json'}
    		});
		if(result.ok){
			let newArticleArray = [];
			for(let article of jsArticleArray){
				if(article.id !== deleteID){
				newArticleArray.push(article);
				}
			}
			paginize(newArticleArray);
			jsArticleArray= newArticleArray;
		}
		else{
			throw new Error("Error while fetching");
		}
	}catch(error){
		console.error("Cant fetch request", error.message)
	}
}
document.addEventListener("click",async function(event){
	if(event.target.classList.contains("deleteButton")){
		event.preventDefault();
		const deleteID = event.target.id.split('_')[1];
		await deleteArticle(deleteID);
	}
});
