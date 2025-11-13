<?php
namespace ZGS;

if (!defined('ABSPATH')) exit;

class Loader {
    public function init() {
        require_once __DIR__ . '/Admin/class-admin-settings.php';
        require_once __DIR__ . '/Frontend/class-summary-display.php';
        require_once __DIR__ . '/Database/class-summary-generator.php';

        (new Admin\Admin_Settings())->init();
        (new Database\Summary_Generator())->init();
        (new Frontend\Summary_Display())->init();
    }
}
