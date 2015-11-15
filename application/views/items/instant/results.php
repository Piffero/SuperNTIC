<?php
require_once ('mysql_connect.php');

// only show results if two or more characters have been typed - max of 50 characters
$len = strlen(str_replace(" ", "", $_POST[s])); // don't count blank spaces
if ($len < 3 || $len > 50) {
    echo 'hide';
    die();
}
//

// get results if search string is longer than 3 characters
if ($len > 3) {
    
    record_set('results', " 
            SELECT news_title, news_heading,  
            MATCH (news_title,news_text) AGAINST ('" . strip_tags($_POST[s]) . "*' IN BOOLEAN MODE) AS ranking  
            FROM jbp_blog_articles  
            WHERE MATCH (news_title,news_text) AGAINST ('" . strip_tags($_POST[s]) . "*' IN BOOLEAN MODE)  
            AND news_type = 1 
            ORDER BY ranking DESC  
            LIMIT 0,8 
        ");
}

?>

<ul>
	<!--display user's initial search term-->
	<li><a class="link" href="#" title="<?php echo $_POST[s]; ?>"><?php echo "$_POST[s]"; ?></a></li>
	<!---->     

    <?php if ($totalRows_results) do { ?> 
    <li><a class="link"
		href="/blog/<?php echo $row_results[news_heading]; ?>" target="_blank"
		title="<?php echo $row_results[news_title]; ?>"><?php echo "$row_results[news_title]"; ?></a></li> 
    <?php } while ($row_results = mysql_fetch_assoc($results)); ?> 
</ul>
