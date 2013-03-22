<?php
function parseTemplate($address){
	$adress_fields = explode("\n", $address);
	$main_address = implode ("\\\\\n", $adress_fields);
	
	$file = file_get_contents("letter-template.tex");
	$parsed = str_replace("%%ADDRESS%%", $main_address ,$file);
	if(file_put_contents("letter-tmp.tex", $parsed) === false){
		return false;
	}
	
	return "letter-tmp.tex";
}

function createLetter($address){
	$file = parseTemplate($address);
	if($file === false){
		echo "Sorry, there's been a failure\n";
		return;
	}
	shell_exec(("cat {$file} | /usr/local/bin/mate -at tex -m 'Letter.tex'"));
	shell_exec("rm {$file}");
	echo "Write Letter!";
}
