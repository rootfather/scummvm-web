<?php

/*
 * Documentation Page for ScummVM
 * by Jeremy Newman <jnewman@dracowulf.com>
 *
 */

// set this for position of this file relative
$file_root = ".";

// load libraries
require($file_root."/include/"."incl.php");

// start of html
html_header("ScummVM");
sidebar_start();

//display News
echo html_round_frame_start("ScummVM Documentation","");
echo html_frame_start("","100%",1,1);

$view = $HTTP_GET_VARS['view'];

if ($view and file_exists($file_root."/docs/".$view.".xml"))
{
	// First extract the body from the XML file
	$html = display_xml($file_root."/docs/".$view.".xml",'BODY');
	// Now evaluate any PHP code embedded into it, and output the result
	echo '<tr valign="top" class="color2"><td>';
	echo eval("?>" . $html . "<?php ");
	echo "</td></tr>";
}
else
{
    // intro
    echo html_frame_tr(
                html_frame_td(
                              html_b("Documentation").html_br().
                              html_line().html_br(2)
                             )
                      );

    // get list of documentation items
    $docs = get_files($file_root."/docs","xml");
    sort($docs);
    
    // loop and display docs
    $c = 0;
    while (list($key,$item) = each($docs))
    {
        $c++;
        list($file,$ext) = split("\.",$item,2);
        echo html_frame_tr(
                    html_frame_td(
                                  html_ahref(display_xml($file_root."/docs/".$item,'NAME'),"$PHP_SELF?view=$file").html_br().
                                  display_xml($file_root."/docs/".$item,'DESC').html_br(2)."\n"
                                 )
                          );
    } // end of docs loop


	// Hard code link to doxygen for now...
	echo html_frame_tr(
				html_frame_td(
							  html_ahref("Source code documentation",$file_root."/docs/doxygen/html/index.php").html_br().
							  "Cross referenced source code documentation for ScummVM, generated using".
							  html_ahref("Doxygen","http://www.doxygen.org").html_br(2)."\n"
							 )
					  );
    
	// Hard code link to specs for now...
	echo html_frame_tr(
				html_frame_td(
							  html_ahref("The inComplete SCUMM Reference Guide",$file_root."/docs/specs/index.php").html_br().
							  "being a Partially Complete and Mostly Accurate guide to the SCUMM Engine data file Format
							   for Versions Five and Six (and above)".html_br(2)."\n"
							 )
					  );
    
    // outro
    echo html_frame_tr(
                html_frame_td(
                              html_line().html_p("Click the title of the section of the documentation you want to read.")
                             )
                      );    
    
}

echo html_frame_end();
echo html_round_frame_end("&nbsp;");
//end of docs display

// end of html
sidebar_end();
html_footer();

?>
