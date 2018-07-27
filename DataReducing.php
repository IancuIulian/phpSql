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
    $columnKey = $arr[0][0]; //holds the working column corresponding key, used for parsing the arrays from level 2
    foreach ($arr[0] as $key => $value) {
        if ($userInput === $value) {
            $columnKey = $key;
        }
    }

    $distinctValuesArray = [];
    foreach ($arr as $key => $value) {
        $distinctValuesArray[] = $arr[$key][$columnKey];
    }
    $distinctValuesArray = array_unique($distinctValuesArray);

    $resultArray = [];
    foreach ($distinctValuesArray as $key => $columnValue) {
        $foundFirstAppearance = false;
        foreach ($arr as $entryKey => $v) {
            if ($arr[$entryKey][$columnKey] === $columnValue) {
                $resultArray[]        = $arr[$entryKey];
                $foundFirstAppearance = true;
            }
            if ($foundFirstAppearance) {
                break;
            }
        }
    }

    return $resultArray;
}

/**
 * @param array $arr
 * @param string $userInput
 * @return array
 */
function filterByWhere(array $arr, string $userInput): array
{
    $wordPattern = '/([\w]+)/u';
    preg_match($wordPattern, $userInput, $match);
    $userWhereColumn = $match[0];

    $symbolPattern = '/(<>|>|<|=)/u';
    preg_match($symbolPattern, $userInput, $match);
    $userWhereSymbol = $match[0];

    $userWhereValue = substr($userInput, strpos($userInput, $userWhereSymbol) + strlen($userWhereSymbol));

    $columnKey = $arr[0][0]; //holds the working column corresponding key, used for parsing the arrays from level 2
    foreach ($arr[0] as $key => $value) {
        if ($userWhereColumn === $value) {
            $columnKey = $key;
        }
    }

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
