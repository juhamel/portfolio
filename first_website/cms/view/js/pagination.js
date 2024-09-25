console.log(jsArticleArray);
console.log(jsTagArray);
let currentPage = 1;
function paginize(articleData){
	const articlesPerPage = 10;
	const totalArticles = articleData.length;
	const totalPages = Math.ceil(totalArticles / articlesPerPage);

	function updateNavigationButtons(){
		const prevButton=document.getElementById("prevButton");
		const nextButton=document.getElementById("nextButton");
		if(currentPage == 1){prevButton.classList.add("hidden");}
		else{prevButton.classList.remove("hidden");}
		if(currentPage == totalPages){nextButton.classList.add("hidden");}
		else{nextButton.classList.remove("hidden");}
	}

	function showItems(page) {
    		const startIndex = (page - 1) * articlesPerPage;
    		const endIndex = startIndex + articlesPerPage;
    		const pageArticles = articleData.slice(startIndex, endIndex);

    		const itemsContainer = document.querySelector("#articlesList");
    		itemsContainer.innerHTML = "";

		if(pageArticles.length == 0){
			const li = document.createElement("li");
			li.innerText = "There is no article";
			itemsContainer.appendChild(li);
		}
		else{
			pageArticles.forEach((item) => {
				let itemID = item['id'];
        			const li = document.createElement("li");
        			li.innerText = item.name;
				li.id = 'article_'+itemID;
	
        			const deleteButton = document.createElement("a");
        			deleteButton.href = "";
        			deleteButton.classList.add("deleteButton");
        			deleteButton.innerText = "Delete";
				deleteButton.id = 'deleteButton_'+itemID;
        			li.appendChild(deleteButton);

        			const editButton = document.createElement("a");
        			editButton.href = 'https://webik.ms.mff.cuni.cz/~73984481/cms/article-edit/'+itemID;
        			editButton.classList.add("editButton");
        			editButton.innerText = "Edit";
        			li.appendChild(editButton);

				const showButton = document.createElement("a");
				showButton.href = 'https://webik.ms.mff.cuni.cz/~73984481/cms/article/'+itemID;
				showButton.classList.add("showButton");
        			showButton.innerText = "Show";
        			li.appendChild(showButton);

        			itemsContainer.appendChild(li);
    			});
		}

	}

	function setPaginationNavigation(){
    		const paginationContainer = document.querySelector("#navigation");
    		paginationContainer.innerHTML = "";
		
    		const prevButton = document.createElement("button");
		prevButton.id = "prevButton";
    		prevButton.innerText = "Previous";
    		prevButton.addEventListener("click", () => {
        		if (currentPage > 1) {
            			currentPage--;
            			showItems(currentPage);
				updateNavigationButtons();
        		}
    		});
		paginationContainer.appendChild(prevButton);

    		const nextButton = document.createElement("button");
		nextButton.id = "nextButton";
    		nextButton.innerText = "Next";
    		nextButton.addEventListener("click", () => {
        		if (currentPage < totalPages) {
            			currentPage++;
            			showItems(currentPage);
				updateNavigationButtons();
        		}
    		});
		paginationContainer.appendChild(nextButton);
		updateNavigationButtons();

    		const showTotalPages = document.createElement("p");
    		showTotalPages.innerText = "Total pages: "+totalPages;
		showTotalPages.id = "TotalPageCounter";
   	 	paginationContainer.appendChild(showTotalPages);

		//check if page will be empty after deletion
		if(totalArticles < (currentPage-1)*articlesPerPage){
			currentPage--;
		}
	}	

	showItems(currentPage);
	setPaginationNavigation();
}

//function fetchArticles(){
//	const modelURL = 'https://webik.https://webik.ms.mff.cuni.cz/~73984481/cms/model/articleDB.php';
//	try{
//		const result = await fetch(modelURL);
//		const data = result.json();
//		return data;
//	} catch(error){
//		console.log("Can't fetch data", error);
//	}
//}

//const articleData = fetchArticles();
paginize(jsArticleArray);


