<?php
// определяем параметры шага
$step_size = 25;                              
//  количество единиц информации, обрабатываемых за шаг
$step=$_GET['step'];                         
//  определяем номер шага, для примера мы его передаем через GET
if ($step=='') { $step=1; }                 //  если шаг не задан, то 1
$start = ($step-1)*$step_size+2100;         //  начальная позиция информации для обработки 
$newstep = $step+1;                        //  следующий шаг

/*  обработка $step_size единиц информации, начиная с позиции $start   */
$all=3106;

//if ($all==1000) sleep(60);if ($all==2000) sleep(60);

set_time_limit(0);
define('WP_USE_THEMES', true);
$ABSPATH = dirname(dirname(__FILE__));
$site="http://railway.travelertales.ru";

$wpl=$site.'/wp-blog-header.php';
if (file_exists($wpl)) // !!!
           require_once( $wpl);

$title = 'ЖД билеты ';
$body ='123456';

$hotness = date( 'Y-m-d H:i:s', time() - 11000*3600 +3600);


$post = array(
    'post_title' => $title,
    'post_content' => $body,
    'post_author' => 0,
    'comment_status' => 'closed',
    'ping_status' => 'closed',
    'post_type' => 'post',
    'post_status'    =>  'publish',

   // 'post_date' => $tm, 
  //'ID' => [ <post id> ] //Are you updating an existing post?
  'post_category' =>  array(4), //array(3) //Add some categories.  !!!
  //'post_date'     => date("Y-m-d H:i:s", strtotime("Sept 11, 2001"))
  'post_date' => $hotness //[ Y-m-d H:i:s ] //The time post
  //'date_created_gmt'=>$pubdate 
  //'post_date_gmt' => $hotness//[ Y-m-d H:i:s ] //The time post was made, in GMT.
  //'post_excerpt' => [ <an excerpt> ] //For all your post excerpt needs.
  //'post_name' => [ <the name> ] // The name (slug) for your post
  //'post_parent' => [ <post ID> ] //Sets the parent of the new post.
  //'post_password' => [ ? ] //password for post?
  //'tags_input' => [ '<tag>, <tag>, <...>' ] //For tags.
  //'to_ping' => [ ? ] //?
);
$wpl=$site.'.ru/wp-includes/post.php';
if (file_exists($wpl))
          require_once( $wpl);
require(dirname(dirname(__FILE__)) . '/wp-load.php');

$args = array("meta_key" => "source_link", "meta_value" =>$url);

global $wpdb;
 



$city1='Москва';
$city2 = 'Санкт-Петербург';


$end=$start+$step_size;

if ($end>=$all) $end=$all;

for($id=$start;$id<$end;$id++){ 



 $table_name = $wpdb->prefix . "zd1"; 
  $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d LIMIT 1", $id ) );
  if (!$row) {echo 'ERROR can`t read BD circl_1 id='.$id;exit;}


     echo 'ok id= '.$id.'<br>';
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

/*
расписание поездов москва санкт петербург	12374
билеты москва санкт петербург поезд	8436
билеты москва санкт петербург поезд	8436
поезд москва санкт петербург цена	3462
поезд москва санкт петербург купить	1219
санкт петербург москва поезд стоимость	1106
москва санкт петербург поезд ржд	690
отправление поездов москва санкт петербург	513
поезд экспресс москва санкт петербург	466
прибытие поезда москва санкт петербург	454
скоростной поезд москва санкт петербург	453
расстояние москва санкт петербург поезд	428
поезд москва санкт петербург дешево	283
дешевый поезд москва санкт петербург	283
скорый поезд москва санкт петербург	226
скорые поезда москва санкт петербург	226
поезд москва санкт петербург плацкарт	192
движение поездов москва санкт петербург	148
*/

$key='билеты '. $city1.' - '. $city2.' поезд, поезд в '. $city2.' из '. $city1.' цена, поезд '. $city1.' - '. $city2.
' ржд, скорые поезда '. $city1.' - '. $city2.', поезд из '. $city1.' в '. $city2.' дешево.';

$descr='Посмотреть расписание поездов '.$city_name2.' и купить дешевые билеты на поезд '.$city_name2.' из '.$city_name1.
' можно на нашем сайте. Узнайте стоимость билета на поезд  '.$city1.' - '.$city2.', время отправления и время прибытия поезда '
.$city1.' - '.$city2.'.';


$url = 'http://sample2.com/entertainment/default.aspx?tabid=2305&conid=102950' . strval ($id);
$args = array("meta_key" => "source_link", "meta_value" =>$url);
$args = array("meta_key" => "description", "meta_value" =>$descr);
$args = array("meta_key" => "keywords", "meta_value" =>$key);
$posts = get_posts($args);

$body='';


$body=
'<br><br><strong><span style="margin: 8px; padding: 2px; text-align: center;">Поиск железнодорожных билетов ' . $city1 . ' - ' 
. $city2 . '</span></strong><!--more--><br><br>'.
'На этой страничке Вы сможете узнать точное расписание, цены и наличие железнодорожных билетов на поезд ' . $city1 . ' - ' 
. $city2 . ' или по любым другим маршрутам, а также забронировать нужные Вам билеты.'.
'<br><br>Для этого в форме ниже укажите дату отправления и количество пассажиров, и нажмите кнопку "<strong>НАЙТИ</strong>"'. 
' после чего Вы получите полный список с самыми актуальными ценами, наличием мест и вариантами переезда на вашу дату.';
/*
$c1=convert_cyr_string($city1,"k","w");
$c1= iconv("UTF-8", "Windows-1251", $city1); 
$c2= iconv("UTF-8", "Windows-1251", $city2); 
$c2=convert_cyr_string($city2,"k","w");
*/
$body .='<script language="javascript" type="text/javascript" src="http://www.davs.ru/core/js/jquery-1.6.1.min.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/core/js/jquery-ui-1.8.13.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/poezda/js/jquery.jqtransform.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/poezda/js/jquery.ui.autocomplete.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/poezda/js/js.js"></script>
<script language="javascript" type="text/javascript" src="http://www.davs.ru/poezda/js/insert.js?encoding=utf-8&partner=travelertales.ru&form_from_city='.$city1.'&form_to_city='.$city2.'"></script>';

//$date45 = date( 'j F Y г.', time()  + 3600*24*45 );
$formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
$formatter->setPattern('d MMMM YYYY г.');
//echo $formatter->format(new DateTime()); // сегодня
$d45 = date( 'd-m-Y', time()  + 3600*24*45 );

$date45 =$formatter->format(new DateTime($d45)); 

$body .='<br><br><br><br>По маршруту '. $city1.' - '. $city2.' курсируют железнодорожные поезда под номером: '. $npp .'.<br><br>'. 
'Минимальное время по железной дороге в пути на поезде '. $city1.' - '. $city2.'  с учетом всех остановок составит: '.$mint.'.<br><br>'. 
'Купить железнодорожный билет на поезд '. $city1.' - '. $city2.'  можно по следующим ориентировочным ценам: '.$minp.'.<br><br>'.
'Напоминаем, что на сегодняшний день Вы можете забронировать билеты на дату, отстоящую от текущей не позднее чем на 45 дней'. 
', т.е на любое число включая '. $date45;


$body .='<br><br>В таблице ниже мы нашли варианты переезда на поезде по маршруту ' . 
$city1 . ' - ' . $city2.
' с указанием времени отправления, времени прибытия и общим временем в пути, а также с ориентировочными ценами на билеты.<br>';

$body .='<table class="tableborder" border="1" cellpadding="4" cellspacing="0">
<tbody><tr><td class="tabletitle" style="text-align: center;" colspan="7">
<strong>Лучшие цены   по маршруту ' . $city1 . ' - ' . $city2.'</strong><br>Все сборы и таксы включены.</td></tr>
<tr>
<td><strong>Номер<br>поезда</strong></td>
<td><strong>Полный<br>маршрут<br>поезда</strong></td>
<td><strong>Время<br>в пути</strong></td>
<td><strong>Время<br>отправления</strong></td>
<td><strong>Время<br>прибытия</strong></td>
<td><strong>Тип<br>вагона</strong></td>
<td><strong>Цена, руб.</strong></td>
</tr>';

$body .='<tr>
<td>'.$np1.'</strong></td>
<td>'.$route1.'</td>
<td>'.$t1.'</td>
<td>'.$dep1.'</td>
<td>'.$arr1.'</td>
<td>'.$vagon1.'</td>
<td>'.$price1.'</td>
</tr>';

if ( $route2 != "" ) {
  $body .='<tr>
  <td>'.$np2.'</strong></td>
  <td>'.$route2.'</td>
  <td>'.$t2.'</td>
  <td>'.$dep2.'</td>
  <td>'.$arr2.'</td>
  <td>'.$vagon2.'</td>
  <td>'.$price2.'</td>
  </tr>';
}

$body .='</tbody></table>';
$body .='<br><br>Для получения более точной информации, пожалуйста, воспользуйтесь вышеприведенной формой "Онлайн заказ железнодорожных билетов".<br><br>';


$mod=1;
$body .='<br>[zd1 from='.$city1.' to='.$city2.' mod='.$mod.']<br>';
$body .='<br>[zd2 from='.$city1.' to='.$city2.' mod='.$mod.']<br>';

if ($mod>1){
  $body .='<br><br><br>'.
  'ЦЕНЫ НА ЖЕЛЕЗНОДОРОЖНЫЕ БИЛЕТЫ и РАСПИСАНИЕ ЖЕЛЕЗНОДОРОЖНЫХ ПОЕЗДОВ ПО ДРУГИМ ПОПУЛЯРНЫМ НАПРАВЛЕНИЯМ:<br>';
}



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

if ($post_id == 0) {
   echo 'Something went wrong!!!';
} else { 

   $table_name0 = $wpdb->prefix . "zd1"; 
   $wpdb->update( $table_name0, 
	array( 'post_id' => $post_id	// integer (number) 
	), 
	array( 'id' => $id ), 
	array( '%d'	// value2
	), 
	array( '%d' ) 
   );

   echo "Article Posted Successfully\n"; 
}//if ($post_id == 0) {


}//for ($id=1;$id<5;$id++){



// переадресация на самого себя с новыми параметрами
//header("Location: script.php?step=".$newstep." ");

if ($end >= $all) exit;
echo('<html>
<head>
<title>Обновление</title>
</head>
<body>
Идет обновление.<br /><a id="go" href="post-zd1.php?step='.$newstep.'">.</a>
<script type="text/javascript">document.getElementById(\'go\').click();</script>
</body>
</html>');
//die("ALL!!!");
exit;

?>