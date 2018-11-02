<?php


class showCategorie extends getCategorie
{
    public function showAllCategories(){

        $datas = $this->getAllCategories();
        foreach ($datas as $data){
            echo "<a href='#' class='cat-style' style='text-decoration: none;'>" . $data["category"] . "</a><br>";
        }
    }
}