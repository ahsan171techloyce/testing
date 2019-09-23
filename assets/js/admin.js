jQuery( function() {
	
	jQuery( ".wcm-form-layout-left" ).on('click','.main-title .dashicons-arrow-down',function(){
			jQuery(this).parent().parent().next().slideToggle();
	});
    jQuery( "#sortable" ).sortable({
      revert: true
    });
    jQuery( ".draggable" ).draggable({
      connectToSortable: "#sortable",
	  cursor: "crosshair",
      helper: "clone",
      revert: "invalid",
	  //helper: function( event ) {
        //return jQuery( "<li class='ui-state-default'><input type='text'></li>" );
     // },
	  
	  stop: function( event, ui ) {
		 jQuery(event.target).addClass("active-fields");
		//var currentobj=jQuery(event.target).addClass("class");
		//jQuery(this).addClass("ui-state-highlight33333").find("p").html("Dropped in " + this.id);
	  }
    });
    //jQuery( "ul, li" ).disableSelection();
} );