<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Richfield Online Library')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style type="text/css">
        :root {
            --richfield-blue: #0056b3;
            --richfield-light-blue: #e6f0ff;
            --richfield-white: #ffffff;
            --richfield-dark-overlay: rgba(0, 30, 60, 0.6);
            --richfield-red: #dc3545;
        }
        
        body {
            background: linear-gradient(var(--richfield-dark-overlay), var(--richfield-dark-overlay)), 
                        url("https://images.pexels.com/photos/267885/pexels-photo-267885.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
        }
        
        .container-custom {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border: none;
            background: rgba(255, 255, 255, 0.95);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .navbar-custom {
            background-color: var(--richfield-blue) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .navbar-brand, .nav-link {
            color: var(--richfield-white) !important;
        }
        
        .nav-link:hover {
            color: var(--richfield-light-blue) !important;
        }
        
        .btn-primary-custom {
            background-color: var(--richfield-blue);
            border-color: var(--richfield-blue);
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .btn-primary-custom:hover {
            background-color: #004494;
            border-color: #004494;
        }
        
        .form-control-custom {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-control-custom:focus {
            border-color: var(--richfield-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 86, 179, 0.25);
            background-color: white;
        }
        
        .welcome-message {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--richfield-blue);
            margin-bottom: 1.5rem;
        }
        
        footer {
            background-color: rgba(0, 86, 179, 0.9);
            color: var(--richfield-white);
            padding: 15px 0;
            margin-top: auto;
        }
        
        .user-info {
            color: white;
            margin-right: 15px;
        }
        
        .password-strength {
            height: 5px;
            margin-bottom: 15px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .strength-0 { width: 0%; background-color: #dc3545; }
        .strength-1 { width: 25%; background-color: #dc3545; }
        .strength-2 { width: 50%; background-color: #ffc107; }
        .strength-3 { width: 75%; background-color: #28a745; }
        .strength-4 { width: 100%; background-color: #28a745; }
        
        /* Chatbot Styles */
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .chatbot-window {
            width: 350px;
            height: 500px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            display: none;
        }

        .chatbot-window.active {
            display: flex;
        }

        .chatbot-header {
            background: var(--richfield-blue);
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            margin: 0;
        }

        .chatbot-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .chatbot-input {
            padding: 15px;
            border-top: 1px solid #ddd;
            display: flex;
            gap: 10px;
        }

        .chatbot-input input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .chatbot-input button {
            padding: 8px 15px;
            background: var(--richfield-blue);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .chatbot-toggle {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60px;
            height: 60px;
            background: var(--richfield-blue);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .chatbot-toggle:hover {
            transform: scale(1.1);
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 10px;
            max-width: 80%;
            word-wrap: break-word;
        }

        .bot-message {
            background: #f1f1f1;
            align-self: flex-start;
        }

        .user-message {
            background: var(--richfield-blue);
            color: white;
            align-self: flex-end;
        }
        
        @media (max-width: 991.98px) {
            .container-custom {
                margin-top: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .welcome-message {
                font-size: 1.5rem;
            }
            
            .chatbot-window {
                width: 300px;
                height: 400px;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    @yield('navbar')
    
    <main class="flex-grow-1">
        @yield('content')
    </main>

    @yield('footer')
    
    <!-- Chatbot -->
    <div class="chatbot-container">  
        <div class="chatbot-window">
            <div class="chatbot-header">
                <h3>Library Assistant Bot</h3>
            </div>
            <div class="chatbot-messages" id="chatbotMessages">
                <div class="message bot-message">
                    Hello! I'm your library assistant. I can help you find books in our collection. What book are you looking for?
                </div>
            </div>
            <div class="chatbot-input">
                <input type="text" id="chatbotInput" placeholder="Type your message...">
                <button id="chatbotSend">Send</button>
                <button class="chatbot-close" id="chatbotClose">✕</button>
            </div>
        </div>
        <button class="chatbot-toggle" id="chatbotToggle">💬</button>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chatbot JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatbotToggle = document.getElementById('chatbotToggle');
        const chatbotWindow = document.querySelector('.chatbot-window');
        const chatbotClose = document.getElementById('chatbotClose');
        const chatbotSend = document.getElementById('chatbotSend');
        const chatbotInput = document.getElementById('chatbotInput');
        const chatbotMessages = document.getElementById('chatbotMessages');

        // Toggle chatbot window
        chatbotToggle.addEventListener('click', function() {
            chatbotWindow.classList.toggle('active');
            chatbotInput.focus();
        });

        // Close chatbot
        chatbotClose.addEventListener('click', function() {
            chatbotWindow.classList.remove('active');
        });

        // Send message
        function sendMessage() {
            const message = chatbotInput.value.trim();
            if (message === '') return;

            // Add user message to chat
            addMessage(message, 'user');
            chatbotInput.value = '';

            // Send to server
            fetch('{{ route("chatbot.message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                addMessage(data.response, 'bot');
            })
            .catch(error => {
                console.error('Error:', error);
                addMessage('Sorry, I encountered an error. Please try again.', 'bot');
            });
        }

        chatbotSend.addEventListener('click', sendMessage);
        chatbotInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            messageDiv.textContent = text;
            chatbotMessages.appendChild(messageDiv);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }
    });
    </script>
    
    @stack('scripts')
</body>
</html>