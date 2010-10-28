<?php

/*

Jappix - An Open μSocial Platform
This is the PHP script used to generate a chat log

-------------------------------------------------

License: AGPL
Author: Valérian Saliou
Contact: http://project.jappix.com/contact
Last revision: 17/03/10

*/

// REQUIRE THE NEEDED FILES
	require_once('../conf/main.php');
	require_once('./functions.php');
	
	if(!isDeveloper())
		hideErrors();

// WE CREATE THE HTML FILE TO BE DOWNLOADED
	if(isset($_POST['originalchat']) && isset($_POST['fromjid'])) {
		// WE DEFINE SOME VARIABLES
			$content_dir = '../store/logs/';
			$original_text = $_POST['originalchat'];
			$from = $_POST['fromjid'];
			$date = date('l jS \of F Y h:i:s A');
			$filename = "chat_log-".crc32($from.$date);
			$filepath = $content_dir.$filename.'.html';
		
		// WE CREATE THE HTML CODE
			$new_text_inter = 
	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">	
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Chat log with '.$from.'</title>
			<style type="text/css">
				html {
					background-color: #97acc3;
				}
			
				body {
					margin: 20px;
					padding: 0 18px;
					border: 1px solid #04172c;
					background-color: #d1dbe7;
					color: #04172c;
					font-family : Verdana, Arial, Helvetica, sans-serif;
					font-size: 0.9em;
				}
			
				.one-line {
					margin: 5px 0;
				}
				
				.title {
					text-decoration: underline;
					margin-bottom: 30px;
				}
				
				.informations {
					margin-top: 50px;
					padding-top: 10px;
					border-top: 1px dotted #04172c;
				}
			</style>
		</head>
		
		<body>
			<h3 class="title">This is your chat log with '.$from.' on '.$date.'.</h3>
			'.$original_text.'
			<h5 class="informations">Generated by Jappix (<a href="http://www.jappix.com/" target="_blank">http://www.jappix.com/</a>), an Open μSocial Network.</h5>
		</body>
	</html>'
			;
			
			$new_text = stripslashes($new_text_inter);
		
		// WE WRITE IT INTO A HTML FILE
			file_put_contents($filepath, $new_text);
		
		// SECURITY: REMOVE THE FILE AND STOP THE SCRIPT IF TOO BIG (6Mio+)
			if(filesize($filepath) > 6000000) {
				unlink($filepath);
				exit('');
			}
		
		// WE RETURN TO THE USER THE GENERATED FILE NAME
			exit($filename);
	}
?>
