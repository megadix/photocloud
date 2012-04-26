<div class="page-header">
  <h1>Aggiungi immagine
  <small>Collezione: <em><? echo htmlspecialchars($collection->name, ENT_NOQUOTES, 'UTF-8'); ?></small>
  </h1>
</div>

<?php
$this->form_validation->set_error_delimiters('<div class="alert-error">', '</div>');

echo form_open_multipart('admin/image_add_post/' . $collection->id, 'class="form-horizontal well"');
?>
<p>
  <label for="name">Titolo</label>
  <?php echo form_error('name'); ?>
  <?php echo form_input($name); ?>
  <span class="help-inline">Titolo dell'immagine</span>
</p>
<p>
  <label for="description">Descrizione</label>
  <?php echo form_error('description'); ?>
  <?php echo form_textarea($description); ?><br />
  <span class="help-inline">Descrizione dell'immagine</span>
</p>
<p>
  <label for="file">File immagine</label>
  <?php echo form_error('file'); ?>
  <?php echo form_upload($file); ?><br />
</p>
<p>
  <?php echo form_submit($submit); ?>
</p>
<?php echo form_close(); ?>
