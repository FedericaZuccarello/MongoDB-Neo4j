<?php 
//settaggio tempo di esecuzione 
function insertConnection(){
ini_set('max_execution_time', 9999999999999999);	
	echo '<pre>';
	print_r("...sono all'ultimo sforzo, sto caricando le Connections!");
	echo '</pre>';
$formongo='Dataset/ForMongo.csv';
$rows = file( $formongo );
foreach ($rows as $key => $value)
{
	$dati[$key] = str_getcsv($value,",","\n");
}
echo '<pre>';
//print_r($dati);
echo '</pre>';
//$destinazione = fopen('prova.csv', 'w'); //crea documento csv da riempire
$conto=count($dati);//numero di valori restituiti
//$output= "";

try {
    //fare la connessione ad db
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017"); 
    //scrivi i risultati sul db
	$bulk = new MongoDB\Driver\BulkWrite();

	
foreach ($dati as $key => $value) {
	
	$id=$value[0];
	$select=['_id' => new MongoDB\BSON\ObjectID($id)];  
	$c=['$push' =>['Connections' => 
		['id_con'=> $value[2],
		'name_con'=> $value[3],
		'type_con'=> $value[4],
		'source_con'=> $value[5]]]];

$bulk->update($select,$c,['multi' => true, 'upsert' => false]);//multi aggiorna tutti i documenti, upset crea nuovi documenti);
//echo '<pre>';
//print_r($c);
//echo '</pre>';
}
foreach ($dati as $key => $value) {
	
	$id=$value[2];
	$select=['_id' => new MongoDB\BSON\ObjectID($id)];  
	$c=['$push' =>['Connections' => 
		['id_con'=> $value[0],
		'name_con'=> $value[1],
		'type_con'=> $value[4],
		'source_con'=> $value[5]]]];

$bulk->update($select,$c,['multi' => true, 'upsert' => false]);//multi aggiorna tutti i documenti, upset crea nuovi documenti);
//echo '<pre>';
//print_r($c);
//echo '</pre>';
}

$mng->executeBulkWrite('DataTrump.DataSet', $bulk);

	

} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Exception!";
}
echo '<pre>';
echo "FINITO.";
echo '</pre>';
}


?>