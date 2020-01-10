<?php
function importNameType(){
    echo '<pre>';
    print_r( "Ciao sono pronto per caricare il tuo DataSet su Mongo...");
    echo '</pre>';
// Nome dei file
$connect_to='Dataset/CONNECT_TO.csv';
$related_to='Dataset/RELATED_TO.csv';
$involved_with='Dataset/INVOLVED_WITH.csv';

ini_set('memory_limit', '-1');
// Leggo il contenuto del file
$rows1 = file( $connect_to );
$rows2 = file( $related_to );
$rows3 = file( $involved_with );

//array associativi
foreach ($rows1 as $key => $value)
{
    $csv1[$key] = str_getcsv($value,",","\n");
}
foreach ($rows2 as $key => $value)
{
    $csv2[$key] = str_getcsv($value,",","\n");
}
foreach ($rows3 as $key => $value)
{
    $csv3[$key] = str_getcsv($value,",","\n");
}

//COLONNA DI SINISTRA
//Si estrapolano i nomi e si eliminano i doppioni mettendo tutto in un nuovo array
$left1=array_column($csv1, '0');//rende il multidimensionale una colonna
$right1=array_column($csv1, '2');//rende il multidimensionale una colonna
$left3=array_column($csv3, '0');//rende il multidimensionale una colonna
$left2=array_column($csv2, '0');//rende il multidimensionale una colonna
$right2=array_column($csv2, '2');//rende il multidimensionale una colonna
$right3=array_column($csv3, '2');//rende il multidimensionale una colonna
$merge1=array_merge_recursive($left1,$right1,$left3); //unisce gli array ORGANIZZATION
$merge2=array_merge_recursive($left2,$right2,$right3); //unisce gli array PERSON
$unique1=array_unique($merge1, SORT_STRING);//elimina i doppioni
$unique2=array_unique($merge2, SORT_STRING);//elimina i doppioni
$output1=array_values($unique1);//restituisce l'array con indici resettati da 0 a n
$output2=array_values($unique2);//restituisce l'array con indici resettati da 0 a n

//Connessione al db

   try {
    //fare la connessione ad db
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017"); 
    //scrivi i risultati sul db
	$bulk = new MongoDB\Driver\BulkWrite();
  
    $conto1=count($output1);//numero di valori restituiti
    $conto2=count($output2);//numero di valori restituiti

//Inserisce il nome di ORGANIZATION
    for ($i=0; $i<$conto1; $i++){
    $doc1 = [
    '_id' => new MongoDB\BSON\ObjectID(), 
    'name' => $output1[$i],
    'type' => "Organization",
	]; 
    $bulk->insert($doc1); 
}
//Inserisce il nome di PERSON
 for ($i=0; $i<$conto2; $i++){
    $doc2 = [
    '_id' => new MongoDB\BSON\ObjectID(), 
    'name' => $output2[$i],
    'type' => "Person",
    ]; 
//aggiungiamo i documenti
    $bulk->insert($doc2); 
}
    $mng->executeBulkWrite('DataTrump.DataSet', $bulk);
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Exception!";
}

}
?>