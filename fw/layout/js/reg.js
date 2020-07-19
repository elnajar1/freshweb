$(function(){
    'use strict';
    //hide Placeholder On form focus
$('[placeholder]').focus(function(){
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder','');
        
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });
});


/*
var chat = getElementById('chat),
	 messeges = getElementById('messeges),
	 messegesButton = getElementById('messegesButton),
	 chatButton = getElementById('chatButton);
	 
chatButton.onclick(function{
	
})
*/