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

    INSERT INTO t_user 
    (cUser, cHost, cAuth, cSuperuser) 
    SELECT 'P{user}', 'S{host}', SHA2(CONCAT('P{user}', 'S{host}', 'P{password}'), 256), 'P{type}'
    FROM t_table_access_control
    WHERE cUser='S{user}' 
    AND cHost='S{host}' 
    AND cTable='t_user'
    AND cInsert='Y';
    
    INSERT INTO t_table_access_control 
    (cUser, cHost, cTable, cSelect, cInsert, cUpdate, cDelete, cDrop) 
    VALUES ('P{user}', 'S{host}', 't_user', 'P{type}', 'P{type}', 'P{type}', 'P{type}', 'N');
    
    INSERT INTO t_table_access_control 
    (cUser, cHost, cTable, cSelect, cInsert, cUpdate, cDelete, cDrop) 
    VALUES ('P{user}', 'S{host}', 't_group', 'P{type}', 'P{type}', 'P{type}', 'P{type}', 'N');
    
    INSERT INTO t_table_access_control 
    (cUser, cHost, cTable, cSelect, cInsert, cUpdate, cDelete, cDrop) 
    VALUES ('P{user}', 'S{host}', 't_note', 'Y', 'Y', 'P{type}', 'P{type}', 'N');
    
    INSERT INTO t_table_access_control 
    (cUser, cHost, cTable, cSelect, cInsert, cUpdate, cDelete, cDrop) 
    VALUES ('P{user}', 'S{host}', 't_upload', 'Y', 'Y', 'P{type}', 'P{type}', 'N');
    
    INSERT INTO t_table_access_control 
    (cUser, cHost, cTable, cSelect, cInsert, cUpdate, cDelete, cDrop) 
    VALUES ('P{user}', 'S{host}', 't_group_access_control', 'P{type}', 'P{type}', 'P{type}', 'P{type}', 'N');
    
    COMMIT;
    ";

    require_once 'init.php';

    $pass = true;

    for ($i = 1; $i < (count($dataset) - 1); $i++) {
        if ($dataset[$i] < 1) {
            $pass = false;
            break;
        }
    }

    echo json_encode($pass);
?>