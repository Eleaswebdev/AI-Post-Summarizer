# AI Post Summarizer Plugin
![Version](https://img.shields.io/badge/Version-1.0.0-informational?style=flat)
![WordPress](https://img.shields.io/badge/WordPress-5.0+-blue?style=flat&logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-7.4+-8892BF?style=flat&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat)

The AI Post Summarizer plugin is a robust WordPress solution designed to automate the generation of concise summaries for your posts. Leveraging advanced large language models such as Google Gemini or OpenAI's ChatGPT API, this plugin streamlines content management by providing 3-4 bullet point summaries, enhancing reader engagement and improving content accessibility. Its reliable architecture ensures seamless integration and efficient operation within the WordPress ecosystem.

---

## Features

*   **Automated Summary Generation**: Automatically creates 3-4 bullet point summaries for posts, reducing manual effort.
*   **Flexible AI Integration**: Supports both Google Gemini and OpenAI ChatGPT API keys for versatile summary generation capabilities.
*   **Enhanced Content Accessibility**: Provides quick overviews of post content, improving user experience and potentially boosting SEO.
*   **Seamless WordPress Integration**: Designed as a native WordPress plugin for easy installation, configuration, and management directly from the admin dashboard.
*   **Configurable AI Models**: Allows administrators to select their preferred AI model and API key, providing control over summary generation quality and cost.

## Tech Stack

*   **Platform**: WordPress
*   **Backend**: PHP
*   **Frontend**: JavaScript
*   **AI Services**: Google Gemini API, OpenAI ChatGPT API

## Installation

To install the AI Post Summarizer plugin, follow these steps:

1.  **Download**: Obtain the plugin files from the GitHub releases page or the WordPress plugin directory.
2.  **Upload**: Upload the unzipped plugin folder to the `/wp-content/plugins/ai-post-summarizer` directory on your WordPress installation.
3.  **Activate**: Navigate to the 'Plugins' menu in your WordPress admin dashboard and activate the 'AI Post Summarizer' plugin.

Alternatively, you can use the WordPress admin panel for installation:

1.  Navigate to 'Plugins' > 'Add New'.
2.  Click 'Upload Plugin'.
3.  Select the downloaded `.zip` file of the plugin and click 'Install Now'.
4.  After installation, click 'Activate Plugin'.

## Configuration

After successful installation and activation, the plugin requires minimal configuration:

1.  **Access Settings**: From your WordPress admin dashboard, navigate to the 'Settings' menu and locate 'AI Post Summarizer'.
2.  **API Key Entry**: Enter your valid Google Gemini API Key or OpenAI ChatGPT API Key into the respective fields on the settings page.
3.  **Model Selection**: Choose your preferred AI model (e.g., Gemini Pro, GPT-3.5, GPT-4) from the available options.
4.  **Save Changes**: Click the 'Save Changes' button to store your configuration. The plugin is now ready for use.

## Usage

Once configured, the AI Post Summarizer plugin can be used as follows:

1.  **Edit Post**: Open an existing post or create a new one in the WordPress editor.
2.  **Locate Meta Box**: In the post editing screen, find the 'AI Post Summarizer' meta box, typically located in the sidebar or below the main content area.
3.  **Generate Summary**: Click the 'Generate Summary' button within the meta box. The plugin will process the post content using the configured AI service.
4.  **Review and Edit**: The generated 3-4 bullet point summary will appear in the designated field. You can review, modify, or approve the summary before publishing or updating the post.
5.  **Display on Frontend**: Utilize the provided shortcode `[ai_summary]` or a template tag (e.g., `<?php echo do_shortcode('[ai_summary]'); ?>`) within your theme files to display the generated summaries on your website's frontend.

## Contributing

We welcome contributions to enhance the AI Post Summarizer plugin. If you wish to contribute, please adhere to the following guidelines:

1.  **Fork the Repository**: Start by forking this repository to your GitHub account.
2.  **Create Branch**: Create a new branch for your feature or bug fix (e.g., `feature/add-new-model` or `bugfix/api-error`).
3.  **Commit Changes**: Make your changes and commit them with clear, descriptive messages.
4.  **Push to Branch**: Push your local branch to your forked repository.
5.  **Open Pull Request**: Submit a pull request against the `main` branch of this repository.

Please ensure your code adheres to WordPress coding standards and includes appropriate documentation and, if applicable, unit tests.

## License

This project is licensed under the MIT License. For more details, please refer to the [LICENSE](LICENSE) file in the repository.

Developed with expertise by your team.
