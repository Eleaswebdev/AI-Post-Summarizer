# AI Post Summarizer 📝

[![Python](https://img.shields.io/badge/Python-3776AB?logo=python&logoColor=white)](https://www.python.org/)
[![Google Gemini API](https://img.shields.io/badge/Google%20Gemini-4285F4?logo=google&logoColor=white)](https://ai.google.dev/models/gemini)
[![OpenAI ChatGPT API](https://img.shields.io/badge/ChatGPT-74AA9C?logo=openai&logoColor=white)](https://openai.com/blog/chatgpt-api)

Unleash the power of AI to effortlessly distill lengthy articles and posts into concise, digestible summaries! The AI Post Summarizer is a dynamic tool designed to automatically generate 3–4 bullet-point summaries for any given text, leveraging the cutting-edge capabilities of either Google Gemini or OpenAI's ChatGPT API. Say goodbye to information overload and hello to instant insights!

---

## 🚀 Features

*   ✨ **Intelligent Summarization**: Automatically condenses long-form content into clear, concise 3–4 bullet summaries.
*   🤖 **Dual AI Power**: Seamlessly switch between Google Gemini API and OpenAI's ChatGPT API for summarization, giving you flexibility and choice.
*   ⚡ **Boost Productivity**: Quickly grasp the core ideas of articles, reports, or blog posts without reading every word.
*   ⚙️ **Easy Integration**: Simple setup allows you to get started with your preferred AI model in minutes.
*   🎯 **Configurable Output**: Designed to provide actionable, easy-to-read summaries.

## 🛠️ Tech Stack

*   **Language**: Python 🐍
*   **AI Models**:
    *   Google Gemini API 🧠
    *   OpenAI (ChatGPT) API 💬
*   **Dependency Management**: `pip`

## ⚙️ Installation

Getting started with the AI Post Summarizer is a breeze! Follow these steps to set up your local development environment.

1.  **Clone the repository**:
    ```bash
    git clone https://github.com/your-username/ai-post-summarizer.git
    cd ai-post-summarizer
    ```

2.  **Create a virtual environment**:
    It's recommended to use a virtual environment to manage dependencies.
    ```bash
    python -m venv venv
    ```

3.  **Activate the virtual environment**:
    *   **On macOS/Linux**:
        ```bash
        source venv/bin/activate
        ```
    *   **On Windows**:
        ```bash
        .\venv\Scripts\activate
        ```

4.  **Install dependencies**:
    ```bash
    pip install -r requirements.txt
    ```

## 🔑 Configuration

To use the AI Post Summarizer, you'll need API keys for either Google Gemini or OpenAI (ChatGPT).

1.  **Obtain your API Key**:
    *   For **Google Gemini**: Visit [Google AI Studio](https://ai.google.dev/tutorials/setup) to get your `GEMINI_API_KEY`.
    *   For **OpenAI (ChatGPT)**: Visit [OpenAI Platform](https://platform.openai.com/account/api-keys) to get your `OPENAI_API_KEY`.

2.  **Create a `.env` file**:
    In the root directory of the project, create a file named `.env` and add your API keys.
    ```env
    GEMINI_API_KEY="YOUR_GOOGLE_GEMINI_API_KEY"
    OPENAI_API_KEY="YOUR_OPENAI_API_KEY"
    ```
    *You only need to provide the key for the model you intend to use, but you can include both for flexibility.*

## 🚀 Usage

Once configured, you can start summarizing posts!

1.  **Prepare your post content**:
    Have the text you want to summarize ready. You can paste it directly or read it from a file.

2.  **Run the summarizer script**:
    (Assuming `main.py` is your entry point, adjust if different)

    ```bash
    python main.py
    ```

    The script will likely prompt you for the text to summarize and which AI model to use (Gemini or ChatGPT). Follow the on-screen instructions.

    **Example (conceptual CLI interaction):**
    ```
    Enter the post content you want to summarize (or type 'exit' to quit):
    [PASTE YOUR LONG POST HERE]
    
    Choose AI model (1 for Gemini, 2 for ChatGPT): 1
    
    Generating summary using Google Gemini...
    
    --- Summary ---
    ✨ Key Takeaways:
    *   Bullet point 1
    *   Bullet point 2
    *   Bullet point 3
    *   Bullet point 4
    -----------------
    ```

## 👋 Contributing

We absolutely love contributions! If you have ideas for improvements, new features, or bug fixes, please feel free to:

1.  **Fork** the repository.
2.  **Create** a new branch (`git checkout -b feature/AmazingFeature`).
3.  **Commit** your changes (`git commit -m 'Add some AmazingFeature'`).
4.  **Push** to the branch (`git push origin feature/AmazingFeature`).
5.  **Open** a Pull Request.

Please ensure your code adheres to our style guidelines and includes appropriate tests.

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

Made with ❤️ by the Open Source Community
