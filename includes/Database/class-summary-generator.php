<?php

namespace ZGS\Database;

use ZGS\Admin\Admin_Settings;

if (!defined('ABSPATH')) exit;

class Summary_Generator
{
    const META_KEY_GEMINI = '_zgs_ai_gemini_summary';
    const META_KEY_CHATGPT = '_zgs_ai_chatgpt_summary';
    const GEMINI_API_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent';

    public function init()
    {
        add_action('save_post', [$this, 'generate_summary'], 10, 2);
    }

    public function generate_summary($post_id, $post)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (wp_is_post_revision($post_id)) return;
        if ($post->post_status !== 'publish' || $post->post_type !== 'post') return;

        $content = wp_strip_all_tags(strip_shortcodes($post->post_content));
        if (strlen($content) < 50) return;

        // Get API keys
        $api_keys = wp_parse_args(get_option(Admin_Settings::OPTION_KEY_API, []), [
            'gemini' => '',
            'chatgpt' => ''
        ]);

        // === Gemini Summary ===
        if ($api_keys['gemini'] && !get_post_meta($post_id, self::META_KEY_GEMINI, true)) {
            $gemini_summary = $this->call_gemini_api($content, $api_keys['gemini']);
            if ($gemini_summary) update_post_meta($post_id, self::META_KEY_GEMINI, $this->markdown_to_html($gemini_summary));
        }

        // === ChatGPT Summary ===
        if ($api_keys['chatgpt'] && !get_post_meta($post_id, self::META_KEY_CHATGPT, true)) {
            $chatgpt_summary = $this->call_chatgpt_api($content, $api_keys['chatgpt']);
            if ($chatgpt_summary) update_post_meta($post_id, self::META_KEY_CHATGPT, $this->markdown_to_html($chatgpt_summary));
        }
    }

    private function call_gemini_api($content, $api_key)
    {
        $payload = [
            'contents' => [['parts' => [['text' => "Summarize this into 3–4 bullet points:\n\n$content"]]]],
            'systemInstruction' => ['parts' => [['text' => 'You are a content summarizer. Return only bullet points.']]]
        ];

        $response = wp_remote_post(add_query_arg('key', $api_key, self::GEMINI_API_URL), [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($payload),
            'timeout' => 45,
        ]);

        if (is_wp_error($response)) return '';
        $data = json_decode(wp_remote_retrieve_body($response), true);
        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    private function call_chatgpt_api($content, $api_key)
    {
        // Prepare the prompt
        $prompt = "Summarize the following content into 3–4 bullet points:\n\n$content";

        // OpenAI API endpoint
        $url = 'https://api.openai.com/v1/chat/completions';

        $body = [
            'model' => 'gpt-4.1-mini', // You can use gpt-4.1 or gpt-4.1-mini
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a content summarizer. Return only bullet points.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.3,
            'max_tokens' => 400
        ];

        $response = wp_remote_post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => wp_json_encode($body),
            'timeout' => 45
        ]);

        if (is_wp_error($response)) return '';

        $data = json_decode(wp_remote_retrieve_body($response), true);

        // Extract text from response
        $summary = $data['choices'][0]['message']['content'] ?? '';
        return $summary;
    }


    private function markdown_to_html($text)
    {
        $html = esc_html($text);
        $html = preg_replace('/^\s*[-*]\s*(.*)$/m', '<li>$1</li>', $html);
        if (strpos($html, '<li>') !== false) $html = '<ul>' . $html . '</ul>';
        return $html;
    }
}
