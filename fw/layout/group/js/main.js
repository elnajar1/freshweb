$(document).ready(function(){
	
	//member to admin 
	$(".member-to-admin").click(function(e){
		var memberId = this.id;
		var groupId = $(this).val();
		
		$.ajax({
			url : "memberToAdmin.php", 
			type : "POST", 
			data : {
				"member_id": memberId , 
				"group_id" : groupId
				
			}, 
			beforeSend : function(){
				$( "#"  + memberId ).html(".....").attr("disabled", "disabled");
			}, 
			success:  function(data){
				
				$("#"  + memberId).html( data )
				.addClass("text-dark")
				.attr("disabled", "disabled")
				.removeClass("btn-primary");
				
			}
		});
		
		e.preventDefault();
	       e.stopImmediatePropagation();
	});
	
	//accept-join
	$(".accept-join").click(function(e){
		var memberId = this.id;
		var groupId = $(this).val();
		$.ajax({
			url : "acceptJoin.php", 
			type : "POST", 
			data : {
				"member_id" : memberId , 
				"group_id" : groupId
				
			}, 
			beforeSend : function(){
				$("#"  + memberId).html(".....").attr("disabled", "disabled");
			}, 
			success:  function(data){
				
				$("#"  + memberId).html( data )
				.addClass("text-dark")
				.attr("disabled", "disabled")
				.removeClass("btn-primary");
				
			}
		});
		
		e.preventDefault();
	       e.stopImmediatePropagation();
	});
	
	//group join
	$(".group-join").click(function(){
		var groupId = this.id;
		
		$.ajax({
			url : "groupJoin.php", 
			type : "POST", 
			data : {
				"group_id" : groupId,
			}, 
			beforeSend : function(){
				$(".group-join").html(".....").attr("disabled", "disabled");;
			}, 
			success:  function(data){
				$(".group-join").html("Request sended");
				$(".group-join").addClass("text-dark");
				$(".group-join").attr("disabled", "disabled");
				$(".group-join").removeClass("btn-primary");
			}
		});
		
	});
		
	addSuggetions( "getUniversitySuggestion.php" , "university-name" , "university-id" , "university-suggestion-container" , "add-university-suggestion" );
	
	addSuggetions( "getScienceFieldSuggestion.php" , "science-field-name" ,  "science-field-id" , "science-field-suggestion-container" , "add-science-field-suggestion" );

	//belong to library (add bookc science input)
	addSuggetions( "getScienceSuggestion.php" , "science-name" ,  "science-id" , "science-suggestion-container" , "add-science-suggestion" );
	//get sugestions for inputs valus
	function addSuggetions( url , inputName,  inputId , suggetionsContainer , suggetionDiv ){

		$("#" + inputName).keyup(function(e){
			e.preventDefault();
	    	e.stopImmediatePropagation();
			var sectionVal = $(this).val();
			$("#" + suggetionsContainer).show();
			$.ajax({
				url : url , 
				type : "POST", 
				data : {
					"search" : sectionVal
				}, 
				beforeSend : function(){
					$("#" + suggetionsContainer).html('searching... ');
				}, 
				success:  function(data){
					$("#" + suggetionsContainer ).html( data);
				}
			});
			
			$("#" + inputName).css( "background", "#F1F1F1");
			$("#" + inputId ).val( '');
		});
		
		
		
		$("." + suggetionDiv ).click(function(){

			$("#" + inputName).val( $(this).html() );
			$("#" + inputId ).val( this.id );
			$("#" + inputName).css( "background", "yellow");
			$("#" + suggetionsContainer).hide();
			
		});

	}
	
		
});



















    
