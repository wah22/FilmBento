<?php 

$command = 'git pull';
// Execute the shell command
$shellOutput = shell_exec($command);
   
//return execute status;
echo $shellOutput; 

echo 'Pulled,';
