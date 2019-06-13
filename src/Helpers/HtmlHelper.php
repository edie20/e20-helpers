<?php

namespace CIS\Helpers;

class HtmlHelper {

    static public function form_multiselect($name = '', array $options = [], array $selected = [], $extra = '') {

        if (stripos($extra, 'multiple') === false) {
            $extra .= ' multiple="multiple"';
        }

        return self::form_dropdown($name, $options, $selected, $extra);
    }

    static public function form_dropdown($data = '', $options = [], $selected = [], $extra = '') {
        $defaults = [];
        if (is_array($data)) {
            if (isset($data['selected'])) {
                $selected = $data['selected'];
                unset($data['selected']); // select tags don't have a selected attribute
            }
            if (isset($data['options'])) {
                $options = $data['options'];
                unset($data['options']); // select tags don't use an options attribute
            }
        } else {
            $defaults = ['name' => $data];
        }

        is_array($selected) OR $selected = [$selected];
        is_array($options) OR $options = [$options];

        //$extra = stringify_attributes($extra);
        $multiple = (count($selected) > 1 && stripos($extra, 'multiple') === false) ? ' multiple="multiple"' : '';
        $form = '<select ' . rtrim(self::parse_form_attributes($data, $defaults)) . $extra . $multiple . ">\n";
        foreach ($options as $key => $val) {
            $key = (string) $key;
            if (is_array($val)) {
                if (empty($val)) {
                    continue;
                }
                $form .= '<optgroup label="' . $val['name'] . "\">\n";
                foreach ($val['options'] as $optgroup_key => $optgroup_val) {
                    $sel = in_array($optgroup_key, $selected) ? ' selected="selected"' : '';
                    $form .= '<option value="' . htmlspecialchars($optgroup_key) . '"' . $sel . '>'
                            . (string) $optgroup_val . "</option>\n";
                }
                $form .= "</optgroup>\n";
            } else {
                $form .= '<option value="' . htmlspecialchars($key) . '"'
                        . (in_array($key, $selected) ? ' selected="selected"' : '') . '>'
                        . (string) $val . "</option>\n";
            }
        }

        return $form . "</select>\n";
    }

    static public function parse_form_attributes($attributes, $default) {
        if (is_array($attributes)) {
            foreach ($default as $key => $val) {
                if (isset($attributes[$key])) {
                    $default[$key] = $attributes[$key];
                    unset($attributes[$key]);
                }
            }
            if (count($attributes) > 0) {
                $default = array_merge($default, $attributes);
            }
        }

        $att = '';

        foreach ($default as $key => $val) {
            if ($key === 'value') {
                $val = esc($val, 'html');
            } elseif ($key === 'name' && !strlen($default['name'])) {
                continue;
            }
            $att .= $key . '="' . $val . '" ';
        }

        return $att;
    }

}
