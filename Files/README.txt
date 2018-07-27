
================================== ABOUT ==================================

Version: 	1.0
Author: 	Iulian Iancu
Built with: 	PHP7.2.7
Release Date:	23/07/2018

===========================================================================



=============================== Description ===============================

This is a PHP application (for command line) that simulates an SQL select

===========================================================================



============================== How To Use It ==============================

- go to the directory where the app is stored
- run command 1 :   ./sql.php <options_list>
- run command 2 : php sql.php <options_list>

- use 	./sql.php --help   to see available options


Mandatory fields:
    --select   	column1,column2,...
    --from     	filename.csv

===========================================================================



============================ Available Options ============================ 

INPUT:			
    --select   	column1,column2,...
    --from     	filename.csv


OUTPUT:
    --output        	csv|json|screen      (default - screen)
    --output-file   	filename.csv    (required if --output=csv)


SORTING:
    --sort-column       column_name
    --sort-mode         natural
                        alpha
                        numeric
    --sort-direction    asc
                        desc
    --unique            column_name     (returns distinct values)


FILTERING:
    --where   	'column<>value'
    --where    	'column=value'
    --where    	'column<value'
    --where    	'column>value'

===========================================================================

For any questions or possible issues please contact me at:

	iulian.iancu@evozon.com

===========================================================================


