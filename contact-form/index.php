<?php
	// Start session.
	session_start();
	
	// Set a key, checked in mailer, prevents against spammers trying to hijack the mailer.
	$security_token = $_SESSION['security_token'] = uniqid(rand());
	
	if ( ! isset($_SESSION['formMessage'])) {
		$_SESSION['formMessage'] = 'Fill in the form below to send me an email.';	
	}
	
	if ( ! isset($_SESSION['formFooter'])) {
		$_SESSION['formFooter'] = ' ';
	}
	
	if ( ! isset($_SESSION['form'])) {
		$_SESSION['form'] = array();
	}
	
	function check($field, $type = '', $value = '') {
		$string = "";
		if (isset($_SESSION['form'][$field])) {
			switch($type) {
				case 'checkbox':
					$string = 'checked="checked"';
					break;
				case 'radio':
					if($_SESSION['form'][$field] === $value) {
						$string = 'checked="checked"';
					}
					break;
				case 'select':
					if($_SESSION['form'][$field] === $value) {
						$string = 'selected="selected"';
					}
					break;
				default:
					$string = $_SESSION['form'][$field];
			}
		}
		return $string;
	}
?><!doctype html>
<html lang="en" class="no-js">
<head>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="robots" content="index, follow" />
		<meta name="generator" content="RapidWeaver" />
		<link rel="apple-touch-icon" href="https://www.j3rc3k.eu/apple-touch-icon.png" />
		
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700|Ubuntu:300,400,700|Merriweather:400,700?rwcache=635461086' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" media="all" href="../rw_common/themes/split/consolidated.css?rwcache=635461086" />
		 	
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="../rw_common/themes/split/js/modernizr.js?rwcache=635461086"></script>
	<title>KAPCSOLAT | J3RC3K</title>
	
	
	
	
	
</head>

<body>
	<header class="header">
		<div id="logo"><a href="https://www.j3rc3k.eu/"><img src="../rw_common/images/flat cmd.png" width="2000" height="2000" alt="J3RC3K"/></a></div>

		<nav class="main-nav">
				<ul><li><a href="../" rel="">KEZDŐLAP</a></li><li><a href="../styled/" rel="">CÉGRŐL</a></li><li><a href="../blog-2/" rel="">HÍREK</a></li><li><a href="../styled-2/" rel="">EDU</a></li><li><a href="./" rel="" id="current">KAPCSOLAT</a></li></ul>
		</nav> <!-- main-nav -->
	</header>

	<section id="intro">
		<div id="intro-background"></div>
		<div id="intro-tagline">
			<h1>J3RC3K</h1> 
		</div> 
	</section> 

	<main class="content">
		<section id="subheader">
		
				<nav class="secondary-nav">
					<ul></ul>
				</nav> <!-- secondary-nav -->
		</section>
		
		<div class="container">
		<aside id="aside" role="complementary">
			<div id="sidebar">
					<h3 class="sidebarTitle"></h3>
					
					<div id="archives">
					
					</div><!-- archives -->
			</div><!-- sidebar -->
		</aside><!-- aside -->
			<div id="contentContainer">
					
<div class="message-text"><?php echo $_SESSION['formMessage']; unset($_SESSION['formMessage']); ?></div><br />

<form class="rw-contact-form" action="./files/mailer.php" method="post" enctype="multipart/form-data">
	 <div>
		<label>Név</label> *<br />
		<input class="form-input-field" type="text" value="<?php echo check('element0'); ?>" name="form[element0]" size="40"/><br /><br />

		<label>Email cím</label> *<br />
		<input class="form-input-field" type="text" value="<?php echo check('element1'); ?>" name="form[element1]" size="40"/><br /><br />

		<label>Tárgy</label> *<br />
		<input class="form-input-field" type="text" value="<?php echo check('element2'); ?>" name="form[element2]" size="40"/><br /><br />

		<label>Üzenet</label> *<br />
		<textarea class="form-input-field" name="form[element3]" rows="8" cols="38"><?php echo check('element3'); ?></textarea><br /><br />

		<div style="display: none;">
			<label>Spam Protection: Please don't fill this in:</label>
			<textarea name="comment" rows="1" cols="1"></textarea>
		</div>
		<input type="hidden" name="form_token" value="<?php echo $security_token; ?>" />
		
		<input class="form-input-button" type="submit" name="submitButton" value="Küldés" />
	</div>
</form>

<br />
<div class="form-footer"><?php echo $_SESSION['formFooter']; unset($_SESSION['formFooter']); ?></div><br />

<?php unset($_SESSION['form']); ?>

			</div>
		</div>
	</main> <!-- content -->
	
	<footer id="footer" role="contentinfo" class="clearfix">	
		<div id="footerContent">
			<div id="footerText">&copy; 2021 J3RC3K <a href="#" id="rw_email_contact">EMIAIL</a><script type="text/javascript">var _rwObsfuscatedHref0 = "mai";var _rwObsfuscatedHref1 = "lto";var _rwObsfuscatedHref2 = ":he";var _rwObsfuscatedHref3 = "llo";var _rwObsfuscatedHref4 = "@j3";var _rwObsfuscatedHref5 = "rc3";var _rwObsfuscatedHref6 = "k.e";var _rwObsfuscatedHref7 = "u";var _rwObsfuscatedHref = _rwObsfuscatedHref0+_rwObsfuscatedHref1+_rwObsfuscatedHref2+_rwObsfuscatedHref3+_rwObsfuscatedHref4+_rwObsfuscatedHref5+_rwObsfuscatedHref6+_rwObsfuscatedHref7; document.getElementById("rw_email_contact").href = _rwObsfuscatedHref;</script></div>
		</div><!-- footerContainer -->
		<div class="clearer"></div>
	</footer><!-- footer -->
	<script src="../rw_common/themes/split/js/yuzoolthemes.js?rwcache=635461086"></script>
	<script type="text/javascript" src="../rw_common/themes/split/javascript.js?rwcache=635461086"></script>
</body>
</html><!-- END html -->