<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../config/db.php');

// mysql query builder
class SelectQueryBuilder
{
    private $mysqli;
    private $table;
    private $columns;
    private $where;
    private $limit;
    private $offset;
    private $order_by;
    private $order;
    private $group_by;
    private $having;
    private $join;
    private $sql;

    public function __construct()
    {
        global $mysqli;
        $this->mysqli = $mysqli;
        $this->columns = '*';
        $this->table = '';
        $this->join = [];
        $this->where = [];
        $this->group_by = [];
        $this->having = [];
        $this->order_by = [];
        $this->limit = '';
        $this->offset = '';
        $this->sql = '';
    }

    public function SELECT(...$columns)
    {
        if (count($columns) === 0) {
            $this->columns = '*';
        } else {
            $this->columns = implode(', ', $columns);
        }
        return $this;
    }

    public function FROM($table)
    {
        $this->table = $table;
        return $this;
    }

    public function JOIN($table, $column1, $operator, $column2)
    {
        $this->join[] = [
            'table' => $table,
            'column1' => $column1,
            'operator' => $operator,
            'column2' => $column2
        ];
        return $this;
    }

    public function WHERE($column, $operator, $value)
    {
        $this->where[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    public function ORDER_BY($column, $order = 'ASC')
    {
        $this->order_by[] = [
            'column' => $column,
            'order' => $order
        ];
        return $this;
    }

    public function GROUP_BY($column)
    {
        $this->group_by = $column;
        return $this;
    }

    public function HAVING($column, $operator, $value)
    {
        $this->having = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    public function LIMIT($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function OFFSET($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function build()
    {
        $sql = 'SELECT ' . $this->columns . ' FROM ' . $this->table;
        if (count($this->join) > 0) {
            foreach ($this->join as $join) {
                $sql .= ' JOIN ' . $join['table'] . ' ON ' . $join['column1'] . ' ' . $join['operator'] . ' ' . $join['column2'];
            }
        }
        if (count($this->where) > 0) {
            $sql .= ' WHERE ';
            foreach ($this->where as $where) {
                $sql .= $where['column'] . ' ' . $where['operator'] . ' ' . $where['value'] . ' AND ';
            }
            $sql = substr($sql, 0, -5);
        }
        if (count($this->group_by) > 0) {
            $sql .= ' GROUP BY ' . $this->group_by;
        }
        if (count($this->having) > 0) {
            $sql .= ' HAVING ' . $this->having['column'] . ' ' . $this->having['operator'] . ' ' . $this->having['value'];
        }
        if (count($this->order_by) > 0) {
            $sql .= ' ORDER BY ';
            foreach ($this->order_by as $order_by) {
                $sql .= $order_by['column'] . ' ' . $order_by['order'] . ', ';
            }
            $sql = substr($sql, 0, -2);
        }
        if ($this->limit !== '') {
            $sql .= ' LIMIT ' . $this->limit;
        }
        if ($this->offset !== '') {
            $sql .= ' OFFSET ' . $this->offset;
        }
        $this->sql = $sql;
        return $this;
    }

    public function sql()
    {
        return $this->sql;
    }

    public function exec()
    {
        $this->build();
        $result = $this->mysqli->query($this->sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}