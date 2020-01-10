<?php 
function aggregateObjID(){
echo '<pre>';
print_r("...attendi, sto elaborando...");
echo '</pre>';
ini_set('max_execution_time', 9999999999999999);
// Nome dei file
$completed='Dataset/COMPLETED.csv';
$recuperaID='Dataset/recuperaID.csv';
// Leggo il contenuto del file
$rows1 = file( $completed );
//array associativi
foreach ($rows1 as $key => $value)
{
	$connect[$key] = str_getcsv($value,",","\n");
}
// Leggo il contenuto del file
$rows2 = file( $recuperaID );
//array associativi
foreach ($rows2 as $key => $value)
{
	$id[$key] = str_getcsv($value,",","\n");
}
$conto1=count($connect);//numero di valori restituiti
$conto2=count($id);//numero di valori restituiti
$destinazione = fopen('Dataset/ForMongo.csv', 'w'); //crea documento csv da riempire
for ($i=0; $i <$conto1 ; $i++) { //i è l'indice di CONNECT
	for ($j=0; $j <$conto2 ; $j++) { //j è il primo indice di MONGO
		for ($k=0; $k <$conto2 ; $k++) { //k è il secondo indice di MONGO
			$output = "";
			if (($connect[$i][0]==$id[$j][1])&&($connect[$i][2]==$id[$k][1])) {
				$output .= $id[$j][0] . ",". $connect[$i][0].",".$id[$k][0].",".$connect[$i][2].",".$connect[$i][1].",".$connect[$i][3]."\r";
//Manda a capo ogni riga
				if($output!= ''){$output.="\n";}
//				echo $output; //stampa a video il dataset
				fwrite($destinazione, $output);
// setto la variabile per segnalare un successo nella ricerca
				$mark = 0;
			}

		}
	}
}

}

?>