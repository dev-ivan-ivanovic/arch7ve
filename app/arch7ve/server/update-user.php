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
    
    SELECT cUpdate INTO @vUpdate FROM t_table_access_control
    WHERE cUser='S{user}' AND cHost='S{host}' AND cTable='t_user';

    UPDATE t_user 
    SET cAuth=SHA2(CONCAT('P{user}', 'S{host}', 'P{password}'), 256),
    cSuperuser='P{type}'
    WHERE cUser='P{user}' 
    AND cHost='S{host}' 
    AND @vUpdate='Y';
    
    UPDATE t_table_access_control 
    SET cSelect='P{type}', 
    cInsert='P{type}', 
    cUpdate='P{type}', 
    cDelete='P{type}'
    WHERE cUser='P{user}' 
    AND cHost='S{host}'
    AND cTable='t_user'
    AND @vUpdate='Y';
    
    UPDATE t_table_access_control 
    SET cSelect='P{type}', 
    cInsert='P{type}', 
    cUpdate='P{type}', 
    cDelete='P{type}'
    WHERE cUser='P{user}' 
    AND cHost='S{host}'
    AND cTable='t_group' 
    AND @vUpdate='Y';
    
    UPDATE t_table_access_control 
    SET cSelect='Y', 
    cInsert='Y', 
    cUpdate='P{type}', 
    cDelete='P{type}'
    WHERE cUser='P{user}' 
    AND cHost='S{host}'
    AND cTable='t_note' 
    AND @vUpdate='Y';
    
    UPDATE t_table_access_control 
    SET cSelect='Y', 
    cInsert='Y', 
    cUpdate='P{type}', 
    cDelete='P{type}'
    WHERE cUser='P{user}' 
    AND cHost='S{host}'
    AND cTable='t_upload' 
    AND @vUpdate='Y';
    
    UPDATE t_table_access_control 
    SET cSelect='P{type}', 
    cInsert='P{type}', 
    cUpdate='P{type}', 
    cDelete='P{type}'
    WHERE cUser='P{user}' 
    AND cHost='S{host}'
    AND cTable='t_group_access_control' 
    AND @vUpdate='Y';
    
    COMMIT;
    ";

    require_once 'init.php';

    $pass = true;

    for ($i = 1; $i < (count($dataset) - 1); $i++) {
        if ($dataset[$i] < 0) {
            $pass = false;
            break;
        }
    }

    echo json_encode($pass);
?>