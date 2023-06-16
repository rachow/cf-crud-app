<?php
/**
 * 	@author: $rachow
 * 	@copyright: CF Partners 2023
 *
 * 	Core app's extended layouts file.
 *
 *	todo: use layout file to extend views in futre. 
*/
?>
<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="robots" content="noindex,nofollow">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" type="image/png" href="/favicon.ico">	
</head>
<body <?php if(isset($body_class)): echo 'class=\"' . $body_class . '\"'; endif;?>>
	<div class="content">
		<?php echo $content; ?>
	</div>
</body>
</html>
