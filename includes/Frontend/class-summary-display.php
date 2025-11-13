<?php
namespace ZGS\Frontend;

use ZGS\Database\Summary_Generator;
use ZGS\Admin\Admin_Settings;

if (!defined('ABSPATH')) exit;

class Summary_Display {
    public function init() {
        add_filter('the_content', [$this, 'display_summary']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    }

public function enqueue_styles() {
    $css_url = plugin_dir_url(dirname(__FILE__, 2)) . 'assets/scss/main.css';
    wp_enqueue_style('zgs-ai-summary', $css_url, [], '1.0');

    // Get saved style options with defaults
    $styles = wp_parse_args(get_option(\ZGS\Admin\Admin_Settings::OPTION_KEY_STYLES, []), [
        'background'       => '#eff6ff',
        'border_color'     => '#3b82f6',
        'title_color'      => '#1e40af',
        'content_color'    => '#333333',
        'padding'          => ['top'=>'20','right'=>'20','bottom'=>'20','left'=>'20','unit'=>'px'],
        'margin'           => ['top'=>'20','right'=>'20','bottom'=>'20','left'=>'20','unit'=>'px'],
        'border_radius'    => ['top'=>'8','right'=>'8','bottom'=>'8','left'=>'8','unit'=>'px'],
        'title_size'       => ['value'=>'1.5','unit'=>'rem'],
        'content_size'     => ['value'=>'1','unit'=>'rem'],
        'title_text_space' => ['value'=>'1','unit'=>'rem'],
    ]);

    // Flatten all style arrays into CSS variables
    $flattened = [];
    foreach ($styles as $key => $val) {
        if (is_array($val)) {
            // Handle spacing fields (padding, margin, border_radius)
            if (isset($val['top'], $val['right'], $val['bottom'], $val['left'], $val['unit'])) {
                foreach (['top','right','bottom','left'] as $side) {
                    $flattened["{$key}_{$side}"] = $val[$side] . $val['unit'];
                }
            }
            // Handle font size / spacing (title_size, content_size, title_text_space)
            elseif (isset($val['value'], $val['unit'])) {
                $flattened[$key] = $val['value'] . $val['unit'];
            }
        } else {
            // Colors or string values
            $flattened[$key] = $val;
        }
    }

    // Build CSS variable string
    $css = ":root {";
    foreach ($flattened as $key => $val) {
        $css .= "--zgs-" . str_replace('_','-',$key) . ": {$val};";
    }
    $css .= "}";

    // Add inline CSS
    wp_add_inline_style('zgs-ai-summary', $css);
}




    public function display_summary($content) {
        if (!is_single() || is_admin()) return $content;

        $enabled = get_option(Admin_Settings::OPTION_KEY_ENABLE, '1');
        if ($enabled !== '1') return $content;

        $engine = get_option(Admin_Settings::OPTION_KEY_ENGINE, 'gemini');
        $meta_key = $engine === 'chatgpt' ? Summary_Generator::META_KEY_CHATGPT : Summary_Generator::META_KEY_GEMINI;
        $summary = get_post_meta(get_the_ID(), $meta_key, true);

        if ($engine === 'chatgpt' && empty($summary)) {
            $summary = "- ChatGPT summary not available in free plan.";
        }

        if (!$summary) return $content;

        $title = get_option(Admin_Settings::OPTION_KEY_TITLE, 'AI Overview');

        $summary_html = sprintf(
            '<div class="zgs-ai-overview-box">
                <h2>%s</h2>
                <div class="zgs-summary-list">%s</div>
            </div>',
            esc_html($title),
            $summary
        );

        return $summary_html . $content;
    }
}
