<h1>Ultime collezioni</h1>

<div class="row">
  <div class="span5">
    <div id="collectionsCarousel" class="carousel slide">
      <div class="carousel-inner" style="text-align: center;">
        <?php
        while($item = each($collections)) {
          $key = $item['key'];
          $collection = $item['value'];
          $active = $key == 0 ? ' active' : '';
          $name = htmlspecialchars($collection->name, ENT_NOQUOTES, 'UTF-8');
          ?>
          <div class="item <?php echo $active; ?>">
            <?php $detail_url = base_url() . 'index.php/collection/get/' . $collection->id; ?>
            <a href="<?php echo $detail_url;?>">
              <img src="<?php echo $collection->thumbnail_path; ?>"
                  width="<?php echo $collection->thumbnail_width; ?>"
                  heigth="<?php echo $collection->thumbnail_height; ?>"
                  alt="<?php echo $name;?>"
                  style="display: inline-block;">
              <div class="carousel-caption">
                <h4><?php echo $name;?></h4>
              </div>
            </a>
          </div><!-- class="item" -->
          <?php
        }
        ?>
      </div><!-- class="carousel-inner" -->
      <a class="left carousel-control" href="#collectionsCarousel" data-slide="prev">‹</a>
      <a class="right carousel-control" href="#collectionsCarousel" data-slide="next">›</a>
    </div><!-- id="myCarousel" -->
  </div>
</div>


<script type="text/javascript">
$('#collectionsCarousel').carousel({
  interval: 5000
});
</script>
