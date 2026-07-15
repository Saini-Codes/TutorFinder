<style>

@keyframes slideUp {
  from {
    transform: translateY(100%);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes slideDown {
  from {
    transform: translateY(0);
    opacity: 1;
  }
  to {
    transform: translateY(100%);
    opacity: 0;
  }
}

#chatbot-container.closing {
  animation: slideDown 0.3s ease-in;
}

#chatbot-container.opening {
  animation: slideUp 0.4s ease-out;
}

#chatbot-icon {
  position: fixed;
  bottom: 40px;
  right: 40px;
  width: 80px;
  height: 80px;
  background-color: red;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 2px solid #d32f2f; /* Fixed */
  border-radius: 50%;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
  cursor: pointer;
  transition: transform 0.2s;
  z-index: 999;
  padding: 5px;
}

#chatbot-icon img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

  #chatbot-icon:hover {
    background-color: #ff5e5e;
    transform: scale(1.1);
  }

  #chatbot-container {
    position: fixed;
    bottom: 90px;
    right: 30px;
    width: 400px;
    height: 700px;
    background: linear-gradient(to right, #fcd1d2ff, #fde7e1ff);
    border-radius: 20px;
    box-shadow: 0 0 20px rgba(255, 85, 85, 0.6);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 1000;
  }

  .hidden{
    display: none !important;
  }

  #chatbot-header {
    background-color: rgb(252, 96, 96);
    border: 1px solid  #d32f2f;
    border-radius: 20px 20px 0 0;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
  }

  .chatbot-title {
  display: flex;
  align-items: center;
  gap: 10px;
}

.chatbot-title img {
  width: 100px;
  height: 100px;
  border: 2px solid #000000ff;
  border-radius: 50%;
  object-fit: cover;
  background-color:#ff9a9e; 
}

  #close-btn {
  background-color: #d32f2f;
  border: none;
  padding: 5px;
  border-radius: 100px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

#close-btn img {
  width: 15px;
  height: 15px;
}


#close-btn:hover {
  background-color: #b71c1c;
}

 #chatbot-body {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
  display: flex;
  flex-direction: column-reverse;
}

#chatbot-messages {
  display: flex;
  flex-direction: column;
  width: 100%;
}

  .message {
    margin-bottom: 15px;
    padding: 12px;
    border-radius: 8px;
    max-width: 85%;
    text-align: left;
  }

  .message.user {
    background-color: #f52a2aff;
    color: white;
    align-self: flex-end;
  }

  .message.bot {
    background-color: rgba(88, 87, 87, 1);
    color: white;
    align-self: flex-start;
  }

  #chatbot-input-container {
    display: flex;
    padding: 10px;
    border-top: 1px solid rgb(252, 96, 96);
    background-color:rgb(252, 96, 96);
  }

  #chatbot-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #444;
    border-radius: 10px;
    background-color: white;
    color: black;
  }
#send-btn img {
  width: 24px;
  height: 24px;
}
  #send-btn {
  background-color: #d32f2f;
  border: none;
  padding: 10px;
  border-radius: 10px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

#send-btn:hover {
  background-color: #b71c1c;
}

.typing-indicator {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 10px;
  color: #555;
  font-style: italic;
  font-size: 14px;
}

.typing-indicator::after {
  content: '...';
  animation: dots 1.2s steps(3, end) infinite;
}

@keyframes dots {
  0% { content: '.'; }
  33% { content: '..'; }
  66% { content: '...'; }
}

</style>

<div id="chatbot-icon">
  <img src="Images/chatbot.png" alt="Chatbot" />
</div>

<div id="chatbot-container" class="hidden">
  <div id="chatbot-header">
  <div class="chatbot-title">
    <img src="Images/TutorFinder1.png" alt="Bot Avatar" />
    <span>Tutor Finder Assistant</span>
  </div>
  <button id="close-btn">
  <img src="Images/downarrow.png" alt="Close" />
</button>
</div>
  <div id="chatbot-body">
    <div id="chatbot-messages"></div>
  </div>
  <div id="chatbot-input-container">
 <input type="text" id="chatbot-input" placeholder="Type a message..." autocomplete="off" />
    <button id="send-btn">
      <img src="Images/send.png" alt="Send" />
    </button>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const chatbotContainer = document.getElementById("chatbot-container");
    const closeBtn = document.getElementById("close-btn");
    const sendBtn = document.getElementById("send-btn");
    const chatbotInput = document.getElementById("chatbot-input");
    const chatbotMessages = document.getElementById("chatbot-messages");
    const chatbotIcon = document.getElementById("chatbot-icon");

  let hasWelcomed = false;

chatbotIcon.addEventListener("click", function () {
  chatbotContainer.classList.remove("hidden");
  chatbotIcon.style.display = "none";

  if (!hasWelcomed) {
    appendMessage("bot", "Hey, how can I help you?");
    hasWelcomed = true;
  }

  chatbotContainer.classList.add("opening");
  setTimeout(() => chatbotContainer.classList.remove("opening"), 250);
});

  closeBtn.addEventListener("click", function () {
  chatbotContainer.classList.add("closing");
  setTimeout(() => {
    chatbotContainer.classList.remove("closing");
    chatbotContainer.classList.add("hidden");
    chatbotIcon.style.display = "flex";
  }, 250);
});


    sendBtn.addEventListener("click", sendMessage);
    chatbotInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        sendMessage();
      }
    });

    function sendMessage() {
      const userMessage = chatbotInput.value.trim();
      if (userMessage) {
        appendMessage("user", userMessage);
        chatbotInput.value = "";
        getBotResponse(userMessage);
      }
    }

    function getCurrentTime() {
  const now = new Date();
  return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function appendMessage(sender, message) {
  const messageElement = document.createElement("div");
  messageElement.classList.add("message", sender);

  const timestamp = getCurrentTime();
  messageElement.innerHTML = `
    <div>${message.replace(/\n/g, "<br>")}</div>
    <div style="font-size: 10px; margin-top: 5px; text-align: right;">${timestamp}</div>
  `;
  chatbotMessages.appendChild(messageElement);
  chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

async function getBotResponse(userMessage) {
  try {
    const typingIndicator = document.createElement("div");
    typingIndicator.className = "typing-indicator";
    typingIndicator.id = "typing-indicator";
    typingIndicator.innerText = "Bot is typing";
    chatbotMessages.appendChild(typingIndicator);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

    const response = await fetch("http://localhost:5005/webhooks/rest/webhook", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ sender: "user", message: userMessage })
    });

    typingIndicator.remove();

    if (!response.ok) {
      throw new Error(`Server error: ${response.status}`);
    }

    const data = await response.json();

    if (!data.length) {
      appendMessage("bot", "🤖 I didn't get that. Can you please tell me by rephrasing the line?");
      return;
    }

    data.forEach(entry => {
      if (entry.text) {
        appendMessage("bot", entry.text);
      }
    });
  } catch (error) {
    console.error("Fetch error:", error);
    const typingIndicator = document.getElementById("typing-indicator");
    if (typingIndicator) typingIndicator.remove();
    appendMessage("bot", "⚠️ Bot is currently unavailable.");
  }
}

  });
</script>
