<?php
$link = mysql_connect('localhost', 'root', 'masterkey');
mysql_select_db('NTIC', $link);

// only show results if two or more characters have been typed - max of 50 characters
$len = strlen(str_replace(" ", "", $_POST[s])); // don't count blank spaces
if ($len < 3 || $len > 50) {
    echo 'hide';
    die();
}
//

// get results if search string is longer than 3 characters
if ($len > 3) {
    
    $result = mysql_query(" 
            SELECT `CODIGOPROD`, `DESCRICAO`,  MATCH (CODIGOPROD, DESCRICAO)  AGAINST ('" . strip_tags($_POST[s]) . "*' IN BOOLEAN MODE) AS ranking
            FROM `ItemOS`
          	WHERE MATCH (CODIGOPROD, DESCRICAO) AGAINST ('" . strip_tags($_POST[s]) . "*' IN BOOLEAN MODE)

		ORDER BY ranking DESC
		LIMIT 0 , 8
          	
          
        ");
}

?>
<ul>
	<!--display user's initial search term-->
	<li><a class="link" href="#" title="<?php echo $_POST[s]; ?>"><?php echo "$_POST[s]"; ?></a></li>
	<!---->
<?php

while ($row = mysql_fetch_assoc($result)) {
    
    ?>
    <li><a class="link"
		href="index.php?page=PCliente&id=<?php echo $row['CODIGOPROD'];?>"
		target="_blank"
		title="<?php echo $row['CODIGOPROD'].' '.$row['DESCRICAO']; ?>"><?php echo $row['CODIGOPROD'].' '.$row['DESCRICAO']; ?></a></li>
    <?php }  ?>
</ul>
