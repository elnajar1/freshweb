$(document).ready(function(){
		
	
	//img error handling
	

	//loading
	$(".se-pre-con").fadeOut("slow");
	
	$('.show-sing-in-advise' ).click(function(){
		$('.sign-in-advise' ).css("background","black");
	});
	
	$('.close-sign-in-advise' ).click(function(){
		$('.sign-in-advise' ).hide();
	});
	
	//share and copy link
	function copyToClipboard(text) { 
		var textArea = document.createElement( "textarea" ); 
		textArea.value = text;
		 document.body.appendChild( textArea ); 
		 textArea.select(); 
		 try { var successful = document.execCommand( 'copy' ); var msg = successful ? 'successful' : 'unsuccessful'; 
		  } catch (err) { console.log('Oops, unable to copy'); } document.body.removeChild( textArea ); 
	}
	
	$('.share' ).click(function(){
		copyToClipboard(  this.id );
		prompt( "تم نسخ رابط المشاركة الي الحافظة", this.id);
	});
	
    //typing effect
    var typed2 = new Typed('#typed2', {
     strings: ['pdf <i class="fas fa-file-pdf"></i>' , 'Records <i class="far fa-play-circle"></i>' , 'documents <i class="far fa-file-alt"></i>' , ' all learning files <i class="fas fa-heart text-warning"></i> ' , 'videos <i class="fas fa-video"></i>'],
     typeSpeed: 100,
     backSpeed: 0,
     fadeOut: true,
        loop: true
    });
    
	/*
	if (Modernizr.mq('(min-width: 768px)')) {
		
		var c       = $('.add-side-bookmark').html();
		var pre   = '<div class = "container-fluid" ><div class = "row"> <div class = "col-4  pc-bookmarks-div"></div> <div class = "col-6">';
		var post = '</div></div></div>';
		$('.add-side-bookmark').html( pre + c + post);
		$(".pc-bookmarks-div").load("/fw/bookmarks.php #pc").hide().show('slow') ;
		
	}
	 */
});









    
