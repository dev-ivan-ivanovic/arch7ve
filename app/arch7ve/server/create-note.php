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

    define('RELATIVE_UPLOAD_PATH', '../uploads/');
    define('ABSOLUTE_UPLOAD_PATH', 'http://localhost/app/arch7ve/uploads/');

    require_once '../../co7e/upload.php';

    $query = "
    START TRANSACTION;

    INSERT INTO t_note 
    (cText, cUser, cHost, cGroup, cGroupHost, cBatch) 
    SELECT 'P{note}', 'S{user}', 'S{host}', 'P{group}', 'S{host}', 'S{batch}'
    FROM t_group_access_control
    WHERE cUser='S{user}' 
    AND cHost='S{host}' 
    AND cGroup='P{group}' 
    AND cGroupHost='S{host}'
    AND cInsert='Y';
    
    {$_SESSION['upload']}

    COMMIT;";

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