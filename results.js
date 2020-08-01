
$(document).on('click', '.delete-link', function(){
    $date = $(this).next().text();
	delete_record($date);
});

$("#high").click(function(){
	sort("high");
})

$("#level").click(function(){
	sort("level");
})

$("#recent").click(function(){
	sort("recent");
})

function ajaxGet(endpointUrl, returnFunction){
		var xhr = new XMLHttpRequest();
		xhr.open('GET', endpointUrl, true);
		xhr.onreadystatechange = function(){
			if (xhr.readyState == XMLHttpRequest.DONE) {
				if (xhr.status == 200) {
					// When ajax call is complete, call this function, pass a string with the response
					returnFunction( xhr.responseText );
				} else {
					console.log(xhr.status);
				}
			}
		}
		xhr.send();
};

function delete_record(dateInput){
	$.ajax({
      url: 'delete.php',
      type: 'POST',
      data: { date : dateInput },
      success: function(output){   
       	// console.log(output);
       	sort("recent");
      }
    });
}

function sort(searchTerm){

ajaxGet("sort.php?term=" + searchTerm, function(results) {

		// console.log(results);
		results = JSON.parse(results);
		// console.log(results);

		// This code will run when we get a succesful response back from backend.php
		if (jQuery.isEmptyObject(results)){

			let resultsList = document.querySelector(".result-gallery");
			resultsList.innerHTML = "";

			var empty = document.createElement("div"); 
			empty.innerHTML = "<p>No results yet! Play now!</p>";

			resultsList.appendChild(empty);

		}else{

			// Convert JSON string to JS objects

		// Grab the list element
		let resultsList = document.querySelector(".result-gallery");

		//clar
		resultsList.innerHTML = "";

		for(let i = 0; i < results.length; i++) {
			var galleryDiv = document.createElement("div"); 
			galleryDiv.classList.add("gallery");

			var flipInner = document.createElement("div"); 
			flipInner.classList.add("flip-card-inner");

			var flipFront = document.createElement("div"); 
			flipFront.classList.add("flip-card-front");
			flipFront.classList.add(results[i].level);

			var scoreDiv = document.createElement("div"); 
			scoreDiv.classList.add("score");
			scoreDiv.innerHTML = results[i].score;

			var levelDiv = document.createElement("div"); 
			levelDiv.classList.add("level");
			levelDiv.innerHTML = results[i].level;

			var dateDiv = document.createElement("div"); 
			dateDiv.classList.add("date");
			dateDiv.innerHTML = results[i].date.substr(6, 10);

			var flipBack = document.createElement("div"); 
			flipBack.classList.add("flip-card-back");

			var flipBackInner = document.createElement("div"); 
			flipBackInner.classList.add("back-inner");

			var deleteLink = document.createElement("a"); 
			deleteLink.href = "#";
			deleteLink.classList.add("delete-link");

			var icon = document.createElement("i");
			icon.classList.add("far", "fa-trash-alt", "fa-2x");

			var hidden = document.createElement("p");
			hidden.classList.add("hidden");
			hidden.innerHTML = results[i].date;
			// console.log("Date: " + results[i].date);

			deleteLink.appendChild(icon);

			flipBackInner.appendChild(deleteLink);
			flipBackInner.appendChild(hidden);
			flipBack.appendChild(flipBackInner);

			flipFront.appendChild(scoreDiv);  
			flipFront.appendChild(levelDiv);  
			flipFront.appendChild(dateDiv); 

			flipInner.appendChild(flipFront);
			flipInner.appendChild(flipBack);

			galleryDiv.appendChild(flipInner);

			resultsList.appendChild(galleryDiv);
		}	

		}
	})
};