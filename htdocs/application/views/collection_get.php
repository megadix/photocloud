<?php
$logged_in = isset($this->session->userdata['logged_in']);

$name = htmlspecialchars($collection->name, ENT_NOQUOTES, 'UTF-8');
$description = htmlspecialchars($collection->description, ENT_NOQUOTES, 'UTF-8');
?>
<div class="page-header">
  <h1><?php echo $name;?></h1>
</div>

<p><?php echo $description;?></p>
<hr />

<p><?php
if ($logged_in) {
  echo anchor('admin/image_add/' . $collection->id, 'Aggiungi foto', 'class="btn"');
}
?></p>

<div id="gallery">
<?php
$cols = 3;

$i = 0;
foreach($images as $image) {
  $name = htmlspecialchars($image->name, ENT_NOQUOTES, 'UTF-8');
  $description = htmlspecialchars($image->description, ENT_NOQUOTES, 'UTF-8');
  
  if ($i % $cols == 0) {
    ?>
<div class="row">
    <?php
  }
  ?>
  <div class="span3 thumbnail">
    <a href="<?php echo $image->path;?>" title="<?php echo $description;?>">
      <img src="<?php echo $image->thumbnail_path; ?>"
          width="<?php echo $image->thumbnail_width; ?>"
          heigth="<?php echo $image->thumbnail_height; ?>"
          alt="<?php echo $name;?>">
      <div class="caption">
        <h5><?php echo $name;?></h5>
      </div>
    </a>
  </div>
<?php
  if ($i > 0 && ($i + 1) % $cols == 0) {
    ?>
</div><!-- class="row" -->
    <?php
  }
  $i++;
}
?>
</div><!-- id="gallery" -->

<script src="assets/js/jquery.lightbox-0.5.min.js"></script>
<script>
$('#gallery a').lightBox();
</script>
