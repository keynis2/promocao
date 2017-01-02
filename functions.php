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


class Upload{
	
	/*
	Desenvolvido por Marco Antoni <marquinho9.10@gmail.com>
*/
	private $arquivo;
	private $altura;
	private $largura;
	private $pasta;

	function __construct($arquivo, $altura, $largura, $pasta){
		$this->arquivo = $arquivo;
		$this->altura  = $altura;
		$this->largura = $largura;
		$this->pasta   = $pasta;
	}
	
	private function getExtensao(){
		//retorna a extensao da imagem	
		return $extensao = strtolower(end(explode('.', $this->arquivo['name'])));
	}
	
	private function ehImagem($extensao){
		$extensoes = array('gif', 'jpeg', 'jpg', 'png');	 // extensoes permitidas
		if (in_array($extensao, $extensoes))
			return true;	
	}
	
	//largura, altura, tipo, localizacao da imagem original
	private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao){
		//descobrir novo tamanho sem perder a proporcao
		if ( $imgLarg > $imgAlt ){
			$novaLarg = $this->largura;
			$novaAlt = round( ($novaLarg / $imgLarg) * $imgAlt );
		}
		elseif ( $imgAlt > $imgLarg ){
			$novaAlt = $this->altura;
			$novaLarg = round( ($novaAlt / $imgAlt) * $imgLarg );
		}
		else // altura == largura
			$novaAltura = $novaLargura = max($this->largura, $this->altura);
		
		//redimencionar a imagem
		
		//cria uma nova imagem com o novo tamanho	
		$novaimagem = imagecreatetruecolor($novaLarg, $novaAlt);
		
		switch ($tipo){
			case 1:	// gif
				$origem = imagecreatefromgif($img_localizacao);
				imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
				$novaLarg, $novaAlt, $imgLarg, $imgAlt);
				imagegif($novaimagem, $img_localizacao);
				break;
			case 2:	// jpg
				$origem = imagecreatefromjpeg($img_localizacao);
				imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
				$novaLarg, $novaAlt, $imgLarg, $imgAlt);
				imagejpeg($novaimagem, $img_localizacao);
				break;
			case 3:	// png
				$origem = imagecreatefrompng($img_localizacao);
				imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
				$novaLarg, $novaAlt, $imgLarg, $imgAlt);
				imagepng($novaimagem, $img_localizacao);
				break;
		}
		
		//destroi as imagens criadas
		imagedestroy($novaimagem);
		imagedestroy($origem);
	}
	
	public function salvar(){									
		$extensao = $this->getExtensao();
		
		//gera um nome unico para a imagem em funcao do tempo
		$novo_nome = time() . '.' . $extensao;
		//localizacao do arquivo 
		$destino = $this->pasta . $novo_nome;
		
		//move o arquivo
		if (! move_uploaded_file($this->arquivo['tmp_name'], $destino)){
			if ($this->arquivo['error'] == 1)
				return "Tamanho excede o permitido";
			else
				return "Erro " . $this->arquivo['error'];
		}
			
		if ($this->ehImagem($extensao)){												
			//pega a largura, altura, tipo e atributo da imagem
			list($largura, $altura, $tipo, $atributo) = getimagesize($destino);

			// testa se é preciso redimensionar a imagem
			if(($largura > $this->largura) || ($altura > $this->altura))
				$this->redimensionar($largura, $altura, $tipo, $destino);
		}
		return $novo_nome;
	}						
}