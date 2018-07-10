<?php

/* This controller renders the home page */

class HomeController{
	public function handleRequest(){
		
		// Select all the categories:
		$content = Category::find();
		
		render('home',array(
			'title'		=> 'Cotizador M&U Servicios Generales Ltda.',
			'content'	=> $content
		));
	}
}

?>