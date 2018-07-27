<?php
declare(strict_types=1);


/**
 * Returns the $val corresponding key from $arr
 *
 * @param array $arr
 * @param string $val
 * @return int
 */
function getKeyByValue(array $arr, string $val): int
{
    foreach ($arr as $k => $el) {
        if ($el === $val) {
            return $k;
        }
    }

    return -1;
}

/**
 * @param string $userInput
 * @param array $tableStructure
 * @return array
 */
function getSearchedValues(string $userInput, array $tableStructure): array
{
    $returnArray = [];
    ($userInput === '*')
        ? $userInputAsArray = $tableStructure[0]
        : $userInputAsArray = explode(',', $userInput);
    $returnArray[] = $userInputAsArray;

    foreach (array_slice($tableStructure, 1) as $tableEntry) {
        //because $tableStructure[0] holds the column titles

        $resultEntry = [];
        foreach ($userInputAsArray as $userSelectColumn) {
            $corespondingKey = getKeyByValue($tableStructure[0], $userSelectColumn);
            $resultEntry[]   = $tableEntry[$corespondingKey];
        }
        $returnArray[] = $resultEntry;
    }

    return $returnArray;
}





