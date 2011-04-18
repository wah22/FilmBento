<?php 

$command = 'git pull';
// Execute the shell command
$shellOutput = shell_exec($command.' > /dev/null; echo $?');
   
//return execute status;
echo trim($shellOutput); 
