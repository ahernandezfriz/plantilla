<?php

/* 
 * generales.php
 * Recopilación de Funcionalidades generales implementadas 
 * en la gran mayoria de los proyectos
 * 
 * Nota: Esta página se debe enlazar desde el archivo functions.php 
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
function failed_login() {
    return 'Usuario y/o Contraseña Incorrectos';
}
add_filter('login_errors', 'failed_login');


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

/*
 * remover_admin_bar ()
 * @descripción: función que se encarga de eliminar de la  barra de 
 * administración, los elementos innecesarios o que no deseamos permitir que 
 * se desplieguen, para de esta forma, simplificarla a lo que se considere
 * estrictamente necesario.
------------------------------------------------------------------------------*/
function remover_admin_bar () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu ( 'new-content' );//new-content: Para eliminar el enlace que permite generar un nuevo elemento (entrada, página, usuario, etc).
    $wp_admin_bar->remove_menu ( 'search' );//search: Para eliminar la caja de búsqueda.
    $wp_admin_bar->remove_menu ( 'comments' );//comments: Para eliminar el aviso de comentarios
    $wp_admin_bar->remove_menu ( 'updates' );//updates: Para eliminar el aviso de actualizaciones
    $wp_admin_bar->remove_menu ( 'edit' );//edit: Elimina editar entrada y páginas
    $wp_admin_bar->remove_menu ( 'get-shortlink' );//get-shortlink: Proporciona un enlace corto a esa página/post
    $wp_admin_bar->remove_menu ( 'my-sites' );// my-sites: Elimina el menu my sitios, si utilizas la función multisitios de wordpress
    //$wp_admin_bar->remove_menu ( 'site-name' ); //site-name: Elimina el nombre de la web
    $wp_admin_bar->remove_menu ( 'wp-logo' );//wp-logo: Elimina el logo(y el sub Menú)
    //$wp_admin_bar->remove_menu ( 'my-account' );//my-account: Elimina los enlaces a su cuenta. El ID depende de si usted tiene Avatar habilitado o no.
    //$wp_admin_bar->remove_menu ( 'view-site' );//view-site: Elimina el sub menú que aparece al pasar el cursor sobre el nombre de la web
    $wp_admin_bar->remove_menu ( 'about' );//about: Elimina el enlace “Sobre WordPress�?
    $wp_admin_bar->remove_menu ( 'wporg' );//wporg: Elimina el enlace a wordpress.org
    $wp_admin_bar->remove_menu ( 'documentation' );//documentation: Elimina el enlace a la documentación oficial (Codex)
    $wp_admin_bar->remove_menu ( 'support-forums' );//support-forums: Elimina el enlace a los foros de ayuda
    $wp_admin_bar->remove_menu ( 'feedback' );//feedback: Elimina el enlace “Sugerencias�?
}
add_action ( 'wp_before_admin_bar_render', 'remover_admin_bar' );


/*
 * quitar_widgets_dashboard()
 * Elimina los widget del escritorio de inicio de Wordpress
------------------------------------------------------------------------------*/
function quitar_widgets_dashboard() {
    global $wp_meta_boxes;

    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}
add_action('wp_dashboard_setup', 'quitar_widgets_dashboard');


// FUNCIONES

/*

Ruta de la imagen destacada
 @param $size String thumbnail medium, large, full
------------------------------------------------------------------ */
function src_imagen_destacada($size){
	global $post;
	$imagen = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size);
	$ruta_imagen = $imagen[0];
	return $ruta_imagen;
}


/*
================================================================================
  hf_breadcrumbs()
  Funcion que permite agregar una miga de pan para una mayor usabilidad
  ayuda a ubicarse de manera rapida dentro de la navegacion del sitio
================================================================================*/
function hf_breadcrumbs(){
    global $post;
    $list_ancestors = ''; 
    $ancestors = get_post_ancestors($post->ID);

    for( $i = count( $ancestors)-1; $i>=0; $i--){
            $list_ancestors .= '<div class="miga" style="display:inline;" >
                                    <span>'.get_the_title($ancestors[$i]).'</span>
                                </div>&nbsp;/&nbsp;&nbsp;&nbsp;';
    }

    $list_ancestors .= '<span class="miga-activa">'.get_the_title($ancestors[$i]).'</span>';
    echo '<div class="cont-miga">';
    echo '<div class="miga" style="display:inline;" ><a href="' . home_url() . '">';
    echo '<span >' . _e('Inicio','arielhf') . '</span></a></div>&nbsp;/&nbsp;' . $list_ancestors; 
    echo '</div>';
}


/*
================================================================================
  extracto()
  función que permite una configuración personalizada para los extractos 
  en los artículos, limitando la cantidad de palabras que se despliegan.
================================================================================*/
function extracto ( $longitud ) {
  $excerpt = get_the_excerpt (); 
    $words = explode ( ' ', $excerpt, ( $longitud + 1 ) );
    if ( count ( $words ) > $longitud ) : array_pop ( $words ); endif;
    return implode ( ' ', $words );
}



/*
================================================================================
  titulo_corto()
  Corta los titulos de las entradas a la cantidad de palabras que se le indique
================================================================================*/
function titulo_corto( $length) {
  $mytitle = explode(' ', get_the_title(), $length);
    if (count($mytitle) >= $length) {
        array_pop($mytitle);
        $mytitle = implode(" ",$mytitle);
    } else {
        $mytitle = implode(" ",$mytitle);
    }
    return $mytitle;
}
