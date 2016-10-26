<?php header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1. 
header('Pragma: no-cache'); 
header('Expires: 0');

//require_once('firecom.class.php');
?>
<meta http-equiv="refresh" content="30">
<link rel="apple-touch-icon" href="/apple-touch-icon.png"/>
<style type="text/css"> body { background-color:#000000; color: #ffffff; } .littletext { font-size: x-small; font-style:italic; } .units { font-size: small; color:#C4C2C3;} .MEDICAL {background-color: #ada300; padding: 2px; margin: 2px; } .FIRE {background-color: #5c0000;  padding: 2px; margin: 2px;} .POLICE { background-color: #000080; padding: 2px; margin: 2px; }.callSum{ color:#ffffff; font-size:large;}</style><center><a href="http://www.wccca.com/PITS/"><img src="wccca.png" border="0"></a>

<br>
<br>
</center>
<hr>
<p>Special thanks to Brandan for giving us a new data feed!!! Check out his site at <a href="http://cad.oregon911.net">Oregon911.net</a></p>
<hr>
<!-- news and updates go here --> 
<?php

$url = "http://www.api.oregon911.net/api/1.0/?method=listCalls&key=5baff2eaa4a8b80503213a410b17bac43715025a&type=JSON";

$handle=fopen($url,"rb");
// initialize
$lines_string="";
// read content line by line
do{
    $data=fread($handle,1024);
    if(strlen($data)==0) {
        break;
    }
    $lines_string.=$data;
}while(true);
//close handle to release resources
fclose($handle);
//output, you can also save it locally on the server

$json = json_decode($lines_string, true);

foreach ($json as $row){
  
    $callType = "";

    if ($row['county'] == 'W'){
    

        if ($row['type'] == 'M'){
            $callType = "MEDICAL";
        }
        if ($row['type'] == 'F'){
            $callType = "FIRE";
        }
        if ($row['type'] == 'P'){
            $callType = "POLICE";
        }


    echo "<div class=\"" . $callType . "\">
    <span class=\"callSum\">" . $row['callSum'] . "</span><br />
    <span>" . getDepartment($row['station']) . " (" . $callType . ") </span><br />
    <span>" . $row['address'] . "</span><br />
    <span class=\"units\">Units:  " . $row['units'] . "</span><br />
    <br>
    <span class=\"littletext\">Dispatched: " . $row['timestamp'] . "</span><br />
    </center></div>
    <hr>";

    }
    
}

function getDepartment ($station) 
    {
         $stations = array (
                    "CBOC" => "TUALATIN VALLEY FIRE & RESCUE", // Tualatin Valley Fire & Rescue
                    "SHW" => "TUALATIN VALLEY FIRE & RESCUE",
                    "TUA" => "TUALATIN VALLEY FIRE & RESCUE",
                    "KCF" => "TUALATIN VALLEY FIRE & RESCUE",
                    "WAL" => "TUALATIN VALLEY FIRE & RESCUE",
                    "TIG" => "TUALATIN VALLEY FIRE & RESCUE",
                    "WIL" => "TUALATIN VALLEY FIRE & RESCUE",
                    "PRO" => "TUALATIN VALLEY FIRE & RESCUE",
                    "CNL" => "TUALATIN VALLEY FIRE & RESCUE",
                    "CHS" => "TUALATIN VALLEY FIRE & RESCUE",
                    "ALO" => "TUALATIN VALLEY FIRE & RESCUE",
                    "RCK" => "TUALATIN VALLEY FIRE & RESCUE",
                    "WSL" => "TUALATIN VALLEY FIRE & RESCUE",
                    "BRR" => "TUALATIN VALLEY FIRE & RESCUE",
                    "BVM" => "TUALATIN VALLEY FIRE & RESCUE",
                    "KAI" => "TUALATIN VALLEY FIRE & RESCUE",
                    "SKY" => "TUALATIN VALLEY FIRE & RESCUE",
                    "CMT" => "TUALATIN VALLEY FIRE & RESCUE",
                    "ERD" => "TUALATIN VALLEY FIRE & RESCUE",
                    "MTR" => "TUALATIN VALLEY FIRE & RESCUE",
                    "BOL" => "TUALATIN VALLEY FIRE & RESCUE",
                    "WFD" => "TUALATIN VALLEY FIRE & RESCUE",
                    "HBM" => "HILLSBORO FIRE DEPARTMENT", // Hillsboro Fire Department
                    "HWH" => "HILLSBORO FIRE DEPARTMENT",
                    "HRA" => "HILLSBORO FIRE DEPARTMENT",
                    "HJF" => "HILLSBORO FIRE DEPARTMENT",
                    "HCL" => "HILLSBORO FIRE DEPARTMENT",
                    "FGF" => "FOREST GROVE FIRE & RESCUE", // Forest Grove Fire & Rescue
                    "GCF" => "FOREST GROVE FIRE & RESCUE",
                    "NPF" => "WASHINGTON COUNTY FIRE DISTRICT #2", // Washington County Fire District #2
                    "MWF" => "WASHINGTON COUNTY FIRE DISTRICT #2",
                    "COF" => "CORNELIUS FIRE DEPARTMENT", // Cornelius Fire Department
                    "BKF" => "BANKS FIRE DISTRICT #13", // Banks Fire District
                    "BUX" => "BANKS FIRE DISTRICT #13",
                    "TIM" => "BANKS FIRE DISTRICT #13",
                    "GAF" => "GASTON FIRE DEPARTMENT", // Gaston Fire Department
                    "BOR" => "BORING FIRE DISTRICT", // Boring Fire District
                    "ECR" => "BORING FIRE DISTRICT",
                    "DAM" => "BORING FIRE DISTRICT",
                    "CNB" => "CANBY FIRE DISTRICT #62", // Canby Fire District #62
                    "LNE" => "CANBY FIRE DISTRICT #62",
                    "TCR" => "CLACKAMAS FIRE DISTRICT #1", // Clackamas Fire District #1
                    "MIL" => "CLACKAMAS FIRE DISTRICT #1",
                    "OGR" => "CLACKAMAS FIRE DISTRICT #1",
                    "LKR" => "CLACKAMAS FIRE DISTRICT #1",
                    "CAU" => "CLACKAMAS FIRE DISTRICT #1",
                    "HVA" => "CLACKAMAS FIRE DISTRICT #1",
                    "PVA" => "CLACKAMAS FIRE DISTRICT #1",
                    "CLA" => "CLACKAMAS FIRE DISTRICT #1",
                    "HOL" => "CLACKAMAS FIRE DISTRICT #1",
                    "BCK" => "CLACKAMAS FIRE DISTRICT #1",
                    "RDL" => "CLACKAMAS FIRE DISTRICT #1",
                    "LOG" => "CLACKAMAS FIRE DISTRICT #1",
                    "CLK" => "CLACKAMAS FIRE DISTRICT #1",
                    "HLD" => "CLACKAMAS FIRE DISTRICT #1",
                    "JAS" => "CLACKAMAS FIRE DISTRICT #1",
                    "HLT" => "CLACKAMAS FIRE DISTRICT #1",
                    "SND" => "CLACKAMAS FIRE DISTRICT #1",
                    "COL" => "COLTON FIRE DISTRICT #70", // Colton Fire District
                    "EST" => "ESTACADA FIRE DISTRICT #69", // Estacada Fire District
                    "GEO" => "ESTACADA FIRE DISTRICT #69",
                    "GLA" => "GLADSTONE FIRE DEPARTMENT", // Gladstone Fire Department
                    "WEL" => "HOODLAND FIRE DISTRICT #74", // Hoodland Fire District
                    "BRI" => "HOODLAND FIRE DISTRICT #74",
                    "GOV" => "HOODLAND FIRE DISTRICT #74",
                    "MOL" => "MOLALLA FIRE DISTRICT #73", // Molalla Fire District TODO: Add Station 85 of Mollala
                    "MUL" => "MOLALLA FIRE DISTRICT #73",
                    "SAN" => "SANDY FIRE DISTRICT #72", // Sandy Fire District
                    "DVR" => "SANDY FIRE DISTRICT #72",
                    "RLK" => "SANDY FIRE DISTRICT #72"); 

        return $stations[$station];
    }

echo "<center><form action=\"feed.php\" method=\"post\"><input type=\"submit\" value=\"Refresh Call List\"></form></center><br><br>
    <p></p>";
?>
