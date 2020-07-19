$(document).ready(function(){

	//SEARCH SUGGEST
	$(".search-input").keyup(function(e){
		e.preventDefault();
    	e.stopImmediatePropagation();

		var sectionVal = $(this).val();

		$("#search-suggestion-container").show();
		$.ajax({
			url : "/fw/search/getSearchSuggestion.php" , 
			type : "POST", 
			data : {
				"search" : sectionVal
			}, 
			beforeSend : function(){
				//$("#search-suggestion-container").html('searching... ');
			}, 
			success:  function(data){
				$(".search-suggestion-container").html( data);
			}
		});

	});
	
	//search 
	$('.search-icon').click(function(e){
		e.preventDefault();
	    e.stopImmediatePropagation();
		$('.search-container').load('/fw/search/searchBox.php  #search-box');
		
	});



});



















    
