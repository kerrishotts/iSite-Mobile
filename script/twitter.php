<?php
///////////////////////////////////////////////////////////////////////////////
//
// twitter PHP RSS Parser by Kerri Shotts (photoKandy Studios)
//
// Version 0.5
//
// Supports Twitter Feeds
//
///////////////////////////////////////////////////////////////////////////////


//
// twitter_Item Class
// ---------------------------------------------------------------------------
//
// twitter Item has the following properties:
//
//   title: the title of the item
//   link:  the link to the image on SM
//   description: the caption of the image
//   category: the gallery to which the image belongs
//   pubDate: the date the image was published
//   author: image author
//

class twitter_Item
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
class TwitterParser
{
	var $twitterItem;
	var $insideitem = false;
	var $tag = "";
	var $title = "";
	var $description = "";
	var $link = "";
	var $twitterEntries  = array();
	
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
						$this -> twitterItem -> link = $attrs["HREF"];
					}
					break;
				
			}
			
		}
		elseif( $tagName == "ITEM" )
		{
			$this -> insideitem = true;
			$this -> twitterItem = new twitter_Item();
		}
	}
	
	function endElement( $parser, $tagName )
	{
		if( $tagName == "ITEM" )
		{// finish any SM processing
		
			// replace "photoKandy:" at the beginning,
			$this -> twitterItem -> content = substr ( $this -> twitterItem -> content, strpos( $this -> twitterItem -> content, ":")+2 );

			// replace http links
            $in=array(
            '`((?:https?|ftp)://\S+[[:alnum:]]/?)`si',
            '`((?<!//)(www\.\S+[[:alnum:]]/?))`si'
            );
            $out=array(
            '<a href="$1">$1</a> ',
            '<a href="http://$1">$1</a>'
            );
			$this -> twitterItem -> content = preg_replace ( $in, $out, $this -> twitterItem -> content );

			// replace hash tags			
			// replace @ directs			
            $in=array(
            '`(\@)([[:alnum:]]+)`si',
            '`(\#[[:alnum:]]+)`si'
            );
            $out=array(
            '@<a href="http://www.twitter.com/$2">$2</a> ',
            '<a href="http://www.twitter.com/search?q=$1">$1</a>'
            );
			$this -> twitterItem -> content = preg_replace ( $in, $out, $this -> twitterItem -> content );
		
			array_push( $this -> twitterEntries, $this -> twitterItem );
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
					$this -> twitterItem -> title .=iconv("UTF-8", "CP1252", $data);
					break;
				case "DESCRIPTION":
					$this -> twitterItem -> content .= iconv("UTF-8", "CP1252", $data);
					break;
				case "PUBDATE":
					$this -> twitterItem -> published .= iconv("UTF-8", "CP1252", $data);
					break;
				case "LINK":
					$this -> twitterItem -> link .= iconv("UTF-8", "CP1252", $data);
					break;
				}
		}
	}
}

function getTwitterItems( $feedURL )
{
	$xml_parser = xml_parser_create();
	$rss_parser = new TwitterParser();
	xml_set_object( $xml_parser, &$rss_parser );
	xml_set_element_handler( $xml_parser, "startElement", "endElement" );
	xml_set_character_data_handler( $xml_parser, "characterData" );
	$fp = fopen( $feedURL, "r" );
	
	//if ($fp !== false)
	//{
    	while( $data = fread( $fp, 4096 ) )
    	{
    		xml_parse( $xml_parser, $data, feof( $fp ) ); // or die( sprintf( "XML error: %s at line %d", xml_error_string( xml_get_error_code( $xml_parser ) ), xml_get_current_line_number( $xml_parser ) ) );
    	}
    	
    	fclose( $fp );
    //}
	xml_parser_free( $xml_parser );
	return $rss_parser -> twitterEntries;
}
?>