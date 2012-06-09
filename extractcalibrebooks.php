#!/usr/bin/php
<?php
$ignoreFiles = array('metadata.opf', 'cover.jpg', '.DS_Store', 'metadata.db');

function copyFiles($calibreDirectory, $targetDirectory) {
	$iterator = new DirectoryIterator($calibreDirectory);

	foreach ($iterator as $fileinfo)
	{
		global $ignoreFiles;

		if (!$fileinfo->isDot() && $fileinfo->isDir()) 
		{
			copyFiles($fileinfo->getPathname(), $targetDirectory);
		} else if ($fileinfo->isFile() && (!in_array($fileinfo->getFilename(), $ignoreFiles)))
		{	
			echo 'COPIYNG FILE: ' . $fileinfo->getPathname() . PHP_EOL;
			copy($fileinfo->getPathname(), $targetDirectory . $fileinfo->getFilename());
		}
	}
}

function showUsage() {
	echo PHP_EOL;
	echo 'Extract Calibre Books' . PHP_EOL;
	echo 'Extracts the books from the Calibre Directory into a diferent directory.' . PHP_EOL . PHP_EOL;
	echo 'Usage:' . PHP_EOL;
	echo '   extractcalibrebooks.php [calibre directory] [target directory]' . PHP_EOL . PHP_EOL;
	echo 'Example: extractcalibrebooks.php "/users/perico/Calibre Library/" "./"' . PHP_EOL . PHP_EOL;	
	exit(1);
}




if ($argv[1] === null or $argv[2] === null) {
	showUsage();
}

$calibreDirectory = $argv[1];
$targetDirectory = $argv[2];
copyFiles($calibreDirectory, $targetDirectory);
