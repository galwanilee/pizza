<?php
include_once 'db.php';
if (isset($_POST['order'])) {
   $order = $_POST['order'];
   $data = [];
   for ($i = 0; $i <= count($order); $i++) {
       if ($result = $mysqli->query("SELECT * FROM products WHERE id_product = '". $order[$i]['id'] ."';")) {

           foreach ($result as $row) {
               /*$data['id'] = $row["id_product"];
               $data['imgname'] = $row["product_imgname"];
               $data['name'] = $row["product_name"];
               $data['price'] = $row["product_price"];
               $data['size'] = $row["product_size"];
               $data['desc'] = $row["product_desc"];*/
               $data[$i] = array('id' => $row['id_product'], 'imgname' => $row['product_imgname'], 'name' => $row['product_name'], 'price' => $row['product_price'], 'size' => $row['product_size'], 'desc' => $row['product_desc']);
           }
       } else {
           echo $mysqli -> error;
       }
   }
   echo json_encode($data);
}