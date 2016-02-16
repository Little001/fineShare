$( document ).ready(function() {
	/*Při kliknutí na filter "Vše, Video, Audio..."*/
	$(".searchUploadComponent ul li").click(function() {
        /*Grafické upravy*/
        $(".searchUploadComponent ul li").each(function() {
            $(this).removeClass("active");
        });
        $(this).addClass("active");
	});
    
	/*Při kliknutí na hledat*/
	$("#searchButton").click(function() {
		startLoading();
		setTimeout(stopLoading, 2000);
	});	
    
    /*Při stlačení tlačítka, pro najetí nahoru stránky*/
    $(".buttonUpScroll").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
});


function startLoading(){
  $('.loader').css('display', 'block');
}

function stopLoading(){
  $('.loader').css('display', 'none');
}
