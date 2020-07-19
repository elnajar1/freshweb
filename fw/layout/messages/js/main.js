$(document).ready(function(){
	
	$("#send-message").submit(function(){
		$.post("postMessages.php", $("#send-message").serialize(), function(data){
			//$("#messages").append(data);
			$("#chat-textarea").val("");
			
		});
		return false;
	});
	
	function getMessages(){

		var cId = $("#c_id").val();
		var groupId = $("#group_id").val();
		
		$.post("getMessages.php",  {
			
			'c_id' : cId, 
			'group_id' : groupId
			
			}, function(data){
			$("#messages").html(data);
		});
		
		$("#messages").animate(
		{ 
			scrollTop: 2000
			
		}, 2000);
	}
	
getMessages();
	
	if (top.location.pathname === '/fw/messages/chat.php' ||  top.location.pathname === '/fw/messages/chatroom.php' )
{

setInterval(getMessages , 1000 );

}	 

	
	function urlify(text) {
	    var urlRegex = /(https?:\/\/[^\s]+)/g;
    	return text.replace(urlRegex, function(url) {
      	  return '<a href="' + url + '">' + url + '</a>';
   	 })
 	   // or alternatively
    	// return text.replace(urlRegex, '<a href="$1">$1</a>')
	}
	
	var text =  $('.msg').html();
	$('.msg' ).html( urlify(text)  );
		
		
});

    
