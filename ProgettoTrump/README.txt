1) Con un generatore di dati casuali generare il Dataset desiderato(1.000,10.000,100.000,1.000.000)
2)"manipulation_dataset.php" Eseguirlo attivando xampp da browser prestando attenzione a cambiare: Organization-Person(INVOLVED_WITH.csv),Person-Person(RELATED_TO.csv) e Organization-Organization(CONNECT_TO.csv). Esso genereerà i tre rispettivi csv nella cartella DataSet. 
3)Unire i tre documenti in un unico file csv COMPLETED nella stessa cartella.
4)"main.php" eseguendo questo file si inseriscono su mongo i documenti con i relativi collegamenti. Esso richiama più funzioni contenute in più file .php:
4.1)"importData.php" con la funzione importNameType() inserisce su mongo i documenti con nome e tipo senza doppioni, mentre mongo associa ad essi un objectID univoco per tutti.
4.2)"recuperoIDMongo.php" con la funzione importObjID() recupera da Mongo e salva nel file csv "recuperaID" gli objID con i relativi nomi.
4.3)"updateIDMongo.php" con la funzione aggregateObjID(), crea un dataset completo "ForMongo.csv" prendendo il file "COMPLETED.csv" e associando ad ogni nome il suo corrispondente objID.
4.4)"appendConnection.php" con la funzione insertConnection() inserisce su mongo tutte le connessioni relative ai documenti già esistenti.
5)FINE. Adesso si possono eseguire le query scritte in python eseguendole da terminale.