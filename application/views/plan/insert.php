<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Explosion page</title>
</head>
<body>
	<form method="post"
		action="http://172.1.3.195/SuperNTIC-AudioZoom/application/views/plan/insert.php"
		enctype="multipart/form-data"
		title="insira um arquivo para explodir os ;">
		<input type="file" name="txt" accept="text/plain"> <input
			type="submit">
	</form>

<?php
/**
 * if ($_POST)
 * {
 * echo '<pre>';
 * print_r($_FILES);
 * echo '</pre>';
 * }
 * $lines = file('http://www1.receita.fazenda.gov.br/sistemas/sped-contabil/PlanoContasRef/contasref-SRF.txt');
 * echo $lines;
 * foreach ($lines as $line_num => $line)
 * {
 * $linha_completa = explode(";", $line);
 * //print_r($linha_completa);
 * //echo "Linha #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n";
 * }
 * echo '<pre>';
 * print_r($linha_completa);
 * echo '</pre>';
 */
?>
</body>
</html>