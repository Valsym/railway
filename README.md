# railway
make web-site with a railway tickets
Данный проект был реализован 29-апр-2014 г.
Суть проекта: создания сайта на котором находится 40697 страниц с информацией о расписании и ценах на железнодорожные пассажирские перевозки по территории РФ. 
На каждой из страничек сайта выводится следующая информация:
    * Номер поезда	
    * Полный    маршрут    поезда	
    * Время    в пути	
    * Время    отправления	
    * Время    прибытия	
    * Тип    вагона	
    * Цена, руб.
    
    На момент создания сайта (март-апрель 2014г) вся информация была абсолютно актуальной поскольку парсилась с сайта партнера.
    Затем данные упорядочивались в exel-таблицу и экспортировались в Базу Данных mysql на хостинге. Структура БД - см. фото database-structure.jpg Пример первой страницы таблицы zd1 с данными см. фото database-page1.jpg
   ************************
   Наполнение сайта генерировал написанный мной скрипт на php (см. файл post-zd1.php), который запускался на хостиге вручную прямо из браузера. 
   Чтобы не создавать излишнюю нагрузку на хостинг, и для контроля за ходом генерации страниц, скрипту можно задавать количество генерируемых за один шаг страниц и диапазон их ID, по мере выполнения его работы.
   ************************
   Скрипт генерурует не просто html-код, а страницы в формате CMS Wordpress. Таким образом создается полноценный сайт для этой популярной CMS.
   Т.е. сначала из таблицы wp_zd1 БД построчно выбирается вся информация о маршруте, цене, времени отправления и т.п.: 
   $table_name = $wpdb->prefix . "zd1"; 
  $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d LIMIT 1", $id ) );

   Затем для поста формируются переменные: $title, $keywords, $description, $body (content), $date:
   $city1 = $row->c1; $city2 = $row->c2;
     $city1 = mb_convert_case($city1, MB_CASE_TITLE, "UTF-8"); echo 'city1='.$city1.'  ';
     $city2 = mb_convert_case($city2, MB_CASE_TITLE, "UTF-8"); echo 'city2='.$city2.'  ';

     $npp = $row->npp;
     $mint = $row->mint;
     $minp = $row->minp;

     $route1 = $row->route1;
     $np1 = $row->np1;
     $t1= $row->t1;
     $arr1 =  $row->dep1;
     $dep1 = $row->arr1;//!!! это правильно !!!
     $vagon1 = $row->vag1;
     $price1 = $row->price1;

     $route2 = $row->route2;
     if ( $route2 != "" ) {
       $np2 = $row->np2;
       $t2= $row->t2;
       $arr2 =  $row->dep2;
       $dep2 = $row->arr2;
       $vagon2 = $row->vag2;
       $price2 = $row->price2;
     }
     $title ='Железнодорожные билеты на поезд '. $city1.' - '. $city2;
     $key='билеты '. $city1.' - '. $city2.' поезд, поезд в '. $city2.' из '. $city1.' цена, поезд '. $city1.' - '. $city2.
' ржд, скорые поезда '. $city1.' - '. $city2.', поезд из '. $city1.' в '. $city2.' дешево.';

$descr='Посмотреть расписание поездов '.$city_name2.' и купить дешевые билеты на поезд '.$city_name2.' из '.$city_name1.
' можно на нашем сайте. Узнайте стоимость билета на поезд  '.$city1.' - '.$city2.', время отправления и время прибытия поезда '
.$city1.' - '.$city2.'.';
$body=
'<br><br><strong><span style="margin: 8px; padding: 2px; text-align: center;">Поиск железнодорожных билетов ' . $city1 . ' - ' 
. $city2 . '</span></strong><!--more--><br><br>'.
'На этой страничке Вы сможете узнать точное расписание, цены и наличие железнодорожных билетов на поезд ' . $city1 . ' - ' 
. $city2 . ' или по любым другим маршрутам, а также забронировать нужные Вам билеты.'.
'<br><br>Для этого в форме ниже укажите дату отправления и количество пассажиров, и нажмите кнопку "<strong>НАЙТИ</strong>"'. 
' после чего Вы получите полный список с самыми актуальными ценами, наличием мест и вариантами переезда на вашу дату.';
...

   И наконец все это записывается в таблицу wp_posts Базы данных в формате вордпресс:
   
   if (empty($posts) || empty($posts->ID) ){ 

    $post['post_content'] = $body;
    $post['post_title'] = $title;
    //$post ['post_date'] => date( 'Y-m-d H:i:s', time() );//$hotness;
    $post_id = wp_insert_post( $post, $wp_error );
    $post_date = date( 'Y-m-d H:i:s', time()  - 11000*3600 +  900*$id + rand(1,700) );
    $post_data = array(
	"ID" => $post_id,
	"post_date" => $post_date,
	"edit_date" => true
    );
    $post_id = wp_update_post($post_data);
    
    update_post_meta($post_id,'source_link',$url);
    update_post_meta($post_id,'description',$descr);
    update_post_meta($post_id,'keywords',$key);
}
   
   И так было сгенерировано более 40тыс страниц...
   
   Кроме того, на момент создания сайта, работала партнерка, позволяющая вставлять на сайт javascript-код с формой поиска ж/д билетов по заданному маршруту:
   $body .='<script language="javascript" type="text/javascript" src="http://www.davs.ru/core/js/jquery-1.6.1.min.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/core/js/jquery-ui-1.8.13.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/poezda/js/jquery.jqtransform.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/poezda/js/jquery.ui.autocomplete.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/poezda/js/js.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/poezda/js/insert.js?encoding=utf-8&partner=...&form_from_city='.$city1.'&form_to_city='.$city2.'"></script>';
где $city1 - пункт отправления и $city2 - пункт прибытия.
Эта форма давала пользователю возможность перейти на сайт партнерки и сделать заказ билетов. С апреля по август 2014 было 9 заказов на сумму 39тыс.руб. Однако партерка оказалась довольно мутной и предложила мне (после моих настойчивых просьб прислать договор) выплатить 420р. т.е. чуть больше 1% (см.файл mail.txt). После чего форма была деактивирована и с сентября 2014 заменена на блоки контекстной рекламы (результаты за весь период по наст.время см. фото income-public.jpg)
Т.ч. проект продолжает жить и приность пусть и небольшие деньги.
*********************************************************************************************************
Проект написан для подтверждения моего резюме. Некоторые файлы, содержащие финансовые отчеты и мою личную е-мейл переписку в были добавлены в игнор и могут быть выложены на данный репозиторий только по просьбе потенциального работодателя.

