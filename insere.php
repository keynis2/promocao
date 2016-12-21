<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="refresh" content="10;url=index.php" />
		<!--
		
		$diretorio = $_GET['dir'];
$info = pathinfo($diretorio);
$dirname = $info['dirname'];
<a href="index.php?dir=<? echo $dirname ?>">voltar</a>

		-->
		
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
		if (errSQLQuery("INSERT INTO promocao (nome, validadeDe, validadeAte, premios, iPremios, urlSite, foto, envioMax, guardar) VALUES ('". $nome ."', '". setDateTime($dataDe) ."', '". setDateTime($dataAte) ."', '". $premios ."', '". $iPremios ."', '". setUrlSite($urlSite) ."', '". uploadImage($foto) ."', '". $envioMax ."', '". $guardar ."')")) 
			echo "<h1>Os dados foram cadastrados com sucesso!</h1>";
		else
			echo "<h1>Ocorreu um erro durante o cadastro!</h1>";
		
	} elseif ($_GET['op'] == "edit"){
		if (errSQLQuery("UPDATE promocao SET nome = '".$nome."', validadeDe = '".setDatetime($dataDe)."', validadeAte = '".setDateTime($dataAte)."', premios = '".$premios."', iPremios = '".$iPremios."', urlSite = '".setUrlSite($urlSite)."', envioMax = '".$envioMax."', guardar = '".$guardar."'  WHERE id = ".$_GET['id']))
			echo "<h1>Os dados foram atualizados com sucesso!</h1>";
		else
			echo "<h1>Ocorreu um erro durante a atualização!</h1>";
	}
}catch (Exception $e){
	echo $e->getMessage();
}
?>
	<div id="interval"></div>
	<script type="text/javascript">setInterval(i = 10;function(i){document.getElementById("interval").innerHTML = "Aguarde " + i-- + " segundos";}, 10000)</script>
	</body>
</html>

<!--

<meta http-equiv="refresh" content="5;url=javascript:history.go(-1)" />

<?php header("Location: http://www.google.com.br"); ?>

<script type="text/javascript">
	window.location = "http://www.google.com.br";
</script>

-->