<?php 

$secretKey = 'Xcad0T1dD04aEa25poASjs';
echo md5($secretKey);

$currentDate = date("dmY", strtotime("today"));
echo $currentDate;