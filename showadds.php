<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, td, th {
            border: 1px solid black;
            padding: 5px;
        }

        th {text-align: left;}
    </style>
</head>
<body>
<?php

require_once "config.php";

$q = intval($_GET['q']);

$sql="SELECT * FROM adds WHERE category_id = '".$q."'";
$result = mysqli_query($link,$sql);

echo '<table class="table table-striped">
<thead style="background-color: black; color: white;">
<th>Add_ID</th>
<th>Categorie_ID</th>
<th>Titel</th>
<th>Omschrijving</th>
</thead>';

while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['add_id'] . "</td>";
    echo "<td>" . $row['category_id'] . "</td>";
    echo "<td>" . $row['titel'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($link);
?>
</body>
</html>

