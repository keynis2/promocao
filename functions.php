<?php
function errDBConnected(){
	$conn = mysql_connect(HOST, USER, PASSWORD);
	if (!$conn){
		throw new Exception("Não foi possível conectar ao Banco de Dados");
	}
	return $conn;
}

function errDBSelected($conn){
	$db_selected = mysql_select_db("promocao", $conn);
	if (!$db_selected){
		throw new Exception("Não foi possível selecionar o Banco de Dados");
	}
}

function errSQLQuery($query){
	if (!$query){
		throw new Exception("Invalid query: ".mysql_error());
	}
	return mysql_query($query);
}

function converteDatetime($datetime){
	$str = explode('T',$datetime);
	$t = explode(':', $str[1]);
	$h = $t[0];
	$m = $t[1];
	return $str[0].' 00:'.$m.':'.$h;
}

function getDatetime($datetime){
	$str = explode(' ', $datetime);
	$d = explode('-', $str[0]);
	$date = $d[2].'/'.$d[1].'/'.$d[0];
	$t = explode(':', $str[1]);
	$time = $t[2].':'.$t[1].':'.$t[0];
	return $date.' '.$time;
}

function getField($field){
	return $field;
}
?>