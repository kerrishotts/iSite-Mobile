<?php
error_reporting ( 0 );
///////////////////////////////////////////////////////////////////////////////
//
// itunes PHP RSS Parser by Kerri Shotts (photoKandy Studios)
//
// Version 0.5
//
// Supports itunes Feeds
//
///////////////////////////////////////////////////////////////////////////////


//
// itunes_Item Class
// ---------------------------------------------------------------------------
//
// itunes Item has the following properties:
//
//   title: the title of the podcast
//   link: the link to the podcast post
//   description: the description of the podcast
//   duration (itunes:): the length of the podcast (in seconds?)
//   image (itunes:): an image of the podcast
//   keywords (itunes:) Keywords
//   pubDate: date published
//   enclosure (media url, type, length)
//

class itunes_Item
{
	var $title;	// inside
	var $link;	// inside
	var $description; // inside
	var $duration;	// inside
	var $image;	// inside
	var $keywords;	// inside
	var $published;	// insude
	var $mediaURL;	// attribute
}

class itunesParser
{
	var $itunesItem;
	var $insideitem = false;
	var $tag = "";
	var $title = "";
	var $description = "";
	var $link = "";
	var $itunesEntries  = array();
	
	function startElement( $parser, $tagName, $attrs )
	{
		if( $this -> insideitem )
		{
			$this -> tag = $tagName;
			switch ( $this -> tag)
			{
				case "LINK":
/*				 	if ( $attrs["REL"] == "alternate" )
				 	{
						$this -> itunesItem -> link = $attrs["HREF"];
					}*/
					break;
				case "ENCLOSURE":
					$this -> itunesItem -> mediaURL = $attrs["URL"];
					break;	
			}
			
		}
		elseif( $tagName == "ITEM" )
		{
			$this -> insideitem = true;
			$this -> itunesItem = new itunes_Item();
		}
	}
	
	function endElement( $parser, $tagName )
	{
		if( $tagName == "ITEM" )
		{		
			array_push( $this -> itunesEntries, $this -> itunesItem );
			$this -> insideitem = false;
		}
	}
	
	function characterData( $parser, $data )
	{
		if( $this -> insideitem )
		{
			switch( $this -> tag )
			{
				case "TITLE":
					$this -> itunesItem -> title .=iconv("UTF-8", "CP1252", $data);
					break;
				case "DESCRIPTION":
					$this -> itunesItem -> description .= iconv("UTF-8", "CP1252", $data);
					break;
				case "PUBDATE":
					$this -> itunesItem -> published .= iconv("UTF-8", "CP1252", $data);
					break;
				case "LINK":
					$this -> itunesItem -> link .= iconv("UTF-8", "CP1252", $data);
					break;
				case "ITUNES:DURATION":
					$this -> itunesItem -> duration .= iconv("UTF-8", "CP1252", $data);
					break;
				case "ITUNES:IMAGE":
					$this -> itunesItem -> image .= iconv("UTF-8", "CP1252", $data);
					break;
				case "ITUNES:KEYWORDS":
					$this -> itunesItem -> keywords .= iconv("UTF-8", "CP1252", $data);
					break;
			}
		}
	}
}

function getitunesItems( $feedURL )
{
	$xml_parser = xml_parser_create();
	$rss_parser = new itunesParser();
	xml_set_object( $xml_parser, &$rss_parser );
	xml_set_element_handler( $xml_parser, "startElement", "endElement" );
	xml_set_character_data_handler( $xml_parser, "characterData" );
	$fp = fopen( $feedURL, "r" );
    	while( $data = fread( $fp, 4096 ) )
    	{
    		xml_parse( $xml_parser, $data, feof( $fp ) );
	}
    	fclose( $fp );
	xml_parser_free( $xml_parser );
	return $rss_parser -> itunesEntries;
}
?>