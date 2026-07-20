@extends('layouts.app')

@section('content')

<style>
    :root {
        --cream: #F6F1E8;
        --cream2: #EDE5D4;
        --terra: #C25A2A;
        --terra-light: #D97040;
        --terra-dark: #8C3D1A;
        --ink: #1A1208;
        --muted: #8A7A62;
        --border: #E0D5C0;
        --green: #3D8C5A;
        --red: #C23A2A;
    }

    .lr-wrap {
        padding: 30px;
    }

    .lr-header {
        margin-bottom: 25px;
    }

    .lr-eyebrow {
        color: var(--terra);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .lr-heading {
        margin: 0;
        color: var(--ink);
        font-size: 32px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }

    .lr-heading span {
        color: var(--terra);
    }

    .lr-description {
        margin-top: 7px;
        color: var(--muted);
        font-size: 14px;
    }

    /* ALERT */

    .lr-success {
        padding: 14px 18px;
        margin-bottom: 20px;
        color: #15803D;
        background: #DCFCE7;
        border: 1px solid #86EFAC;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
    }

    .lr-error-box {
        padding: 14px 18px;
        margin-bottom: 20px;
        color: #B91C1C;
        background: #FEE2E2;
        border: 1px solid #FCA5A5;
        border-radius: 10px;
        font-size: 13px;
    }

    .lr-error-box ul {
        margin: 0;
        padding-left: 20px;
    }

    /* MAIN CARD */

    .lr-card {
        padding: 25px;
        margin-top: 25px;
        background: #FFFFFF;
        border: 1px solid rgba(194, 90, 42, 0.15);
        border-radius: 16px;
        box-shadow: 0 3px 18px rgba(0, 0, 0, 0.06);
    }

    .lr-card-title {
        margin: 0 0 22px;
        color: var(--ink);
        font-size: 20px;
        font-weight: 700;
    }

    /* GRID */

    .lr-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 25px;
    }

    .lr-section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 10px;
    }

    .lr-label {
        display: block;
        margin-bottom: 8px;
        color: var(--ink);
        font-size: 13px;
        font-weight: 700;
    }

    /* SELECT ALL */

    .lr-select-all {
        display: flex;
        align-items: center;
        gap: 7px;
        color: var(--terra-dark);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .lr-checkbox {
        width: 17px;
        height: 17px;
        accent-color: var(--terra);
        cursor: pointer;
    }

    /* SEARCH */

    .lr-search {
        width: 100%;
        padding: 10px 13px;
        margin-bottom: 10px;
        color: var(--ink);
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
    }

    .lr-search:focus {
        outline: none;
        border-color: var(--terra);
        box-shadow: 0 0 0 3px rgba(194, 90, 42, 0.1);
    }

    /* CUSTOMER AND OFFER LIST */

    .lr-list {
        height: 330px;
        overflow-y: auto;
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 12px;
    }

    .lr-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px;
        margin: 0;
        border-bottom: 1px solid #EDE5D4;
        cursor: pointer;
        transition: 0.2s;
    }

    .lr-row:last-child {
        border-bottom: none;
    }

    .lr-row:hover {
        background: var(--cream2);
    }

    .lr-row.hidden {
        display: none;
    }

    .lr-name {
        color: var(--ink);
        font-size: 14px;
        font-weight: 700;
    }

    .lr-info {
        margin-top: 3px;
        color: var(--muted);
        font-size: 12px;
    }

    .lr-empty {
        padding: 50px 20px;
        color: var(--muted);
        text-align: center;
        font-size: 13px;
    }

    /* FORM */

    .lr-form-section {
        margin-top: 22px;
    }

    .lr-input {
        width: 100%;
        padding: 12px 14px;
        color: var(--ink);
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 9px;
        font-family: inherit;
        font-size: 14px;
    }

    .lr-input:focus {
        outline: none;
        background: #FFFFFF;
        border-color: var(--terra);
        box-shadow: 0 0 0 3px rgba(194, 90, 42, 0.1);
    }

    textarea.lr-input {
        min-height: 140px;
        resize: vertical;
    }

    .lr-field-error {
        display: block;
        margin-top: 6px;
        color: var(--red);
        font-size: 12px;
    }

    /* BUTTON */

    .lr-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 13px 25px;
        margin-top: 25px;
        color: #FFFFFF;
        background: var(--terra);
        border: none;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .lr-btn:hover {
        background: var(--terra-light);
        transform: translateY(-1px);
    }

    /* TABLE STATUS BADGES (reused as classes for consistency) */

    .lr-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .lr-badge-birthday { color: #8C3D1A; background: #FDE8D8; }
    .lr-badge-festival { color: #7C3AED; background: #EDE9FE; }
    .lr-badge-sent     { color: #15803D; background: #DCFCE7; }
    .lr-badge-failed   { color: #B91C1C; background: #FEE2E2; }

    @media (max-width: 800px) {
        .lr-grid {
            grid-template-columns: 1fr;
        }

        .lr-wrap {
            padding: 18px 14px;
        }

        .lr-heading {
            font-size: 25px;
        }

        .lr-card {
            padding: 18px;
        }
    }
</style>


<div class="lr-wrap">

    {{-- PAGE HEADER --}}

    <div class="lr-header">

        <div class="lr-eyebrow">
            Restaurant Panel
        </div>

        <h1 class="lr-heading">
            Loyalty <span>& Rewards</span>
        </h1>

        <p class="lr-description">
            Send birthday and festival rewards to your restaurant customers.
        </p>

    </div>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div class="lr-success">
            ✓ {{ session('success') }}
        </div>

    @endif


    {{-- ALL VALIDATION ERRORS --}}

    @if($errors->any())

        <div class="lr-error-box">

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="lr-card">

        <h3 class="lr-card-title">
            Create Reward Campaign
        </h3>


        <form
            action="{{ route('restaurant.loyalty.send') }}"
            method="POST"
        >

            @csrf


            <div class="lr-grid">


                {{-- CUSTOMERS --}}

                <div>

                    <div class="lr-section-heading">

                        <label class="lr-label">
                            Select Customers
                        </label>

                        <label class="lr-select-all">

                            <input
                                type="checkbox"
                                id="allCustomers"
                                class="lr-checkbox"
                            >

                            Select All

                        </label>

                    </div>


                    <input
                        type="text"
                        id="customerSearch"
                        class="lr-search"
                        placeholder="Search customer by name or email..."
                    >


                    <div class="lr-list">


                        @forelse($customers as $customer)

                            <label class="lr-row customer-row">

                                <input
                                    type="checkbox"
                                    name="customers[]"
                                    class="lr-checkbox customerCheck"
                                    value="{{ $customer->id }}"
                                    {{ in_array($customer->id, old('customers', [])) ? 'checked' : '' }}
                                >


                                <div>

                                    <div class="lr-name">

                                        {{ $customer->name }}

                                    </div>


                                    <div class="lr-info">

                                        {{ $customer->email }}

                                    </div>


                                    <div class="lr-info">

                                        🎂 DOB:

                                        @if($customer->dob)

                                            {{ \Carbon\Carbon::parse($customer->dob)->format('d M Y') }}

                                        @else

                                            Not Added

                                        @endif

                                    </div>

                                </div>

                            </label>

                        @empty

                            <div class="lr-empty">

                                No Restaurant Customers Found

                            </div>

                        @endforelse


                    </div>


                    @error('customers')

                        <span class="lr-field-error">

                            {{ $message }}

                        </span>

                    @enderror

                </div>



                {{-- OFFERS --}}

                <div>

                    <div class="lr-section-heading">

                        <label class="lr-label">
                            Select Offers
                        </label>

                        <label class="lr-select-all">

                            <input
                                type="checkbox"
                                id="allOffers"
                                class="lr-checkbox"
                            >

                            Select All

                        </label>

                    </div>


                    <input
                        type="text"
                        id="offerSearch"
                        class="lr-search"
                        placeholder="Search offer..."
                    >


                    <div class="lr-list">


                        @forelse($offers as $offer)

                            <label class="lr-row offer-row">

                                <input
                                    type="checkbox"
                                    name="offers[]"
                                    class="lr-checkbox offerCheck"
                                    value="{{ $offer->id }}"
                                    {{ in_array($offer->id, old('offers', [])) ? 'checked' : '' }}
                                >


                                <div>

                                    <div class="lr-name">

                                        {{ $offer->title }}

                                    </div>


                                    <div class="lr-info">

                                        @if($offer->value_type === 'percentage')

                                            {{ $offer->value }}% OFF

                                        @else

                                            £{{ $offer->value }} OFF

                                        @endif

                                    </div>


                                    @if($offer->end_date)

                                        <div class="lr-info">

                                            Valid Until:

                                            {{ \Carbon\Carbon::parse($offer->end_date)->format('d M Y') }}

                                        </div>

                                    @endif

                                </div>

                            </label>

                        @empty

                            <div class="lr-empty">

                                No Active Offers Found

                            </div>

                        @endforelse


                    </div>


                    @error('offers')

                        <span class="lr-field-error">

                            {{ $message }}

                        </span>

                    @enderror

                </div>


            </div>



            {{-- REWARD TYPE --}}

            <div class="lr-form-section">

                <label class="lr-label">

                    Reward Type

                </label>


                <select
                    name="reward_type"
                    id="rewardType"
                    class="lr-input"
                    required
                >

                    <option value="">

                        Select Reward Type

                    </option>


                    <option
                        value="birthday"
                        {{ old('reward_type') === 'birthday' ? 'selected' : '' }}
                    >

                        🎂 Birthday Reward

                    </option>


                    <option
                        value="festival"
                        {{ old('reward_type') === 'festival' ? 'selected' : '' }}
                    >

                        🎉 Festival Reward

                    </option>

                </select>


                @error('reward_type')

                    <span class="lr-field-error">

                        {{ $message }}

                    </span>

                @enderror

            </div>



            {{-- FESTIVAL NAME --}}

            <div
                id="festivalBox"
                class="lr-form-section"
                style="{{ old('reward_type') === 'festival' ? '' : 'display: none;' }}"
            >

                <label class="lr-label">

                    Festival Name

                </label>


                <input
                    type="text"
                    name="festival_name"
                    id="festivalName"
                    class="lr-input"
                    value="{{ old('festival_name') }}"
                    placeholder="Example: Diwali, Holi, Eid, Christmas"
                >


                @error('festival_name')

                    <span class="lr-field-error">

                        {{ $message }}

                    </span>

                @enderror

            </div>



            {{-- EMAIL SUBJECT --}}

            <div class="lr-form-section">

                <label class="lr-label">

                    Email Subject

                </label>


                <input
                    type="text"
                    name="subject"
                    class="lr-input"
                    value="{{ old('subject') }}"
                    placeholder="Example: A Special Birthday Reward For You"
                    required
                >


                @error('subject')

                    <span class="lr-field-error">

                        {{ $message }}

                    </span>

                @enderror

            </div>



            {{-- MESSAGE --}}

            <div class="lr-form-section">

                <label class="lr-label">

                    Reward Message

                </label>


                <textarea
                    name="message"
                    class="lr-input"
                    rows="6"
                    placeholder="Write your birthday or festival reward message..."
                    required
                >{{ old('message') }}</textarea>


                @error('message')

                    <span class="lr-field-error">

                        {{ $message }}

                    </span>

                @enderror

            </div>



            <button
                type="submit"
                class="lr-btn"
            >

                🎁 Send Reward Email

            </button>


        </form>

    </div>

    {{-- REWARD EMAIL HISTORY --}}

    <div class="lr-card">

        <h3 class="lr-card-title">
            Reward Email History
        </h3>

        <div style="overflow-x: auto;">

            <table style="
                width: 100%;
                min-width: 950px;
                border-collapse: collapse;
            ">

                <thead>

                    <tr style="
                        background: #F6F1E8;
                        color: #1A1208;
                    ">

                        <th style="padding: 14px; text-align: left;">
                            Customer
                        </th>

                        <th style="padding: 14px; text-align: left;">
                            Email
                        </th>

                        <th style="padding: 14px; text-align: left;">
                            Reward Type
                        </th>

                        <th style="padding: 14px; text-align: left;">
                            Festival
                        </th>

                        <th style="padding: 14px; text-align: left;">
                            Subject
                        </th>

                        <th style="padding: 14px; text-align: left;">
                            Status
                        </th>

                        <th style="padding: 14px; text-align: left;">
                            Sent Date
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($rewardLogs as $rewardLog)

                        <tr style="border-bottom: 1px solid #EDE5D4;">

                            {{-- CUSTOMER NAME --}}

                            <td style="padding: 14px;">

                                <strong>

                                    {{ $rewardLog->user->name ?? 'User Deleted' }}

                                </strong>

                            </td>


                            {{-- CUSTOMER EMAIL --}}

                            <td style="padding: 14px;">

                                {{ $rewardLog->user->email ?? 'N/A' }}

                            </td>


                            {{-- REWARD TYPE --}}

                            <td style="padding: 14px;">

                                @if($rewardLog->reward_type === 'birthday')

                                    <span class="lr-badge lr-badge-birthday">
                                        🎂 Birthday
                                    </span>

                                @else

                                    <span class="lr-badge lr-badge-festival">
                                        🎉 Festival
                                    </span>

                                @endif

                            </td>


                            {{-- FESTIVAL NAME --}}

                            <td style="padding: 14px;">

                                {{ $rewardLog->festival_name ?? '—' }}

                            </td>


                            {{-- SUBJECT --}}

                            <td style="padding: 14px;">

                                {{ $rewardLog->subject }}

                            </td>


                            {{-- EMAIL STATUS --}}

                            <td style="padding: 14px;">

                                @if($rewardLog->status === 'sent')

                                    <span class="lr-badge lr-badge-sent">
                                        ✓ Sent
                                    </span>

                                @else

                                    <span class="lr-badge lr-badge-failed">
                                        ✕ Failed
                                    </span>

                                @endif

                            </td>


                            {{-- DATE AND TIME --}}

                            <td style="padding: 14px;">

                                @if($rewardLog->sent_at)

                                    {{ $rewardLog->sent_at->format('d M Y') }}

                                    <br>

                                    <small style="color: #8A7A62;">

                                        {{ $rewardLog->sent_at->format('h:i A') }}

                                    </small>

                                @else

                                    N/A

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                style="
                                    padding: 60px 20px;
                                    color: #8A7A62;
                                    text-align: center;
                                "
                            >

                                <div style="margin-bottom: 8px; font-size: 35px;">
                                    🎁
                                </div>

                                No Reward Emails Sent Yet

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($rewardLogs->hasPages())

            <div style="margin-top: 25px;">

                {{ $rewardLogs->links() }}

            </div>

        @endif

    </div>

</div>


<script>

document.addEventListener("DOMContentLoaded", function () {


    /*
    |--------------------------------------------------------------------------
    | SELECT ALL CUSTOMERS
    |--------------------------------------------------------------------------
    */

    const allCustomers = document.getElementById("allCustomers");

    if (allCustomers) {

        allCustomers.addEventListener("change", function () {

            document
                .querySelectorAll(".customerCheck")
                .forEach(function (customer) {

                    customer.checked = allCustomers.checked;

                });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SELECT ALL OFFERS
    |--------------------------------------------------------------------------
    */

    const allOffers = document.getElementById("allOffers");

    if (allOffers) {

        allOffers.addEventListener("change", function () {

            document
                .querySelectorAll(".offerCheck")
                .forEach(function (offer) {

                    offer.checked = allOffers.checked;

                });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | FESTIVAL FIELD SHOW/HIDE
    |--------------------------------------------------------------------------
    */

    const rewardType = document.getElementById("rewardType");
    const festivalBox = document.getElementById("festivalBox");
    const festivalName = document.getElementById("festivalName");

    function manageFestivalField() {

        if (rewardType.value === "festival") {

            festivalBox.style.display = "block";
            festivalName.setAttribute("required", "required");

        } else {

            festivalBox.style.display = "none";
            festivalName.removeAttribute("required");
            festivalName.value = "";

        }

    }

    if (rewardType && festivalBox && festivalName) {

        rewardType.addEventListener("change", manageFestivalField);
        manageFestivalField();

    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER SEARCH
    |--------------------------------------------------------------------------
    */

    const customerSearch = document.getElementById("customerSearch");

    if (customerSearch) {

        customerSearch.addEventListener("input", function () {

            const searchValue = this.value.toLowerCase().trim();

            document
                .querySelectorAll(".customer-row")
                .forEach(function (row) {

                    const customerData = row.innerText.toLowerCase();

                    row.classList.toggle(
                        "hidden",
                        !customerData.includes(searchValue)
                    );

                });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | OFFER SEARCH
    |--------------------------------------------------------------------------
    */

    const offerSearch = document.getElementById("offerSearch");

    if (offerSearch) {

        offerSearch.addEventListener("input", function () {

            const searchValue = this.value.toLowerCase().trim();

            document
                .querySelectorAll(".offer-row")
                .forEach(function (row) {

                    const offerData = row.innerText.toLowerCase();

                    row.classList.toggle(
                        "hidden",
                        !offerData.includes(searchValue)
                    );

                });

        });

    }


});

</script>

@endsection