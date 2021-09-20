<?php
   require APPROOT . '/views/includes/header.php';
   require APPROOT . '/views/includes/toolbar.php';
?>
<div class="container mb-5">
<table class="table" style="table-layout: fixed; word-break: break-word;">
  <thead>
    <tr>
      <th scope="col" class="col-sm-1">#</th>
      <th scope="col" class="col-sm-1">Timestamp</th>
      <th scope="col" class="col-sm-1">Offset</th>
      <th scope="col" class="col-sm-9">Hex value</th>
    </tr>
  </thead>
  <tbody>
  <?php
  foreach ($data['rows'] as $index=>$row) {
    $index++;
    echo '<tr>';
    echo '<th scope="row">'.$index.'</th>';
    echo '<td>'.$row->timestamp.'</td>';
    echo '<td>'.$row->data1.'</td>';
    echo '<td>'.$row->data2.'</td>';
    echo '</tr>';
    }   
  ?>
  </tbody>
</table>
</div>
</body>