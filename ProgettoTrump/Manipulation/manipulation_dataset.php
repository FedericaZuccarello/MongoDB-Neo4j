<?php
// il file da cui prendere i dati
$csv = "10.000.csv";
// termine da cercare 
//Sostituire Organization o Person in base al dataset da generare
$term = "Person";
$term1 =  "Organization";
// imposto il separatore
$sep = ",";
$mark = 1; // per la segnalazione di uscita
$iteraction = 1; // per sapere a che riga ho l'occorrenza
// apro il file e lo scorro
if (($handle = fopen($csv, "r")) !== FALSE) {
    $destinazione = fopen('INVOLVED_WITH.csv', 'w'); //crea documento csv da riempire
    while (($data = fgetcsv($handle, 1000, $sep)) !== FALSE) {
// una stringa per preparare l'output a video
    	$output = "";
// controllo se c'è il termine
    	if ($data[0] === $term && $data[2] === $term1) {
// preparo la stringa di output sostituendo eventuali virgole che interferiscono per la suddivisione dei campi in colonne(str_replace(cerca, sostituisci ,dove_cercare))
    		$output .= str_replace(",", "" ,$data[1]) . ",". str_replace(",", "" ,$data[4]).",".str_replace(",", "" ,$data[3]).",".$data[5]."\r";
//Manda a capo ogni riga
    		if($output!= ''){$output.="\n";}
//				echo $output; //stampa a video il dataset
    		fwrite($destinazione, $output);
// setto la variabile per segnalare un successo nella ricerca
    		$mark = 0;
    	}
// incremento il numero di riga
    	$iteraction++;
    }
}
// se non ha trovato nulla mostro il messaggio di uscita
if ($mark != 0 ) {
	echo "nessuna occorrenza di $term";
}
fclose($destinazione);
?>