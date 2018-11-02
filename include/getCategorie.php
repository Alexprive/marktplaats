<?php

class getCategorie extends Dbc
{
   protected function getAllCategories(){

       $sql = "SELECT * FROM categorys";
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