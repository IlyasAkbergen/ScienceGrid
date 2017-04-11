<?php 

$jsonurl = "https://api.exline.systems/public/v1/calculate?origin_id=3&destination_id=12&weight=2.1";
$json = file_get_contents($jsonurl);
$json1 = json_decode($json, true);
// var_dump(json_decode($json, true));

// $propertyName = key(get_object_vars($json));

// foreach ($json->regions as $item) {
//    var_dump($item->title);
// }
echo "----------";
// echo gettype($json1);

$title = array();
$id = array();
$oblast = array();
// var_dump($json1['regions']);
// var_dump($json1['calculations']);
$i = 0;

echo '+++++++++++++++++++++++++';
// echo var_dump(json_decode($json, true));
var_dump($json1['calculations']['standard']['price']);
// foreach($json1['calculations']['standard'] as $mydata)

//     {	
//             var_dump($mydata);    
//             echo '------------------------';

         
//    //       $title[$i] = $mydata['title'];
// 		 // $id[$i] =  $mydata['id'];
// 		 // $oblast[$i] = $mydata['cached_path'];
// 		 // $i++;
//          // foreach($mydata->values as $values)
//          // {
//          //      echo $values->value . "\n";
//          // }
//     }

// // echo $propertyName->{'regions'}(0);

// for($j=0; $j<$i; $j++){
// 	echo $title[$j];
// }
 ?>