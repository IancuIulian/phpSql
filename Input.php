<?php
declare(strict_types=1);


function getUserOptionsCli(): array
{
    return getopt('', [
        'help',
        'select:',
        'from:',

        'sort-column:',
        'sort-mode:',
        'sort-direction:',
//        'multi-sort:',
//        'multi-sort-dir:',
        'unique:',
        'where:',

//        'aggregate-sum:',
//        'aggregate-product:',
//        'aggregate-list:',
//        'aggregate-list-glue:',

//        'uppercase-column:',
//        'lowercase-column:',
//        'titlecase-column:',
//        'power-values:',

//        'map-function:',
//        'map-function-column:',

//        'column-sort:',

        'output:',
        'output-file:',

    ]);
}



