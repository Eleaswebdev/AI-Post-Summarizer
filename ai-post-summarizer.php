<?php
/**
 * Plugin Name: AI Post Summarizer
 * Description: Automatically generates 3–4 bullet summaries for posts using Google Gemini API. OOP structured version.
 * Version: 2.0
 * Author: Eleas Kanchon
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/class-loader.php';
(new ZGS\Loader())->init();
