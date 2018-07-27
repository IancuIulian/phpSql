<?php
declare(strict_types=1);
const CHOOSE_FUNCTION = [
    'select' => 'validateSelect',
    'from' => 'validateFrom',

    'sort-column' => 'validateSort',
    'sort-mode' => 'validateEmpty',
    'sort-direction' => 'validateEmpty',
//    'multi-sort',
//    'multi-sort-dir',
    'unique' => 'validateUnique',
    'where' => 'validateWhere',

//    'aggregate-sum',
//    'aggregate-product',
//    'aggregate-list',
//    'aggregate-list-glue',

//    'uppercase-column',
//    'lowercase-column',
//    'titlecase-column',
//    'power-values',

//    'map-function',
//    'map-function-column',

//    'column-sort',

    'output' => 'validateOutput',
    'output-file' => 'validateEmpty',
];