<?php 
		session_start();
		$rand =rand(1, 9999999)."".time();
		$_SESSION['r5'] = md5($rand);
		$_SESSION['r'] = $rand;
		header("location:bookList.php?yema=1");
?>