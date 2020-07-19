$(document).ready(function(){
	
	//info
	var bookId = $('.book-id').html(); 
	var role = $('.role').html(); 
	
	//file love
	$('.file-love' ).click(function(e){
		e.preventDefault();
	    e.stopImmediatePropagation();
	    
	    var fileId = this.id;
		
		$.ajax({
			url : "/fw/library/fileLove.php", 
			type : "POST", 
			data : {
				 "file_id" : fileId
			},  
			beforeSend : function(){
				$(".file-love-"  +  fileId ).html('<i class ="fas  fa-heart animated heartBeat text-danger"></i>');
				$(".file-love-count-"  +  fileId ).text( " " );
			}, 
			success:  function(data){
				//$(".online" ).html(data);
			}
		});
		
	});
	
	
	//online
	/*
	function isOnline() {
		
    	$.ajax({
    		url: '/fw/library/fileUpload.php',
   		 timeout: 10000,
    		error: function(jqXHR) { 
    			
       		 if(jqXHR.status==0) {
       			$(".online").html("<span class =' alert alert-warning w-100 p-0 '> waiting for network...  </span>");
       		 }
    		},
    		beforeSend : function(){
    			//$(".online").html("<span style style ='color:yellow'> ¦ </span>");
    
    		}, 
 		   success: function() {
 		   	
       		 $(".online").html("<span style ='color:green'> <i class =' fa fa-signal'></i></span>");
       		 
   		 }
		});
	} 
	setInterval( isOnline , 2000 ) ;
	*/
		
	//move  file  form
	var sectionIdAddSection;
	$(".move-file").click(function(e){
		e.preventDefault();
    	   e.stopImmediatePropagation();
		$(".add-section-form-container").show();
		
		$.ajax({
			url : "fileMoveForm.php", 
			type : "POST", 
			data : {
			 "file_id" :  this.id, 
			 "book_id" : bookId
			}, 
			beforeSend : function(){
				$(".add-section-form-container " ).html('loading #!!!!! ');
			}, 
			success:  function(data){
				$(".add-section-form-container" ).html(data);
			}
		});
		
	});
	
	
	//move file
	$("#move-file-form").submit(function(e){
		e.preventDefault();
    	   e.stopImmediatePropagation();
		$.ajax({
			url : "fileMove.php", 
			type : "POST", 
			data : $("#move-file-form").serialize() ,
			beforeSend:function(){
				$(".add-section-form-container " ).append("loading #!!!!!!!");
				$("#move-submit-button").attr("disabled", "disabled");
				
			} ,
			success:  function(data){
				$(".add-section-form-container " ).append(data);
				$(".add-section-form-container " ).hide();
				
			}
		});
		return false ;
	});
	
	//Rename section 
	$('.rename-section' ).click(function(e){
		e.preventDefault();
	    e.stopImmediatePropagation();
	    
	    var sectionId = this.id;
		var  sectionName = prompt( "ادخل اسم الفولدر الجديد", $(this).val() );
		
		$.ajax({
			url : "sectionRename.php", 
			type : "POST", 
			data : {
				 "section_id" : sectionId, 
				 "section_name" : sectionName
			},  
			beforeSend : function(){
				//$(".footer" ).html('loading #!!!!! ');
			}, 
			success:  function(data){
				
				 if ( sectionName.trim() !== ""){
					$("#"  +  sectionId ).html(sectionName);
				}
			
				
			}
		});
		
	});
	
	//Rename author
	$('.rename-file-author' ).click(function(e){
		e.preventDefault();
	        e.stopImmediatePropagation();
	        
	        var fileId = this.id;
		var  authorName = prompt( "ادخل اسم مؤلف الملف");
		
		$.ajax({
			url : "fileAuthorRename.php", 
			type : "POST", 
			data : {
				 "file_id" : fileId, 
				 "author_name" : authorName
			}, 
			beforeSend : function(){
				//$(".footer" ).html('loading #!!!!! ');
			}, 
			success:  function(data){
				
				 if ( authorName.trim() !== ""){
					$("#author-name-"  +  fileId ).html(authorName);
				}
			
				
			}
		});
		
	});
	
	//Rename 
	$('.rename-file' ).click(function(e){
		e.preventDefault();
	        e.stopImmediatePropagation();
	        
	        var fileId = this.id;
		var  newCustomName = prompt( "ادخل اسم الملف الجديد");
		
		$.ajax({
			url : "fileRename.php", 
			type : "POST", 
			data : {
				 "file_id" : fileId, 
				 "new_custom_name" : newCustomName
			}, 
			beforeSend : function(){
				//$(".footer" ).html('loading #!!!!! ');
			}, 
			success:  function(data){
				
				 if ( newCustomName.trim() !== ""){
					$("#name-"  +  fileId ).html(newCustomName);
				}
			
				
			}
		});
		
	});
	
	//Delete 
	$('.delete-file' ).click(function(e){
		e.preventDefault();
	        e.stopImmediatePropagation();
	        
	        var fileId = this.id;
	        var bookId = $(this).val();
		 var  fileName = this.name;
		 var r = confirm("هل انت متأكد انك تريد حذف هذا الملف؟ ");
		
		if (r == true) {
		  
			$.ajax({
			url : "fileDelete.php", 
			type : "POST", 
			data : {
				
				"file_name" : fileName, 
				 "book_id" : bookId
				
			}, 
			beforeSend : function(data){
				
			}, 
			success:  function(data){
				
				$("#name-"  +  fileId ).html('<span class ="px-2  text-danger  font-weight-bold " >  Deleted !<span>' );
				 $("#name-"  +  fileId ).parent().parent().parent().hide("slow");
			}
			
			});
		}
		
	});
	
	$('.show-sing-in-advise' ).click(function(){
		$('.sign-in-advise' ).css("display","block");
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
	
	$('.share' ).click(function(e){
		e.preventDefault();
	        e.stopImmediatePropagation();
		copyToClipboard(  this.id );
		prompt( "تم نسخ رابط المشاركة الي الحافظة", this.id);
	});
	
     //file (lecture) upload
     var sectionId;
    $(".btn-upload" ).click(function(e) {
    	sectionId = this.id;
	    $(".file-upload-" + sectionId ).click();
	    e.preventDefault();
	    e.stopImmediatePropagation();

	});


	$('.file-upload' ).change(function (e) {
	   
	    $(".file-upload-form-"  + sectionId ).submit();
	    e.preventDefault();
	    e.stopImmediatePropagation();

	});

	$(".file-upload-form").submit(function(e) {

	    var formData = new FormData(this);
	    formData.append('file', $( '.file-upload-' + sectionId )[0].files[0]); 

	    $.ajax({
	        type:'POST',
	        url: 'fileUpload.php',
	        data:formData,
	        xhr: function() {
	                var myXhr = $.ajaxSettings.xhr();
	                if(myXhr.upload){
	                    myXhr.upload.addEventListener('progress',progress, false);
	                }
	                return myXhr;
	        },
	        cache:false,
	        contentType: false,
	        processData: false,
		
		beforeSend : function(data){
			$(".online").html('<span class = " text-center text-light w-100 p-0" >  من فضلك لا تغلق المتصفح اثناء رفع الملف  <i class ="fas  fa-info animated fadeIn text-info"></i>  </span>' );
		}, 
	        success:function(data){
	           $('#data-' + sectionId ).html(data);
	           $(".online").html(' ');
	         // alert(data);
	        },

	        error: function (request, status, error) { 
			
			console.log("Sorry, An error occured & respons status  : " +  request.status  + " & readyState " + request.readyState  + ": & Respons text : "  + request.responseText  +  " & status : "  +  status  + " & error : "  + error) ;
			
			if ( request.readyState == 0 ){
				
				$(".progress-bar-" + sectionId ).text( " retrying... ");
				//try again
              		$.ajax(this);
             		 return;
             	 
			} else {
				alert("Sorry, An error occured & respons status  : " +  request.status  + " & readyState " + request.readyState  + ": & Respons text : "  + request.responseText  +  " & status : "  +  status  + " & error : "  + error) ;
				$(".progress-bar-" + sectionId ).text( " error ! ");
			}
			
		 }
	    });

	    e.preventDefault();
	    e.stopImmediatePropagation();
	});


	function progress(e){

	    if(e.lengthComputable){
	        var max = e.total;
	        var current = e.loaded;

	        var Percentage = Math.round((current * 100)/max);
	            
	         $(".progress-bar-div-" + sectionId).css("display","block");
	        
	        $(".progress-bar-" + sectionId ).css("width", Percentage + "%")
	        .attr("aria-valuenow", Percentage)
	        .text( Percentage + "%");
		
		
	        if(Percentage >= 100)
	        {
	        	/*
	        	//setTimeout(function(){
	        		Percentage = 0;
	        		$('.my-progress').css("display","none");

	        		 $(".progress-bar-" + sectionId ).css("width", Percentage + "%")
	     	 	  .attr("aria-valuenow", Percentage)
	      		  .text(Percentage + "%");

				//$( "#"  + sectionId ).click();
			//}, 1200);
	              */
	        }
	    }  
	 } 

	
	
	
	
	//show section content
	$(".show-section-content").click(function(e){
		e.preventDefault();
    	   e.stopImmediatePropagation();
		var sectionId = this.id;
		$("#add-section-" + sectionId ).show();
		
		$.ajax({
			url : "getSectionContent.php", 
			type : "POST", 
			data : {
				"sectionId" : sectionId,
				"book_id" : bookId, 
				"role" : role 
			}, 
			beforeSend : function(){
				$("#section-" + sectionId ).html('<div class="text-center d-block mx-auto w-100 lds-hourglass"></div>');
				$("button").attr("disabled", "disabled");
			}, 
			success:  function(data){
				$("#section-" + sectionId ).html( data);
				$("button").removeAttr("disabled");
			}
		});
		
	});
		
	//hide section content
	/*
	$(".section").dblclick(function(e){
		e.preventDefault();
    	   e.stopImmediatePropagation();
		var sectionId = this.id;
		$("#section-" + sectionId ).hide();
		
	});
	*/
		
	//show  section form
	var sectionIdAddSection;
	$(".add-section").click(function(e){
		e.preventDefault();
    	   e.stopImmediatePropagation();
		sectionIdAddSection = $(this).val();
		$(".add-section-form-container").show();
		
		$.ajax({
			url : "addSectionForm.php", 
			type : "POST", 
			data : {
			 "section_id" :  sectionIdAddSection ,
			 "book_id" : bookId 
			}, 
			beforeSend : function(){
				$(".add-section-form-container " ).html('loading #!!!!! ');
			}, 
			success:  function(data){
				$(".add-section-form-container" ).html(data);
			}
		});
		
	});
	
	
	//add section 
	$("#add-section-form").submit(function(e){
		e.preventDefault();
    	   e.stopImmediatePropagation();
		$.ajax({
			url : "addSection.php", 
			type : "POST", 
			data : $("#add-section-form").serialize() , 
			beforeSend:function(){
				$(".add-section-form-container " ).append("loading #!!!!!!!");
				$("#add-section-submit-button").attr("disabled", "disabled");
				
			} ,
			success:  function(data){
			$(".add-section-form-container " ).append(data);
			 location.reload();
			}
		});
		return false ;
	});
	
	//hide section button
	$(".add-section-hide").click(function(){
		$(".add-section-form-container").hide();
	});
	
	
	//big the img on click
	// Get the modal
	var modal = document.getElementById('myModal');

	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var img = document.getElementById('myImg');
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");

	$("img").click(function(){
		modal.style.display = "block";
		modalImg.src = this.src;
	captionText.innerHTML = this.alt;
	});

	// Get the <span> element that closes the modal
	var span = $(".close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
	  modal.style.display = "none";
	}
	
	
		

		
});




















//file download
	/*
		<button id ="<?= 'files/' . $book_id . '/' . $f['name' ] ?>" class ="file-download"><span><i class = "fa fa-download"></i></span></button>
	$(".file-download").click(function(){
		downloadFile('download.php?file=' + this.id );
	});
	
	function downloadFile(url) { 
		var iframe;
		iframe = document.getElementById("download-container"); 
		if (iframe === null) { 
			iframe = document.createElement('iframe');
		 	iframe.id = "download-container";
	 		iframe.style.visibility = 'hidden'; 
	  		document.body.appendChild(iframe); 
	 	 }
	   iframe.src = url; 
	   }

	*/
	

		
/*
	
			
	
	
	<!-- upload forms -->
    <div class = "row">
		
		<div class = "m-auto border" >
			<form action="index.php?c_section_id=<?= $c_section_id ?>" enctype="multipart/form-data" method="post">
				 upload lecture
				<br>
				<input type="text" name="custom_name" placeholder="custom name">
				<input type="file" name="lec">
				<input type="text" name="c_section_id" value="<?= $c_section_id ?>">
				<input type="submit" name="upload_file" value="upload">
			</form>
		</div>
    	
    </div>

    <!-- add section -->
	<div class = "row">
	
		<div class = "col" >
			 <div>
			 	<form action="index.php?c_section_id=<?= $c_section_id ?>" method="post">
					add section (folder)
					<?php include '../includes/errors.php'; ?>
					<br>
					<input type="text" name="name" placeholder = "name" class = "form-control">
					<br>
					<input type="text" name="c_section_id" value="<?= $c_section_id ?>" >
					<input type="submit" name="add_section" value="add" class =" btn btn-primary ">
				</form>
			</div>
		</div>
		
	</div>
*/
    
    
    
    
    
    
    
    
    
    
    
