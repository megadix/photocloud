<div class="page-header">
  <h1>Aggiungi collezione</h1>
</div>

<?php
$this->form_validation->set_error_delimiters('<div class="alert-error">', '</div>');

echo form_open('admin/collection_add_post', 'class="form-horizontal well"');
?>
<p>
  <label for="name">Titolo</label>
  <?php echo form_error('name'); ?>
  <?php echo form_input($name); ?>
  <span class="help-inline">Titolo della collezione</span>
</p>
<p>
  <label for="description">Descrizione</label>
  <?php echo form_error('description'); ?>
  <?php echo form_textarea($description); ?><br />
  <span class="help-inline">Descrizione della collezione</span>
</p>
<p>
  <?php echo form_submit($submit); ?>
</p>
<?php echo form_close(); ?>
