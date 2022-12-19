<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/db.php');

// mysql insert query builder

class InsertQueryBuilder
{
    private $mysqli;
    private $built;
    private $executed;
    private $table;
    private $columns;
    private $values;
    private $sql;

    public function __construct()
    {
        global $mysqli;
        $executed = false;
        $this->mysqli = $mysqli;
        $this->columns = [];
        $this->values = [];
        $this->table = '';
        $this->sql = '';
    }

    public function INSERT_INTO($table)
    {
        $this->table = $table;
        return $this;
    }

    public function COLUMNS(...$columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function VALUES(...$values)
    {
        $this->values = $values;
        return $this;
    }

    public function build()
    {
        $this->sql = "INSERT INTO $this->table (";
        $this->sql .= implode(', ', $this->columns);
        $this->sql .= ') VALUES (';
        $this->sql .= implode(', ', $this->values);
        $this->sql .= ')';
        $this->built = true;
        return $this;
    }

    public function execute()
    {
        if (!$this->built) {
            $this->build();
        }
        $this->executed = true;
        return $this->mysqli->query($this->sql);
    }
}