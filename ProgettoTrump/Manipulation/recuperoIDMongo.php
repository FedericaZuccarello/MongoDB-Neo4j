<?php
function importObjID(){
try{
	echo '<pre>';
	print_r("...ho aggiunto su Mongo il DataSet con nome e tipo,");
	print_r("lui creerà automaticamente gli ObjectID...");
	echo '</pre>';
	
	//fare la connessione ad db
	$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017"); 
	//scrivi i risultati sul db
	$bulk = new MongoDB\Driver\BulkWrite();
		
	//$id = ['_id' => new MongoDB\BSON\ObjectId()];
		$filter = ['name' =>[ '$ne' => ""]];
		$options = ['id'=> new MongoDB\BSON\ObjectId(),
		'dati'=> $filter];
		$query = new MongoDB\Driver\Query($filter, $options);
		$rows = $mng->executeQuery('DataTrump.DataSet', $query);

	$destinazione = fopen('Dataset/recuperaID.csv', 'w'); //crea documento csv da riempire
// una stringa per preparare l'output a video
	$sep = ",";
	$mark = 1; // per la segnalazione di uscita
	$iteraction = 1; // per sapere a che riga ho l'occorrenza
	foreach($rows as $row){

	//$Mjson=json_encode($rMongo);
	//$Bjson=json_decode($Mjson);
		$rMongo=(array) $row;
		//echo '<pre>';
		//print_r($rMongo['_id']);
		//print_r($rMongo['name']);
		//echo '</pre>';
		$output = "";	
// preparo la stringa di output sostituendo eventuali virgole che interferiscono per la suddivisione dei campi in colonne(str_replace(cerca, sostituisci ,dove_cercare))
		$output .= str_replace(",", "" ,$rMongo['_id']) . ",". str_replace(",", "" ,$rMongo['name'])."\r";
//Manda a capo ogni riga
		if($output!= ''){$output.="\n";}
//				echo $output; //stampa a video il Dataset
		fwrite($destinazione, $output);
// setto la variabile per segnalare un successo nella ricerca
		$mark = 0;

// incremento il numero di riga
		$iteraction++;

	}
	echo '<pre>';
	print_r("...sto importando gli ObjectID da Mongo per creare i collegamenti...");
	echo '</pre>';
}catch (MongoDB\Driver\Exception\Exception $e) {
	echo "Exception!";
}
}

?>