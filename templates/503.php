<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
  die(__('You are not allowed to call this page directly.')); 
} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php bloginfo('name'); ?></title>
	
	<style>
	@font-face {
	    font-family: 'JournalRegular';
	    src: url('<?php echo plugins_url(); ?>/xc1-helper/assets/fonts/journal-webfont.eot');
	    src: url('<?php echo plugins_url(); ?>/xc1-helper/assets/fonts/journal-webfont.eot?#iefix') format('embedded-opentype'),
	         url('<?php echo plugins_url(); ?>/xc1-helper/assets/fonts/journal-webfont.woff') format('woff'),
	         url('<?php echo plugins_url(); ?>/xc1-helper/assets/fonts/journal-webfont.ttf') format('truetype'),
	         url('<?php echo plugins_url(); ?>/xc1-helper/assets/fonts/journal-webfont.svg#JournalRegular') format('svg');
	    font-weight: normal;
	    font-style: normal;

	}
	* { margin: 0px; padding: 0px;}
	body { background: #f6f6f6; font-family:  Helvetica, Arial, Verdana, Geneva, sans-serif; font-size: 14px; line-height: 20px; color: #000000;  }
	#wrapper {}
	#container { width: 960px; margin: 0px auto; position: relative; }
	#container img { margin: 0px auto; display: block; }
	h1, h2, h3 {font-family: 'JournalRegular'; font-size: 36px; line-height: 48px; color: #2b85a8; font-weight: 100; margin: 10px 0px 5px 0px; }
	p { margin: 0px; padding: 0px;}
	a { color: #000; text-decoration: none; border-bottom: 1px dotted #999; }
	.column { float: left; display: block; margin: 0px 10px; }
	.grid-6 { width: 460px; }
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
</head>
<body>
<div id="wrapper">
	<div id="container">
	<img src="<?php echo plugins_url(); ?>/xc1-helper/assets/images/xc1-503.jpg" /> 	
	
	<!-- Info about why the website might be down -->
	<div class="column grid-6">
		<h2>The website is temporarily down</h2>
		<p>The website should be up and running within a near future. Please check back again later.</p>
		<h2>Why do i see this page?</h2>
		<p>This webpage is maintained by <a href="http://xc1.se">XC1 Group</a>, which is owned and managed by <a href="http://framert.se">Framert AB</a> and <a href="http://parhaggstrom.com">Pär Häggström Photograhy</a>. We create webpages and opportunities for our clients.</p>
	</div>
	<div class="column grid-6">
		<h2>Webbplatsen är tillfälligt nere</h2>
		<p>Detta beror på en planerad uppdatering av sidan. Webbplatsen bör därför vara uppe igen inom kort. Återkom därför gärna vid ett senare tillfälle.</p>
		<h2>Varför möts jag av denna sida?</h2>
		<p>Denna webbplats driftas av <a href="http://xc1.se">XC1 Group</a>, som ägs och drivs av <a href="http://framert.se">Framert AB</a> och <a href="http://parhaggstrom.com">Pär Häggström Photography</a>. Vi skapar webbplatser och möjligheter för våra kunder.</p>
	</div>
	
	</div>
</div>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4229266-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>

</html>