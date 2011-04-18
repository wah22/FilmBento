<?php 

$command = 'cd /var/www/FilmBento; git pull';
// Execute the shell command
$shellOutput = shell_exec($command);
   
//return execute status;
echo $shellOutput; 

echo 'Successfully pulled testing';
