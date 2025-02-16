<?php
class Database {
    private static $link;
    private $host = 'fdb27.runhosting.com';
    private $db_name = '3534042_dbempresax';
    private $username = '3534042_dbempresax';
    private $password = '2010fabiojcb';
    public $conn;

    public static function getConnection() {
        if (!self::$link) {
            self::$link = new mysqli($host, $username, $password,  $db_name);
            if (self::$link->connect_error) {
                die("Connection failed: " . self::$link->connect_error);
            }
        }
        return self::$link;
    }
}
