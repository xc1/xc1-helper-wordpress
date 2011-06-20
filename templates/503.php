<?php 
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
  die(__('You are not allowed to call this page directly.')); 
}?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>XC1 Group</title>

	<style>
	* { font-family: verdana; font-size: 11pt; color: #000000; }
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <h1><?php _e('The website is temporarily down.');?></h1>
</body>

</html>