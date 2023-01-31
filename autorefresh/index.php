<?php

$kurs = file_get_contents('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11');
						
								$response_info = json_decode($kurs, true);
							
								foreach ($response_info as $key => $value) {
								foreach ($value as $val) {
									if($value['ccy']=='USD'){
										$def_currency_val = $value['sale'];
										$link = mysqli_connect('localhost', 'root', '', 'ivancotv_shopfe6') or die();

											$query ="UPDATE oc_currency SET value='$def_currency_val' WHERE code = 'UAH'";
											$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

									}
									break;
								}
							}


?>