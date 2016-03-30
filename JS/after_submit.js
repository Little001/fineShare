$( document ).ready(function() {
	
	/*Když není aktivni javascript tak stránka zašedne*/
	$('.loader').css('display', 'none');
	
	/*Zobrazí chybovou hlášku ze serveru*/
	if($("#message").val() != 0){
		clientMessage($("#message").val(), $('#typeMsg').val());
	}
	
	/*Naplní vyhledávací input po refreshu*/
	$("#serchInput").val(paramFromUrl('search'));
	
	/*Nastaví řadící komboBox po refreshu aby zůstal stejný*/
	switch(paramFromUrl('sort')){
		case "latest": $("#sortInput").val("latest");
			break;
		case "famous": $("#sortInput").val("famous");
			break;
		case "biggest": $("#sortInput").val("biggest");
			break;
		case "smallest": $("#sortInput").val("smallest");
			break;
		default: $("#sortInput").val("latest");
	}
	
	/*Nastaví kategorii po refreshu*/
	switch(paramFromUrl('category')){
		case "audio": $("#audio").addClass('active');
			break;
		case "video": $("#video").addClass('active');
			break;
		case "images": $("#images").addClass('active');
			break;
		case "archives": $("#archives").addClass('active');
			break;
		case "documents": $("#documents").addClass('active');
			break;
		case "virtualImages": $("#virtualImages").addClass('active');
			break;
		default: $("#all").addClass('active');
	}
});