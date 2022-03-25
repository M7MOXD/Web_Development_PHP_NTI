<?php
class DB
{
    public $server = "localhost";
    public $dbUser = "root";
    public $dbPassword = "";
    public $dbName = "test";
    public $con;
    public function __construct()
    {
        $this->con = mysqli_connect($this->server, $this->dbUser, $this->dbPassword, $this->dbName);
        if (!$this->con) {
            die('Error ' . mysqli_connect_error());
        }
    }
    public function runQuery($sql)
    {
        return mysqli_query($this->con, $sql);
    }
    public function __destruct()
    {
        mysqli_close($this->con);
    }
}
?>