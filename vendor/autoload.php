<?php

// custom autoload class
spl_autoload_register(function ( $class_name ) {
	$class_name = ltrim( $class_name, "\\" );
	$file_name = "";
	$namespace = "";
	if ( $last_ns_pos = strrpos( $class_name, "\\" ) ) {
		$namespace = substr( $class_name, 0, $last_ns_pos );
		$class_name = substr( $class_name, $last_ns_pos + 1 );
		$file_name = str_replace( "\\", DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR;
	}
	$file_name .= str_replace( "_", DIRECTORY_SEPARATOR, $class_name ) . ".php";

	// Require file only if it exists. Else let other registered autoloaders worry about it.
	if ( file_exists( "app" . DIRECTORY_SEPARATOR . $file_name ) ) {
		require "app" . DIRECTORY_SEPARATOR . $file_name;
	} else
	if ( file_exists( "vendor" . DIRECTORY_SEPARATOR . $file_name ) ) {
		require "vendor" . DIRECTORY_SEPARATOR . $file_name;
	}
});
