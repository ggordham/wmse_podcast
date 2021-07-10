<?php

  $filename='shows.xml';
  date_default_timezone_set ( 'America/Chicago' );

  // get parameter for what show to return podcoast list for
  $pshow = htmlspecialchars($_GET["show"]);

  if(!empty($pshow)){

    // Load the configuation file with shows information
    if (file_exists($filename)) {
        $show_xml = simplexml_load_file ($filename);

        foreach( $show_xml->show as $show) {
            // echo 'Checking: "', $pshow, '" with xml: "', $show->sname,'"';
            if ( strcmp($pshow, $show->sname) == 0 ) {

                // get start date for episode list form xml
                $start_date = strtotime( $show_xml->start_date );
                $end_date = time();

                // get day of week for episode list form xml
                $show_day = $show->day ;
                $start_time = $show->start_time ;
                $show_dur = $show->length;

                // Calculate number of years between dates
                $num_years = date('Y', $end_date) - date('Y', $start_date);

                // Calculate number of weeks between dates
                $num_weeks = date('W', $end_date) - date('W', $start_date) + 1;

                // Start outputing XML for RSS feed
                header('Content-Type: text/xml');
                echo '<?xml version="1.0" encoding="utf-8"?>';

                // debug code
                echo '<!-- start_date:', date("Y/m/d H:i:s", $start_date), '-->';
                echo '<!-- num_years:', $num_years, ' num_weeks:', $num_weeks, '-->';

                echo '<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:itunesu="http://www.itunesu.com/feed" version="2.0">';
                echo '  <channel>';
                echo '    <link>', $show_xml->site, '</link> ';
                echo '    <language>en-us</language>';
                echo '    <copyright>&#xA9;2019</copyright>';
                echo '    <webMaster>',$show_xml->email, '</webMaster>';
                echo '    <managingEditor>',$show_xml->email, '</managingEditor>';
                echo '    <image><url>https://www.wmse.org/wp-content/themes/wmse-new/images/header/logo.svg</url>';
                echo '    <title>', $show->name, '</title>';
                echo '    <link>', $show_xml->site, '</link>';
                echo '    </image>';
                echo '    <itunes:owner>';
                echo '      <itunes:name>', $show_xml->company, '</itunes:name>';
                echo '      <itunes:email>', $show_xml->email, '</itunes:email>';
                echo '    </itunes:owner>';
                echo '    <itunes:category text="Music"> </itunes:category>';
                echo '    <itunes:keywords>radio station, college radio, rock</itunes:keywords>';
                echo '    <itunes:explicit>no</itunes:explicit>';
                echo '    <itunes:type>Episodic</itunes:type>';
                echo '    <itunes:image href="', $show->logo, '" />';
                echo '    <atom:link href="', $_SERVER['SERVER_NAME'], $_SERVER['DOCUMENT_ROOT'], 'pod.php?name=', $show->sname, '" rel="self" type="application/rss+xml" />';
                echo '    <pubDate>', date('D d M Y H:i:s T'), '</pubDate>';
                echo '    <title>', $show->name, '</title>';
                echo '    <itunes:author>', $show_xml->company, '</itunes:author>';
                echo '    <description>', $show->description, '</description>';
                echo '    <itunes:summary>', $show->description, '</itunes:summary>';
                echo '    <itunes:subtitle>', $show->sdesc, '</itunes:subtitle>';
                echo '    <lastBuildDate>', date('D d M Y H:i:s T'), '</lastBuildDate>';

                // Loop through the number of weeks for the show
                for ( $day = strtotime($show_day, $start_date);
                      $day < $end_date;
                      $day = strtotime('+7 day', $day)) {


                    echo '    <item>';
                    echo '      <title>', $show->name, ' ', date('M d Y', $day), '</title>';
                    echo '      <description>', $show->name, ' ', date('M d Y', $day), '</description>';
                    echo '      <itunes:summary>', $show->name, ' ', date('M d Y', $day), '</itunes:summary>';
                    echo '      <itunes:season>',  date('Y', $day), '</itunes:season>';
                    echo '      <itunes:episode>',  date('W', $day), '</itunes:episode>';
                    echo '      <itunes:subtitle>', $show->name, ' ', date('M d Y', $day), '</itunes:subtitle>';
                    echo '      <itunesu:category itunesu:code="102107" />';
//                    echo '       <enclosure url="https://wmsearchive.blob.core.windows.net/2019/01/01-28-2019-18-00.mp3" type="audio/mpeg" length="1" />';
                    echo '        <enclosure url="',$show_xml->url_base,date('Y',$day),'/',date('m',$day),'/',date('m-d-Y',$day),'-',substr($start_time, 0,2),'-',substr($start_time, 2,2),'.mp3" type="audio/mpeg" length="1"/>';
                    echo '        <guid>',$show_xml->url_base,date('Y',$day),'/',date('m',$day),'/',date('m-d-Y',$day),'-',substr($start_time, 0,2),'-',substr($start_time, 2,2),'.mp3</guid>';
                    echo '        <itunes:duration>',substr($show_dur,0,1),':',substr($show_dur,1,2),':00','</itunes:duration>';
                    echo '        <itunes:image href="buzz.jpg"/>';
                    $pub_time = substr($start_time, 0,2) + substr($show_dur,0,1);
                    echo '        <pubDate>',date('D, d M Y', $day), ' ',$pub_time,':00:00 CST</pubDate>';

                    echo '    </item>';
                }

                echo '  </channel>';
                echo '</rss>';

            }

        }

    } else {
      // We couldn't find the needed configuration file.
      exit(' Failed to open shows.xml file.');
    }
 } else {
      exit(' Show name must be provided.');
 }

?>
