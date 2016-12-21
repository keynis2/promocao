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

function setDatetime($datetime){
 	//return date_format($datetime, "Y-m-d H:i");
 	/*$dateTime = new DateTime($datetime);
	return $dateTime->format("Y-m-d H:i");
	*/
	$aux = explode(":", $datetime);
	return str_replace(' ', 'T', $aux[0]).':'.$aux[1];
}

function getDatetime($datetime){
	$dateTime = new DateTime($datetime);
	return $dateTime->format("d-m-Y H:i");
}

function getDateTtime($datetime){
	//$dateTime = new DateTime($datetime);
	//return $dateTime->format("Y-m-d T H:i");
	//return ("1990-12-31T23:59");
	$aux = explode(":", $datetime);
	return str_replace(' ', 'T', $aux[0]).':'.$aux[1];
}

function getField($field){
	return $field;
}

function setUrlSite($urlSite){
	return str_ireplace('http://', '', $urlSite);
}

function uploadImage($imagem){
/******
 * Upload de imagens
 ******/
 
	// verifica se foi enviado um arquivo
	if (isset($imagem['name']) && $imagem['error'] == 0){
	    //echo "Você enviou o arquivo: <strong>".$imagem['name']."</strong><br />";
	    //echo "Este arquivo é do tipo: <strong >".$imagem['type']."</strong ><br />";
	    //echo "Temporariamente foi salvo em: <strong>".$imagem['tmp_name']."</strong><br />";
	    //echo "Seu tamanho é: <strong>".$imagem['size']."</strong> Bytes<br /><br />";
	 
	    $arquivo_tmp = $imagem['tmp_name'];
	    $nome = $imagem['name'];
	 
	    // Pega a extensão
	    $extensao = pathinfo($nome, PATHINFO_EXTENSION);
	 
	    // Converte a extensão para minúsculo
	    $extensao = strtolower($extensao);
	 
	    // Somente imagens, .jpg;.jpeg;.gif;.png
	    // Aqui eu enfileiro as extensões permitidas e separo por ';'
	    // Isso serve apenas para eu poder pesquisar dentro desta String
	    if (strstr(".jpg;.jpeg;.gif;.png", $extensao)){
	        // Cria um nome único para esta imagem
	        // Evita que duplique as imagens no servidor.
	        // Evita nomes com acentos, espaços e caracteres não alfanuméricos
	        $novoNome = uniqid(time()).'.'.$extensao;
	 
	        // Concatena a pasta com o nome
	        $destino = "imagens/".$novoNome;
	 
	        // tenta mover o arquivo para o destino
	        if (@move_uploaded_file($arquivo_tmp, $destino)){
	            //echo "Arquivo salvo com sucesso em : <strong>".$destino."</strong><br />";
	            //echo "<img src="'.$destino.'" />";
	            return $novoNome;
	        }
	        
	        else
	            echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />";
	    }
	    else
	        echo 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br />';
	}
	else
	    echo "Você não enviou nenhum arquivo!";
}