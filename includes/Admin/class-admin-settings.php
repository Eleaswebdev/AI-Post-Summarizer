<?php
namespace ZGS\Admin;

if (!defined('ABSPATH')) exit;

class Admin_Settings {
    const OPTION_KEY_ENABLE   = 'zgs_enable_ai_overview';
    const OPTION_KEY_STYLES   = 'zgs_ai_styles';
    const OPTION_KEY_ENGINE   = 'zgs_ai_engine';
    const OPTION_KEY_API      = 'zgs_ai_api';
    const OPTION_KEY_TITLE    = 'zgs_ai_heading';

    public function init() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_footer', [$this, 'api_field_script']);
       add_action('updated_option', [$this, 'maybe_update_dynamic_scss'], 10, 3);

       
    }
    public function maybe_update_dynamic_scss($option, $old_value, $value) {
    if ($option === self::OPTION_KEY_STYLES) {
        $this->update_dynamic_scss();
    }
}

    public function add_admin_menu() {
        add_options_page(
            'AI Post Summary Settings',
            'AI Post Summary',
            'manage_options',
            'ai-post-summarizer',
            [$this, 'settings_page']
        );
    }

    public function register_settings() {
        // Register options
        register_setting('ai-post-summarizer-group', self::OPTION_KEY_ENABLE);
        register_setting('ai-post-summarizer-group', self::OPTION_KEY_STYLES);
        register_setting('ai-post-summarizer-group', self::OPTION_KEY_ENGINE);
        register_setting('ai-post-summarizer-group', self::OPTION_KEY_API);
        register_setting('ai-post-summarizer-group', self::OPTION_KEY_TITLE);

        // ===== GENERAL TAB =====
        add_settings_section('zgs_section_general', 'General Settings', null, 'ai-post-summarizer-general');
        add_settings_field(self::OPTION_KEY_ENABLE, 'Enable AI Overview', [$this, 'enable_toggle_field'], 'ai-post-summarizer-general', 'zgs_section_general');
        add_settings_field(self::OPTION_KEY_ENGINE, 'AI Engine', [$this, 'engine_field'], 'ai-post-summarizer-general', 'zgs_section_general');
        add_settings_field(self::OPTION_KEY_API, 'API Key', [$this, 'api_field'], 'ai-post-summarizer-general', 'zgs_section_general');

        // ===== STYLES TAB =====
        add_settings_section('zgs_section_styles', 'Box Appearance', null, 'ai-post-summarizer-styles');
        add_settings_field(self::OPTION_KEY_STYLES, 'Customize Styles', [$this, 'style_fields'], 'ai-post-summarizer-styles', 'zgs_section_styles');

        // ===== CONTENT TAB =====
        add_settings_section('zgs_section_content', 'Content Settings', null, 'ai-post-summarizer-content');
        add_settings_field(self::OPTION_KEY_TITLE, 'AI Overview Title', [$this, 'overview_title_field'], 'ai-post-summarizer-content', 'zgs_section_content');
    }

    // === General Tab ===
    public function enable_toggle_field() {
        $enabled = get_option(self::OPTION_KEY_ENABLE, '1');
        $checked = checked('1', $enabled, false);
        echo '<label><input type="checkbox" name="' . self::OPTION_KEY_ENABLE . '" value="1" ' . $checked . '> Enable AI Overview Box</label>';
    }

    public function engine_field() {
        $engine = get_option(self::OPTION_KEY_ENGINE, 'gemini');
        echo '<select id="zgs_ai_engine" name="' . self::OPTION_KEY_ENGINE . '">
                <option value="gemini" ' . selected($engine, 'gemini', false) . '>Google Gemini</option>
                <option value="chatgpt" ' . selected($engine, 'chatgpt', false) . '>Chat GPT</option>
              </select>';
    }

    public function api_field() {
        $apis = wp_parse_args(get_option(self::OPTION_KEY_API, []), [
            'gemini' => '',
            'chatgpt' => ''
        ]);

        echo '<div id="zgs_api_fields">';
        echo '<div class="zgs_api_input" data-engine="gemini">Gemini API Key: <input type="password" name="' . self::OPTION_KEY_API . '[gemini]" value="' . esc_attr($apis['gemini']) . '" class="regular-text"></div>';
        echo '<div class="zgs_api_input" data-engine="chatgpt">
            ChatGPT API Key: <input type="password" name="' . self::OPTION_KEY_API . '[chatgpt]" value="' . esc_attr($apis['chatgpt']) . '" class="regular-text"><br>
            <small style="color:#555;">ChatGPT requires a paid plan to use this API.</small>
          </div>';
        echo '</div>';
    }

    // === Styles Tab ===
   public function style_fields() {
    $defaults = [
        'background'       => '#eff6ff',
        'border_color'     => '#3b82f6',
        'title_color'      => '#1e40af',
        'content_color'    => '#333333',
        'padding'          => ['top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px'],
        'margin'           => ['top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px'],
        'border_radius'    => ['top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'unit' => 'px'],
        'title_size'       => '1.5rem',
        'content_size'     => '1rem',
        'title_text_space' => '1rem',
    ];
    $styles = wp_parse_args(get_option(self::OPTION_KEY_STYLES, []), $defaults);

    echo '<table class="form-table">';

    foreach ($styles as $key => $val) {
           // Skip spacing fields and the font size/text spacing fields (they have separate handling)
        if (in_array($key, ['title_size', 'content_size', 'title_text_space'])) {
            continue;
        }
        $label = ucwords(str_replace('_', ' ', $key));

        // === Handle special fields ===
        if (in_array($key, ['padding', 'margin', 'border_radius'])) {
            echo '<tr><th scope="row"><label>' . $label . '</label></th><td>';
            $this->render_spacing_control(self::OPTION_KEY_STYLES . '[' . $key . ']', $val);
            echo '</td></tr>';
            continue;
        }

        // === Handle colors ===
        $type = (strpos($key, 'color') !== false || $key === 'background') ? 'color' : 'text';
        echo '<tr><th scope="row"><label>' . $label . '</label></th>';
        echo '<td><input type="' . $type . '" name="' . self::OPTION_KEY_STYLES . '[' . $key . ']" value="' . esc_attr($val) . '" class="regular-text"></td></tr>';
    }
    // Inside style_fields(), after the foreach loop for $styles
    foreach (['title_size', 'content_size', 'title_text_space'] as $key) {
        $value = isset($styles[$key]['value']) ? $styles[$key]['value'] : '1';
        $unit  = isset($styles[$key]['unit']) ? $styles[$key]['unit'] : 'rem';
        $label = ucwords(str_replace('_', ' ', $key));

        echo '<tr><th scope="row"><label>' . $label . '</label></th><td>';
        echo '<input type="number" name="' . self::OPTION_KEY_STYLES . '[' . $key . '][value]" value="' . esc_attr($value) . '" style="width:70px;">';
        echo '<select name="' . self::OPTION_KEY_STYLES . '[' . $key . '][unit]">';
        foreach (['px', 'em', '%', 'rem'] as $u) {
            echo '<option value="' . $u . '" ' . selected($unit, $u, false) . '>' . $u . '</option>';
        }
        echo '</select>';
        echo '</td></tr>';
    }


    echo '</table>';

    // Add JS & CSS for spacing control
    $this->enqueue_spacing_script();
    
}

private function render_spacing_control($name, $value) {
    $value = wp_parse_args($value, [
        'top' => '',
        'right' => '',
        'bottom' => '',
        'left' => '',
        'unit' => 'px',
    ]);
    ?>
    <div class="zgs-spacing-control" data-name="<?php echo esc_attr($name); ?>">
        <?php foreach (['top', 'right', 'bottom', 'left'] as $side): ?>
            <div class="zgs-spacing-item">
                <label><?php echo ucfirst($side); ?></label>
                <input type="number" 
                    name="<?php echo esc_attr($name); ?>[<?php echo $side; ?>]" 
                    value="<?php echo esc_attr($value[$side]); ?>" 
                    class="zgs-spacing-input" />
            </div>
        <?php endforeach; ?>

        <select name="<?php echo esc_attr($name); ?>[unit]" class="zgs-unit">
            <option value="px" <?php selected($value['unit'], 'px'); ?>>px</option>
            <option value="em" <?php selected($value['unit'], 'em'); ?>>em</option>
            <option value="%" <?php selected($value['unit'], '%'); ?>>%</option>
            <option value="rem" <?php selected($value['unit'], 'rem'); ?>>rem</option>
        </select>

       
    </div>
    <?php
}

private function enqueue_spacing_script() {
    ?>
    <style>
    .zgs-spacing-control {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .zgs-spacing-item {
        text-align: center;
    }
    .zgs-spacing-item label {
        display: block;
        font-size: 11px;
        color: #555;
        margin-bottom: 2px;
    }
    .zgs-spacing-input {
        width: 60px;
        text-align: center;
    }
    .zgs-unit {
        padding: 3px 5px;
    }
    </style>
    <?php
}




    // === Content Tab ===
    public function overview_title_field() {
        $title = get_option(self::OPTION_KEY_TITLE, 'AI Overview');
        echo '<input type="text" name="' . self::OPTION_KEY_TITLE . '" value="' . esc_attr($title) . '" class="regular-text">';
    }

    // === JS for API Field Toggle ===
    public function api_field_script() {
        ?>
        <script>
        (function($){
            function toggleApiField() {
                var selected = $('#zgs_ai_engine').val();
                $('.zgs_api_input').hide();
                $('.zgs_api_input[data-engine="'+selected+'"]').show();
            }
            $(document).ready(function(){
                toggleApiField();
                $('#zgs_ai_engine').on('change', toggleApiField);

                // Tabs
                $('.nav-tab').on('click', function(e){
                    e.preventDefault();
                    $('.nav-tab').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');
                    $('.zgs-tab-content').removeClass('active');
                    $($(this).attr('href')).addClass('active');
                });
            });
        })(jQuery);
        </script>
        <?php
    }

    // === Settings Page UI ===
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>AI Post Summary Settings</h1>
            <h2 class="nav-tab-wrapper">
                <a href="#tab-general" class="nav-tab nav-tab-active">General Settings</a>
                <a href="#tab-styles" class="nav-tab">Styles</a>
                <a href="#tab-content" class="nav-tab">Content Settings</a>
            </h2>

            <form method="post" action="options.php">
                <?php settings_fields('ai-post-summarizer-group'); ?>

                <div id="tab-general" class="zgs-tab-content active">
                    <?php do_settings_sections('ai-post-summarizer-general'); ?>
                </div>

                <div id="tab-styles" class="zgs-tab-content">
                    <?php do_settings_sections('ai-post-summarizer-styles'); ?>
                </div>

                <div id="tab-content" class="zgs-tab-content">
                    <?php do_settings_sections('ai-post-summarizer-content'); ?>
                </div>

                <?php submit_button(); ?>
            </form>
        </div>

        <style>
        .zgs-tab-content { display: none; }
        .zgs-tab-content.active { display: block; margin-top: 20px; }
        </style>
        <?php
    }

 public function update_dynamic_scss() {
    $styles = wp_parse_args(get_option(self::OPTION_KEY_STYLES, []), [
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

    $scss = ":root {\n";

    foreach ($styles as $key => $val) {
        if (in_array($key, ['title_size','content_size','title_text_space']) && isset($val['value'], $val['unit'])) {
            $scss .= "  --zgs-" . str_replace('_','-',$key) . ": {$val['value']}{$val['unit']};\n";
        } elseif (is_array($val) && isset($val['unit'])) {
            foreach (['top','right','bottom','left'] as $side) {
                $v = isset($val[$side]) && $val[$side] !== '' ? $val[$side] : '0';
                $scss .= "  --zgs-" . str_replace('_','-',$key) . "-{$side}: {$v}{$val['unit']};\n";
            }
        } else {
            $scss .= "  --zgs-" . str_replace('_','-',$key) . ": {$val};\n";
        }
    }

    $scss .= "}\n";

    $file = realpath(dirname(__FILE__) . '/../../assets/scss') . '/_dynamic.scss';
    if (!file_exists(dirname($file))) wp_mkdir_p(dirname($file));
    file_put_contents($file, $scss);
}



}
