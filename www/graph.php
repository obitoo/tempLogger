<?php 
   include('graph_fns.php'); 

   // globals
   $ydata = array();
   $xdata = array();

   // read files
   read_all_graph_data();

   // jpgraph calls
   mygraph_draw();

?> 
