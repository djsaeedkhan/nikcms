<?php
use DatabaseBackup\Utility\BackupExport;
use Cake\Core\Configure;
Configure::write('DatabaseBackup.target', ROOT . DS . 'backups');
//Configure::write('DatabaseBackup.bin.bzip2', ROOT);
//Configure::write('MysqlBackup.bin.mysqldump', 'F://xampp//mysql//bin//mysqldump.exe');

$backup = new BackupExport();

//$backup->compression('gzip');
//$backup->send('mymail@example.com');
$backup->export();


?>