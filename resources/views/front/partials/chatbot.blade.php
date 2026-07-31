<!-- FLOATING CHATBOT SUPPORT WIDGET -->
<style>
  .hyst-chat-launcher {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 99999;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #C25A2A 0%, #E07038 100%);
    color: #ffffff;
    border: none;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(194, 90, 42, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .hyst-chat-launcher:hover {
    transform: scale(1.08) translateY(-2px);
    box-shadow: 0 12px 30px rgba(194, 90, 42, 0.55);
  }
  .hyst-chat-launcher svg {
    width: 28px;
    height: 28px;
    transition: transform 0.3s ease;
  }
  .hyst-chat-badge {
    position: absolute;
    top: -2px;
    right: -2px;
    width: 14px;
    height: 14px;
    background: #10B981;
    border: 2.5px solid #ffffff;
    border-radius: 50%;
  }

  /* Chat Box Popup */
  .hyst-chat-card {
    position: fixed;
    bottom: 96px;
    right: 24px;
    z-index: 99999;
    width: 380px;
    max-width: calc(100vw - 32px);
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);
    overflow: hidden;
    display: none;
    flex-direction: column;
    animation: hystChatSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    border: 1px solid rgba(194, 90, 42, 0.15);
    font-family: 'Poppins', sans-serif;
  }

  @keyframes hystChatSlideUp {
    from {
      opacity: 0;
      transform: translateY(20px) scale(0.95);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  .hyst-chat-header {
    background: linear-gradient(135deg, #1A1208 0%, #2E2318 100%);
    color: #ffffff;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .hyst-chat-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .hyst-chat-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #C25A2A;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }
  .hyst-chat-title {
    font-size: 15px;
    font-weight: 700;
    line-height: 1.2;
  }
  .hyst-chat-sub {
    font-size: 11px;
    color: #10B981;
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 2px;
  }
  .hyst-chat-sub::before {
    content: '';
    width: 6px;
    height: 6px;
    background: #10B981;
    border-radius: 50%;
  }

  .hyst-chat-close {
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: #ffffff;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: background 0.2s ease;
  }
  .hyst-chat-close:hover {
    background: rgba(255, 255, 255, 0.3);
  }

  .hyst-chat-body {
    padding: 20px;
    max-height: 480px;
    overflow-y: auto;
    background: #FDFBF7;
  }

  .hyst-chat-field {
    margin-bottom: 12px;
  }
  .hyst-chat-field label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6B5C46;
    margin-bottom: 4px;
  }
  .hyst-chat-field input,
  .hyst-chat-field textarea {
    width: 100%;
    padding: 10px 12px;
    font-size: 13px;
    border: 1px solid #E0D5C0;
    border-radius: 10px;
    background: #ffffff;
    color: #1A1208;
    box-sizing: border-box;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    font-family: inherit;
  }
  .hyst-chat-field input:focus,
  .hyst-chat-field textarea:focus {
    outline: none;
    border-color: #C25A2A;
    box-shadow: 0 0 0 3px rgba(194, 90, 42, 0.12);
  }

  .hyst-chat-submit {
    width: 100%;
    background: #C25A2A;
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    padding: 12px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(194, 90, 42, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 6px;
  }
  .hyst-chat-submit:hover {
    background: #A84C20;
    box-shadow: 0 6px 18px rgba(194, 90, 42, 0.45);
  }

  /* Success Screen */
  .hyst-chat-success {
    text-align: center;
    padding: 20px 10px;
    display: none;
  }
  .hyst-chat-success-icon {
    width: 56px;
    height: 56px;
    background: #DCFCE7;
    color: #15803D;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto 14px;
  }
  .hyst-chat-success h4 {
    font-size: 18px;
    font-weight: 700;
    color: #1A1208;
    margin: 0 0 6px;
  }
  .hyst-chat-success p {
    font-size: 13px;
    color: #6B5C46;
    margin: 0 0 16px;
    line-height: 1.4;
  }
  .hyst-ticket-badge {
    display: inline-block;
    background: #F3EAD8;
    color: #8C3D1A;
    font-family: monospace;
    font-size: 15px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 8px;
    margin-bottom: 16px;
    letter-spacing: 1px;
  }
</style>

<!-- Launcher Button -->
<button type="button" class="hyst-chat-launcher" id="hystChatLauncher" onclick="toggleHystChat()" title="Support Chat">
  <span class="hyst-chat-badge"></span>
  <svg id="hystChatIconOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
  </svg>
  <svg id="hystChatIconClose" style="display:none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
  </svg>
</button>

<!-- Support Popup Box -->
<div class="hyst-chat-card" id="hystChatCard">
  <div class="hyst-chat-header">
    <div class="hyst-chat-header-info">
      <div class="hyst-chat-avatar">🎧</div>
      <div>
        <div class="hyst-chat-title">HYST Support</div>
        <div class="hyst-chat-sub">Online • We usually reply fast</div>
      </div>
    </div>
    <button type="button" class="hyst-chat-close" onclick="toggleHystChat()">✕</button>
  </div>

  <div class="hyst-chat-body">
    <!-- Form View -->
    <form id="hystSupportForm" onsubmit="submitHystTicket(event)">
      @csrf
      <div class="hyst-chat-field">
        <label>Your Name *</label>
        <input type="text" name="name" required placeholder="John Doe" value="{{ auth()->user()->name ?? '' }}">
      </div>

      <div class="hyst-chat-field">
        <label>Email Address *</label>
        <input type="email" name="email" required placeholder="john@example.com" value="{{ auth()->user()->email ?? '' }}">
      </div>

      <div class="hyst-chat-field">
        <label>Phone Number *</label>
        <input type="text" name="phone" required placeholder="+44 7123 456789" value="{{ auth()->user()->phone ?? '' }}">
      </div>

      <div class="hyst-chat-field">
        <label>Order ID (Optional)</label>
        <input type="number" name="order_id" placeholder="e.g. 1042">
      </div>

      <div class="hyst-chat-field">
        <label>How can we help? *</label>
        <textarea name="message" rows="3" required placeholder="Describe your inquiry or order issue..."></textarea>
      </div>

      <button type="submit" class="hyst-chat-submit" id="hystSubmitBtn">
        <span>Raise Ticket</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
      </button>
    </form>

    <!-- Success View -->
    <div class="hyst-chat-success" id="hystChatSuccess">
      <div class="hyst-chat-success-icon">✓</div>
      <h4>Support Ticket Created!</h4>
      <p>Thank you! Your support ticket has been registered. Our team will contact you shortly.</p>
      <div class="hyst-ticket-badge" id="hystTicketNumberDisplay">TICK-00000</div>
      <button type="button" class="hyst-chat-submit" onclick="resetHystChatForm()">
        Submit Another Query
      </button>
    </div>
  </div>
</div>

<script>
  function toggleHystChat() {
    const card = document.getElementById('hystChatCard');
    const openIcon = document.getElementById('hystChatIconOpen');
    const closeIcon = document.getElementById('hystChatIconClose');

    if (card.style.display === 'none' || card.style.display === '') {
      card.style.display = 'flex';
      openIcon.style.display = 'none';
      closeIcon.style.display = 'block';
    } else {
      card.style.display = 'none';
      openIcon.style.display = 'block';
      closeIcon.style.display = 'none';
    }
  }

  async function submitHystTicket(e) {
    e.preventDefault();
    const form = document.getElementById('hystSupportForm');
    const submitBtn = document.getElementById('hystSubmitBtn');
    const formData = new FormData(form);

    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Submitting...';

    try {
      const response = await fetch('{{ route("support.ticket.store") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: formData
      });

      const result = await response.json();

      if (response.ok && result.status === 'success') {
        document.getElementById('hystTicketNumberDisplay').textContent = result.ticket_number;
        form.style.display = 'none';
        document.getElementById('hystChatSuccess').style.display = 'block';
      } else {
        alert(result.message || 'Something went wrong. Please check your inputs.');
      }
    } catch (err) {
      console.error(err);
      alert('Unable to submit support ticket. Please try again.');
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerHTML = '<span>Raise Ticket</span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>';
    }
  }

  function resetHystChatForm() {
    const form = document.getElementById('hystSupportForm');
    form.reset();
    form.style.display = 'block';
    document.getElementById('hystChatSuccess').style.display = 'none';
  }
</script>
