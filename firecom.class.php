<?php

class Firecom {

    public function getFeedData() {

        $myFile = "feed.php";

        $data = file_get_contents("http://www.wccca.com/PITSv1/"); //thanks WCCCA!
        $pattern = "/id=\"hidXMLID\" value=\"([^\"]+)\"/"; //looking for the rnd xml id#
        preg_match_all($pattern, $data, $xmlext);

        $fh = fopen($myFile, 'w');

        fwrite($fh, "<?php header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1. header('Pragma: no-cache'); // HTTP 1.0. header('Expires: 0'); // Proxies  ?><link rel=\"apple-touch-icon\" href=\"/apple-touch-icon.png\"/><style type=\"text/css\"> body { background-color:#000000; color: #ffffff; } .littletext { font-size: x-small; color:#616161; font-style:italic; } .units { font-size: small; color:#C4C2C3;}</style><center><a href=\"http://www.wccca.com/PITS/\"><img src=\"wccca.png\" border=\"0\"></a>
		<br><br><span class=\"littletext\">Last update: " . date('g:iA ', time() - 7200) . "<br><br>Latest News: Map Functionality is fixed!</span><br></center><br /><hr>");
        fclose($fh);

        $url = "http://www.wccca.com/PITSv1/xml/fire_data_" . $xmlext[1][0] . ".xml"; //putting together the secret xml url
        $xml = simplexml_load_file($url);

        foreach ($xml->marker as $row) {

            $maplat = $row->attributes()->lat[0];
            $maplong = $row->attributes()->lng[0];

            //echo $row->AGENCY;

            $data2 = file_get_contents("$url");
            $calltime = $row->CALL_CREATED_DATE_TIME;
            preg_match_all("/lat=\"([^\"]+)\"/", $data2, $latout); //get the lat
            preg_match_all("/lng=\"([^\"]+)\"/", $data2, $lngout); //get the lon

            $latt = $latout[0][0]; //string for the lat
            $long = $lngout[0][0]; //string for the lon
            $county = $row->AGENCY; // get first marker agency
            $id = $row->TWO_DIGIT_CALL_NO; // get call id#
            $call = $row->CALL_TYPE_FINAL_D; // get first marker call type
            $location = $row->LOCATION; // get first marker location
            $station = $row->BEAT_OR_STATION; // get first marker station
            $units = $row->UNITS; // get first marker units
            //this next section removes the "~" from the start of all the lines
            $cleancounty = str_replace('~', '', $county);
            $cleancall = str_replace('~', '', $call);
            $cleanstation = str_replace('~', '', $station);
            $cleanlocation = str_replace('~', '', $location);
            $cleanunits = str_replace('~', '', $units);
            $cleancalltime = str_replace('~', '', $calltime);
            $cleanid = str_replace('~', '', $id);
            //cleans up the lat and lon
            $lati = str_replace('lat="', '', $latt);
            $llatt = str_replace('"', '', $lati);
            $longi = str_replace('lng="', '', $long);
            $llonn = str_replace('"', '', $longi);

            // start changing names

            $symbols = array();
            $stationnames = array();

            // these are the names as they are stored in the XML
            $symbols[0] = '/EST/';
            $symbols[1] = '/BRR/';
            $symbols[2] = '/GAF/';
            $symbols[3] = '/FGR/';
            $symbols[4] = '/COF/';
            $symbols[5] = '/CHS/';
            $symbols[6] = '/GLA/';
            $symbols[7] = '/CNB/';
            $symbols[8] = '/HWH/';
            $symbols[9] = '/BKF/';
            $symbols[10] = '/BUX/';
            //$symbols[11] = '/FG/';
            $symbols[12] = '/MW/';
            $symbols[13] = '/TIG/';
            $symbols[14] = '/FGF/';
            $symbols[15] = '/WIL/';
            $symbols[16] = '/HBM/';
            $symbols[17] = '/HPW/';
            $symbols[18] = '/HRA/';
            $symbols[19] = '/PRO/';
            $symbols[20] = '/WAL/';
            $symbols[21] = '/NPF/';
            $symbols[22] = '/RCK/';
            $symbols[23] = '/HCL/';
            $symbols[24] = '/KCF/';
            $symbols[25] = '/SHW/';
            $symbols[26] = '/WSL/';
            $symbols[27] = '/ALO/';
            $symbols[28] = '/HJF/';
            $symbols[29] = '/WFD/';

            // these are "friendly names"
            $stationnames[0] = "ESTACADA FIRE";
            $stationnames[1] = "TVF&R - BEAVERTON";
            $stationnames[2] = "GASTON FIRE";
            $stationnames[3] = "FOREST GROVE FIRE";
            $stationnames[4] = "CORNELIUS FIRE";
            $stationnames[5] = "TVF&R - CEDAR HILLS";
            $stationnames[6] = "GLADSTONE";
            $stationnames[7] = "CANBY FIRE";
            $stationnames[8] = "HILLSBORO FIRE";
            $stationnames[9] = "BANKS FIRE";
            $stationnames[10] = "BANKS FIRE";
            //$stationnames[11] = "FOREST GROVE FIRE";
            $stationnames[12] = "WCFD 2 MIDWAY";
            $stationnames[13] = "TVF&R - TIGARD";
            $stationnames[14] = "FOREST GROVE FIRE";
            $stationnames[15] = "TVF&R - WILSONVILLE";
            $stationnames[16] = "HILLSBORO FIRE - STATION 1";
            $stationnames[17] = "HILLSBORO FIRE - PARKWOOD";
            $stationnames[18] = "HILLSBORO FIRE - RONLER ACRES";
            $stationnames[19] = "TVF&R - PROGRESS";
            $stationnames[20] = "TVF&R - TIGARD";
            $stationnames[21] = "NORTH PLAINS FIRE";
            $stationnames[22] = "HILLSBORO FIRE - RONLER ACRES";
            $stationnames[23] = "HILLSBORO FIRE - CHERRY LANE";
            $stationnames[24] = "TVF&R - KING CITY";
            $stationnames[25] = "TVF&R - SHERWOOD";
            $stationnames[26] = "TVF&R - WEST SLOPE";
            $stationnames[27] = "TVF&R - ALOHA";
            $stationnames[28] = "HILLSBORO FIRE - JONES FARM";
            $stationnames[29] = "TVF&R - WEST LINN";

            $cleanstation = preg_replace($symbols, $stationnames, $cleanstation);

            $tiny_url = 'http://maps.google.com/maps?z=12&q=' . $maplat . "+" . $maplong;

            // select only Washington County Calls
            if ($cleancounty == "W") {

                $tiny_url = 'http://maps.google.com/maps?z=12&q=' . $maplat . "+" . $maplong;

                //put the parts together
                $status = "<strong>" . $cleancall . " - " . $cleanstation . "</strong><br>" . $cleanlocation . "<br /><span class=\"units\">Units: " . $cleanunits .
                        "</span><br><span class=\"littletext\">Call Time:" . $cleancalltime . "</span><br><a href=\"" . $tiny_url . "\">View Map</a><hr>"; //assemble status for twitter

                $fh = fopen($myFile, 'a');
                fwrite($fh, $status);
                fclose($fh);
            }
            unset($tiny_url);
        }
        if (!$status) {

            $fh = fopen($myFile, 'a');
            fwrite($fh, "There are currently no 911 calls. This is a good thing.");
            fclose($fh);
        } else {

            $fh = fopen($myFile, 'a');
            fwrite($fh, "<center><form action=\"loader.php\" method=\"post\"><input type=\"submit\" value=\"Refresh Call List\"></form></center><br><p>What do you think of the changes? Got suggestions? Contact me on <a href=\"http://www.facebook.com/jeremycmorgan\">Facebook</a> or <a href=\"https://twitter.com/jeremycmorgan\">Twitter</a></p>");
            fclose($fh);
        }
    }

    public function writedata($data, $mode) {

        $myFile = "dynamicfeed.php";

        if ($mode = "new") {
            $fh = fopen($myFile, 'w') or die("can't open file");
        }
        if ($mode = "append") {
            $fh = fopen($myFile, 'a') or die("can't open file");
        }
        fwrite($fh, $data);
        fclose($fh);
    }

}

?>
