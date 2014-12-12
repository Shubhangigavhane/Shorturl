<!DOCTYPE html>
<html>
	<head>
	{literal}
		<style type="text/css">
			#displaytable {
			width:50%;
			height:90px;
			background-color:#ADD8E6;
			box-shadow:0px 4px 2px #333;
		}
		</style>
	{/literal}	
	</head>
	<body>
		<form name="AcceptUrl" id="AcceptUrl" action="MakeShortUrl.php" method="post">
		
			{if isset($short_url) && isset($long_url) }
				<div id="urldisplay">
				<h1>Short URL Was Created:</h1>
				<h4>The following URL:</h4>
				<p>{$long_url}<br/>
					[<a href="{$long_url}" target="_blank">Open in new window</a>]
				</p>
				<h4>has a length of {$long_url|count_characters} characters and resulted in the following TinyURL which has a length of {$short_url|count_characters} characters:</h4>
				<p>{$short_url}<br/>
					[<a href="{$short_url}" target="_blank">Open in new window</a>]
				</p>
				</div>
			{else}
				<h3> Make Short URL </h3>	
			{/if}	
			<table id="displaytable">
				<tr>
					<td>Enter long url to make short:</td>
					<td><input type="text" name="longurl" onChange="ValidURL(this.value);">
					<input type="submit" name="submit" value="Make ShortURL" onClick=" return checkEmpty();"/>
					
				</tr>
				
			</table>
		</form>
	<body>
	{literal}
	<script language="javascript">

	function checkEmpty(){
		var str = document.AcceptUrl.longurl.value;
		if(!str || 0 === str.length){
			alert('Please enter valid URL!');
   			 return false;
		}else{
			return true;
		}
	}
	
	function ValidURL(str) { 
 		var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
 		
  		if((!RegExp.test(str))) {
  			alert('Please enter valid URL!');
   			 return false;
 		 } else {
   			 return true;
 		 }
	}
	</script>
	{/literal}
<html>