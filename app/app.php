<?php

use \Paste\Paste;
use \Paste\PasteException;
use \Exception;


// --------------------------------------------------------
//  Routes
// --------------------------------------------------------

// Show paste form
$app->get( "/", function () use ( $app ) {
	$app->render( "paste_form.phtml", array(
		"syntax_default" => \Paste\Paste::$config["syntax_default"],
		"syntax_list"    => \Paste\Paste::$config["syntax_list"],
	));
});

// Save paste
$app->post( "/", function () use ( $app ) {
	$syntax = $app->request->post( "syntax" );
	$text   = $app->request->post( "text" );

	if ( strlen( $text ) < 2 ) {
		$app->redirect( "/" );
		return true;
	}

	try {
		$paste = Paste::create( $text, $syntax );
		$paste->save();
	} catch ( Exception $e ) {
		$app->redirect( "/" );
		return true;
	}

	$app->redirect( "/" . $paste->uid );
	return true;
});

// Show paste
$app->get( "/:uid", function ( $uid ) use ( $app ) {
	$paste = new Paste( $uid );
	try {
		$paste->load();
	} catch ( Exception $e ) {
		$app->redirect( "/" );
		return true;
	}
	$app->render( "paste_show.phtml", array(
		"uid"    => $paste->uid,
		"text"   => $paste->text,
		"syntax" => $paste->syntax,
	));
});


// --------------------------------------------------------
//  Execution
// --------------------------------------------------------

$app->run();
