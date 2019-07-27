<?php
    require('php/conectarBanco.php');

	function getRemoteAddr()
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && (!isset($_SERVER['REMOTE_ADDR']) || preg_match('/^127\..*/i', trim($_SERVER['REMOTE_ADDR'])) || preg_match('/^172\.16.*/i', trim($_SERVER['REMOTE_ADDR'])) || preg_match('/^192\.168\.*/i', trim($_SERVER['REMOTE_ADDR'])) || preg_match('/^10\..*/i', trim($_SERVER['REMOTE_ADDR'])))) {
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
				$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				return $ips[0];
			} else
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $_SERVER['REMOTE_ADDR'];
    }
    
    $ip = getRemoteAddr();

    $consulta = mysqli_query($mysqli, "SELECT * FROM ips_blocked WHERE ip='$ip'");
    $linhas = mysqli_num_rows($consulta);

    if($linhas == 1) {
        $blacklistStatus = true;
    } else {
        $blacklistStatus = false;
    }
?>
<html>
    <head>
        <title>Index page</title>
    </head>
    <body>
        <?php if($blacklistStatus == false):?>
        <center><h1>Você não está na blacklist.</h1></center>
        <?php else:?>
        <center><h1>Você está na blacklist.</h1></center>
        <?php endif;?>
    </body>
</html>