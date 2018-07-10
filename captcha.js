	var txtCaptcha = null;
	var urlcaptcha="https://zeus.sii.cl/cvc_cgi/stc/CViewCaptcha.cgi?oper=1&txtCaptcha="
	//var imgCaptcha		='<img src="'+ urlcaptcha + txtCaptcha+'" /><br/>';
	var inputCaptcha 	='<input type="text" placeholder="Escriba Captcha..." onkeyup="javascript:this.value=this.value.toUpperCase();" style="width: 8em;" id="txt_code"  maxlength="4" name="txt_code">';

	function getImgCaptcha(){
		return '<img id="imgcapt" src="'+ urlcaptcha + txtCaptcha+'" /> <input type="hidden" id="txt_captcha" autocomplete="off" name="txt_captcha"><br/>';
	}
	function dispCaptcha() {
		var var_aux = '<div id="divCaptcha" style="width: 24em;  margin: 0 auto;">';
		var_aux +='<fieldset>';
		var_aux +='<div style="width:22em; padding:7px">';
			var_aux +='<div style="float:left;width:15em;">';
			var_aux +=getImgCaptcha();
			var_aux +='</div>';
			var_aux +='<div style="float:right;width:7em;">';
			var_aux +='<br>';
			var_aux +='<input type="button" value="Refrescar" onClick="callRefreshCaptcha();">';
			var_aux +='</div>';
		var_aux +='<br>';
		var_aux +='<div style="float:left;width:15em;">';
		var_aux +='<input type="text" placeholder="Escriba Captcha..."  onkeyup="javascript:this.value=this.value.toUpperCase();" style="width: 8em;" id="txt_code"  maxlength="4" name="txt_code">';
		var_aux +='</div>';
		var_aux +='</div>';
		var_aux +='</fieldset>';
		var_aux +='</div>';

     		document.write(var_aux);
	}


	function dispImgCaptcha() {
	 		document.write(getImgCaptcha());
	}
	function dispInputCaptcha() {
	 		document.write(inputCaptcha);
	}

	function callCaptcha(tipo) {
        	$.ajax({
                	type: "post",
                	contentType: "text/html;charset=utf-8",
                	url: "https://zeus.sii.cl/cvc_cgi/stc/CViewCaptcha.cgi",
                	async: false,
                	data: "oper=0",
                	dataType: 'json',
                	beforeSend: function() {
                        	//$.mobile.showPageLoadingMsg();
                	},
                	complete: function() {
                        	//$.mobile.hidePageLoadingMsg();
                	},
                	error: function() {
                        	alert("Error Interno");
                        	return false;
                	},
                	success: function(data) {
                        	if (data != null){
								if (data.codigorespuesta == 0) {
									txtCaptcha = data.txtCaptcha;
									if(tipo==null)
										dispCaptcha();
									if(tipo==1)
										dispImgCaptcha();

									var objc = document.getElementById("txt_captcha");
									 if(objc)
									 	objc.value=txtCaptcha;
								}
							}
                	}
        	});
	}

	function callRefreshCaptcha(tipo) {
        	$.ajax({
                	type: "post",
                	contentType: "text/html;charset=utf-8",
                	url: "https://zeus.sii.cl/cvc_cgi/stc/CViewCaptcha.cgi",
                	async: false,
                	data: "oper=0",
                	dataType: 'json',
                	beforeSend: function() {
                        	//$.mobile.showPageLoadingMsg();
                	},
                	complete: function() {
                        	//$.mobile.hidePageLoadingMsg();
                	},
                	error: function() {
                        	alert("Error Interno");
                        	return false;
                	},
                	success: function(data) {
                        	if (data != null){
								if (data.codigorespuesta == 0) {
									txtCaptcha = data.txtCaptcha;
									var objImg = document.getElementById("imgcapt");
									if(objImg){
										objImg.src=urlcaptcha + txtCaptcha;
									}
									var objc = document.getElementById("txt_captcha");
									 if(objc)
									 	objc.value=txtCaptcha;
								}
							}
                	}
        	});
	}

	function login(){
		var obj=document.getElementById("txt_code");
		if(obj)
			if(obj.value=='')
				alert("Debe ingresar Captcha");
			else{
				alert("Aqui colocar mi funcion submit?")
			}
	}
	function captcha(tipo){
		callCaptcha(tipo);

	}