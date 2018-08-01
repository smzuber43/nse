<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Db {

    var $host;
    var $user;
    var $password;
    var $database;
    var $port;
    var $socket;
    var $db;
    

    function __construct($host,
            $user,
            $password,
            $database,
            $port = NULL,
            $socket = NULL) {

        $this->db = new mysqli($host, $user, $password, $database, $port, $socket);
        if ($this->db->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    function select($table,$col = array()) {
        if ($col != null && count($col) > 0) {
            $result = $this->db->query('Select ' . implode(',', $col) . ' from ' . $table);
        } else {
            $result = $this->db->query('Select * from ' . $table);
        }
        $out = array();
        /* fetch associative array */
        while ($row = $result->fetch_assoc()) {
            $out[] = $row;
        }
        
        return json_encode($out);
    }

}


