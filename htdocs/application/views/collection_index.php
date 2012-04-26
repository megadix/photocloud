<h1>Collezioni</h1>

<div class="row">
  <div class="span9">
    <ul class="thumbnails">
    <?php
    foreach($collections as $collection) {
      $name = htmlspecialchars($collection->name, ENT_NOQUOTES, 'UTF-8');
      $detail_url = base_url() . 'index.php/collection/get/' . $collection->id;
      ?>
      <li class="span3">
        <a href="<?php echo $detail_url;?>" class="thumbnail">
          <img src="<?php echo $collection->thumbnail_path; ?>"
              width="<?php echo $collection->thumbnail_width; ?>"
              heigth="<?php echo $collection->thumbnail_height; ?>"
              alt="<?php echo $name;?>">
          <div class="caption">
            <h5><?php echo $name;?></h5>
          </div>
        </a>
      </li>
      <?php
      }
      ?>
    </ul>
  </div>
</div><!-- class="row" -->
