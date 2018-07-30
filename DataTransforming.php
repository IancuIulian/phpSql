<?php
declare(strict_types=1);


/**
 * Input array must have two levels
 *      -level 1 keys type: int
 *      -level 2 keys type: int
 *
 * Used algorithm: Selection Sort
 *
 * @param array $arr
 * @param int $key
 * @return array
 */
function sortNatural(array $arr, int $key, string $direction): array
{
    for ($i = 1, $length = count($arr); $i < $length - 1; $i++) {
        $minIndex = $i;
        for ($j = $i + 1; $j < $length; $j++) {
            if ($direction === 'asc') {
                if (strnatcmp((string)$arr[$j][$key], (string)$arr[$minIndex][$key]) <= 0) {
                    $minIndex = $j;
                }
            } else if ($direction === 'desc') {
                if (strnatcmp((string)$arr[$j][$key], (string)$arr[$minIndex][$key]) > 0) {
                    $minIndex = $j;
                }
            }
        }
        if ($minIndex != $i) {
            $temp           = $arr[$i];
            $arr[$i]        = $arr[$minIndex];
            $arr[$minIndex] = $temp;
        }
    }

    return $arr;
}

/**
 * Input array must have two levels
 *      -level 1 keys type: int
 *      -level 2 keys type: int
 *
 * Used algorithm: Selection Sort
 *
 * @param array $arr
 * @param int $key
 * @param string $direction
 * @return array
 */
function sortAlpha(array $arr, int $key, string $direction): array
{
    $minIndex = 0;
    $temp     = 0;
    for ($i = 1, $length = count($arr); $i < $length - 1; $i++) {
        $minIndex = $i;
        for ($j = $i + 1; $j < $length; $j++) {
            if ($direction === 'asc') {
                if (strcmp((string)$arr[$j][$key], (string)$arr[$minIndex][$key]) <= 0) {
                    $minIndex = $j;
                }
            } else if ($direction === 'desc') {
                if (strcmp((string)$arr[$j][$key], (string)$arr[$minIndex][$key]) > 0) {
                    $minIndex = $j;
                }
            }
        }
        if ($minIndex != $i) {
            $temp           = $arr[$i];
            $arr[$i]        = $arr[$minIndex];
            $arr[$minIndex] = $temp;
        }
    }

    return $arr;
}


/**
 * Input array must have two levels
 *      -level 1 keys type: int
 *      -level 2 keys type: int
 *
 * Used algorithm: Selection Sort
 *
 * @param array $arr
 * @param int $key
 * @param string $direction
 * @return array
 */
function sortNumeric(array $arr, int $key, string $direction): array
{
    $minIndex = 0;
    $temp     = 0;
    for ($i = 1, $length = count($arr); $i < $length - 1; $i++) {
        $minIndex = $i;
        for ($j = $i + 1; $j < $length; $j++) {
            if ($direction === 'asc') {
                if ($arr[$j][$key] < $arr[$minIndex][$key]) {
                    $minIndex = $j;
                }
            } else if ($direction === 'desc') {
                if ($arr[$j][$key] > $arr[$minIndex][$key]) {
                    $minIndex = $j;
                }
            }
        }
        if ($minIndex != $i) {
            $temp           = $arr[$i];
            $arr[$i]        = $arr[$minIndex];
            $arr[$minIndex] = $temp;
        }
    }

    return $arr;
}

/**
 * Input array must have two levels
 *      - level 1 key types: int
 *      - level 2 key types: int
 *
 * @param array $arr
 * @param array $userOptions
 * @return array
 */
function sortByColumn(array $arr, array $userOptions): array
{
    $column    = $userOptions['sort-column'];
    $mode      = $userOptions['sort-mode'];
    $direction = $userOptions['sort-direction'];


    $columnKey = extractHeaderKey($arr, $column);

    if ($mode === 'natural') {
        $arr = sortNatural($arr, $columnKey, $direction);
    } else if ($mode === 'alpha') {
        $arr = sortAlpha($arr, $columnKey, $direction);
    } else if ($mode === 'numeric') {
        $arr = sortNumeric($arr, $columnKey, $direction);
    }


    return $arr;
}



