<?php

// Debug util
function ulog() {
  $formatted_args = array_map(function($arg) { return print_r($arg, true); }, func_get_args());
  $func_name = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1]['function'];
  error_log($func_name . ': ' . join(', ', $formatted_args));
}

function array_map_assoc(callable $f, array $a) {
  return array_column(array_map($f, array_keys($a), $a), 1, 0);
}

/**
 * Substitute parameters into template(s) containing {{param}} fields.
 * @param String|Array $templates If array, function returns array of substituted strings.
 * @param Array        $params    If a string, this string is substituted into all fields.
 *                                If array, array keys = param name. If there's no matching
 *                                key in $params, {{[field]}} is left in place.
 */
function umunandi_substitute_params($templates, $params = array()) {
  if (is_array($params) && empty($params)) return $templates;
  return preg_replace_callback(
    '|{{(.*?)}}|',
    function($match) use ($params) {
      if (!is_array($params)) return $params;
      if (array_key_exists(trim($match[1]), $params)) return $params[trim($match[1])];
      return $match[0];
    },
    $templates
  );
}
