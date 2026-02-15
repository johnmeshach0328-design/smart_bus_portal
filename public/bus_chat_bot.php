<?php
session_start();
// Optional: Check if user is logged in, or leave it public. Keeping it public or passenger-only as per context.
// Assuming it's accessible to everyone or at least passengers.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Assistant Chatbot</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="assets/CSS/custom_style.css" rel="stylesheet">
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
    <style>
        .chat-container {
            max-width: 600px;
            margin: 50px auto;
            background: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 80vh;
            border: 1px solid var(--border-color);
        }

        .chat-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: var(--input-bg);
        }

        .message {
            margin-bottom: 15px;
            max-width: 80%;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .message.bot {
            background-color: var(--card-bg);
            color: var(--text-main);
            border-bottom-left-radius: 5px;
            align-self: flex-start;
            border: 1px solid var(--border-color);
        }

        .message.user {
            background-color: var(--primary-blue);
            color: white;
            border-bottom-right-radius: 5px;
            align-self: flex-end;
            /* This needs a flex container wrapper to work if not using float */
            margin-left: auto;
            /* Push to right */
        }

        .chat-input-area {
            padding: 15px;
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
        }

        .bus-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .bus-card h6 {
            margin-bottom: 8px;
            color: var(--primary-blue);
            font-weight: 700;
        }

        .bus-card .bus-info-text {
            color: var(--text-main) !important;
        }

        .bus-card .shifts span {
            display: inline-block;
            background: var(--primary-blue);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin: 2px;
        }
        
        .bus-card .text-muted,
        .bus-card small {
            color: var(--text-main) !important;
            opacity: 0.7;
        }
        
        .bus-card strong {
            color: var(--text-heading) !important;
        }
        
        .bus-card .btn-view-details {
            margin-top: 8px;
            font-size: 0.85rem;
        }
    </style>
</head>

<body class="bg-movable bg-overlay">
    <!-- Background Animation -->
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    <nav class="navbar navbar-expand-lg backdrop-blur shadow-sm mb-0">
        <div class="container-fluid">
            <a class="navbar-brand text-dark fw-bold" href="javascript:history.back()">
                <i class="bi bi-arrow-left-circle me-2"></i>Back
            </a>
        </div>
    </nav>

    <div class="chat-container">
        <div class="chat-header">
            <i class="bi bi-robot me-2"></i> Bus Assistant
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="message bot">
                Hello! I can help you find buses. Just enter your destination village or stop name (e.g., "Tirunelveli",
                "Market").
            </div>
            <!-- Admin Announcements will appear here -->
        </div>
        <div class="chat-input-area">
            <input type="text" id="userInput" class="form-control rounded-pill" placeholder="Type a destination..."
                autocomplete="off">
            <button class="btn btn-primary rounded-circle" id="sendBtn"
                style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>

    <script>
        const chatMessages = document.getElementById('chatMessages');
        const userInput = document.getElementById('userInput');
        const sendBtn = document.getElementById('sendBtn');

        function appendMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', sender);
            messageDiv.textContent = text;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function appendBusCards(buses) {
            const containerDiv = document.createElement('div');
            containerDiv.classList.add('message', 'bot');
            containerDiv.style.background = 'transparent';
            containerDiv.style.padding = '0';

            buses.forEach(bus => {
                const card = document.createElement('div');
                card.classList.add('bus-card');

                let shiftsHtml = '<div class="shifts">';
                for (let shift in bus.shifts) {
                    shiftsHtml += `<span>${bus.shifts[shift]}</span>`;
                }
                shiftsHtml += '</div>';

                card.innerHTML = `
                    <h6 class="fw-bold"><i class="bi bi-bus-front"></i> ${bus.bus_number}</h6>
                    <div class="mb-1 bus-info-text"><small class="text-muted">Route:</small> <strong>${bus.route}</strong></div>
                    <div class="mb-1 bus-info-text"><small class="text-muted">Type:</small> <span class="bus-info-text">${bus.type}</span></div>
                    ${shiftsHtml}
                    <a href="bus_details.php?id=${bus.id}" class="btn btn-sm btn-primary btn-view-details rounded-pill mt-2 w-100">
                        <i class="bi bi-info-circle me-1"></i>View Full Details
                    </a>
                `;
                containerDiv.appendChild(card);
            });

            chatMessages.appendChild(containerDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        async function sendMessage() {
            const text = userInput.value.trim();
            if (!text) return;

            appendMessage(text, 'user');
            userInput.value = '';

            try {
                const response = await fetch('chatbot_backend.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ message: text })
                });
                const data = await response.json();

                if (data.status === 'success') {
                    appendMessage(data.reply, 'bot');
                    if (data.data && data.data.length > 0) {
                        appendBusCards(data.data);
                    }
                } else {
                    appendMessage(data.message || 'Something went wrong.', 'bot');
                }
            } catch (error) {
                console.error('Error:', error);
                appendMessage('Sorry, I am having trouble connecting to the server.', 'bot');
            }
        }

        sendBtn.addEventListener('click', sendMessage);
        userInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });

        // Auto-fetch announcements on load
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const district = urlParams.get('district');

            if (district) {
                try {
                    const response = await fetch('chatbot_backend.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ action: 'fetch_messages', district: district })
                    });
                    const data = await response.json();

                    if (data.status === 'success') {
                        // Add a small delay for natural feel
                        setTimeout(() => {
                            const announcementDiv = document.createElement('div');
                            announcementDiv.classList.add('message', 'bot');
                            announcementDiv.style.borderLeft = '4px solid var(--primary-blue)';
                            announcementDiv.innerHTML = `<strong>📢 Announcement from ${district} Admin:</strong><br>${data.message}<br><small class="text-muted" style="font-size: 0.75em;">${new Date(data.time).toLocaleString()}</small>`;
                            chatMessages.appendChild(announcementDiv);
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }, 500);
                    }
                } catch (error) {
                    console.log('Failed to fetch announcements', error);
                }
            }
        });
    </script>
</body>

</html>