<?php
declare(strict_types=1);


/**
 * @param array $options
 * @return array
 */
function validateSelect(array $options): array
{
    if (!isset($options['select'])) {
        return ['Missing  --select  option. Format: --select column1,column2,...'];
    }

    if ($options['select'] === '*') {
        return [];
    }

    $pattern = '/[^\w,]/u';
    if (preg_match($pattern, $options['select'])) {
        return ['Invalid format for option  --select. Format: --select column1,column2,...'];
    }

    return [];
}

/**
 * --from parameters accepts a valid .csv file
 *      -> does not accept filename that begins with digits. To modify this, check $pattern inside this function
 *
 * @param array $options
 * @return array
 */
function validateFrom(array $options): array
{
    if (!isset($options['from'])) {
        return ['Missing  --from  option. Format: --from filename' . FILE_EXTENSION];
    }

    if (substr($options['from'], -4) !== FILE_EXTENSION) {
        return ['Invalid format: --from  option requires a valid ' . FILE_EXTENSION . ' file'];
    }

    $pattern = '/([a-z\d*?A-Z\d*?\-_]*\\' . FILE_EXTENSION . '$)/u';
    preg_match($pattern, $options['from'], $matches);
    if ($matches[0] !== $options['from']) {
        return ['Invalid format for option  --from. Format: --from filename' . FILE_EXTENSION];
    }
    if (!file_exists(FILES_DIRECTORY . $options['from'])) {
        return ["File '{$options['from']}' not found. Try moving your file into /Files directory"];
    }

    return [];
}

/**
 * @param array $options
 * @return array
 */
function validateSort(array $options): array
{
    if (!isset($options['sort-column']) && !isset($options['sort-mode']) && !isset($options['sort-direction'])) {
        return [];
    }

    if (!isset($options['sort-column']) || !isset($options['sort-mode']) || !isset($options['sort-direction'])) {
        return ['Sorting option requires each of the following to be specified:' . PHP_EOL
            . '     --sort-column     column_name' . PHP_EOL
            . '     --sort-mode       natural|alpha|numeric' . PHP_EOL
            . '     --sort-direction  asc|desc'
        ];

    }

    $errors  = [];
    preg_match('/[\w]+/u', $options['sort-column'], $matches);
    if ($matches[0] !== $options['sort-column']) {
        $errors[] = 'Invalid format for option  --sort-column. Format: --sort-column column_name';
    }
    if ($options['sort-mode'] !== 'natural' && $options['sort-mode'] !== 'alpha' && $options['sort-mode'] !== 'numeric') {
        $errors[] = 'Invalid format for option  --sort-mode. Format: --sort-mode natural|alpha|numeric';
    }
    if ($options['sort-direction'] !== 'asc' && $options['sort-direction'] !== 'desc') {
        $errors[] = 'Invalid format for option  --sort-direction. Format: --sort-direction asc|desc';
    }

    return $errors;
}

/**
 * @param array $options
 * @return array
 */
function validateUnique(array $options): array
{
    if (!isset($options['unique'])) {
        return [];
    }

    preg_match('/[\w]+/u', $options['unique'], $matches);
    if ($matches[0] !== $options['unique']) {
        return ['Invalid format for option  --unique. Format: --unique column_name'];
    }

    return [];
}

function validateWhere(array $options): array
{
    if (!isset($options['where'])) {
        return [];
    }

    preg_match_all('/([\w]+)/u', $options['where'], $wordMatches);
    preg_match_all('/(<>|>|<|=)/u', $options['where'], $symbolMatches);
    if ((count($wordMatches[0]) !== 2) || (count($symbolMatches[0]) !== 1)) {
        return ['Invalid format for option  --where. Available options:' . PHP_EOL
            . '     --where     \'column<>value\'' . PHP_EOL
            . '     --where     \'column=value\'' . PHP_EOL
            . '     --where     \'column<value\'' . PHP_EOL
            . '     --where     \'column>value\'' . PHP_EOL
        ];
    }

    return [];
}

/**
 * Validates the input option "output"
 *
 * @param array $options
 * @return array
 */
function validateOutput(array $options): array
{
    if (!isset($options['output'])) {
        return [];
    }

    if ($options['output'] !== 'csv' && $options['output'] !== 'screen' && $options['output'] !== 'json') {
        return ['Invalid format for option --output. Format: --output csv|json|screen   (default - screen)'];
    }

    if ($options['output'] == 'csv' && !isset($options['output-file'])) {
        return ['Missing  --output-file  option. Format: --output-file filename' . FILE_EXTENSION];
    }

    if (isset($options['output-file'])) {
        if (substr($options['output-file'], -4) !== FILE_EXTENSION) {
            return ['Invalid format: --from  option requires a valid ' . FILE_EXTENSION . ' file'];
        }

        $pattern = '/([a-z\d*?A-Z\d*?\-_]*\\' . FILE_EXTENSION . '$)/u';
        preg_match($pattern, $options['from'], $matches);
        if ($matches[0] !== $options['from']) {
            return ['Invalid format for option  --output-file. Format: --output-file filename' . FILE_EXTENSION];
        }
    }

    return [];
}

/**
 * DO NOT REMOVE THIS FUNCTION
 *
 * This empty function must be present due to the function selector strategy used for validations
 *
 * @return array
 */
function validateEmpty(): array
{
    return [];
}

/**
 * @param array $userOptions
 * @param callable $stringValueValidator
 * @return mixed
 */
function optionValidator(array $userOptions, callable $stringValueValidator)
{
    return $stringValueValidator($userOptions);
}

/**
 * @param array $userOptions
 * @return array
 */
function getUserInputErrorMessages(array $userOptions): array
{
    if (isset($userOptions['help'])) {
        return helpMessages(HELP_FILE);
    }

    $errors = [];
    foreach (AVAILABLE_OPTIONS as $currentOption) {
        $errors = array_merge($errors, optionValidator($userOptions, CHOOSE_FUNCTION[$currentOption]));
    }

    if (empty($userOptions)) {
        $errors[] = PHP_EOL . 'Use     --help     for all available options.';
    }

    return $errors;
}












