<HTML>
<HEADER>
<H1>WMSE Show Archive, Simple Podcast List</H1>
</HEADER>

<BODY>
<H2>WMSE Show List</H2>

<table>
  <tr>
    <th>Show Name</th>
    <th>Podcast URL</th>
  </tr>

<?php

  $filename='shows.xml';

  // Load the configuation file with shows information
  if (file_exists($filename)) {
      $show_xml = simplexml_load_file ($filename);
      foreach( $show_xml->show as $show) {
          echo '<tr>';
          echo '<td>', $show->name, '</td>';
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
