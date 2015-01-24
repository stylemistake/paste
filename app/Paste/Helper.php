<?php

namespace Paste;

class Helper {

	// generate random string for uids
	public static function getRandString( $length = 6 ) {
		$ch = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$ch_len = strlen( $ch );
		$out = "";
		for ( $i = 0; $i < $length; $i += 1 ) {
			$out .= $ch[ mt_rand( 0, $ch_len - 1 ) ];
		}
		return $out;
	}

}
