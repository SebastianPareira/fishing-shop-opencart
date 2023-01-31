<?php

// строка, которую будем записывать
$text = date("F j, Y, g:i a")." CRON отработал\n";
 
//Открываем файл
$fp = fopen("test.txt", "a+");
 
// записываем в файл текст
fwrite($fp, $text);
 
// закрываем
fclose($fp);

require_once('config.php');


$kurs = file_get_contents('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11');
						
								$response_info = json_decode($kurs, true);
							
								foreach ($response_info as $key => $value) {
								foreach ($value as $val) {
									if($value['ccy']=='USD'){
										$def_currency_val = $value['sale'];
										$link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die();

											$query ="UPDATE oc_currency SET value='$def_currency_val' WHERE code = 'UAH'";
											$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
											
											mysqli_close();
									}
									break;
								}
							}


?>