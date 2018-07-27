<?php
declare(strict_types=1);

/**
 * Prints an array to console where each array element is a new line
 * This method does not touch the array elements content
 *
 * @param array $arr
 */
function arrayToConsole(array $arr)
{
    echo PHP_EOL;
    foreach ($arr as $el) {
        echo $el . PHP_EOL;
    }
    echo PHP_EOL;
}


function arrayToFileAsCsv(array $arr, string $filename)
{
    $filename = FILES_DIRECTORY . $filename;
    $f        = fopen($filename, 'w');

    foreach ($arr as $entry) {
        $line = '';
        foreach ($entry as $key => $value) {
            $line .= $value;
            if (end($entry) !== $key) {
                $line .= ',';
            }
        }
        $line .= PHP_EOL;
        fputs($f, $line);
    }

    fclose($f);
}

/**
 * This method is used for properly padding the final output for console
 *
 * Returned array holds 2 sets of key => value information
 *  1. key   = the selected column names
 *     value = the corresponding max length value from the result array
 *
 *  2. key   = the selected column name's corresponding index
 *     value = the corresponding max length value from the result array
 *
 * @param array $arr
 * @return array
 */
function getPaddingForOutputColumns(array $arr): array
{
    $columnTitlesOnKeys = array_flip($arr[0]);
    $paddingValue       = []; //will hold the column title name as key and the corresponding max length value from initial arr
    foreach ($columnTitlesOnKeys as $key => $value) {
        $paddingValue[$key] = 0;
    }

    foreach ($columnTitlesOnKeys as $indexName => $indexKey) {
        foreach (array_slice($arr, 1) as $entry) {
            if ($paddingValue[$indexName] < strlen($entry[$indexKey])) {
                $paddingValue[$indexName] = strlen($entry[$indexKey]);
            }
        }
    }

    foreach ($columnTitlesOnKeys as $key => $value) {
        $paddingValue[$value] = ($paddingValue[$key] + OUTPUT_SPACING_BETWEEN_COLUMNS);
    }

    return $paddingValue;
}

/**
 * Input array must have two levels
 *
 * @param array $arr
 */
function arrayToConsoleFormatted(array $arr)
{
    $paddingValue = getPaddingForOutputColumns($arr);
    echo PHP_EOL . "========== RESULT ==========" . PHP_EOL . PHP_EOL;
    foreach ($arr as $entry) {
        foreach ($entry as $key => $value) {
            echo str_pad($value, $paddingValue[$key], ' ', STR_PAD_RIGHT);
        }
        echo PHP_EOL;
    }
    echo PHP_EOL . "============================" . PHP_EOL;
}

function arrayToConsoleAsJson(array $arr)
{
    $result = json_encode($arr, JSON_PRETTY_PRINT);
    echo PHP_EOL . $result . PHP_EOL;
}

function displayResults(array $arr, array $options)
{
    if (isset($options['output-file'])) {
        arrayToFileAsCsv($arr, $options['output-file']);
    } elseif (isset($options['output'])) {
        ($options['output'] === 'json')
            ? arrayToConsoleAsJson($arr)
            : arrayToConsoleFormatted($arr);
    } else {
        arrayToConsoleFormatted($arr);
    }
}


















