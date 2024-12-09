<?php

    abstract class Connect {

        const HOST = "localhost";
        const DB = "php_authentication";
        const USER = "root";
        const PASSWORD = "";


        public static function seConnecter() {

            try {
                return new \PDO("mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASSWORD);
            } catch (\PDOException $ex) {
                return $ex->getMessage();
            }

        }

    }

?>