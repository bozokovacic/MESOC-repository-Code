<?php

        $path = "NUTS.txt";
	   
	$fp = fopen($path, "r");

	$buf = "";
	
        if(!$fp)
 
	{
		$fp = fopen($path, 'c');
	}
	else	
	{
		while(!feof($fp))
			$buf .= fread($fp, 4096);
	}
	fclose($fp);
	
	
	$trans_temp = explode("\n", $buf);	
	
	unset($buf);
               
        $i = 0;
	$tran_data = array();
	$tran = array();
	/* Break the array into a two dimensional array for data processing */
	foreach($trans_temp as $trans)
	{
            $trans_array = preg_split("[;]", $trans);
            $TerritCon = $trans_array[0];
            $RegionName1 = $trans_array[1];
            $RegionName2 = $trans_array[2];
            $RegionName3 = $trans_array[3];
            $CountryName = $trans_array[4];  
/**            die(var_dump($trans));
            $CountryCode = rtrim($trans_array[0]);
            $CountryName = rtrim($trans_array[1]);
            echo "Hey - ".' '.$CountryCode.' '.$CountryName.'<BR>';   */
            echo "Hey - ".' '.$RegionName1.' '.$RegionName2.' '.$RegionName3.' '.$CountryName; 
            
            $query = "SELECT * FROM Country WHERE CountryName ='$CountryName'";        
            echo $query.'<BR>';
            $resultGeneral = $this->db->query($query);
            $resultGeneral->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
            $resultGeneral = $resultGeneral->fetchAll($resultGeneral); 
//            die(var_dump($resultGeneral));
            foreach ($resultGeneral as $row => $result){                      
                     $ID_Country = $result['ID_Country'];
                 }
            
            echo "Hey - ".$ID_Country; 
            $NUTS = "NUTS 1";
            $region = new Region();
            if ( $RegionName1 != '-'){ 
                $RegionName = $RegionName1;
                $NUTSType = 'NUTS1';
            }
            if ( $RegionName2 != '-'){ 
                $RegionName = $RegionName2;
                $NUTSType = 'NUTS2';
            }
            if ( $RegionName3 != '-'){ 
                $RegionName = $RegionName3;
                $NUTSType = 'NUTS3';
            }
            
            $region->RegionTeritCon = $TerritCon;
            $region->ID_Country = $ID_Country; 
            
/**            $country = new Country();
            $country->CountryCode = $CountryCode;
            $country->CountryName = $CountryName;  */
            
           
            $query = "INSERT INTO region(ID_Region, RegionName, RegionTeritCon, NUTSType, ID_Country) VALUES (0, '$RegionName','$TerritCon','$NUTSType',$ID_Country)";        
            echo $query.'<BR>'; 
            $resultGeneral = $this->db->query($query);
/**                if ($country->save() == false) {            
                    foreach ($coluntry->getMessages() as $message) {
                $this->flash->error($message); 
             }  
          }     */
        }
	
	$tran = array();
	$j = 0;
        
	echo "<table border=\"1\"><tr>";
	printf("<td>Naslov</td><td>Komentar</td>");
	echo("<tr></tr>");
	foreach($tran_data as $trans)
	{
		$i = 0;
		foreach($trans as $tran_item) 	
			printf("<td>%s</td>", $tran_item);
		echo("<tr></tr>");
	}
	echo "</tr></table>";
         
        $docinstitution = Docinstitution::find(" ID_Doc = '$ID_Doc'");


