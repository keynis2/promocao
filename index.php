<html>
	<head>
		<title>Promoção</title>
		<link rel="stylesheet" type="text/css" href="style.css">
 	</head>
	<body>
		<header>
		<?php
		require("config.php");
		require("functions.php");
		
		try{ $conn = errDBConnected(); }catch (Exception $e){ echo $e->getMessage();}

		try{ errDBSelected($conn); } catch (Exception $e){ echo $e->getMessage();}

		if ((isset($_GET['op'])) && (!empty($_GET['op']))) $op = $_GET['op']; else $op = false;
		if ((isset($_GET['id'])) && (!empty($_GET['id']))) $id = $_GET['id']; else $id = false;
		
		if (($op == 'edit') || ($op == 'insert')){
			if ($id) $row = mysql_fetch_assoc(errSQLQuery("SELECT * FROM promocao WHERE id = ".$id));
		}

		if ($op == 'delete' || $op == '') echo "Listagem de promoções";
		else echo "Formulário de ".$title = ($op == "insert") ? "inserção" : "edição"; 
		?>		
		</header>
		<div id="container">
		<?php if ($op == "insert" || $op == "edit"){?>
		    <form name="formulario" action="insere.php?op=<?= $op; ?>&id=<?= $id; ?>" method="post" enctype="multipart/form-data">
				<table id="insert">
					<tr>
						<td>(*) Nome:</td>
						<td colspan="2"><input type="text" name="tNome" onchange="fDefault(this);" value="<?php if ($op == 'edit') echo getField($row['nome']); ?>"></td>	
					</tr>
					<tr>
						<td>(*) Período de validade:</td>
						<td><span>De: </span><input type="datetime-local" name="dtlDataDe" onchange="fDefault(this);" value="<?php if ($op == 'edit') echo getDateTtime($row['validadeDe']); ?>"></td>
						<td><span>Até: </span><input type="datetime-local" name="dtlDataAte" onchange="fDefault(this);" value="<?php if ($op == 'edit') echo getDateTtime($row['validadeAte']); ?>"></td>
					</tr>
					<tr>
						<td>(*) Prêmios</td>
						<td colspan="2"><input type="text" name="tPremios" onchange="fDefault(this);" value="<?php if ($op == 'edit') echo getField($row['premios']); ?>"></td>
					</tr>
					<tr>
						<td>Prêmios - Informações:</td>
						<td colspan="2"><textarea name="taPremios" onfocus="onIn(this.name, 'Entre com informações dos prêmios...');" onblur="onOut(this.name, 'Entre com informações dos prêmios...');" onchange="fDefault(this);"><?= $t = ($id) ? getField($row['iPremios']) : "Entre com informações dos prêmios..."; ?></textarea></td>
					</tr>
					<tr>
						<td>(*) Link para Site:</td>
						<td>
							<div id="dUrl">http://</div>
						</td>
						<td><input type="text" name="tUrlSite" onchange="fDefault(this);" value="<?php if ($op == 'edit') echo getField($row['urlSite']); ?>">
						</td>
					</tr>
					<tr>
						<td>Foto da promoção</td>
						<td colspan="2"><input type="file" name="fFoto"></td>
					</tr>
					<tr>
						<td>(*) Envio máx.</td>
						<td colspan="2"><textarea name="taEnvioMax" onfocus="onIn(this.name, 'Entre com envio máx....');"  onblur="onOut(this.name, 'Entre com envio máx....');" onchange="fDefault(this);"><?= $t = ($id) ? getField($row['envioMax']) : "Entre com envio máx...."; ?></textarea></td>
					</tr>
					<tr>
						<td>(*) Guardar:</td>
						<td colspan="2">
							<select name="sGuardar" onchange="document.getElementsByTagName('select')[0].value = this.value;">
								<option value="0" <?php if (($id) && (getField($row['guardar'] == 0))) echo "selected"; ?>>Embalagem</option>
								<option value="1" <?php if (($id) && (getField($row['guardar'] == 1))) echo "selected"; ?>>Comprovante Fiscal</option>
								<option value="2" <?php if (($id) && (getField($row['guardar'] == 2))) echo "selected"; ?>>Ambos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="3"><button name="btEnviar" onclick="if(validacao()) return false;">Enviar</button><button name="btVoltar" onclick="window.history.back();">Voltar</button>
						</td>
					</tr>	
				</table>
			</form>
		<?php
		} else {
			if ($op == 'delete'){
				if (errSQLQuery("DELETE FROM promocao WHERE id = '".$id."'")) echo "<h2 style=\"margin-bottom:20px;\">#".$id." excluído com sucesso!</h2>";
			}
			try{
				$q = errSQLQuery("SELECT * FROM promocao");
			}catch (Exception $e){
				echo $e->getMessage();
			}
		?>
			<table id="list">
				<thead>
					<tr>
						<th>#</th>
						<th>Nome</th>
						<th>Data início</th>
						<th>Data fim</th>
						<th>url Site</th>
						<th>foto</th>
						<th>Editar</th>
						<th>Remover</th>
					</tr>
				</thead>
				<tbody>
				<?php
					while ($rows = mysql_fetch_assoc($q)){
				?>
					<tr>
						<td><?= $rows['id']; ?></td>
						<td><?= $rows['nome']; ?></td>
						<td><?= getDatetime($rows['validadeDe']); ?></td>
						<td><?= getDatetime($rows['validadeAte']); ?></td>
						<td><a href="http://<?= $rows['urlSite']; ?>" target="_blank">http://<?= $rows['urlSite']; ?></a></td>
						<td style="text-align:center;"><img style="border-radius:5px;padding:5px;border:1px solid #AAA;" src=<?= "'./vendor/thumb.php?img=../imagens/{$rows['foto']}'";?>></td>
						<td><a href="?op=edit&id=<?= $rows['id']; ?>" onclick="if (!confirm('Deseja editar?')) return false;"><img src="img/dedit.png" border="0"></a></td>
						<td><a href="?op=delete&id=<?= $rows['id']; ?>" onclick="if (!confirm('Deseja excluir?')) return false;"><img src="img/excluir.png" border="0"></a></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<div id="insert"><a href="?op=insert">Inserir</a></div>
		<?php } ?>
		</div>
	<footer>Copyright by KN2 - 2016</footer>
	<script type="text/javascript" src="js.js"></script>
	</body>
</html>