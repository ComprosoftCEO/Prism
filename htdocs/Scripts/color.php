<?php
//Pick a random number 0 to 2555
function random_color_part() {
    return mt_rand( 0, 255 );
}

//Convert number to strinng hex
function int_to_hex($input) {
	return str_pad( dechex($input), 2, '0', STR_PAD_LEFT);
}

function random_color() {
	$const = 192;
	
	//Force the colors to be bright enough to see
	do {
		$c1 = random_color_part();
		$c2 = random_color_part();
		$c3 = random_color_part();
		
	} while (($c1 < $const) && ($c2 < $const) && ($c3 < $const));

    return int_to_hex($c1) . int_to_hex($c2) . int_to_hex($c3);
}

function getcolor() {
	return 'style="color: #'.random_color().';"';
	}
?>