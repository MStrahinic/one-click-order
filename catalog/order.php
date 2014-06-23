<?php

$mysqli = new mysqli("localhost", "xxx", "zzz", "yyy");
$mysqli->query("set names 'utf8'");

$products_id = $_POST["productsId"];
$productName = $_POST["productName"];
$productPrice = $_POST["productPrice"];
$name = $_POST["new_order-FIO"];
$tel = $_POST["new_order-PHONE"];
$email = $_POST["new_order-EMAIL"];
$auto_message="Это сообщение отправлено автоматически. Пожалуйста, не отвечайте на него. В ближайшее время с вами свяжется менеджер для уточнения заказа.";
$parts = explode(' ', $name);

$result = $mysqli->query("SELECT * FROM customers WHERE customers_firstname = '".$parts[0]."' AND customers_telephone = '".$tel."' AND customers_email_address = '".$email."'");
$row = $result->fetch_assoc();
$result->free();

if(!$row){

//Customers
	
	$customers_status = 2; 	
	$customers_gender = " ";
	$customers_firstname = $parts[0];
	$customers_secondname = " ";
	$customers_lastname = $parts[1];
	$customers_email_address = $email;
	$customers_default_address_id = 0;// customer id = customers_default_address_id 
	$customers_telephone = $tel;
	
	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    $customers_password = implode($pass); //turn the array into a string
	$customers_date_added = date("Y-m-d H:i:s");
	$customers_last_modified = date("Y-m-d H:i:s");
	$customers_vat_id = " ";
	$customers_newsletter = "1";
	
	$mysqli->query("INSERT INTO customers(customers_vat_id, customers_status, customers_gender, customers_firstname, customers_secondname, customers_lastname, customers_email_address, customers_default_address_id, customers_telephone, customers_password, customers_newsletter, customers_date_added, customers_last_modified) VALUES('".$customers_vat_id."', '".$customers_status."', '".$customers_gender."', '".$customers_firstname."', '".$customers_secondname."', '".$customers_lastname."', '".$customers_email_address."', '".$customers_default_address_id."', '".$customers_telephone."', '".md5($customers_password)."', '".$customers_newsletter."', '".$customers_date_added."', '".$customers_last_modified."')");
	
	$result = $mysqli->query("SELECT customers_id FROM customers ORDER BY customers_id DESC LIMIT 1");
	$row_customers = $result->fetch_assoc();
	$result->free();
	$customers_id = $row_customers['customers_id'];

//Customers info

	$customers_info_id = $customers_id; 
	$customers_info_number_of_logons = 0;
	$customers_info_date_account_created = date("Y-m-d H:i:s");
	$customers_info_date_account_last_modified = date("Y-m-d H:i:s");
	
	$mysqli->query("INSERT INTO customers_info(customers_info_id, customers_info_number_of_logons, customers_info_date_account_created, customers_info_date_account_last_modified) VALUES('".$customers_info_id."','".$customers_info_number_of_logons."', '".$customers_info_date_account_created."', '".$customers_info_date_account_last_modified."')");
		
//Customers IP

	 $customers_ip = getenv('HTTP_CLIENT_IP')?:
				getenv('HTTP_X_FORWARDED_FOR')?:
				getenv('HTTP_X_FORWARDED')?:
				getenv('HTTP_FORWARDED_FOR')?:
				getenv('HTTP_FORWARDED')?:
				getenv('REMOTE_ADDR');

	$customers_ip_date = date("Y-m-d H:i:s");
	$customers_host = gethostbyaddr($customers_ip);
	
	$mysqli->query("INSERT INTO customers_ip(customers_id, customers_ip, customers_ip_date, customers_host) VALUES('".$customers_id."', '".$customers_ip."', '".$customers_ip_date."', '".$customers_host."')");
	
//address book

	$entry_gender = " ";
	$entry_firstname = $parts[0];
	$entry_secondname = " ";
	$entry_lastname = $parts[1];
	$entry_street_address = "UNKNOWN";
	$entry_postcode = "UNKNOWN";
	$entry_city = "UNKNOWN";
	$entry_state = "UNKNOWN";
	$address_date_added = date("Y-m-d H:i:s");
	$address_last_modified = date("Y-m-d H:i:s");
	
	$mysqli->query("INSERT INTO address_book(customers_id, entry_gender, entry_firstname, entry_secondname, entry_lastname, entry_street_address, entry_postcode, entry_city, entry_state, address_date_added, address_last_modified ) VALUES('".$customers_id."', '".$entry_gender."', '".$entry_firstname."', '".$entry_secondname."', '".$entry_lastname."', '".$entry_street_address."', '".$entry_postcode."', '".$entry_city."', '".$entry_state."', '".$address_date_added."' ,'".$address_last_modified."')");

$result = $mysqli->query("SELECT address_book_id FROM address_book WHERE customers_id = '".(int)$customers_id."'");
$x = $result->fetch_assoc();
$result->free();
$x_value = (int)$x['address_book_id'];
$mysqli->query("UPDATE customers SET customers_default_address_id = '".$x_value."' WHERE customers_id = '".(int)$customers_id."'");
	
} else {
	
	$customers_id = $row['customers_id'];
	$customers_status = 2; 	
	$customers_gender = " ";
	$customers_firstname = $parts[0];
	$customers_secondname = " ";
	$customers_lastname = $parts[1];
	$customers_email_address = $email; 
	$customers_telephone = $tel;
		
}	
//consumer basket

	$customers_basket_quantity = 1;
	$final_price = 0.0000;
	$customers_basket_date_added = date("Ymd");
	
	$mysqli->query("INSERT INTO customers_basket(customers_id, products_id, customers_basket_quantity, final_price, customers_basket_date_added) VALUES('".$customers_id."', '".$products_id."', '".$customers_basket_quantity."', '".$final_price."', '".$customers_basket_date_added."')");
			
//orders
 
if($row){
	 $customers_ip = getenv('HTTP_CLIENT_IP')?:
				getenv('HTTP_X_FORWARDED_FOR')?:
				getenv('HTTP_X_FORWARDED')?:
				getenv('HTTP_FORWARDED_FOR')?:
				getenv('HTTP_FORWARDED')?:
				getenv('REMOTE_ADDR');
}
$customers_cid = " "; 
$customers_vat_id = " "; 
$customers_status_name = "Покупатель";  
$customers_status_image = "customer_status.gif";
$customers_status_discount = 0.00;
$customers_name = $name;
$customers_company = "UNKNOWN";
$customers_street_address = "UNKNOWN"; 
$customers_suburb = "UNKNOWN";
$customers_city = "UNKNOWN";
$customers_postcode = "UNKNOWN";
$customers_state  = "UNKNOWN";
$customers_country  = "UNKNOWN";
$customers_address_format_id  = 1; 
$delivery_name  =  $name;
$delivery_firstname  = $parts[0];
$delivery_secondname  =  " ";
$delivery_lastname =  $parts[1];
$delivery_company  =  "UNKNOWN";
$delivery_street_address  = "UNKNOWN";
$delivery_suburb =  "UNKNOWN";
$delivery_city  =  "UNKNOWN";
$delivery_postcode =  "UNKNOWN";
$delivery_state  = "UNKNOWN";
$delivery_country  =  "UNKNOWN";
$delivery_country_iso_code_2 =  "RU";
$delivery_address_format_id = 1;
$billing_name = $name;
$billing_firstname =  $parts[0];
$billing_secondname =  " ";
$billing_lastname =  $parts[1];
$billing_company  = "UNKNOWN";
$billing_street_address = "UNKNOWN"; 
$billing_suburb =  "UNKNOWN";
$billing_city =  "UNKNOWN";
$billing_postcode =  "UNKNOWN";
$billing_state =  "UNKNOWN";
$billing_country =  "UNKNOWN";
$billing_country_iso_code_2 = "RU"; 
$billing_address_format_id = 1; 
$payment_method =  "rbkmoney";
$cc_type =  " ";
$cc_owner =  " ";
$cc_number =  " ";
$cc_expires =  " ";
$cc_start =  " ";
$cc_issue =  " ";
$cc_cvv =  " ";
$comments =  " ";
$last_modified = date("Y-m-d H:i:s");  
$date_purchased = date("Y-m-d H:i:s"); 
$orders_status  =  1;
$orders_date_finished = NULL; 
$currency =  "RUR";
$currency_value = 1.000000; 
$account_type = 0; 
$payment_class  = "rbkmoney"; 
$shipping_method  = "Самовывоз (Покупатель сам забирает свой заказ)";
$shipping_class = "selfpickup_selfpickup";
$language = "russian";
$afterbuy_success = 0; 
$afterbuy_id = 0; 
$refferers_id = 0;
$conversion_type = 1; 
$orders_ident_key = NULL;
$orig_reference =  "://?";
$login_reference = "://?";
	

$mysqli->query("INSERT INTO orders (customers_id, customers_cid, customers_vat_id, customers_status, customers_status_name, customers_status_image, customers_status_discount, customers_name, customers_firstname, customers_secondname, customers_lastname, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_firstname, delivery_secondname, delivery_lastname, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_country_iso_code_2, delivery_address_format_id, billing_name, billing_firstname, billing_secondname, billing_lastname, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_country_iso_code_2, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, cc_start, cc_issue, cc_cvv, comments, last_modified, date_purchased, orders_status, orders_date_finished, currency, currency_value, account_type, payment_class, shipping_method, shipping_class, customers_ip, language, afterbuy_success, afterbuy_id, refferers_id, conversion_type, orders_ident_key, orig_reference, login_reference) VALUES
('".$customers_id."', '".$customers_cid."', '".$customers_vat_id."', '".$customers_status."', '".$customers_status_name."', '".$customers_status_image."', '".$customers_status_discount."', '".$customers_name."','".$customers_firstname."', '".$customers_secondname."','".$customers_lastname."' , '".$customers_company."' , '".$customers_street_address."', '".$customers_suburb."', '".$customers_city."', '".$customers_postcode."', '".$customers_state."' , '".$customers_country."' , '".$customers_telephone."', '".$customers_email_address."','".$customers_address_format_id."' , '".$delivery_name."' , '".$delivery_firstname."' ,'".$delivery_secondname."' , '".$delivery_lastname."', '".$delivery_company."' , '".$delivery_street_address."' , '".$delivery_suburb."', '".$delivery_city."' , '".$delivery_postcode."', '".$delivery_state."' ,'".$delivery_country."' , '".$delivery_country_iso_code_2."', '".$delivery_address_format_id."', '".$billing_name."', '".$billing_firstname."', '".$billing_secondname."', '".$billing_lastname."', '".$billing_company."' ,'".$billing_street_address."', '".$billing_suburb."', '".$billing_city."', '".$billing_postcode."', '".$billing_state."', '".$billing_country."', '".$billing_country_iso_code_2."', '".$billing_address_format_id."', '".$payment_method."', '".$cc_type."', '".$cc_owner."', '".$cc_number."', '".$cc_expires."', '".$cc_start."', '".$cc_issue."', '".$cc_cvv."', '".$comments."', '".$last_modified."', '".$date_purchased."', '".$orders_status."' , '".$orders_date_finished."' , '".$currency."', '".$currency_value."', '".$account_type."', '".$payment_class."' , '".$shipping_method."' , '".$shipping_class."', '".$customers_ip."' , '".$language."', '".$afterbuy_success."', '".$afterbuy_id."', '".$refferers_id."', '".$conversion_type."', '".$orders_ident_key."','".$orig_reference."', '".$login_reference."')");

//orders_products
$result = $mysqli->query("SELECT orders_id FROM orders WHERE customers_id = '".$customers_id."' ORDER BY orders_id DESC LIMIT 1");
$row_orders = $result->fetch_assoc();
$result->free();

	$orders_id = $row_orders['orders_id'];
	$final_price = $productPrice;
	$products_tax = 0.0000;
	$products_quantity = 1;
	$allow_tax = 1;

	$mysqli->query("INSERT INTO orders_products(orders_id, products_id, products_name, products_price, final_price, products_tax, products_quantity, allow_tax) VALUES('".$orders_id."', '".$products_id."', '".$productName."', '".$productPrice."', '".$final_price."', '".$products_tax."', '".$products_quantity."', '".$allow_tax."')");

//orders_status_history

	$orders_status_id = 1;
	$date_added = date("Y-m-d H:i:s");

	$mysqli->query("INSERT INTO orders_status_history(orders_id, orders_status_id, date_added) VALUES('".$orders_id."', '".$orders_status_id."', '".$date_added."')");

//orders_total

	$title1 = 'Стоимость товара:';
	$title2 = '<span class="errorText">Нет доступных способов доставки для выбранной страны.</span>:';
	$title3 = '<b>Всего</b>:';
	
	$text1 = $productPrice . " руб.";
	$text2 = '<span class="Requirement"><strong>бесплатно</strong></span>';
	$text3 = '<b>'. $productPrice . ' руб.' .'</b>';
	
	$value1 = $productPrice;
	$value2 = 0;
	$value3 = $productPrice;
	
	$class1 = "ot_subtotal";
	$class2 = "ot_shipping";
	$class3 = "ot_total";
 
	$sort_order1 = 10;
	$sort_order2 = 30;
	$sort_order3 = 99;


	$mysqli->query("INSERT INTO orders_total(orders_id, title, text, value, class, sort_order) VALUES
	('".$orders_id."', '".$title1."', '".$text1."', '".$value1."', '".$class1."', '".$sort_order1."' ),
	('".$orders_id."', '".$title2."', '".$text2."', '".$value2."', '".$class2."', '".$sort_order2."' ),
	('".$orders_id."', '".$title3."', '".$text3."', '".$value3."', '".$class3."', '".$sort_order3."' )");


//Email

$to_admin      = 'strahinicmilan@gmail.com';
$subject_admin = 'Покупка в один клик - www.worldcupski.ru';
$message_admin = 'Покупка в один клик'."\n\n".
				 'Покупатель: '.$name."\n".
        		 'Телефон: '.$tel."\n".
            	 'E-mail: '.$email."\n".
				 'Номер заказа: '.$orders_id."\n".
				 'Продукт: '.$productName."\n".
				 'Цена: '.$productPrice."\n";	

$headers_admin = 'From: info@worldcupski.ru' . "\r\n" .
    			 'Reply-To: info@worldcupski.ru' . "\r\n" .
    			 'X-Mailer: PHP/' . phpversion();

$result1 = mail($to_admin, $subject_admin, $message_admin, $headers_admin);

$to_customer      = $email;
$subject_customer = 'Покупка в один клик - www.worldcupski.ru';
if(!$row){
$message_customer =  'Здравствуйте, '.$name.'!'."\n\n".
					 'Ваш номер заказа: '.$orders_id."\n".
					 'Продукт: '.$productName."\n".
					 'Цена: '.$productPrice."\n\n".
					 'Для вас была автоматически создана учетная запись, которой вы можете пользоваться в дальнейшем для покупок в нашем магазине.'."\n".
					 'Логин: '.$email."\n".
					 'Пароль: '.$customers_password."\n\n".
					 'В ближайшее время с вами свяжется менеджер для уточнения заказа по телефону '.$tel."\n".
					 'Это сообщение отправлено автоматически. Пожалуйста, не отвечайте на него.'."\n\n".
					 'Интернет-магазин горнолыжной одежды worldcupski.ru'."\n".
					 '+7 (495) 921-37-46'."\n".
					 'info@worldcupski.ru';
} else {
$message_customer =  'Здравствуйте, '.$name.'!'."\n\n".
					 'Ваш номер заказа: '.$orders_id."\n".
					 'Продукт: '.$productName."\n".
					 'Цена: '.$productPrice."\n\n".
					 'Вы уже зарегистрированы на сайте!'."\n\n".
					 'В ближайшее время с вами свяжется менеджер для уточнения заказа по телефону '.$tel."\n".
					 'Это сообщение отправлено автоматически. Пожалуйста, не отвечайте на него.'."\n\n".
					 'Интернет-магазин горнолыжной одежды worldcupski.ru'."\n".
					 '+7 (495) 921-37-46'."\n".
					 'info@worldcupski.ru';	
}
$headers_customer = array();
$headers_customer[] = "MIME-Version: 1.0";
$headers_customer[] = "Content-type: text/plain; charset=iso-8859-1";
$headers_customer[] = "From: worldcupski.ru <info@worldcupski.ru>";
$headers_customer[] = "Reply-To: worldcupski.ru <info@worldcupski.ru>";
$headers_customer[] = "Subject: Покупка в один клик";
$headers_customer[] = "X-Mailer: PHP/".phpversion();


$result2 = mail($to_customer, $subject_customer, $message_customer, implode("\r\n", $headers_customer));
	
    if(($result1 === true) && ($result2 === true))
    {
        $arr = array('ok' => 'Y', 'msg' => 'All is good!');
    }

    else  {
        $arr = array('ok' => 'N', 'msg' => 'Some error has ocured!');
    }

    echo json_encode($arr);


?>