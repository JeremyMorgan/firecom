<?php

require_once('firecom.class.php');

// create new object
$firecom = new Firecom();

// refreshes data
$firecom->getFeedData();

// push us to new file
header('Location: http://www.jeremymorgan.com/apps/firecom/feed.php');
