<?php
/*
Plugin Name: OpenBot
Description: Custom AI ChatBot
Version: 1.1.0
Author: Md. Saiful Islam AKash
*/

// Shortcode দিয়ে চ্যাটবট UI দেখানো
function custom_chatbot_shortcode()
{
    ob_start(); ?>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            position: relative;
        }

        /* Need help button style */
        .need-help-btn {
            background: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            color: #FF2D55;
            border: none;
            cursor: pointer;
            z-index: 1001;
            outline: none;
            transition: 0.4s ease-in-out;
        }

        .need-help-btn:hover {
            color: #DD072F;
        }

        .need-help-btn:hover .floating-smile-btn {
            opacity: 1;
        }

        .need-help-btn:hover .floating-dot-btn {
            opacity: 0;
        }

        .need-help-btn:hover .support-msg {
            opacity: 1;
        }

        .help-btn-img {
            position: relative;
        }

        .icon .floating-dot-btn {
            position: absolute;
            left: 50%;
            top: 50%;
            color: #ffffff;
            transform: translate(-50%, -50%);
            transition: 0.3s ease-in-out;
        }

        .icon .floating-smile-btn {
            position: absolute;
            left: 50%;
            top: 62%;
            color: #ffffff;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: 0.3s ease-in-out;
        }

        .support-msg {
            position: absolute;
            right: 80px;
            top: 9px;
            text-align: left;
            background: #ffffff;
            padding: 12px 12px;
            border-radius: 5px;
            margin: 0;
            box-shadow: 0 4px 4px -1px rgba(58, 59, 64, .08), 0 8px 8px 2px rgba(58, 59, 64, .02), 0 2px 16px 0 rgba(58, 59, 64, .1);
            width: 165px;
            opacity: 0;
            transition: 0.3s ease-in-out;
        }

        .support-msg h6 {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            line-height: 10px;
            margin: 0;
        }

        .support-msg p {
            font-weight: 400;
            font-size: 12px;
            color: #333;
            margin: 0px;
            margin-top: 6px;
        }

        /* What Window */
        .chat-window {
            font-family: "Roboto", sans-serif !important;
            position: fixed;
            bottom: 10px;
            right: 10px;
            width: 400px;
            max-height: 600px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 2px -1px rgba(59, 60, 63, 0.1), 0 4px 4px 1px rgba(59, 60, 63, 0.02), 0 1px 8px 0 rgba(59, 60, 63, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 1000;
        }

        .chat-header {
            background-color: #FF2D55;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .chat-header .profile-info {
            display: flex;
            align-items: center;
        }

        .chat-header .profile-info img {
            width: 40px;
            height: 40px;
            border-radius: 2px;
            margin-right: 10px;
        }

        .chat-header .profile-info .name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .chat-header .profile-info .status {
            font-weight: 500;
            font-size: 12px;
            color: #f0f0f0;
        }

        .chat-header .controls {
            display: flex;
            align-items: center;
        }

        .chat-header .controls button {
            background: white;
            width: 31px;
            height: 31px;
            text-align: center;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            outline: none;
            transition: 0.3s ease-in-out;
        }

        .chat-header .controls button:hover {
            background: #f3eaea;
        }

        /* join AI Assistant */
        .ai-assistant {
            font-family: "Roboto", sans-serif !important;
            text-align: center;
            margin-bottom: 20px;
        }

        .ai-assistant h4 {
            font-family: "Roboto", sans-serif !important;
            font-weight: 500;
            font-size: 16px;
            line-height: 18px;
            margin: 0;
        }

        .ai-assistant h6 {
            font-family: "Roboto", sans-serif !important;
            font-weight: 400;
            font-size: 14px;
            margin: 0;
        }

        .ai-assistant img {
            margin-top: 20px;
        }

        .chat-header i {
            line-height: 31px;
            color: #333333;
            font-size: 16px;
            transition: 0.3s ease-in-out;
        }

        .chat-body {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            background-color: #fafafa;
        }

        .chat-message {
            margin: 10px 0;
            display: flex;
            align-items: flex-start;
        }

        .chat-message.bot .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #555;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .chat-message .message-content {
            max-width: 70%;
            padding: 10px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.5;
        }

        .chat-message.user .message-content {
            background-color: #e8f0fe;
            color: #333;
            margin-left: auto;
        }

        .chat-message.bot .message-content {
            background-color: #fff;
            border: 1px solid #ddd;
            color: #333;
        }

        .chat-footer {
            display: flex;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .chat-footer input[type="text"] {
            flex: 1;
            padding: 8px;
            font-size: 15px;
            border: none;
            border-radius: 4px;
            outline: none;
        }

        .chat-footer button {
            background-color: none;
            color: white;
            border: none;
            padding: 6px 8px 3px 8px;
            margin-left: 8px;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        .chat-footer button:hover {
            background-color: #dddddd;
        }

        /* Chat Alert style */
        .chat-alert {
            position: absolute;
            top: 90px;
            left: 20px;
            right: 20px;
            background: #fff;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 15px;
            z-index: 1000;
            font-family: Arial, sans-serif;
        }

        .chat-alert .alert-content {
            text-align: center;
        }

        .chat-alert p {
            font-weight: 600;
            margin: 0px 0px 15px;
            font-size: 15px;
            color: #333;
        }

        .chat-alert .alert-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .chat-alert button {
            font-weight: 600;
            padding: 8px 14px;
            font-size: 13px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            outline: none;
        }

        .chat-alert button#confirmCloseBtn {
            background-color: #DD072F;
            color: #fff;
        }

        .chat-alert button#cancelCloseBtn {
            background-color: #ddd;
            color: #333;
        }

        .chat-alert button:hover {
            opacity: 0.9;
        }

        @media (max-width: 480px) {
            .chat-window {
                width: 350px;
                height: 60vh;
                bottom: 8px;
                right: 5;
                border-radius: 10px 10px 0 0;
            }
        }
    </style>


    <!-- Need Help Button -->
    <button id="needHelpBtn" class="need-help-btn">
        <svg
            class="help-btn-img"
            xmlns="http://www.w3.org/2000/svg"
            width="65"
            height="65"
            viewBox="0 0 256 256"
            fill="currentColor">
            <path d="M128 252a124 124 0 1 1 124-124c0 12.1-3 29.1-11.8 52.4-9 24.3 5.6 52.3 5.7 52.6a7.9 7.9 0 0 1-8.9 11.2c-.8-.1-22.8-4-37.6-4s-23.5 4-48.5 4z"></path>
        </svg>
        <div class="icon">
            <svg
                class="floating-dot-btn"
                xmlns="http://www.w3.org/2000/svg"
                width="40"
                height="40"
                viewBox="0 0 100 30"
                fill="currentColor">
                <circle cx="15" cy="15" r="10"></circle>
                <circle cx="50" cy="15" r="10"></circle>
                <circle cx="85" cy="15" r="10"></circle>
            </svg>
            <svg
                class="floating-smile-btn"
                width="40"
                height="40"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 34 12">
                <path
                    d="M17,12c-0.3,0-0.5,0-0.8,0C6.9,11.6,0.7,3.6,0.4,3.2c-0.7-0.9-0.5-2.1,0.4-2.8c0.9-0.7,2.1-0.5,2.8,0.4C3.7,0.9,9,7.7,16.4,8c4.8,0.2,9.5-2.3,14.1-7.3c0.7-0.8,2-0.9,2.8-0.1c0.8,0.7,0.9,2,0.1,2.8C28.3,9.1,22.7,12,17,12z"
                    fill="white"></path>
            </svg>
        </div>
        <div class="support-msg">
            <h6>Any Quires?</h6>
            <p>Tap to Chat with our assistant!</p>
        </div>
    </button>

    <!-- Chat Window -->
    <div id="chatWindow" class="chat-window" style="display: none;">
        <!-- Header -->
        <div class="chat-header">
            <div class="profile-info">
                <img src="http://localhost/wordpress/wp-content/uploads/2024/12/123456789.jpg" alt="Profile">
                <div>
                    <div class="name">CIHF. Assistant</div>
                    <div class="status">Available</div>
                </div>
            </div>
            <div class="controls">
                <button id="minimizeBtn" title="Minimize">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <button id="closeBtn" title="Close Conversation">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div id="chatBody" class="chat-body">
            <div class="ai-assistant bot">
                <img width="60px" src="http://localhost/wordpress/wp-content/uploads/2024/12/123456789.jpg" alt="profile-picture">
                <h4>Assistant of CIHF.</h4>
                <h6>joined the chat</h6>
            </div>
            <div class="chat-message bot auto-response">
                <div class="avatar">
                    <img width="22px" src="http://localhost/wordpress/wp-content/uploads/2024/12/logo-nc.svg" alt="auto-response-bot">
                </div>
                <div class="message-content">
                    Hi,
                    Discover the 15th China International Hair Fair 2025 – The world’s biggest event for hair industry experts and enthusiasts!
                </div>
            </div>
            <div class="chat-message bot auto-response">
                <div class="avatar">
                    <img width="22px" src="http://localhost/wordpress/wp-content/uploads/2024/12/logo-nc.svg" alt="auto-response-bot">
                </div>
                <div class="message-content">
                    Join us in Guangzhou, Sep 2-4, 2025, to explore products, and connections!
                </div>
            </div>
            <div class="chat-message bot auto-response">
                <div class="avatar">
                    <img width="22px" src="http://localhost/wordpress/wp-content/uploads/2024/12/logo-nc.svg" alt="auto-response-bot">
                </div>
                <div class="message-content">
                    Have other quires, feel free to ask me!
                </div>
            </div>
            <!-- <div class="chat-message user">
                <div class="message-content">
                    Yes, Thanks for your response
                </div>
            </div> -->
        </div>

        <!-- Footer -->
        <div class="chat-footer">
            <input type="text" id="userMessage" placeholder="What can we help you with?" />
            <button id="sendMessageBtn">
                <!-- <i class="fa-regular fa-paper-plane"></i> -->
                <img width="20" src="http://localhost/wordpress/wp-content/uploads/2024/12/Sent-icon.png" alt="message-sent-icon">
            </button>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select DOM elements
            const needHelpBtn = document.getElementById("needHelpBtn");
            const chatWindow = document.getElementById("chatWindow");
            const minimizeBtn = document.getElementById("minimizeBtn");
            const closeBtn = document.getElementById("closeBtn");
            const chatBody = document.getElementById("chatBody");
            const sendMessageBtn = document.getElementById("sendMessageBtn");
            const userMessage = document.getElementById("userMessage");

            // Show chat window
            needHelpBtn.addEventListener("click", () => {
                chatWindow.style.display = "flex";
                needHelpBtn.style.display = "none"; // Hide the Need Help button
            });

            // Minimize chat window
            minimizeBtn.addEventListener("click", () => {
                chatWindow.style.display = "none";
                needHelpBtn.style.display = "block"; // Show the Need Help button
            });

            // Close chat window and clear non-bot messages
            closeBtn.addEventListener("click", () => {
                // Custom confirmation alert inside the chat window
                const confirmationAlert = document.createElement("div");
                confirmationAlert.className = "chat-alert";
                confirmationAlert.innerHTML = `
                    <div class="alert-content">
                        <p>Are you sure you want to Leave this chat?</p>
                        <div class="alert-buttons">
                            <button id="confirmCloseBtn">Leave</button>
                            <button id="cancelCloseBtn">Not now</button>
                        </div>
                    </div>
                `;
                chatWindow.appendChild(confirmationAlert);

                // Confirm close
                document.getElementById("confirmCloseBtn").addEventListener("click", () => {
                    chatWindow.style.display = "none";
                    needHelpBtn.style.display = "block";

                    // Remove non-bot messages
                    const chatMessages = chatBody.querySelectorAll(".chat-message");
                    chatMessages.forEach((message) => {
                        if (!message.classList.contains("auto-response")) {
                            message.remove(); // Remove user messages
                        }
                    });

                    confirmationAlert.remove(); // Remove the alert
                });

                // Cancel close
                document.getElementById("cancelCloseBtn").addEventListener("click", () => {
                    confirmationAlert.remove(); // Remove the alert
                });
            });

            // Function to append a message to the chat body
            function appendMessage(sender, message) {
                const messageElement = document.createElement("div");
                messageElement.className = `chat-message ${sender}`;

                // Add avatar only for bot messages
                if (sender === "bot") {
                    messageElement.innerHTML = `
                        <div class="avatar">
                            <img width="20px" src="http://localhost/wordpress/wp-content/uploads/2024/12/chatGPT-logo-1.png" alt="message-sent-icon">
                        </div>
                        <div class="message-content">${message}</div>
                    `;
                } else {
                    messageElement.innerHTML = `
                        <div class="message-content">${message}</div>
                    `;
                }

                chatBody.appendChild(messageElement);
                chatBody.scrollTop = chatBody.scrollHeight; // Auto-scroll to bottom
            }

            // Send message functionality
            sendMessageBtn.addEventListener("click", async () => {
                const message = userMessage.value.trim();
                if (!message) return; // Do nothing for empty input

                // Show user message
                appendMessage("user", message);
                userMessage.value = ""; // Clear input field

                try {
                    // API call to fetch bot response
                    const response = await fetch('https://www.mailcamply.bitchipsoft.com/api/custom-answer', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'custom_chatbot',
                            question: message,
                        }),
                    });

                    const result = await response.json();

                    // Show bot response
                    const botReply = result.message || 'Something wrond, Try again later!';
                    appendMessage("bot", botReply);
                } catch (error) {
                    console.error("Error fetching bot response:", error);
                    appendMessage("bot", "Sorry, Have a server problem");
                }
            });

            // Optional: Add Enter key support for sending messages
            userMessage.addEventListener("keypress", (event) => {
                if (event.key === "Enter") {
                    sendMessageBtn.click();
                }
            });
        });
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('custom_chatbot', 'custom_chatbot_shortcode');

// API থেকে ডেটা আনা
function custom_chatbot_handler()
{
    $input = json_decode(file_get_contents('php://input'), true);
    $question = sanitize_text_field($input['question']);

    // আপনার কাস্টম API কল
    $api_url = 'https://your-custom-api.com/endpoint';
    $response = wp_remote_post($api_url, [
        'body' => json_encode(['question' => $question]),
        'headers' => ['Content-Type' => 'application/json']
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error(['answer' => 'API তে কোনো সমস্যা হয়েছে।']);
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    wp_send_json_success(['answer' => $data['answer']]);
}
add_action('wp_ajax_custom_chatbot', 'custom_chatbot_handler');
add_action('wp_ajax_nopriv_custom_chatbot', 'custom_chatbot_handler');
