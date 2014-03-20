<!DOCTYPE html>
<html lang="<?php bloginfo ( 'language' ); ?>">
 <head>
    <meta charset="<?php bloginfo ( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <meta name="robots" content="noodp,noydir"/>
    <link rel="pingback" href="<?php bloginfo ( 'pingback_url' ); ?>" />
    <link rel="stylesheet" href="<?php bloginfo ( 'stylesheet_url' ); ?>" />	
    <title><?php bloginfo ( 'name' ); ?> | <?php is_front_page () ? bloginfo ( 'description' ) : wp_title( '' ); ?></title>
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <?php wp_head (); ?>
 </head>
    
    <body>
        <div class="wrapper">
            <header>
                header
            </header>
   
