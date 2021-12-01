<?php

//import.php

if(!empty($_FILES['csv_file']['name']))
{
 $file_data = fopen($_FILES['csv_file']['name'], 'r');
 fgetcsv($file_data);
 while($row = fgetcsv($file_data))
 {
  $data[] = array(
   'id'  => $row[0],
   'koper'  => $row[1],
   'datum'  => $row[2],
   'product'  => $row[3],
   'vestiging'  => $row[4]
  );
 }
 echo json_encode($data);
}

?>