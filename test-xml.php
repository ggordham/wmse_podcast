<HTML>
<HEADER>
<H1>WMSE Show Archive, Simple Podcast List XML Tester</H1>
</HEADER>

<BODY>
<H2>WMSE Show List from XML file</H2>

<table>
  <tr>
    <th>Show Name</th>
    <th>Start Date</th>
    <th>Start Date Formated</th>
    <th>Num Years</th>
    <th>Num Weeks</th>
    <th>Day</th>
    <th>Start Time</th>
    <th>Duration</th>
    <th>Site</th>
    <th>EMail</th>
    <th>Company</th>
    <th>Logo</th>
    <th>Description</th>
    <th>Short Description</th>
    <th>Show Logo</th>
    <th>Podcast URL</th>
  </tr>

<?php

  $filename='shows.xml';
  date_default_timezone_set ( 'America/Chicago' );


  // Load the configuation file with shows information
  if (file_exists($filename)) {
      $show_xml = simplexml_load_file ($filename);

      foreach( $show_xml->show as $show) {

          // Calculate number of years between dates
          $num_years = date('Y', $end_date) - date('Y', $start_date);

          // Calculate number of weeks between dates
          $num_weeks = date('W', $end_date) - date('W', $start_date) + 1;
          $start_date = strtotime( $show_xml->start_date );

          echo '<tr>';
          echo '<td>', $show->name, '</td>';
          echo '<td>', $start_date, '</td>';
          echo '<td>', date("Y/m/d H:i:s", $start_date), '</td>';
          echo '<td>', $num_years, '</td>';
          echo '<td>', $num_weeks, '</td>';
          echo '<td>', $show->day, '</td>';
          echo '<td>', $show->start_time, '</td>';
          echo '<td>', $show->length, '</td>';
          echo '<td>', $show_xml->site, '</td>';
          echo '<td>', $show_xml->email, '</td>';
          echo '<td>', $show_xml->company, '</td>';
          echo '<td>', $show_xml->logo, '</td>';
          echo '<td>', $show->description, '</td>';
          echo '<td>', $show->sdesc, '</td>';
          echo '<td>', $show->logo, '</td>';
          $my_url = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/pod.php?show=' . $show->sname;
          echo '<td><a href="', $my_url, '"> ', $my_url, '</a>', '</td>';
          echo '</tr>';

      }
  } else {
    // We couldn't find the needed configuration file.
    exit(' Failed to open shows.xml file.');
  }

?>
</table>
</BODY>
</HTML>

