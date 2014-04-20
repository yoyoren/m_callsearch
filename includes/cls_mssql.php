<?php

/**
 * MSSQL 公用类库
 * $Author: bisc $
 * $Id: cls_mysql.php 0021 $
*/
//******************************************************************************
//实例化类
//读取包含文件
//require("\database\db.php");
//$SqlDB = new MySQLDB($db_host,$db_user,$db_pass,$db_name); 

class cls_mssql
{
    var $host; 
    var $user; 
    var $passwd; 
    var $database;
    var $conn;
    
    function __construct($host, $user, $passwd, $database)
    {
        $this->cls_mssql($host, $user, $passwd, $database);
    }
   
    function cls_mssql($host,$user,$password,$database) 
    { 
       $this->host = $host; 
       $this->user = $user; 
       $this->passwd = $password; 
       $this->database = $database;
       $this->conn = mssql_connect($this->host, $this->user,$this->passwd) or 
        die("Could not connect to $this->host");
       mssql_select_db($this->database,$this->conn) or 
        die("Could not switch to database $this->database"); 
    }    

    function query($querystr) 
    {
      $res =mssql_query($querystr, $this->conn) or 
      die("Could not query database"); 
      return $res; 
    }
 
    function affected_rows()
    {
        return mssql_affected_rows($this->conn);
    }

    function result($query, $row)
    {
        return @mssql_result($query, $row);
    }

    function num_rows($query)
    {
        return mssql_num_rows($query);
    }

    function num_fields($query)
    {
        return mssql_num_fields($query);
    }

    function free_result($query)
    {
        return mssql_free_result($query);
    }
    function fetchRow($query)
    {
        return mssql_fetch_assoc($query);
    }

    function fetch_fields($query)
    {
        return mssql_fetch_field($query);
    }


    function close()
    {
        return mssql_close($this->conn);
    }
    function getOne($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            $row = mssql_fetch_row($res);

            if ($row !== false)
            {
                return $row[0];
            }
            else
            {
                return '';
            }
        }
        else
        {
            return false;
        }
    }

    function getAll($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            $arr = array();
            while ($row = mssql_fetch_assoc($res))
            {
                $arr[] = $row;
            }

            return $arr;
        }
        else
        {
            return false;
        }
    }
    function getRow($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            return mssql_fetch_assoc($res);
        }
        else
        {
            return false;
        }
    }
    function getCol($sql)
    {
        $res = $this->query($sql);
        if ($res !== false)
        {
            $arr = array();
            while ($row = mssql_fetch_row($res))
            {
                $arr[] = $row[0];
            }

            return $arr;
        }
        else
        {
            return false;
        }
    }

    function autoExecute($table, $field_values, $mode = 'INSERT', $where = '', $querymode = '')
    {
        $field_names = $this->getCol("SELECT b.name FROM sysobjects a LEFT JOIN SYSCOLUMNS b ON a.id=b.id WHERE a.name= '" . $table ."'");
        //print_r($field_names);exit;
        $sql = '';
        if ($mode == 'INSERT')
        {
            $fields = $values = array();
            foreach ($field_names AS $value)
            {
				if (array_key_exists($value, $field_values) == true)
                {
                    $fields[] = $value;
                    $values[] = "'" . $field_values[$value] . "'";
                }
            }

            if (!empty($fields))
            {
				$sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
				                //echo $sql;exit;
            }
        }
        else
        {
            $sets = array();
            foreach ($field_names AS $value)
            {
                if (array_key_exists($value, $field_values) == true)
                {
                    $sets[] = $value . " = '" . $field_values[$value] . "'";
                }
            }

            if (!empty($sets))
            {
                $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $sets) . ' WHERE ' . $where;
            }
        }

        if ($sql)
        {
            return $this->query($sql, $querymode);
        }
        else
        {
            return false;
        }
    }
}

?>