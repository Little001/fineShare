/*Zobrazení příslušné hlášky*/
function clientMessage(msg, typeMsg){
	if(!openError){
		openError = true;
		switch(Number(typeMsg)){
			case 0: $( ".clientMessage" ).addClass( "errorMsg" );
				break;
			case 1: $( ".clientMessage" ).addClass( "succesMsg" );
				break;
		}
		$(".clientMessage span").text(msg);
		$(".clientMessage").animate({
		    top: "+=70px",
		  	}, 600, function() {
				  setTimeout(function(){$(".clientMessage").animate({
				 top: "-=70px" 
			  }, function(){$(".clientMessage span").empty();
			  	 openError = false;
			  });
			  
			  }, 1500);
		});	
	}
}

/*Vrací parametry z URL*/
function paramFromUrl(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);
	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
}



/*Funkce při odkliknutí se něco stane*/
$.fn.clickOff = function(callback, selfDestroy) {
    var clicked = false;
    var parent = this;
    var destroy = selfDestroy || true;
    
    parent.click(function() {
        clicked = true;
    });
    
    $(document).click(function(event) { 
        if (!clicked) {
            callback(parent, event);
        }
        if (destroy) {
            //parent.clickOff = function() {};
            //parent.off("click");
            //$(document).off("click");
            //parent.off("clickOff");
        };
        clicked = false;
    });
};


/*Zavření login dialogu*/
function closeLoginDialog(){
	if(openLogin){
		openLogin = false;
    	$(".login").animate({
				    top: "-=545px",
				  }, 300, function() {
					  $('.login').css('z-index', '-1');
					  $('.searchUploadComponent').css('z-index', '1');						  
					  loginClicked = false;
					  $('.loader').css('display', 'none');
					  
		});
	}
}

	
/*Zablokuje celé dialogové okno pro přihlášení*/
function lockLogin(){
	$("#login_user :input").prop("disabled", true);
}
function unlockLogin(){
	$("#login_user :input").prop("disabled", false);
}


/*zapne načítání stránky*/
function startLoading(){
  $('.loader').css('display', 'block');
}
/*vypne načítání stránky*/
function stopLoading(){
  $('.loader').css('display', 'none');
}

/*Zkontroluje jestli je email validní*/
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/*Zkontroluje jestli je heslo validní*/
function validatePass(password) {
    return password.length >=8;
}

