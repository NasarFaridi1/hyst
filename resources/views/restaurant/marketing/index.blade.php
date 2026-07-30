@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<style>
  :root {
    --cream:     #F6F1E8;
    --cream2:    #EDE5D4;
    --cream3:    #E0D5C0;
    --terra:     #C25A2A;
    --terra-l:   #D97040;
    --terra-d:   #8C3D1A;
    --terra-bg:  rgba(194,90,42,0.08);
    --terra-bg2: rgba(194,90,42,0.14);
    --ink:       #1A1208;
    --ink2:      #2E2318;
    --muted:     #8A7A62;
    --muted2:    #6B5C46;
    --green:     #3D8C5A;
    --green-bg:  rgba(61,140,90,0.1);
    --red:       #C23A2A;
    --red-bg:    rgba(194,58,42,0.08);
    --blue:      #2A6CC2;
    --blue-bg:   rgba(42,108,194,0.08);
    --border:    rgba(194,90,42,0.12);
    --border2:   rgba(194,90,42,0.22);
    --shadow:    0 2px 16px rgba(26,18,8,0.08);
    --shadow2:   0 8px 32px rgba(26,18,8,0.12);
    --ease:      cubic-bezier(0.16,1,0.3,1);
  }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: var(--cream2); }
  ::-webkit-scrollbar-thumb { background: var(--terra); border-radius: 4px; }

  .mk-wrap { margin: 0 auto; padding: 2rem 1.5rem 4rem; }

  .pg-header { margin-bottom: 28px; }
  .pg-eyebrow {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.16em; color: var(--terra); margin-bottom: 6px;
    display: flex; align-items: center; gap: 8px;
  }
  .pg-eyebrow::before { content: ''; width: 16px; height: 2px; background: var(--terra); border-radius: 2px; }
  .pg-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 32px; font-weight: 700; color: var(--ink); line-height: 1.15;
  }
  .pg-header h1 span { color: var(--terra); }
  .pg-sub { font-size: 13px; color: var(--muted); margin-top: 4px; font-weight: 400; }

  /* ── Alert ── */
  .alert-success {
    background: #DCFCE7; border: 1px solid #86EFAC; color: #15803D;
    border-radius: 12px; padding: 14px 18px; margin-bottom: 22px;
    font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;
  }

  /* ── Card ── */
  .mk-card {
    background: #fff; border: 1px solid var(--border); border-radius: 16px;
    box-shadow: var(--shadow); overflow: hidden;
    animation: fadeUp .5s var(--ease) both;
  }
  .mk-card-header {
    padding: 18px 24px; background: var(--cream); border-bottom: 1px solid var(--border);
  }
  .mk-card-header h4 {
    font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: var(--ink); margin: 0;
  }
  .mk-card-body { padding: 26px 24px; }

  /* ── Form elements ── */
  .mk-label {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: var(--muted2); margin-bottom: 8px; display: block;
  }
  .mk-input, .mk-textarea {
    width: 100%; border: 1px solid var(--border2); border-radius: 10px;
    padding: 11px 14px; font-size: 13.5px; font-weight: 500;
    background: var(--cream); color: var(--ink2);
    font-family: 'Poppins', sans-serif;
    transition: border-color .2s, box-shadow .2s;
  }
  .mk-input:focus, .mk-textarea:focus {
    outline: none; border-color: var(--terra); box-shadow: 0 0 0 3px rgba(194,90,42,0.12);
    background: #fff;
  }
  .mk-textarea { resize: vertical; min-height: 160px; }

  .mk-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 6px; align-items: end; }
  @media(max-width:640px) { .mk-row { grid-template-columns: 1fr; } }

  /* ── Select-all toggle ── */
  .mk-select-all {
    display: flex; align-items: center; gap: 10px;
    background: var(--terra-bg); border: 1px solid rgba(194,90,42,0.2);
    border-radius: 10px; padding: 11px 16px; cursor: pointer;
    height: 44px; box-sizing: border-box;
  }
  .mk-select-all label { font-size: 13px; font-weight: 600; color: var(--terra-d); cursor: pointer; margin: 0; }

  /* ── Custom checkbox ── */
  .mk-checkbox {
    appearance: none; -webkit-appearance: none;
    width: 18px; height: 18px; border: 1.5px solid var(--border2); border-radius: 5px;
    background: #fff; cursor: pointer; flex-shrink: 0; position: relative;
    transition: all .18s var(--ease);
  }
  .mk-checkbox:checked {
    background: var(--terra); border-color: var(--terra);
  }
  .mk-checkbox:checked::after {
    content: ''; position: absolute; left: 5px; top: 1px;
    width: 5px; height: 9px; border: solid #fff; border-width: 0 2px 2px 0;
    transform: rotate(45deg);
  }
  .mk-checkbox:focus { outline: 2px solid var(--terra); outline-offset: 1px; }

  /* ── Customer list ── */
  .mk-cust-panel {
    border: 1px solid var(--border); border-radius: 14px;
    height: 300px; overflow-y: auto; background: var(--cream);
    margin-top: 6px;
  }
  .mk-cust-row {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 16px; border-bottom: 1px solid rgba(194,90,42,0.08);
    transition: background .15s; cursor: pointer;
  }
  .mk-cust-row:last-child { border-bottom: none; }
  .mk-cust-row:hover { background: var(--cream2); }
  .mk-cust-row.mk-hidden { display: none; }
  .mk-cust-name { font-size: 13.5px; font-weight: 600; color: var(--ink); }
  .mk-cust-email { font-size: 12px; color: var(--muted); margin-top: 1px; }

  .mk-empty {
    text-align: center; padding: 40px 20px; color: var(--muted); font-size: 13px;
  }

  .mk-error {
    font-size: 12.5px; color: var(--red); margin-top: 8px; display: block; font-weight: 500;
  }

  /* ── Submit button ── */
  .mk-btn {
    display: inline-flex; align-items: center; gap: 9px;
    background: var(--terra); color: #fff; border: none; border-radius: 10px;
    padding: 12px 28px; font-family: 'Poppins', sans-serif;
    font-size: 14px; font-weight: 600; cursor: pointer;
    transition: all .22s var(--ease); box-shadow: 0 4px 14px rgba(194,90,42,0.3);
    margin-top: 26px;
  }
  .mk-btn:hover { background: var(--terra-l); transform: translateY(-1px); box-shadow: 0 8px 22px rgba(194,90,42,0.4); }
  .mk-btn svg { width: 15px; height: 15px; }

  .mk-divider { border: none; border-top: 1px solid var(--border); margin: 26px 0; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media(max-width:640px) {
    .pg-header h1 { font-size: 24px; }
    .mk-card-body { padding: 20px 16px; }
  }

    .mk-contact-admin{
        display:flex;
        align-items:center;
        gap:18px;
        background:linear-gradient(135deg,#FFF8F4,#F6F1E8);
        border:1px solid rgba(194,90,42,.18);
        border-left:5px solid #C25A2A;
        border-radius:16px;
        padding:20px;
        margin-bottom:24px;
    }

    .mk-contact-icon{
        width:60px;
        height:60px;
        border-radius:50%;
        background:#C25A2A;
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:28px;
        flex-shrink:0;
    }

    .mk-contact-content h4{
        margin:0 0 6px;
        font-size:18px;
        color:#1A1208;
    }

    .mk-contact-content p{
        margin:0 0 10px;
        color:#6B5C46;
        font-size:14px;
    }

    .mk-contact-info{
        display:flex;
        gap:12px;
        flex-wrap:wrap;
        font-weight:600;
    }

    .mk-contact-info a{
        color:#C25A2A;
        text-decoration:none;
    }

    .mk-contact-info a:hover{
        text-decoration:underline;
    }
</style>

<div class="mk-wrap">

    <div class="pg-header">
        <div class="pg-eyebrow">Restaurant Panel</div>
        <h1>Marketing <span>Automation</span></h1>
        <p class="pg-sub">Send targeted email campaigns to your customers</p>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="mk-card">

        <div class="mk-contact-admin">
            <div class="mk-contact-icon">
                📞
            </div>

            <div class="mk-contact-content">
                <h4>Contact Admin</h4>
                <p>
                    Need help with marketing campaigns or customer emails?
                    Contact the administrator for assistance.
                </p>

                <div class="mk-contact-info">
                    <a href="tel:+441234567890">+44 1234 567890</a>
                    <span>•</span>
                    <a href="mailto:admin@example.com">admin@example.com</a>
                </div>
            </div>
        </div>
        {{-- <div class="mk-card-header">
            <h4>Compose Campaign</h4>
        </div> --}}

        {{-- <div class="mk-card-body">

            <form action="{{ route('restaurant.marketing.send') }}" method="POST">

                @csrf

                <div class="mk-row">

                    <div>
                        <label class="mk-label">Search Customer</label>
                        <input
                            type="text"
                            id="searchCustomer"
                            class="mk-input"
                            placeholder="Search by name or email…">
                    </div>

                    <div class="mk-select-all" onclick="document.getElementById('selectAll').click()">
                        <input
                            type="checkbox"
                            id="selectAll"
                            class="mk-checkbox"
                            onclick="event.stopPropagation()">
                        <label>Select All Customers</label>
                    </div>

                </div>

                <div class="mk-cust-panel" id="custPanel">

                    @forelse($customers as $customer)

                        <label class="mk-cust-row customerRow">

                            <input
                                class="mk-checkbox customerCheckbox"
                                type="checkbox"
                                name="customers[]"
                                value="{{ $customer->id }}">

                            <div>
                                <div class="mk-cust-name">{{ $customer->name }}</div>
                                
                            </div>

                        </label>

                    @empty

                        <div class="mk-empty">No Customers Found</div>

                    @endforelse

                </div>

                @error('customers')
                    <span class="mk-error">{{ $message }}</span>
                @enderror

                <hr class="mk-divider">

                <div>
                    <label class="mk-label">Subject</label>
                    <input
                        type="text"
                        name="subject"
                        class="mk-input"
                        required>
                </div>

                <div style="margin-top:20px;">
                    <label class="mk-label">Message</label>
                    <textarea
                        class="mk-textarea"
                        rows="8"
                        name="message"
                        required></textarea>
                </div>

                <button class="mk-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Send Email
                </button>

            </form>

        </div> --}}
       

        {{-- <div class="mk-card" style="margin-top: 28px;">

            <div class="mk-card-header">

                <h4>
                    Sent Email History
                </h4>

            </div>


            <div class="mk-card-body">


                <div style="overflow-x: auto;">


                    <table style="
                        width: 100%;
                        border-collapse: collapse;
                        min-width: 850px;
                    ">


                        <thead>

                            <tr style="
                                background: #F6F1E8;
                            ">

                                <th style="
                                    padding: 14px;
                                    text-align: left;
                                ">
                                    Customer
                                </th>




                                <th style="
                                    padding: 14px;
                                    text-align: left;
                                ">
                                    Subject
                                </th>


                                <th style="
                                    padding: 14px;
                                    text-align: left;
                                ">
                                    Status
                                </th>


                                <th style="
                                    padding: 14px;
                                    text-align: left;
                                ">
                                    Sent Date
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            @forelse($emailLogs as $emailLog)


                                <tr style="
                                    border-bottom:
                                    1px solid
                                    rgba(194,90,42,0.12);
                                ">


                                    <td style="padding: 14px;">

                                        {{ $emailLog->customer_name
                                            ?? 'N/A' }}

                                    </td>


                                    


                                    <td style="padding: 14px;">

                                        {{ $emailLog->subject }}

                                    </td>


                                    <td style="padding: 14px;">


                                        @if(
                                            $emailLog->status
                                            === 'sent'
                                        )


                                            <span style="
                                                color: #15803D;
                                                background: #DCFCE7;
                                                padding: 6px 12px;
                                                border-radius: 20px;
                                                font-size: 12px;
                                                font-weight: 600;
                                            ">

                                                Sent

                                            </span>


                                        @else


                                            <span style="
                                                color: #B91C1C;
                                                background: #FEE2E2;
                                                padding: 6px 12px;
                                                border-radius: 20px;
                                                font-size: 12px;
                                                font-weight: 600;
                                            ">

                                                Failed

                                            </span>


                                        @endif


                                    </td>


                                    <td style="padding: 14px;">


                                        {{ $emailLog->sent_at

                                            ? $emailLog
                                                ->sent_at
                                                ->format(
                                                    'd M Y, h:i A'
                                                )

                                            : 'N/A'

                                        }}


                                    </td>


                                </tr>


                            @empty


                                <tr>

                                    <td
                                        colspan="5"

                                        style="
                                            padding: 50px;
                                            text-align: center;
                                            color: #8A7A62;
                                        "
                                    >

                                        No Marketing Emails Sent Yet

                                    </td>

                                </tr>


                            @endforelse


                        </tbody>


                    </table>


                </div>


                @if($emailLogs->hasPages())

                    <div style="margin-top: 22px;">

                        {{ $emailLogs->links() }}

                    </div>

                @endif


            </div>

        </div> --}}
    </div>

</div>

<script>

document
.getElementById("selectAll")
.addEventListener("change",function(){

    document
    .querySelectorAll(".customerCheckbox")
    .forEach(function(item){

        item.checked=
        document
        .getElementById("selectAll")
        .checked;

    });

});

document
.getElementById("searchCustomer")
.addEventListener("keyup",function(){

    let value=this.value.toLowerCase();

    document
    .querySelectorAll(".customerRow")
    .forEach(function(row){

        row.classList.toggle(
            "mk-hidden",
            !row.innerText.toLowerCase().includes(value)
        );

    });

});

</script>

@endsection