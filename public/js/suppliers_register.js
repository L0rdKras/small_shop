$(document).ready(function() {
    enterRut();
    dejarRut();
	guardarProv();
});

var enterRut = function(){
	$("#rut").on("keypress",function(e){
		if(e.which == 13){
			e.preventDefault();
			var rut = $(this).val();
			formatearRevisarRut(rut);
		}
	});
};

var dejarRut = function(){
	$("#rut").on("focusout",function(){
		var rut = $(this).val();
		formatearRevisarRut(rut);
	});
};

var formatearRevisarRut = function(rut){
	rut = daformator(rut);

	if(valida_cadena(rut)){
		$("#rut").val(rut);
	}else{
		$("#rut").select();
	}
};

var guardarProv = function(){
	$("#btn_guardar_prov").on('click',function(e){
		e.preventDefault();
		consultarYGuardarProv();
	});
};

var consultarYGuardarProv = function(){
	var form = $("#formProv");

	var url = form.attr('action');

	var data = form.serialize();

	//console.log(url);
	//console.log(data);

	$.post(url,data,function(response){
		//borrar los alert
		//console.log(response);
		
		var modalWindow = $('#modalTemplate').html();
		if(response.respuesta==="Guardado"){
			//informar y recargar
			modalWindow = modalWindow.replace(':MENSAJE','Empresa Guardada');
			$(modalWindow).modal({
			  keyboard: false,
			  backdrop: 'static'
			});
			setTimeout(location.reload(), 5000);
		}else{
			//informar error
			modalWindow = modalWindow.replace(':MENSAJE',response.respuesta);
			$(modalWindow).modal();
		}
		
	},'json');

};