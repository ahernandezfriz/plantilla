<?php

/**
 * Plantilla base
 * Establece y proporciona algunas funciones auxiliares, que se utilizan en el 
 * tema como etiquetas de plantilla personalizado.
 * Otros se unen a acciones y filtros ganchos en WordPress 
 * para cambiar la funcionalidad básica.   
 */
 


require TEMPLATEPATH. '/inc/shortcodes.php';
require TEMPLATEPATH. '/inc/generales.php';




/*
 * add_style() 
 * Agregar estilos css
------------------------------------------------------------------------------*/
function add_style(){
    if ( !is_admin () ):

        // code
        
    endif;
}
add_action ( 'wp_enqueue_scripts', 'add_style' );



/* 
 * add_js
 * agregar javascript
------------------------------------------------------------------------------*/
function load_javascripts () {
    if( ! is_admin() ):
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.11.0.min.js', array (), '1.9.1', false );
        wp_enqueue_script( 'jquery' );
        
        wp_register_script( 'migrate', 'http://code.jquery.com/jquery-migrate-1.2.1.min.js', array (), '1.9.1', false );
        wp_enqueue_script( 'migrate' );

        wp_register_script ( 'main', ( get_bloginfo ( 'template_url' ) . '/js/main.js' ), array (), '0.1', false );
        wp_enqueue_script ( 'main' );

    endif;
}
add_action ( 'wp_enqueue_scripts', 'load_javascripts' );



/*
 * Redimensionar imagen destaca
 * Si no existe una imagen destaca buscara una por defecto en el directorio images/default/imagen.png
 * Ademas de la función para correcto funcionamiento se debe incluir las siguientes librerias: timthumb-config.php  timthumb.php
 * 
 * @param $w Int ancho de la imagen
 * @param $h Int alto de la imagen
 * @param $img String palabre clave para diferenciar la imagen (P.E. noticia, evento, agenda, docentes, etc.)
 * 
 * cómo se usa?
 * echo img_destacada( 500, 320, 'noticia' )
-----------------------------------------------*/
if ( ! function_exists( 'img_destacada' ) ) :
function img_destacada ( $w, $h, $img ) {
	if ( has_post_thumbnail () ) :
		$destacada =  wp_get_attachment_image_src ( get_post_thumbnail_id (), $img, true );
		$src = str_replace ( get_bloginfo( 'url' ), '', $destacada[0] );
		$output = '<img src="' . get_bloginfo( 'template_url' ) . '/inc/timthumb.php?src=' . $src . '&amp;w='.$w.'&amp;h'.$h.'" alt="' . get_the_title () . '" />' . "\n";
	else:
    	$output = '<img src="' . get_bloginfo ( 'template_url' ) . '/img/default/' . $img . '.jpg" alt="Imagen ' . get_the_title () . '" />';
	endif;
  	return $output;
}
endif;