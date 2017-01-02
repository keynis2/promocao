<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="refresh" content="10;index.php">
		<style type="text/css">
			h1, #interval{
				font:14px Arial;
				color:#777;
			}
			#interval {
				margin-top:20px;
			}
		</style>
	</head>
	<body>
<?php
require("config.php");
require("functions.php");

$id = $_POST['id'];
$nome = $_POST['tNome'];
$dataDe = $_POST['dtlDataDe'];
$dataAte = $_POST['dtlDataAte'];
$premios = $_POST['tPremios'];
$iPremios = $_POST['taPremios'];
$urlSite = $_POST['tUrlSite'];
$foto = $_FILES['fFoto'];
$envioMax = $_POST['taEnvioMax'];
$guardar = $_POST['sGuardar'];

try{ $conn = errDBConnected(); }catch (Exception $e){ echo $e->getMessage();}

try{ errDBSelected($conn); } catch (Exception $e){ echo $e->getMessage();}

try{
	if ($_GET['op'] == "insert"){
		$upload = new Upload($foto, 480, 720,"fotos/");
		if (errSQLQuery("INSERT INTO promocao (nome, validadeDe, validadeAte, premios, iPremios, urlSite, foto, envioMax, guardar) VALUES ('". $nome ."', '". setDateTime($dataDe) ."', '". setDateTime($dataAte) ."', '". $premios ."', '". $iPremios ."', '". setUrlSite($urlSite) ."', '". $upload->salvar() ."', '". $envioMax ."', '". $guardar ."')")) 
			echo "<h1>Os dados foram cadastrados com sucesso!</h1>";
		else
			echo "<h1>Ocorreu um erro durante o cadastro!</h1>";
		
	} elseif ($_GET['op'] == "edit"){
		$r = errSQLQuery("SELECT foto FROM promocao WHERE id =".$id);	
		$photo = mysql_fetch_assoc($r);

		if (isset($photo) && !empty($photo)) unlink("fotos/".$photo['foto']);
		$upload = new Upload($foto, 480, 720, "fotos/");
		if (errSQLQuery("UPDATE promocao SET nome = '".$nome."', validadeDe = '".setDatetime($dataDe)."', validadeAte = '".setDateTime($dataAte)."', premios = '".$premios."', iPremios = '".$iPremios."', urlSite = '".setUrlSite($urlSite)."', foto = '". $upload->salvar() ."', envioMax = '".$envioMax."', guardar = '".$guardar."'  WHERE id = ".$_GET['id']))
			echo "<h1>Os dados foram atualizados com sucesso!</h1>";
		else
			echo "<h1>Ocorreu um erro durante a atualização!</h1>";
	}
}catch (Exception $e){
	echo $e->getMessage();
}
?>
	<div id="interval"></div>
	</body>
	<script type="text/javascript">
		i = 10;
		var n = setInterval(function(){ regressiva() }, 1000);
		function regressiva(){
			document.getElementById("teste").innerHTML = "Aguarde " + i-- + " segundos";
		}
		if (i < 0) clearInterval(n);
	</script>
</html>