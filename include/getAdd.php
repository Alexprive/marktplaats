<?php

class getAdd extends Dbc
{
    protected function getAllAdds(){

        $sql = "SELECT * FROM Adds";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            while ($row =  $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
    }
}