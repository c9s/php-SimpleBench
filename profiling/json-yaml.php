<?php
require( 'tests/bootstrap.php');

$invoice = array (
    "invoice"=> 34843,
    "date"=> 980208000,
    "product"=> array(
        array(
            "sku"=> "BL394D",
            "quantity"=> 4,
            "description"=> "Basketball",
            "price"=> 450,
          ),
        array(
            "sku"=> "BL4438H",
            "quantity"=> 1,
            "description"=> "Super Hoop",
            "price"=> 2392,
          ),
      ),
    "tax"=> 251.42,
    "total"=> 4443.52,
    "comments"=> "Late afternoon is best. Backup contact is Nancy Billsmer @ 338-4338.",
  );
$foo = array( 'foo' => 1 , 'bar' => array( 'zoo' => 1 ) );

$bench = new SimpleBench;
$bench->setN( 60000 );

$bench->iterate( 'json_en' , '' , function() use ($invoice) {
    return json_encode($invoice);
});


$bench->iterate( 'serialize' , '' , function() use ($invoice) {
    return serialize($invoice);
});

$bench->iterate( 'bson_encode' , '' , function() use ($invoice) {
    return bson_encode($invoice);
});

$bench->iterate( 'yaml_emit' , '' , function() use ($invoice) {
    return yaml_emit($invoice);
});

$bench->iterate( 'syck_dump' , '' , function() use ($invoice) {
    return syck_dump($invoice);
});

$result = $bench->compare();
echo $result->output('console');
