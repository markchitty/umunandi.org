<p>
  <label for="<?= esc_attr($this->get_field_id($name)) ?>">
    <?php _e("{$label}:", 'roots') ?>
  </label>
  <input type="text" class="widefat"
    id="<?= esc_attr($this->get_field_id($name)) ?>"
    name="<?= esc_attr($this->get_field_name($name)) ?>"
    value="<?= ${$name} ?>">
</p>
