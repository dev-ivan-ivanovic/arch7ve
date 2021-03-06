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
    SELECT cUser, cHost 
    FROM t_user 
    WHERE cAuth=SHA2(CONCAT('P{user}', 'P{host}', 'P{password}'), 256);
    ";

    require_once 'init.php';

    session_unset();

    if (isset($dataset[0][0]['cUser'])) {
        $_SESSION['user'] = $dataset[0][0]['cUser'];
        $_SESSION['host'] = $dataset[0][0]['cHost'];
        echo json_encode(true);
        exit;
    }

    echo json_encode(false);
?>