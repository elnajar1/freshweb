<div class = "row py-5" >
	<div class = "col ">
		<div class="text-center">
			<h2 class="text-dark font-weight-bold">
				Search for many learning files 
			</h2>
			<small class="d-block text-muted">
				 pdf & photos & lecture records and more en'sha Allah
			</small>
		</div>

		<div id ="search-box" class="p-1 ">
			<form  action = "/fw/search/search.php" method="get" class="form-inline mr-auto ">

				<input  name = "search" class="search-input form-control  z-depth-5 w-50" type="text" placeholder="Search" aria-label="Search" autocomplete="off">

				<button class="btn btn-outline-primary  btn-sm my-0 z-depth-5 " type="submit">
					<span  <i class="fas fa-search py-1"></i> </span>
				</button>

				<div  style = "overflow-y:scroll;max-height:200px"   class = "search-suggestion-container bg-white z-depth-1 w-100  px-1"  >
	            </div>
	                
			</form>

			<!-- search  js -->
			<script src="/fw/layout/search/js/main.js"></script>
		
		</div>

	</div>
</div>


