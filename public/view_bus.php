<?php
include 'db.php';

$district = $_GET['district'];
$type = $_GET['type'];

$q = "
SELECT b.bus_no, d.district_name, t.type_name
FROM buses b
JOIN districts d ON b.district_id = d.id
JOIN bus_types t ON b.bus_type_id = t.id
WHERE b.district_id = $district AND b.bus_type_id = $type
";

$r = mysqli_query($conn, $q);
?>

<h2>Bus List</h2>

<table border="1">
<tr>
    <th>Bus No</th>
    <th>District</th>
    <th>Type</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($r)) { ?>
<tr>
    <td><?= $row['bus_no'] ?></td>
    <td><?= $row['district_name'] ?></td>
    <td><?= $row['type_name'] ?></td>
</tr>
<?php } ?>
</table>
