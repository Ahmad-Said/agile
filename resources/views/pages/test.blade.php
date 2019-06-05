@extends('layouts.app')

@section('content')
<?php   
/* CAT:Misc */

/* pChart library inclusions */
// namespace App\CustomStuff\CustomDirectory;

// require_once("bootstrap.php");


//  namespace vendor\bozhinov\pchart;
// include(pChart\pDraw);
// include("..\..\\vendor\bozhinov\pchart\csharpcorner.php");
// include("..\..\\vendor\bozhinov\pchart\pBarcode128.php");
// include("..\..\\vendor\bozhinov\pchart\pBarcode39.php");
// include("..\..\\vendor\bozhinov\pchart\pBubble.php");
// include("..\..\\vendor\bozhinov\pchart\pCharts.php");
// include("..\..\\vendor\bozhinov\pchart\pColor.php");
// include("..\..\\vendor\bozhinov\pchart\pColorGradient.php");
// include("..\..\\vendor\bozhinov\pchart\pData.php");
// include("..\..\\vendor\bozhinov\pchart\pDraw.php");
// include("..\..\\vendor\bozhinov\pchart\pException.php");
// include("..\..\\vendor\bozhinov\pchart\pIndicator.php");
// include("..\..\\vendor\bozhinov\pchart\pPie.php");
// include("..\..\\vendor\bozhinov\pchart\pRadar.php");
// include("..\..\\vendor\bozhinov\pchart\pScatter.php");
// include("..\..\\vendor\bozhinov\pchart\pSpring.php");
// include("..\..\\vendor\bozhinov\pchart\pStock.php");
// include("..\..\\vendor\bozhinov\pchart\pSurface.php");

// use pChart\pDraw;
// use pChart\pCharts;

// /* Create a pChart object and associate your dataset */ 
// $myPicture = new pDraw(700,230);
// // var_dump($myPicture);
// /* Add data in your dataset */ 
// $myPicture->myData->addPoints([1,3,4,3,5]);

// /* Choose a nice font */
// $a=$myPicture->setFontProperties(["FontName"=>"C:/wamp64/www/agile/vendor/bozhinov/pchart/C:/wamp64/www/agile/vendor/bozhinov/pchart/pChart/fonts/Forgotte.ttf","FontSize"=>11]);
// // var_dump($a);
// /* Define the boundaries of the graph area */
// $myPicture->setGraphArea(60,40,200,300);

// /* Draw the scale, keep everything automatic */ 
// $myPicture->drawScale();

// /* Draw the scale, keep everything automatic */ 
// (new pCharts($myPicture))->drawSplineChart();

// /* Render the picture (choose the best way) */
// $myPicture->render("storage/graph_images/example.basic.png");


?>

<?php   
/* CAT:Polar and radars */

/* pChart library inclusions */
// require_once("bootstrap.php");

use pChart\{
	pColor,
	pDraw,
	pRadar
};

/* Create the pChart object */
$myPicture = new pDraw(700,230);

/* Populate the pData object */
$myPicture->myData->addPoints([40,20,15,10,8,4],"ScoreA");  
$myPicture->myData->addPoints([8,10,12,20,30,15],"ScoreB"); 
$myPicture->myData->addPoints([4,8,16,32,16,8],"ScoreC"); 
$myPicture->myData->setSerieDescription("ScoreA","Application A");
$myPicture->myData->setSerieDescription("ScoreB","Application B");
$myPicture->myData->setSerieDescription("ScoreC","Application C");

/* Define the abscissa serie */
$myPicture->myData->addPoints(["Size","Speed","Reliability","Functionalities","Ease of use","Weight"],"Labels");
$myPicture->myData->setAbscissa("Labels");

/* Draw a solid background */
$myPicture->drawFilledRectangle(0,0,700,230,["Color"=>new pColor(179,217,91), "Dash"=>TRUE, "DashColor"=>new pColor(199,237,111)]);

/* Overlay some gradient areas */
$Settings = 
$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,["StartColor"=>new pColor(194,231,44,50),"EndColor"=>new pColor(43,107,58,50)]);
$myPicture->drawGradientArea(0,0,700,20, DIRECTION_VERTICAL,["StartColor"=>new pColor(0,0,0,100),"EndColor"=>new pColor(50,50,50,100)]);

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,699,229,["Color"=>new pColor(0,0,0)]);

/* Write the picture title */ 
$myPicture->setFontProperties(array("FontName"=>"C:/wamp64/www/agile/vendor/bozhinov/pchart/pChart/fonts/Silkscreen.ttf","FontSize"=>6));
$myPicture->drawText(10,13,"pRadar - Draw radar charts",["Color"=>new pColor(255,255,255)]);

/* Set the default font properties */ 
$myPicture->setFontProperties(array("FontName"=>"C:/wamp64/www/agile/vendor/bozhinov/pchart/pChart/fonts/Forgotte.ttf","FontSize"=>10,"Color"=>new pColor(80,80,80)));

/* Enable shadow computing */ 
$myPicture->setShadow(TRUE,["X"=>1,"Y"=>1,"Color"=>new pColor(0,0,0,10)]);

/* Create the pRadar object */ 
$SplitChart = new pRadar($myPicture);

/* Draw a radar chart */ 
$myPicture->setGraphArea(10,25,300,225);
$Options = [
	"Layout"=>RADAR_LAYOUT_STAR,
	"BackgroundGradient"=>["StartColor"=>new pColor(255,255,255,100),"EndColor"=>new pColor(207,227,125,50)],
    "FontName"=>"C:/wamp64/www/agile/vendor/bozhinov/pchart/pChart/fonts/pf_arma_five.ttf","FontSize"=>6
    // ,    "WriteValues"=>TRUE  // add this line to show value points on chart
];
$SplitChart->drawRadar($Options);

/* Draw a radar chart */ 
$myPicture->setGraphArea(390,25,690,225);
$Options = [
	"Layout"=>RADAR_LAYOUT_CIRCLE,
	"LabelPos"=>RADAR_LABELS_HORIZONTAL,
	"BackgroundGradient"=>["StartColor"=>new pColor(255,255,255,50),"EndColor"=>new pColor(32,109,174,30)],
	"FontName"=>"C:/wamp64/www/agile/vendor/bozhinov/pchart/pChart/fonts/pf_arma_five.ttf","FontSize"=>6
];
$SplitChart->drawRadar($Options);

/* Write the chart legend */ 
$myPicture->setFontProperties(["FontName"=>"C:/wamp64/www/agile/vendor/bozhinov/pchart/pChart/fonts/pf_arma_five.ttf","FontSize"=>6]);
$myPicture->drawLegend(235,205,["Style"=>LEGEND_BOX,"Mode"=>LEGEND_HORIZONTAL]);

/* Render the picture (choose the best way) */
$myPicture->render("storage/graph_images/example.polar.values.png");

?>
<img src="storage/graph_images/example.polar.values.png" style="width: 500px;">
<img src="storage/graph_images/final_result.png" style="width: 500px;">
hello there 

{{-- in general we replace font parameter by full path and comment require bootstrap to make things work
    check my opened issue :
    https://github.com/bozhinov/pChart2.0-for-PHP7/issues/25
    --}}
{{-- for jstree --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/themes/default/style.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/jstree.min.js"></script>
    

    <button onclick="submitMe()">Click me</button>

    <p id="demo"></p>
    
    <script>
    // function myFunction() {
    //   document.getElementById("demo").innerHTML = "Hello World";
    // }
    </script>




<div >
    <div id="mytree">
        <ul>
          <li id='g1'>Groupe 1
            <ul>
              
            <li id='g1t1'>Team node 1
                <ul>
                        <li id='g1m45'>Child node 2</li>
                </ul>

            </li>
              
            </ul>
          </li>
          <li id='g2'> Groupe 2
                <ul>
              
                        <li id='g2t2'>Team node 1

                                <ul>
                                        <li id='g2m45'>Child node 2</li>
                                </ul>

                        </li>
                         
                        </ul>

          </li>
        </ul>
      </div>
      <script>
                        $(function() {
                $('#mytree').jstree({
                    'plugins':["checkbox","unique","state","wholerow"],
                    "state" : { "key" : "state_demo" } // conserve opened state
            
                    
                });
                $('button').on("click", function () {
                    var instance = $('#mytree').jstree(true);
                    instance.deselect_all();
                    instance.select_node('1');
                });
                
                });
      </script>
    <script>

        
            // listen for event

            $('#mytree').on("changed.jstree", function (e, data) {
            console.log(data.selected);
            var i, j, r = [];
                for(i = 0, j = data.selected.length; i < j; i++) {
                // r.push(data.instance.get_node(data.selected[i]).text);
                r.push(data.instance.get_node(data.selected[i]).id);
                }
            document.getElementById("demo").innerHTML = 'Selected: '+ r.toString();
            document.getElementById("sub").value =r.toString();
            //   document.getElementById("demo").value = 'Selected: '+ r.toString();
            });
        </script>
<input type="submit" id='sub' value='var'> 
<br>
// later we can add this button type hidden
    


<div id="jstree2" class="demo jstree jstree-2 jstree-default jstree-checkbox-selection" style="margin-top:2em;" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_1" aria-busy="false"><ul class="jstree-container-ul jstree-children jstree-wholerow-ul jstree-no-dots" role="group"><li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_1_anchor" aria-expanded="true" id="j2_1" class="jstree-node  jstree-open"><div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="j2_1_anchor"><i class="jstree-icon jstree-checkbox jstree-undetermined" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>Same but with checkboxes</a><ul role="group" class="jstree-children"><li role="treeitem" aria-selected="true" aria-level="2" aria-labelledby="j2_2_anchor" id="j2_2" class="jstree-node  jstree-leaf"><div unselectable="on" role="presentation" class="jstree-wholerow jstree-wholerow-clicked">&nbsp;</div><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor  jstree-clicked" href="#" tabindex="-1" id="j2_2_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>initially selected</a></li><li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j2_3_anchor" id="j2_3" class="jstree-node  jstree-leaf"><div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="j2_3_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon jstree-themeicon-custom" role="presentation" style="background-image: url(&quot;//jstree.com/tree-icon.png&quot;); background-position: center center; background-size: auto;"></i>custom icon URL</a></li><li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j2_4_anchor" aria-expanded="true" id="j2_4" class="jstree-node  jstree-open"><div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="j2_4_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>initially open</a><ul role="group" class="jstree-children"><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j2_5_anchor" id="j2_5" class="jstree-node  jstree-leaf jstree-last"><div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="j2_5_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>Another node</a></li></ul></li><li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j2_6_anchor" id="j2_6" class="jstree-node  jstree-leaf jstree-last"><div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="j2_6_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon glyphicon glyphicon-leaf jstree-themeicon-custom" role="presentation"></i>custom icon class</a></li></ul></li><li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_7_anchor" id="j2_7" class="jstree-node  jstree-leaf jstree-last"><div unselectable="on" role="presentation" class="jstree-wholerow">&nbsp;</div><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="j2_7_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>And wholerow selection</a></li></ul></div>
<script>
        $(function () {
            $('#jstree1').jstree();
            $('#jstree2').jstree({'plugins':["wholerow","checkbox"], 'core' : {
                'data' : [
                    {
                        "text" : "Same but with checkboxes",
                        "children" : [
                            { "text" : "initially selected", "state" : { "selected" : true } },
                            { "text" : "custom icon URL", "icon" : "//jstree.com/tree-icon.png" },
                            { "text" : "initially open", "state" : { "opened" : true }, "children" : [ "Another node" ] },
                            { "text" : "custom icon class", "icon" : "glyphicon glyphicon-leaf" }
                        ]
                    },
                    "And wholerow selection"
                ]
            }});
        });
        </script>
        @endsection