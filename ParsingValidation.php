<?php
declare(strict_types=1);

/**
 * @param array $tableStructure
 * @param string $userInput
 * @return array
 */
function validateSelectValues(array $tableStructure, string $userInput): array
{
    $errors = [];
    ($userInput === '*')
        ? $userInputAsArray = $tableStructure[0]
        : $userInputAsArray = explode(',', $userInput);

    foreach ($userInputAsArray as $column) {
        if (!in_array($column, $tableStructure[0])) {
            $errors[] = "Column '{$column}' not found. (from option --select)";
        }
    }

    return $errors;
}

/**
 * @param array $tableStructure
 * @param string $userInput
 * @return array
 */
function validateSortColumn(array $tableStructure, string $userInput): array
{
    $errors = [];
    foreach ($tableStructure[0] as $column) {
        if ($userInput === $column) {
            return [];
        }
    }
    $errors[] = "Column '{$userInput}' not found. (from option --sort-column)";

    return $errors;
}

/**
 * @param array $tableStructure
 * @param string $userInput
 * @return array
 */
function validateWhereOptions(array $tableStructure, string $userInput): array
{
    $wordPattern = '/([\w]+)/u';
    preg_match($wordPattern, $userInput, $userWhereColumn);

    $errors = [];
    foreach ($tableStructure[0] as $column) {
        if ($userWhereColumn[0] === $column) {
            return [];
        }
    }
    $errors[] = "Column '{$userWhereColumn[0]}' not found. (from option --where)";

    return $errors;
}

/**
 * @param array $tableStructure
 * @param string $userInput
 * @return array
 */
function validateUniqueColumn(array $tableStructure, string $userInput): array
{
    $errors = [];
    foreach ($tableStructure[0] as $column) {
        if ($userInput === $column) {
            return [];
        }
    }
    $errors[] = "Column '{$userInput}' not found. (from option --unique)";

    return $errors;
}

/**
 * @param array $tableStructure
 * @param array $userOptions
 * @return array
 */
function getUserValuesErrorMessages(array $tableStructure, array $userOptions): array
{
    $errors = [];
    $errors = array_merge($errors, validateSelectValues($tableStructure, $userOptions['select']));

    if (isset($userOptions['sort-column'])) {
        $errors = array_merge($errors, validateSortColumn($tableStructure, $userOptions['sort-column']));
    }
    if (isset($userOptions['unique'])) {
        $errors = array_merge($errors, validateUniqueColumn($tableStructure, $userOptions['unique']));
    }
    if (isset($userOptions['where'])) {
        $errors = array_merge($errors, validateWhereOptions($tableStructure, $userOptions['where']));
    }

    return $errors;
}
















