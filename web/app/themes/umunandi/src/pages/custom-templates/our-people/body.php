<?php /* Template Name: Our people */
include_once 'People.php';
global $umunandi_people;
$umunandi_people = new Umunandi_People($post->ID);
$class_toggle = false;

// Buffer the output so that we can use shortcodes
ob_start();
?>

<?php foreach ($umunandi_people->get_people_grouped() as $group) : ?>
[section
  class="people-section <?= ($class_toggle = !$class_toggle) ? 'fuzzy-edges' : 'buff'; ?>"
  header="<?= $group['title'] ?> - <?= $group['country'] ?>"]
  <div class="people-group col-grid col-grid-wrap">

    <?php while ($group['people']->have_posts()) : $group['people']->the_post(); ?>
    <div class="col">
      <div class="person-card">
        <a class="person-link" href="#" data-toggle="modal"
          data-target="#people-modal"
          data-carousel-id="<?= get_post_field('post_name') ?>">
          <div class="img">
            <div class="round-img"><?= the_post_thumbnail() ?></div>
          </div>
          <h4 class="name"><?= the_title() ?></h4>
          <h5 class="title"><?= the_field('strap_line') ?></h5>
        </a>
      </div>
    </div>
    <?php endwhile; ?>

  </div>
[/section]
<?php endforeach; ?>

<!-- Carousel modal for biogs -->
[modal class="people-modal" id="people-modal"]
  [carousel class="people-carousel" id="people-carousel"
    items="umunandi_people"
    item_template="src/pages/custom-templates/our-people/person.php"
    indicator_template="src/pages/custom-templates/our-people/carousel-indicators.php"]
[/modal]

<?php
// Now parse the output including the shortcodes
echo do_shortcode(ob_get_clean());
?>
