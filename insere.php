<html>
	<head>
		<meta http-equiv="refresh" content="5;url=javascript:window.back();" />
		<meta charset="utf8" />
		<style type="text/css">
			h1{
				font:14px Arial;
				color:#777;
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
//$foto = $_POST['tFoto'];
$envioMax = $_POST['taEnvioMax'];
$guardar = $_POST['sGuardar'];
/*
echo "Nome: ".$nome;
echo "De: ".$dataDe;
echo "Ate: ".$dataAte;
echo "Premios: ".$premios;
echo "Infomações - Premios: ".$iPremios;
echo "Site: ".$urlSite;
echo "Envio Máx.: ".$envioMax;
echo "Guardar: ".$guardar;
*/


try{ $conn = errDBConnected(); }catch (Exception $e){ echo $e->getMessage();}

try{ errDBSelected($conn); } catch (Exception $e){ echo $e->getMessage();}

try{
	if ($_GET['op'] == "insert"){
		if (errSQLQuery("INSERT INTO promocao (nome, validadeDe, validadeAte, premios, iPremios, urlSite, envioMax, guardar) VALUES ('".$nome."', '".converteDatetime($dataDe)."', '".converteDatetime($dataAte)."', '".$premios."', '".$iPremios."', '".$urlSite."', '".$envioMax."', '".$guardar."')")) 
			echo "<h1>Os dados foram cadastrados com sucesso!</h1>";
		else
			echo "<h1>Ocorreu um erro durante o cadastro!</h1>";
		
	} elseif ($_GET['op'] == "edit"){
		if (errSQLQuery("UPDATE promocao SET nome = '".$nome."', validadeDe = '".converteDatetime($dataDe)."', validadeAte = '".converteDateTime($dataAte)."', premios = '".$premios."', iPremios = '".$iPremios."', urlSite = '".$urlSite."', envioMax = '".$envioMax."', guardar = '".$guardar."'  WHERE id = ".$_GET['id']))
			echo "<h1>Os dados foram atualizados com sucesso!</h1>";
		else
			echo "<h1>Ocorreu um erro durante a atualização!</h1>";
	}
}catch (Exception $e){
	echo $e->getMessage();
}
?>
	</body>
</html>

<!--

<meta http-equiv="refresh" content="5;url=javascript:history.go(-1)" />

<?php header("Location: http://www.google.com.br"); ?>

<script type="text/javascript">
	windows.location = "http://www.google.com.br";
</script>

-->