var openLogin = false;
var loginClicked = false;
var openError = false;

$( document ).ready(function() {
	
	/*Při otevření modalního okna, se naplní formulář pro odeslání příslusného souboru*/
	$('#myModal').on('show.bs.modal', function (event) {	
		var data_item = $(event.relatedTarget);
		var id = data_item.data('id_file');
		var category = data_item.data('category_file');
		var name = data_item.data('name_file');
		var size = data_item.data('size_file');
		var modal = $(this);
		modal.find('.modal-title').text(name);
		modal.find('.modal-size').text(size);
		$( "#category_file" ).attr( "value", category );
		$( "#id_file" ).attr( "value", id );
	});
	
	/*Při kliknutí na download aby se zavřelo modálni okno*/
	$('#downloadClick').click(function(){
		$('#myModal').modal('hide');
	});
	
	
	/*Při kliknutí na close v login dialogu*/
	$(".login_close").click(function(){
		closeLoginDialog();
	});
	
	
	/*Přo odkliknutí se zavře logovací okno*/
	$(".arrow-div").clickOff(function() {
		closeLoginDialog();
	});

	/*Při kliknutí na login pro otevření přihlašovacího okna*/
	$(".login_button").click(function(){
		$('.loader').css('display', 'block');
		$('.login').css('z-index', '100');
		if(!loginClicked){
			loginClicked = true;
			if(!openLogin){
				$('.searchUploadComponent').css('z-index', '0');
				$(".login").animate({
				    top: "+=545px",
				  }, 300, function() {
					  $('.login').css('z-index', '100');
					  openLogin = true;
					  loginClicked = false;
					  unlockLogin();
				});	
			}
		}  
	});
	
	/*Při kliknutí na registraci*/
	$(".reg").click(function() {
		window.location.href = "registration.php";
	});
	
	/*Při kliknutí na login tlačítko pro přihlášení*/
	$("#login_button").click(function() {
		if( $("#login_name").val() && $("#login_pass").val() ){
		}
		else{
			clientMessage("Nezadali jste přihlašovací údaje", 0);
			return false;
		}
	});
	
	

	/*Při kliknutí na filter "Vše, Video, Audio..."*/
	$(".searchUploadComponent ul li").click(function() {
		if($(this).attr('id') == 'all'){
			window.location.href = "search.php";
			return;	
		}
        window.location.href = "search.php?category=" + $(this).attr('id');
	});
	
	/*Při kliknutí na hledat (entrem)*/
	$('#serchInput').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  { 
		 search();
	  }
	}); 
    
	/*Při kliknutí na hledat*/
	$("#searchButton").click(function() {
		search();
	});	
    
    /*Při stlačení tlačítka, pro scrool nahoru stránky*/
    $(".buttonUpScroll").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
	
	/*Při změně řadícího komboboxu*/
	$('#sortInput').on('change', function() {
		search($(this).val()); 
	});
	
	
	/*Validace registrace*/
	$("#regSubmit").click(function() {
        var allFilled = true;
	    $('#registration :input:not(:button)').each(function(index, element) {
	        if (element.value === '') {
	            allFilled = false;
	        }
	    });
	    if(!allFilled){
			clientMessage("Nevyplnili jste všechna políčka", 0);
			return false;
		}
		else{
			if(!validateEmail($('#registration input[type=email]').val())){
				clientMessage("Email není ve správném tvaru", 0);
				return false;	
			}
			if($('#registration input[name=password]').val() != $('#registration input[name=repass]').val()){
				clientMessage("Hesla se neshodujísss", 0);
				return false;
			}
			if(!validatePass($('#registration input[type=password]').val())){
				clientMessage("Heslo musí obsahovat minimálně 8 znaků", 0);
				return false;	
			}
		}
	});
	
    
});



/*nastaví parametry v url při vyhledávání*/
function search(sort){
	
	var sort = (arguments.length > 0) ? sort : 'latest';
	
	if(paramFromUrl('category') != null){
		if($('#serchInput').val()){
			window.location.href = "search.php?category="+ paramFromUrl('category') +"&search=" + $('#serchInput').val() + "&sort=" +sort;
		}
		else{
			window.location.href = "search.php?category="+ paramFromUrl('category') + "&sort=" +sort;
		}
	}
	else{
		if($('#serchInput').val()){
			window.location.href = "search.php?search=" + $('#serchInput').val() + "&sort=" +sort;
		}
		else{
			window.location.href = "search.php" + "?sort=" +sort;	
		}			
	}
}

function closeDownloadModal(){
	$('#myModal').modal('hide');
}
	
