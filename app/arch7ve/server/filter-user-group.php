<?php
/******************************************************************************
"Arch7ve" an open-source web app for document archiving written using "co7e" the open-source web framework.
Copyright (C) 2021  Ivan Ivanovic

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
******************************************************************************/

    $query = "
    START TRANSACTION;
    
    SELECT cSelect 
    INTO @vSelect 
    FROM t_table_access_control
    WHERE cUser='S{user}' 
    AND cHost='S{host}' 
    AND cTable='t_group_access_control';

    SELECT * 
    FROM t_group_access_control 
    WHERE MATCH (cUser, cGroup) 
    AGAINST ('P{keyword}' IN BOOLEAN MODE) 
    AND cHost='S{host}'
    AND cGroupHost='S{host}'
    AND @vSelect='Y';
    
    COMMIT;
    ";
    
    require_once 'init.php';

    echo json_encode($dataset[2]);
?>