<?php

namespace Insid\Blogonslim\Persistence\Util;

use PDO;
use PDOException;

class ConnectionManager
{
    public const DBNAME = 'blog';
    private const SCHEMA = 'mysql';
    private const USERNAME = 'root';
    private const PASSWORD = '';
    private const HOST = 'localhost';
    private static ?ConnectionManager $instance = null;

    private static ?PDO $pdo;

    private function __construct()
    {
        self::open();
    }

    /**
     * Method establishes the connection of Database and stores the connection in private variable $pdo.
     */
    private static function open(): void
    {
        $connectionUrl = self::SCHEMA . ":host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=utf8mb4";

        try {
            self::$pdo = new PDO(
                $connectionUrl,
                self::USERNAME,
                self::PASSWORD
            );
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch (PDOException $error) {
            throw new PDOException('Error to connect to DataBase: Error returned:>> ' . $error->getMessage());
        }
    }

    /**
     * Singleton pattern realisation
     * @return ConnectionManager|null
     */
    public static function getInstance(): ?ConnectionManager
    {
        if (is_null(self::$instance)) {
            self::$instance = new ConnectionManager();
        }
        return self::$instance;
    }

    /**
     * Method return the connection  of Database.
     */
    public static function get(): PDO
    {
        return self::$pdo;
    }

    public function __destruct()
    {
        self::$pdo = null;
    }

    public function __wakeup()
    {
    }

    private function __clone()
    {
    }
}
