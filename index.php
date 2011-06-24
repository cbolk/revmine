<html>
<head>
<title>DBLP ReS App</title>
<link href="./css/dblp.css" rel="stylesheet" type="text/css" /> 
<link href="./css/style.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
</head>

<body id ="home">
<h1>Reviewers' Search with <a href="http://www.informatik.uni-trier.de/~ley/db/" target=_blank>DBLP</a></h1>
<?php include("settings.php"); ?>
<script type="text/javascript">
    $(document).ready(function(){
	    var counter=2; <?php $counter=2; ?>
		var counterKEY=2; <?php $counterKEY=2; ?>
		//button add
	    $("#addButton").click(function (){
			if(counter>10){
		        alert("10 authors maximum");
		        return false;
		    }/* if */   
			
			var authorHeader = $(document.createElement('div')).attr(
			{
  				id: 'author' + counter,
 				class: 'author'
			});
			authorHeader.after().html("<span class='author'>Author #" + counter +"</span>");
			
			authorHeader.appendTo("#inputBoxAuthor");    

			var newinputBoxFN = $(document.createElement('div')).attr("id", 'inputBoxFN' + counter);
                newinputBoxFN.after().html('<label>Firstname (Middle):</label>' +
				'<input type="text" name="n' + counter + '" id="n' + counter + '" value="" >');
		      
			newinputBoxFN.appendTo("#author" + counter);    
			
			var newinputBoxLN = $(document.createElement('div')).attr("id", 'inputBoxLN' + counter);
                newinputBoxLN.after().html('<label>Lastname:</label>' +
				'<input type="text" name="c' + counter + '" id="c' + counter + '" value="" >');
				
			newinputBoxLN.appendTo("#author" + counter);
			

			
			counter++;	<?php $counter++; ?>
	    });/* add */
	
	    $("#removeButton").click(function (){
		    if((counter==2)){
		        alert("At least an author must be specified");
		        return false;
		    }   /* if */
	        counter--;	<?php  $counter--; ?>
	        $("#inputBoxFN" + counter).remove();
			$("#inputBoxLN" + counter).remove();
		});/* remove */
		
		//addkeybutton
		$("#addKeyButton").click(function () {		
			if(counterKEY>10) {
		        alert("10 keywords maximum");
		        return false;
		    }  /* if */ 
			
			var newKinput = $(document.createElement('div')).attr("id", 'inputBoxK' + counterKEY);
            newKinput.after().html('<label>Keyword #'+ counterKEY + ':</label><input name="ch' + counterKEY + '" id="ch' + counterKEY + '">');
		
			newKinput.appendTo("#inputBoxKeyword");
			counterKEY++; <?php $counterKEY++; ?>
	    }); /* addK */
		
		//remove key button
		$("#removeKeyButton").click(function () {
		    if((counterKEY==2)){
		        alert("At least a keyword is necessary")
		        return false;
		    }   
	        counterKEY--;<?php $counterKEY--; ?>
			
			$("#inputBoxK" + counterKEY).remove();
		});/* removeK */
		
		$("#getButtonValue").click(function () {
			var msg = '';
			for(i=1; i<counter; i++){
				msg += "\n First Name " + i + " : " + $('#n' + i).val() +"\n Last Name " + i + " : " + $('#c' + i).val() ;
			}
		   	
			var msg1 = '';
			for(i=1; i<counterKEY; i++){
				msg1 += "\n Keyword " + i + " : " + $('#ch' + i).val() ;
			}
			
			alert(msg);
			alert(msg1);
		});/* get */
		
  });/* main */
</script>

<div class="lastcolumn">
	<div id="box">
	<div class="notice">
		<div class="searchinfo">
			<h3>Previous search: author(s) and keywords</h3>
			<?php 
				$query="SELECT nome from persona where tipo='main';";
				$result = mysql_query($query,$myconn) or die ('Error in the initial query on the keyword [' . $query . ']'. mysql_error());
				if (mysql_num_rows($result) > 0){
					while($resrow = mysql_fetch_array($result)) //stampo gli autori
						echo "Author: ". $resrow['nome'] . "<br />";
				
					$query="SELECT chiave from chiave";
					$result = mysql_query ($query,$myconn) or die ('Error in the initial query on the keyword [' . $query . ']'. mysql_error());
					echo "Keywords: ";
					while($resrow = mysql_fetch_array($result))//stampo le chiavi
						echo  $resrow['chiave'] . "<br />";
					
					echo "<br/><br/><a class='nodec' href='./results.php'><strong>Access data from previous search <img src='images/arrow-80.png'/></a></strong>";
										
				} else {
					echo "No cached previous search data.";
				}
			?>
		</div>
		<div class="fileinfo">
			<h3>XML source data</h3>
			File <?php $filename='dblp.xml'; echo "$filename" ?> downloaded <?php $filename='dblp.xml'; echo date("F d Y H:i:s",filemtime($filename)); ?><br/>
			<br/><a class="nodec" href="download.php">Download latest XML file from DBLP <img src="images/arrow-80.png"/></a>
		</div>
	</div>
	</div>

</div>

<form name='form1' method='post' action='./search.php'>

	<div id='inputBoxAuthor' class="firstcolumn">
		<input type='button' value='Add Author' id='addButton'>
		<input type='button' value='Remove Author' id='removeButton'>
		<hr/>
		<div id="author1" class='author'><span>Author #1</span>
			<div id="inputBoxFN"><label>Firstname (Middle):</label > <input name="n1" type='text' id='n1'></div>
        	<div id="inputBoxLN"><label>Lastname:</label><input name="c1" type='text' id='c1'></div>
        </div>
    </div>	
    <div id='inputBoxKeyword' class="secondcolumn">
    	<input type='button' value='Add keyword' id='addKeyButton'>
   		<input type='button' value='Remove keyword' id='removeKeyButton'>
       	<select name='andor'><option selected value='or'>OR</option><option value='and'>AND</option></select>
		<hr/>
		<div id="inputBoxK">
			<label>Keyword #1:</label><input name="ch1" type='text' id='ch1'>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
    <div id='search'>
 		<input type='image'   src="images/startsearch.png" value='Search' id='getButtonValue' style="width:130px; height:40px;">
    	<!--input type='button' value='Start search' id='getButtonValue' class="search_button" -->
	</div>


</form>

<div id="footer">
	&nbsp;
</div>
</body>
</html>