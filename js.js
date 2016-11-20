function fDefault(obj){
	obj.style.borderColor = "#777";
	obj.style.color = "#777";
}

function t(name, campo, field = '', obg = ''){
	if ((document.getElementsByName(name)[0].value == field) || (document.getElementsByName(name)[0].value == obg)){
		alert("Preencha o campo: " + campo);
		document.getElementsByName(name)[0].focus();
		document.getElementsByName(name)[0].style.borderColor = "#FF0000";
		document.getElementsByName(name)[0].style.color = "#FF0000";
		return true;
	}
}

function validacao(){
	if (t("tNome", "NOME")) return true;
	if (t("dtlDataDe", "PERÍODO DE VALIDADE DE")) return true;
	if (t("dtlDataAte", "PERÍODO DE VALIDADE ATÉ")) return true;
	if (t("tPremios", "PRÊMIOS")) return true;
	if (t("taPremios", "OUTRAS INFORMAÇÕES DE PRÊMIOS", "Entre com informações dos prêmios...", "Entre com informações dos prêmios...")) return true;
	if (t("tUrlSite", "URL DO SITE")) return true;
	if (t("taEnvioMax", "ENVIO MÁX.", "Entre com envio máx....")) return true;
}