#!/usr/bin/php


<?
//apro connessione al db//

include ("connessione-1.php");



 //controllo che siano diversi da null
 if($parolachiave!= NULL)
 {
 
	 //rendo minuscolo e poi maiuscola la key
	 $parolachiave= strtolower($parolachiave);
	 $parolachiave1=strtoupper($parolachiave);
	
	 
	
	 echo "chiave cercata ". $parolachiave;
	 echo "<br>";
	

	echo 'Time Start ,Now:       '. date ("o\g\g\i: D F Y H:i:s");
	flush(); @ob_flush();  ## make sure that all output is sent in real-time 
	set_time_limit(180000); //imposto a xxxx sec il tempo limite per lo script//
	$reader=new XMLReader(); //creo il reader xml
	$reader->open("dblp.xml");//apro il reader
	$reader->setParserProperty(XMLReader::VALIDATE,TRUE);//valido il readerxml con il file dtd 
	echo "reader caricato"; flush(); @ob_flush();  ## make sure that all output is sent in real-time
	echo "<br>"; 
	flush(); @ob_flush();  ## make sure that all output is sent in real-time
	
	while ($reader->read())
	{
		switch($reader->nodeType)
		{
		 case(XMLREADER::ELEMENT):            
				
			
				    if(($reader->localName != "dblp" )&&($reader->localName!="title"))
					{      
					
					if((strpos($reader->readInnerXml(),$parolachiave)||strpos($reader->readInnerXml(),$parolachiave1)) && strpos($reader->readInnerXml(),"author"))//legge il contenuto della stringa
							{
							
							//creo il dom per ogni corrispondenza trovata
							$dom= new DOMDocument();
							$xml1= simplexml_import_dom($dom->importNode($reader->expand(),true));
							if(strpos($xml1->booktitle,$parolachiave)||strpos($xml1->title,$parolachiave)||strpos($xml1->booktitle,$parolachiave1)||strpos($xml1->title,$parolachiave1))
								{
								$reader->moveToElement(); //move ther cursor on the partent element , quindi incollection
								echo "tipo:". $reader->name;echo "<br>"; 
								$reader->moveToAttribute("key");
								echo "key: ".$reader->value;echo "<br>";
								$key=$reader->value;
								echo "titolo: ". $xml1->title;echo "<br>"; 
								 $title=addslashes($xml1->title);
								echo "Booktitle:". $xml1->booktitle;echo "<br>";
								echo "Year:". $xml1->year;echo "<br>";
								echo "Url:". $xml1->url;echo "<br>";
								echo "Pages:". $xml1->pages;echo "<br>";
							    include("RICERCA ENTITA.php"); //inserisco i valori nelle variabili

								 foreach($xml1->author as $terzo)//per ogni autore trovato stampa varie
                               {
                                   echo "autore è ".$terzo; //stampo  il cognome dell'autore        
                                   echo "<br>";
								   $author1=(string)$terzo;
                                   $author1=addslashes($author1);
                                   //inserisco gli autori ricercati per chiave 
                                include("INSERIMENTO DATABASE PER CHIAVE.php"); //inserisco tutti i dati nel db

                                   
                                   
                                     
                               }
								flush(); @ob_flush();  ## make sure that all output is sent in real-time
								echo "<br><br>";
								}
							}
						
				    }
 
	       }


}
 }


 ?>


