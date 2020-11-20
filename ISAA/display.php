<?php

$conn = mysqli_connect("localhost", "root", "", "demo");
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 
$result = mysqli_query($conn,"SELECT * FROM decrypt");
?>

<!DOCTYPE html>
<html>
 <head>
 <title> Retrive data</title>
 </head>
<body>
<?php
if (mysqli_num_rows($result) > 0) {
?>
  <table>
  <tr>
    <td style="border: 3px solid">Name</td>
    <td style="border: 3px solid">dob</td>
    <td style="border: 3px solid">status</td>
    <td style="border: 3px solid">ph_no</td>
    <td style="border: 3px solid">Email id</td>
    <td style="border: 3px solid">addr</td>
    <td style="border: 3px solid">atm</td>
    <td style="border: 3px solid">adhaar</td>
    <td style="border: 3px solid">pan</td>
    <td style="border: 3px solid">dl_no</td>
  </tr>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
?>
<tr style="border: 1px solid">
    <td style="border: 1px solid"><?php echo $row["name"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["dob"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["status"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["ph_no"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["email"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["addr"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["atm"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["adhaar"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["pan"]; ?></td>
    <td style="border: 1px solid"><?php echo $row["dl_no"]; ?></td>
</tr>
<?php
$i++;
}
?>
</table>
 <?php
}
else{
    echo "No result found";
}
?>
 </body>
</html>