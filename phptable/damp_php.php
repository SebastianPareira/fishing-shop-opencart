<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>products</title>
</head>
<body>
	
<?php

$host = 'localhost'; // адрес сервера 
$database = 'ivancotv_shopfe6'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль
$out = '';
	
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
 
// выполняем операции с базой данных
     

$query ="SELECT * FROM oc_product";
$result_all = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

$n = mysqli_num_rows($result_all);

/*echo $n;*/
	echo "<table> <tbody>";

for ($i=0; $i < $n; $i++) { 
	$row_all = mysqli_fetch_row($result_all);
	$id = $row_all[0];
	$query_name ="SELECT name FROM oc_product_description WHERE product_id = $id";
    $result_name = mysqli_query($link, $query_name) or die("Ошибка " . mysqli_error($link));
    $row_name = mysqli_fetch_row($result_name);

        echo "<tr>
            <td> <img src='../image/cache/$row_all[11]' alt='' style='width:100px;'> </td>
            <td>$row_all[0]</td>
            <td>$row_all[1]</td>
            <td>$row_name[0]</td>
            </tr>";





}


echo "</tbody> </table>";





/*$query_all ="SELECT * FROM `oc_product`";
$result_all = mysqli_query($link, $query_all)->fetch_array() or die("Ошибка имя" . mysqli_error($link)); 

$query_id ="SELECT product_id FROM `oc_product`";
$result_id = mysqli_query($link, $query_id) or die("Ошибка ID" . mysqli_error($link)); 

$n = mysqli_num_rows($result_id);

for($i=0;$i<$n;$i++){
    $out .= "<tr>
            <td>$result_all[$i]</td>
            </tr>";
}*/



  

?>




<!-- <table>
 <tbody>
  <?php //echo $out; ?>
 </tbody>
</table> -->






<?php

// закрываем подключение
mysqli_close($link);


?>


</body>
</html>