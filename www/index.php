<head>
<link rel="shortcut icon" href="http://192.168.7.184/favicon.ico" />
<title>Temp Logger - pi </title>
</head>
Temp Logger - RPi - Twin sensors <p>
 <img src="graph.php" >

<p>

<?php 
   include('graph_fns.php'); 


   // All work is done in the above call to graph.php. Here we read again 
   // just so we can dump the raw data

   $num_rows = mygraph_read("tempdata1.txt");
   print "Num Rows:  $num_rows   <p>";

   // dump

   for ($i = $num_rows; $i >= 0 ; $i-- ) {
      print "Line #<b>{$i}</b> : " ;
      print "   y=".$ydata[$i]." ,x=". 
                    $xdata[$i]."   (xRaw=". 
                    $xrawdata[$i]. 
                   ")<br />\n";
   }

   
 ?> 

<p>
<a href="http://192.168.7.184/jpgraph/src/Examples/testsuit.php"> jpgraph/testsuit.php </a>
<br>
<a href="http://192.168.7.184/jpgraph/docportal/chunkhtml/index.html" > jpgraph/manual.html </a>
</body>
