<?php
	$new_login = $_POST["new_login"];
	$new_password = $_POST["new_password"];
	$user_key = $_POST["user_key"];
	
	$dbconn = pg_connect("host=localhost port=5432 dbname=comicsdb user=postgres password=qwerty1245");
	if (!$dbconn) {
		echo "Произошла ошибка.\n";
		exit;
	}
	
	$login_query = pg_query($dbconn, "SELECT * FROM users
	WHERE nickname='" . $new_login . "'");
	$login_result = pg_fetch_row($login_query);
	
	if (!$login_result) {
		update_db($dbconn, $new_login, $new_password, $user_key);
	} else {
		echo "Данный логин уже занят";
	}
	
	function update_db($dbc, $nl, $np, $uk) {
		if ($nl) {
			$result = pg_query($dbc, "UPDATE users
			SET nickname = '" . $nl . "' 
			WHERE user_key = '" . $uk . "'");
			$row = pg_fetch_row($result);
		}
		
		if ($np) {
			$result = pg_query($dbc, "UPDATE users
			SET password = '" . $np . "' 
			WHERE user_key = '" . $uk . "'");
			$row = pg_fetch_row($result);
		}
		
		header('Location: authorization.html');
	}
?>