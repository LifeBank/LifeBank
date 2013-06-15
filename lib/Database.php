<?php

/**
 * @package Database
 * @author
 */
class Database
{
    private static $_connection;

    /**
     * Connects to a database
     *
     * @param string $host Host
     * @param string $user Username
     * @param string $pass Password
     * @param string $database Database name
     *
     * @return mysqli
     */
    public static function connect($host, $user, $pass, $database)
    {
        self::$_connection = false;

        if (!self::$_connection = mysqli_connect($host, $user, $pass, $database)) {
            exit(mysqli_connect_error());
        }

        return self::$_connection;
    }

    /**
     * Executes a sql query
     *
     * @param string $sql
     *
     * @return bool|mysqli_result
     * @throws RuntimeException
     */
    public static function query($sql)
    {
        if(!$query = mysqli_query(self::$_connection, $sql)) {
            throw new RuntimeException(sprintf(
                "Query Error: %s",
                self::error()
            ));
        }

        return $query;
    }

    /**
     * Fetches rows from an sql query command
     * <code>
     *  $rows = Database::fetchRows("SELECT * FROM users");
     *
     *  // Output:
     *  array(
     *      0 => array(
     *          ....
     *      )
     *  )
     * </code>
     *
     * @param string $sql
     *
     * @return array
     */
    public static function fetchRows($sql)
    {
        $query = self::query($sql);
        $rows = array();

        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Fetches a single row from a sql query
     *
     * @param string $sql
     *
     * @return array|null
     */
    public static function fetchRow($sql)
    {
        $query = self::query($sql);
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

        return $result ? $result : array();
    }

    /**
     * Gets the number of rows for a sql SELECT command
     *
     * @param string $sql
     *
     * @return int
     */
    public static function count($sql)
    {
        $query = self::query($sql);

        return mysqli_num_rows($query);
    }

    /**
     * Inserts Data into database
     * <code>
     *  Database::insert('users', array(
     *      'username' => 'morrelinko',
     *      'email' => 'morrelinko@gmail.com'
     *  ));
     * </code>
     *
     * @param string $table Table name
     * @param $insertData Data to insert
     * @param bool $escape Escape inserted data
     *
     * @return bool|int|string
     */
    public static function insert($table, $insertData, $escape = true)
    {
        if (!is_array($insertData)) {
            return false;
        }

        $sql = "INSERT INTO " . $table . " ";

        $cnt = 0;
        $fields = null;
        $values = null;

        foreach ($insertData as $field => $value) {
            $cnt++;
            $fields .= $field . (($cnt == count($insertData)) ? "" : ", ");
            $values .= "'" . ($escape ? self::escape($value) : $value) . "'" . (($cnt == count($insertData)) ? "" : ", ");
        }

        $sql .= "(" . $fields . ") VALUES (" . $values . ")";

        self::query($sql);

        return mysqli_insert_id(self::$_connection);
    }

    /**
     * Updates a record in the database
     *
     * <code>
     *  Database::update('users', array(
     *      'username' => 'morrelinko',
     *      'email' => 'morrelinko@gmail.com'
     *  ));
     * </code>
     *
     * @param string $table Table name
     * @param array $updateData
     * @param string $condition
     * @param bool $escape Escape inserted data
     *
     * @return bool|int|string
     */
    public static function update($table, $updateData = array(), $condition, $escape = true)
    {
        if(!is_array($updateData))
        {
            return false;
        }

        $sets = '';

        foreach($updateData as $field => $value)
        {
            if (strtolower($value) == 'now()') {
                $sets .= "" . $field . " = NOW(), ";
            }
            else if (strtolower($value) == 'null') {
                $sets .= "" . $field . " = NULL, ";
            }
            else if (preg_match('/^inc\((\-?\d+)\)$/i', $value, $match)) {
                $sets .= "" . $field . " = " . $field . " + " . $match[1] . ", ";
            }
            else {
                if ($escape) {
                    $sets .= "" . $field . " = '" . self::escape($value) . "', ";
                }
                else {
                    $sets .= "" . $field . " = '" . $value . "', ";
                }
            }
        }

        $sets[strlen($sets)-2] = '  ';

        $sql = "UPDATE " . $table . " SET " . $sets . " WHERE " . $condition;

        self::query($sql);

        return mysqli_affected_rows(self::$_connection);
    }

    /**
     * Escapes a value
     *
     * @param string $value
     *
     * @return string
     */
    public static function escape($value)
    {
        return mysqli_real_escape_string(self::$_connection, $value);
    }

    /**
     * Returns last sql error
     *
     * @return string
     */
    public static function error()
    {
        return mysqli_error(self::$_connection);
    }

    /**
     * Closes connection
     */
    public static function close()
    {
        if (is_resource(self::$_connection)) {
            mysqli_close(self::$_connection);
        }
    }

    /**
     * PHP Magic __destruct();
     */
    public function __destruct()
    {
        self::close();
    }
}