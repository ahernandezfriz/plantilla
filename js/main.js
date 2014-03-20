jQuery(function($){
    alert('hola');

/*
 * Quita el atributo href de los enlaces
 * cuyo li es padre de un ul	
------------------------------------------------------------------------------*/
    $('.menu li').has('ul.children').css('cursor', 'pointer');
    $('.menu li').has('ul').children("a").removeAttr('href'); 
});


