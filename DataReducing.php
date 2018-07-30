<?php
declare(strict_types=1);

/**
 * Input array must have two levels
 *      - level 1 key types: int
 *      - level 2 key types: int
 *
 * @param array $arr
 * @param string $userInput
 * @return array
 */
function removeDuplicates(array $arr, string $userInput): array
{
    $columnKey = extractHeaderKey($arr, $userInput);

    $occurrences = [];
    return array_filter($arr, function (array $row) use (&$occurrences, $columnKey) {
        if (!array_search($row[$columnKey], $occurrences)) {
            $occurrences[] = $row[$columnKey];
            return true;
        }

        return false;
    });
}

/**
 * @param array $arr
 * @param string $userInput
 * @return array
 */
function filterByWhere(array $arr, string $userInput): array
{
    preg_match('/(<>|>|<|=)/u', $userInput, $match);
    $userWhereSymbol = $match[0];

    list($userWhereColumn, $userWhereValue) = explode($userWhereSymbol, $userInput);

    $columnKey = extractHeaderKey($arr, $userWhereColumn);

    $resultArray[0] = $arr[0];
    foreach ($arr as $entryKey => $entry) {
        if ($entryKey === 0) {
            continue;
        }
        foreach ($entry as $key => $value) {
            if ($userWhereSymbol === '>') {
                if ($entry[$columnKey] > $userWhereValue) {
                    $resultArray[] = $arr[$entryKey];
                    break;
                }
            }
            if ($userWhereSymbol === '<') {
                if ($entry[$columnKey] < $userWhereValue) {
                    $resultArray[] = $arr[$entryKey];
                    break;
                }
            }
            if ($userWhereSymbol === '=') {
                if ($entry[$columnKey] === $userWhereValue) {
                    $resultArray[] = $arr[$entryKey];
                    break;
                }
            }
            if ($userWhereSymbol === '<>') {
                if ($entry[$columnKey] !== $userWhereValue) {
                    $resultArray[] = $arr[$entryKey];
                    break;
                }
            }
        }
    }

    return $resultArray;
}

/**
 * @param array $arr
 * @param $column
 * @return int|string
 */
function extractHeaderKey(array $arr, $column)
{
    $columnKey = ''; //holds the working column corresponding key, used for parsing the arrays from level 2
    foreach ($arr[0] as $key => $value) {
        if ($column === $value) {
            $columnKey = $key;
        }
    }
    return $columnKey;
}
