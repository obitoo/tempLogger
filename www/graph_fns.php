<?php

   // graph stuff
   require_once ('jpgraph.php');
   require_once ('jpgraph_line.php');
   require_once ('jpgraph_date.php');

DEFINE('GRAPHMAXTMP',30); 
DEFINE('GRAPHMINTMP',10); 

function mygraph_read($filename)
{
   global $ydata, $xdata, $xrawdata;
   global $y2data;

   
   //$inputfile='/home/pi/tempLogger/'.$filename;


   //
   // read first file
   //
   $inputfile='/home/pi/tempLogger/tempdata1.txt';
   $lines = file($inputfile);


   $start = time();

   foreach ($lines as $line_num => $line) {
      // split line into strings
      list($xrawdata[$line_num], $ydata[$line_num]) = explode ("|", $line);

      // convert temp (Y axis) to float  - strips 'C' automatically
      $ydata[$line_num] = (float) $ydata[$line_num];

      // parse date into epoch seconds
       $xdata[$line_num] = strtotime($xrawdata[$line_num]);
   }

   //
   // second file  - assume same no of rows?
   //
   $inputfile='/home/pi/tempLogger/tempdata2.txt';
   // read file
   $lines = file($inputfile);


   $start = time();

   foreach ($lines as $line_num => $line) {
      // split line into strings
      list($xrawdata[$line_num], $y2data[$line_num]) = explode ("|", $line);

      // convert temp (Y axis) to float  - strips 'C' automatically
      $y2data[$line_num] = (float) $y2data[$line_num];

      // parse date into epoch seconds
       $xdata[$line_num] = strtotime($xrawdata[$line_num]);
   }


   return $line_num+1;
}


function mygraph_draw($colour)
{
   global $ydata, $xdata, $y2data;

   
//
// Create a data set in range (50,70) and X-positions
DEFINE('NDATAPOINTS',360);
DEFINE('SAMPLERATE',240); 
$start = time();
$end = $start+NDATAPOINTS*SAMPLERATE;
$data = array();
$xxdata = array();
for( $i=0; $i < NDATAPOINTS; ++$i ) {
    $data[$i] = rand(50,70);
    $xxdata[$i] = $start + $i * SAMPLERATE;
}


// Create the new graph
$graph = new Graph(850,300);
$graph->SetShadow();


// Slightly larger than normal margins at the bottom to have room for
// the x-axis labels
$graph->SetMargin(60,150,30,130);

// Fix the Y-scale to go between [0,100] and use date for the x-axis
//$graph->SetScale('datlin',GRAPHMINTMP,GRAPHMAXTMP);
$graph->SetScale('datlin');

// title
$graph->title->Set("Temp - Celsius");
//$graph->yaxis->title->Set('Temp - Celsius');
$graph->title->SetFont( FF_FONT1 , FS_BOLD );



// Set the angle for the labels to 90 degrees
$graph->xaxis->SetLabelAngle(90);

// Set data
$line = new LinePlot($ydata,$xdata);
$line->SetColor("blue");  
$line->SetWeight(2);

$line2 = new LinePlot($y2data,$xdata); // y2
$line2->SetColor("red");  
$line2->SetWeight(2);



$line->SetLegend('Main Bedroom');  // 048
$line->SetFillColor('lightblue@0.5');
$line2->SetLegend('Back Bedroom');  // 049
$line2->SetFillColor('lightpink@0.5');

$graph->Add($line);
$graph->Add($line2);



$graph->Stroke();
}



?>
