# AI Post Summarizer plugin

The AI Post Summarizer plugin is a robust WordPress extension designed to automate the generation of concise, bullet-point summaries for your posts. Leveraging advanced large language models from Google Gemini or ChatGPT, this plugin enhances content management by automatically creating 3-4 bullet summaries whenever a post is published or updated, ensuring content remains fresh and easily digestible for readers. This solution is engineered for reliability and seamless integration into existing WordPress workflows.

---

## Features

*   **Automated Summary Generation**: Automatically generates a 3-4 bullet point summary for posts upon publishing or editing.
*   **AI Model Integration**: Supports leading AI APIs, including Google Gemini and ChatGPT, providing flexibility and choice in summary generation.
*   **Configurable API Keys**: Allows administrators to securely configure and manage their Google Gemini or ChatGPT API keys directly within the WordPress dashboard.
*   **Efficient Workflow**: Streamlines content creation by eliminating the manual effort required for post summarization.
*   **WordPress Native Integration**: Developed as a standard WordPress plugin, ensuring compatibility and ease of deployment within the WordPress ecosystem.

## Tech Stack

*   **Framework**: WordPress
*   **Backend**: PHP
*   **Frontend**: JavaScript

## Installation

To install the AI Post Summarizer plugin, follow these steps:

1.  **Download the Plugin**: Obtain the plugin's `.zip` file from the official source or repository.
2.  **Upload via WordPress Dashboard**:
    *   Navigate to `Plugins` > `Add New` in your WordPress admin dashboard.
    *   Click the `Upload Plugin` button.
    *   Choose the downloaded `.zip` file and click `Install Now`.
3.  **Upload via FTP (Alternative)**:
    *   Unzip the plugin file.
    *   Connect to your WordPress site via FTP or SFTP.
    *   Navigate to the `wp-content/plugins/` directory.
    *   Upload the unzipped plugin folder to this directory.
4.  **Activate the Plugin**:
    *   Once uploaded, return to the `Plugins` page in your WordPress admin dashboard.
    *   Locate "AI Post Summarizer plugin" in the list.
    *   Click `Activate`.

## Configuration

After activating the plugin, you must configure your AI API key:

1.  **Access Plugin Settings**:
    *   In the WordPress admin dashboard, navigate to `Settings` > `AI Summarizer`.
2.  **Enter API Key**:
    *   Locate the field for "Google Gemini API Key" or "ChatGPT API Key".
    *   Enter your valid API key from your chosen AI provider.
3.  **Select AI Model (Optional)**:
    *   If applicable, select your preferred AI model from the available options.
4.  **Save Settings**:
    *   Click the `Save Changes` button to store your configuration.

The plugin is now ready to generate summaries.

## Usage

Once installed and configured, the AI Post Summarizer plugin operates automatically:

1.  **Create or Edit a Post**: Navigate to `Posts` > `Add New` or `Posts` > `All Posts` > `Edit` an existing post.
2.  **Publish or Update**: When you click the `Publish` or `Update` button for a post, the plugin will trigger the AI summary generation process.
3.  **Summary Integration**: The generated 3-4 bullet point summary will be automatically saved with the post, typically in a custom field or meta box, making it accessible for theme integration or further use.

## Contributing

We welcome contributions to the AI Post Summarizer plugin. If you wish to contribute, please fork the repository, make your changes, and submit a pull request for review. Ensure your code adheres to established coding standards and includes appropriate tests.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

---

Crafted with dedication by your development team.
