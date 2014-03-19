<?php

/* 
 * generales.php
 * Funcionalidades generales para todas los proyectos
 * 
 * esta página se debe enlazar desde el archivo functions.php 
 */




/*
 * Soporte para thumbnail (miniaturas) en las entradas o paginas
------------------------------------------------------------------------------*/
add_theme_support( 'post-thumbnails' );


/*
 * Desactivar el complemento que despliega la barra superior al estar logueado. 
------------------------------------------------------------------------------*/
add_filter ( 'show_admin_bar', '__return_false' );



/*
 * cambiar_footer_version()
 * cambiar la version de wordpress en el footer del dashboard
------------------------------------------------------------------------------*/
function cambiar_footer_version() {
  return 'Version 1.0';
}
add_filter( 'update_footer', 'cambiar_footer_version', 9999 );


/*
 * login_title()
 * Cambiar texto title del logo de la pantalla de login
------------------------------------------------------------------------------*/
function login_title(){
    return get_bloginfo('name');
}
add_action("login_headertitle","login_title");


/*
 * url_img_login()
 * Redirecciona al hompage del site al hacer click en la imagen del login
------------------------------------------------------------------------------*/
function my_custom_login_url() {
	return get_site_url();
}
add_action( 'login_headerurl', 'url_img_login' );


/*
 * favicon()
 * favicon del sitio (el favicon.ico debe estar en la raiz del template)
------------------------------------------------------------------------------*/
function favicon() {
  echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . get_bloginfo ( 'template_url' ) . '/favicon.ico" />';
}
add_action ( 'wp_head', 'favicon' );


/*
 * wpb_imagelink_setup()
 * Imágenes sin enlace por defecto
------------------------------------------------------------------------------*/
function wpb_imagelink_setup() {
    $image_set = get_option( 'image_default_link_type' );
    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);


/*
 * wpfme_remove_img_ptags()
 * Quitar etiqueta <p></p> que rodea a las images
 * cuando se obtienen de the_content()
------------------------------------------------------------------------------*/
function wpfme_remove_img_ptags($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'wpfme_remove_img_ptags');


/*
 * left_admin_footer_text_output()
 * Mensaje en lado izquierdo del footer en el Dashboard
------------------------------------------------------------------------------*/
function left_admin_footer_text_output($text) {
    $text = bloginfo('name');
    return $text;
}
add_filter('admin_footer_text', 'left_admin_footer_text_output');


/*
 * failed_login
 * Cambia el mensaje de error de inicio de sesión en WordPress
------------------------------------------------------------------------------*/
add_filter('login_errors', 'failed_login');
function failed_login() {
    return 'Usuario o Contraseña Incorrectos';
}


/*
 * limpiar_head ()
 * @descripción: función que sobreescribe los elementos y
 * metadatos que se cargan por defecto en el bloque header
 * del sitio web. En este caso elimina de la carga los
 * elementos innecesarios en el caso de sitios web que no
 * funcionan como blog.
------------------------------------------------------------------------------*/
function limpiar_head () {
  remove_action ( 'wp_head', 'rsd_link' );
  remove_action ( 'wp_head', 'wp_generator' );
  remove_action ( 'wp_head', 'feed_links', 2 );
  remove_action ( 'wp_head', 'index_rel_link' );
  remove_action ( 'wp_head', 'wlwmanifest_link' );
  remove_action ( 'wp_head', 'feed_links_extra', 3 );
  remove_action ( 'wp_head', 'start_post_rel_link', 10, 0 );
  remove_action ( 'wp_head', 'parent_post_rel_link', 10, 0 );
  remove_action ( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
}
add_action ( 'init', 'limpiar_head' );
