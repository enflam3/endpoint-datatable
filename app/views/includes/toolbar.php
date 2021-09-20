<div class="container mb-5">
<form class="row g-3" action="<?php echo URLROOT; ?>/routers/loader" method ="POST">
  <div class="col-auto">
  <label for="offset" class="col-form-label">Offset</label>
  </div>
  <div class="col-auto">
  <input type="number" class="form-control" name='offset' id="offset" min="0" max="99" step="1" value="0">
  </div>
  <div class="col-auto">
  <label for="limit" class="col-form-label">Limit</label>
  </div>
  <div class="col-auto">
  <input type="number" class="form-control" name='limit' id="limit" min="1" max="10" step="1" value="1">
  </div>
  <div class="col-auto">
    <button type="submit" name="action" value="load" class="btn btn-primary mb-3">Load data</button>
    <button type="submit" name="action" value="delete" class="btn btn-danger mb-3">Delete data</button>
  </div>
</form>
</div>