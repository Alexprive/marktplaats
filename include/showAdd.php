<?php

class showAdd extends getAdd
{
    public function showAllAdds(){

        echo '<table class="table table-striped">
                 <thead style="background-color: #ccc; color: #000;">
                    <th>Add_ID</th>
                    <th>Categorie_ID</th>
                    <th>Titel</th>
                    <th>Omschrijving</th>
                 </thead>';

        $datas = $this->getAllAdds();

        foreach ($datas as $data){
            echo "<tr>";
            echo "<td>" . $data['add_id'] . "</td>";
            echo "<td>" . $data['category_id'] . "</td>";
            echo "<td>" . $data['titel'] . "</td>";
            echo "<td>" . $data['description'] . "</td>";
            echo "</tr>";
        }
    }
}