#! /usr/bin/env php
<?php
declare(strict_types=1);
/* This is the   index.php   file */

require_once 'CONSTANTS.php';
require_once 'Input.php';
require_once 'InputValidation.php';
require_once 'Parsing.php';
require_once 'Output.php';
require_once 'config.php';
require_once 'ParsingValidation.php';
require_once 'OutputComputing.php';
require_once 'DataTransforming.php';
require_once 'DataReducing.php';


$options = getUserOptionsCli();

$errors = getUserInputErrorMessages($options);
if (!empty($errors)) { arrayToConsole($errors);  die(); }

$tableStructure = fileToTableStructure($options['from']);

$errors = getUserValuesErrorMessages($tableStructure, $options);
if (!empty($errors)) { arrayToConsole($errors);  die(); }

if (isset($options['unique'])) {
    $tableStructure = removeDuplicates($tableStructure, $options['unique']);
}
if (isset($options['where'])) {
    $tableStructure = filterByWhere($tableStructure, $options['where']);
}
if (isset($options['sort-column'])) {
    $tableStructure = sortByColumn($tableStructure, $options);
}

$resultArray = getSearchedValues($options['select'], $tableStructure);
displayResults($resultArray, $options);




