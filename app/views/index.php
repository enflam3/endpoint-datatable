<?php
   require APPROOT . '/views/includes/header.php';
   require APPROOT . '/views/includes/toolbar.php';
?>
<div class="container mb-5">
<table class="table" style="table-layout: fixed; word-break: break-word;">
  <thead>
    <tr>
      <th scope="col" class="col-sm-1">#</th>
      <th scope="col" class="col-sm-2">Timestamp</th>
      <th scope="col" class="col-sm-2">Gps</th>
      <th scope="col" class="col-sm-2">One byte</th>
      <th scope="col" class="col-sm-2">Two byte</th>
      <th scope="col" class="col-sm-2">Four byte</th>
      <th scope="col" class="col-sm-2">raw</th>
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
    echo '<td>'.$row->data3.'</td>';
    echo '<td>'.$row->data4.'</td>';
    echo '<td>'.$row->raw.'</td>';
    echo '</tr>';
    }   
  ?>
  </tbody>
</table>
</div>
</body>