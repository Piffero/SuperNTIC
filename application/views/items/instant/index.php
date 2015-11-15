<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Instant Search With Arrow Key Navigation Using jQuery and PHP</title>

<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="search.js"></script>

<script> 

    //arrow key navigation 
    $(document).keydown(function(e){ 

        //jump from search field to search results on keydown 
        if (e.keyCode == 40) {  
            $("#s").blur(); 
              return false; 
        } 

        //hide search results on ESC 
        if (e.keyCode == 27) {  
            $("#results").hide(); 
            $("#s").blur(); 
              return false; 
        } 

        //focus on search field on back arrow or backspace press 
        if (e.keyCode == 37 || e.keyCode == 8) {  
            $("#s").focus(); 
        } 

    }); 
    // 


 $(document).ready(function() { 

    //clear search field & change search text color 
    $("#s").focus(function() { 
        $("#s").css('color','#333333'); 
        var sv = $("#s").val(); //get current value of search field 
        if (sv == 'Search') { 
            $("#s").val(''); 
        } 
    }); 
    // 

    //post form on keydown or onclick, get results 
    $("#s").bind('keyup click', function() { 
        $.post("results.php", //post 
            $("#search").serialize(),  
                function(data){ 
                    //hide results if no more than 2 characters 
                    if (data == 'hide') { 
                        $('#results').hide(); 
                    } 

                    //show results if more than 2 characters 
                    if (data != 'hide') { 
                        $("#results").html(data); 
                        if (data) { 
                            $("#results").show(); 
                        } 
                    } 
            }); 
    }); 
    // 

    //hide results when clicked outside of search field 
    $("body").click(function() { 
        $("#results").hide(); 
    }); 
    // 

}); 


</script>

<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>

	<h1>Instant Search Using jQuery and PHP</h1>

	<h2>
		Example keywords (website, jquery, php, launch)<br /> <br />
	</h2>

	<form id="search" name="search" method="post" action="">
		<input name="s" type="text" id="s" value="Search"/>
		<div id="results"></div>
	</form>


	<br />
	<br />
	<br />

	<a
		href="http://www.johnboy.com/blog/tutorial-instant-search-with-arrow-key-navigation-using-jquery-and-php">Back
		to Article &amp; Source Code</a>


</body>
</html>
