<?php
///////////////////////////////////////////////////////////////////////////////
//
// facebook PHP RSS Parser by Kerri Shotts (photoKandy Studios)
//
// Version 0.5
//
// Supports facebook Feeds
//
///////////////////////////////////////////////////////////////////////////////


//
// facebook_Item Class
// ---------------------------------------------------------------------------
//
// facebook Item has the following properties:
//
//   title: the title of the item
//   link:  the link to the image on SM
//   description: the caption of the image
//   category: the gallery to which the image belongs
//   pubDate: the date the image was published
//   author: image author
//

class facebook_Item
{
	var $title = "";
	var $content = "";
	var $id = "";
	
	var $published = "";
	var $tags = "";
	
	var $link = "";
}

//
// SMParser
//
// Parses an RSS feed.
class facebookParser
{
	var $facebookItem;
	var $insideitem = false;
	var $tag = "";
	var $title = "";
	var $description = "";
	var $link = "";
	var $facebookEntries  = array();
	
	function startElement( $parser, $tagName, $attrs )
	{
		if( $this -> insideitem )
		{
			$this -> tag = $tagName;
			switch ( $this -> tag)
			{
				//LINK
				//CATEGORY
				//PUBLISHED
				//
				
				case "LINK":
				 	if ( $attrs["REL"] == "alternate" )
				 	{
						$this -> facebookItem -> link = $attrs["HREF"];
					}
					break;
				
			}
			
		}
		elseif( $tagName == "ITEM" )
		{
			$this -> insideitem = true;
			$this -> facebookItem = new facebook_Item();
		}
	}
	
	function endElement( $parser, $tagName )
	{
		if( $tagName == "ITEM" )
		{
			array_push( $this -> facebookEntries, $this -> facebookItem );
			$this -> insideitem = false;
		}
	}
	
	function characterData( $parser, $data )
	{
		if( $this -> insideitem )
		{
				switch( $this -> tag )
				{
				
				//TITLE
				//CONTENT
				case "TITLE":
					$this -> facebookItem -> title .=iconv("UTF-8", "CP1252", $data);
					break;
				case "DESCRIPTION":
					$this -> facebookItem -> content .= iconv("UTF-8", "CP1252", $data);
					break;
				case "PUBDATE":
					$this -> facebookItem -> published .= iconv("UTF-8", "CP1252", $data);
					break;
				case "LINK":
					$this -> facebookItem -> link .= iconv("UTF-8", "CP1252", $data);
					break;
				}
		}
	}
}

function j_decode($json)
{
    $comment = false;
    $out = '$x=';
  
    for ($i=0; $i<strlen($json); $i++)
    {
        if (!$comment)
        {
            if (($json[$i] == '{') || ($json[$i] == '['))       $out .= ' array(';
            else if (($json[$i] == '}') || ($json[$i] == ']'))   $out .= ')';
            else if ($json[$i] == ':')    $out .= '=>';
            else                         $out .= $json[$i];          
        }
        else $out .= $json[$i];
        if ($json[$i] == '"' && $json[($i-1)]!="\\")    $comment = !$comment;
    }
    eval($out . ';');
    return $x;
}


function getfacebookItems( $feedURL )
{
/*	$xml_parser = xml_parser_create();
	$rss_parser = new facebookParser();
	xml_set_object( $xml_parser, &$rss_parser );
	xml_set_element_handler( $xml_parser, "startElement", "endElement" );
	xml_set_character_data_handler( $xml_parser, "characterData" );
*/
	$fp = fopen( $feedURL, "r" );

	$jsonData = "";
    	while( $data = fread( $fp, 4096 ) )
    	{
		//echo $data;
		$jsonData .= iconv("UTF-8", "CP1252", $data); // $data;
	   // 		xml_parse( $xml_parser, $data, feof( $fp ) ); // or die( sprintf( "XML error: %s at line %d", xml_error_string( xml_get_error_code( $xml_parser ) ), xml_get_current_line_number( $xml_parser ) ) );
    	}
    	
    	fclose( $fp );
	//xml_parser_free( $xml_parser );
	//return $rss_parser -> facebookEntries;
	$jsonData = str_replace ( "\u00252F", "/", $jsonData);
	$jsonData = str_replace ( "\u00253A", ":", $jsonData);
	$jsonData = str_replace ( "\\\\", "\\", $jsonData);
	$jsonData = str_replace ( "\\/", "/", $jsonData);
	$retData = j_decode( $jsonData );
	//print_r ($retData["data"]);
	return $retData["data"];
}
?>