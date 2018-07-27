<?php
declare(strict_types=1);


/**
 * Directory for file set in FILES_DIRECTORY
 * Returns an array with the unchanged file lines
 *
 * @param string $filename
 * @return array
 */
function fileToArray(string $filename): array
{
    $returnArr = [];
    $filename  = FILES_DIRECTORY . $filename;
    $f         = fopen($filename, 'r');
    while ($line = fgets($f)) {
        $line        = trim($line, "\n\r");
        $returnArr[] = $line;
    }
    fclose($f);

    return $returnArr;
}

/**
 * @param string $helpFile
 * @return array
 */
function helpMessages(string $helpFile): array
{
    return fileToArray($helpFile);
}

/**
 * @param string $filename
 * @return array
 */
function fileToTableStructure(string $filename): array
{
    $returnArray = fileToArray($filename);
    foreach ($returnArray as $key => $line) {
        $returnArray[$key] = explode(',', $line);
    }

    return $returnArray;
}

















