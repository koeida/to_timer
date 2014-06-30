<?php
	require '/inc/Mustache.php';
	require '/inc/functional/_import.php';
	use Functional as F;

	$login = function() {
		if(isset($_POST['username'])) {
			$res = sqlSelect("select * from users where name = '".$_POST['username']."'");
			if(count($res) > 0) {
				$pwd = $res[0]['password'];
				if($pwd == $_POST['password']) {
					$_SESSION['uid'] = $res[0]['id'];
				}
			}
		} 
	};

	function renderTemplate($file,$data) {
		$m = new Mustache_Engine(array("escape" => function($v){return $v;}));
		$template = html_entity_decode(file_get_contents($file));
		echo $m->render($template,$data);
	}

	function renderTemplateNE($file,$data) {
		$m = new Mustache_Engine;
		$template = html_entity_decode(file_get_contents($file));
		return $m->render($template,$data);
	}

	require '/inc/required.php';

	if(!isset($_SESSION['uid'])) {
		renderTemplate("templates/login.html",array());
	} else {
		renderTemplate("templates/main.html",array());
	}
?>
