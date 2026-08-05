@extends('front.layouts.app')

@section('content')

<style>
    
    /* ============================================================
    GLOBAL RESET & FONT
    ============================================================ */
    * { box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        color: #1A1A1A;
        background: #F6F6F6;
    }

    /* ============================================================
    HERO SLIDER
    ============================================================ */
    .hero-slider {
        position: absolute;
        inset: 0;
        overflow: hidden;
        z-index: 0;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        visibility: hidden;
        transition: opacity .8s ease;
    }

    .hero-slide.active {
        opacity: 1;
        visibility: visible;
    }

    .hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1);
        transition: transform 8s linear;
    }

    .hero-slide.active img {
        transform: scale(1.08);
    }

    /* ============================================================
    CATEGORY BAR (sticky)
    ============================================================ */
    .res-category-bar {
        background: #fff;
        border-bottom: 1px solid #EAEAEA;
        position: sticky;
        top: 0;
        z-index: 40;
    }

    .res-category-bar-inner {
        display: flex;
        gap: 0;
        overflow-x: auto;
        scrollbar-width: none;
        padding: 0 32px;
    }

    .res-category-bar-inner::-webkit-scrollbar { display: none; }

    .cat-tab {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        padding: 16px 20px;
        border: none;
        background: none;
        color: #757575;
        cursor: pointer;
        white-space: nowrap;
        border-bottom: 2.5px solid transparent;
        transition: color .12s, border-color .12s;
        text-decoration: none;
        display: inline-block;
        line-height: 1.2;
    }

    .cat-tab:hover {
        color: #1A1A1A;
    }

    .cat-tab.active {
        color: #1A1A1A;
        border-bottom-color: #1A1A1A;
    }

    /* ============================================================
    PROMO / OFFER BANNER
    ============================================================ */
    .promo-bar {
        background: #fff;
        border-bottom: 1px solid #EAEAEA;
        padding: 10px 32px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    /* ============================================================
    MAIN LAYOUT: items list + cart sidebar
    ============================================================ */
    .restaurant-body {
        display: flex;
        align-items: flex-start;
    }

    .items-column {
        flex: 1;
        overflow-y: auto;
        padding: 28px 32px;
        min-width: 0;
    }

    /* ============================================================
    SECTION HEADINGS & ITEM ROWS
    ============================================================ */
    .menu-section {
        margin-bottom: 36px;
    }

    .menu-section-title {
        font-size: 20px;
        font-weight: 700;
        letter-spacing: -.3px;
        margin: 0 0 16px;
    }

    .menu-item-row {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px 0;
        border-bottom: 1px solid #EAEAEA;
        cursor: pointer;
    }

    .menu-item-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .menu-item-name-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .veg-dot-wrap {
        width: 14px;
        height: 14px;
        border-radius: 3px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .veg-dot-wrap.veg   { border: 1.5px solid #1E7A45; }
    .veg-dot-wrap.nonveg { border: 1.5px solid #A93A2C; }
    .veg-dot-wrap.bev   { border: 1.5px solid #C25A2A; }

    .veg-dot-wrap span {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: block;
    }

    .veg-dot-wrap.veg span   { background: #1E7A45; }
    .veg-dot-wrap.nonveg span { background: #A93A2C; }
    .veg-dot-wrap.bev span   { background: #C25A2A; }

    .menu-item-name {
        font-size: 16px;
        font-weight: 600;
        letter-spacing: -.2px;
    }

    .popular-badge {
        font-size: 11px;
        font-weight: 700;
        background: #FFF3CD;
        color: #946C00;
        padding: 2px 7px;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .menu-item-price {
        font-size: 14px;
        font-weight: 600;
        color: #1A1A1A;
    }

    .menu-item-desc {
        font-size: 13px;
        color: #757575;
        line-height: 1.5;
        max-width: 52ch;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .menu-item-tags {
        display: flex;
        gap: 6px;
        margin-top: 2px;
        flex-wrap: wrap;
    }

    .item-tag {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 4px;
    }

    .item-tag.veg-tag        { background: #E7F5EE; color: #1E7A45; }
    .item-tag.nonveg-tag     { background: #FEF0EF; color: #A93A2C; }
    .item-tag.mild-tag       { background: #FFF8EC; color: #946C00; }
    .item-tag.spicy-tag      { background: #FEF0EF; color: #A93A2C; }

    /* ============================================================
    ITEM THUMBNAIL + ADD/QTY BUTTON
    ============================================================ */
    .item-thumb-wrap {
        width: 140px;
        flex-shrink: 0;
        position: relative;
    }

    .item-thumb-wrap img {
        width: 140px;
        height: 110px;
        object-fit: cover;
        border-radius: 12px;
        display: block;
    }

    .item-thumb-placeholder {
        width: 140px;
        height: 110px;
        border-radius: 12px;
        background: #E8E8E8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 11px;
    }

    /* ADD (+) button */
    .btn-add-item {
        position: absolute;
        bottom: -14px;
        right: 10px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: #000;
        color: #fff;
        font-size: 20px;
        font-weight: 300;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,.25);
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        z-index: 1;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-add-item:hover { background: #333; }

    /* QTY stepper on item card */
    .item-qty-stepper {
        position: absolute;
        bottom: -14px;
        right: 4px;
        display: flex;
        align-items: center;
        background: #fff;
        border: 1.5px solid #1A1A1A;
        border-radius: 500px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,.15);
        z-index: 1;
    }

    .item-qty-stepper button {
        font-family: 'DM Sans', sans-serif;
        width: 32px;
        height: 32px;
        border: none;
        background: none;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        color: #1A1A1A;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-qty-stepper .qty-val {
        font-size: 14px;
        font-weight: 700;
        min-width: 18px;
        text-align: center;
    }

    /* ============================================================
    CART SIDEBAR
    ============================================================ */
    .cart-sidebar {
        width: 340px;
        flex-shrink: 0;
        border-left: 1px solid #EAEAEA;
        background: #fff;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        /* height is controlled by JS / parent flex */
        height: calc(100vh - 60px); /* navbar height */
        position: sticky;
        top: 60px;
    }

    .cart-header {
        padding: 20px 20px 16px;
        border-bottom: 1px solid #EAEAEA;
        flex-shrink: 0;
    }

    .cart-header h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 2px;
    }

    .cart-header p {
        font-size: 13px;
        color: #757575;
        margin: 0;
    }

    .cart-empty-state {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 32px;
        text-align: center;
    }

    .cart-empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #F6F6F6;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-items-list {
        flex: 1;
        overflow-y: auto;
        padding: 16px 20px;
    }

    .cart-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #F6F6F6;
    }

    .cart-row-stepper{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        width:fit-content;
        border:1.5px solid #1A1A1A;
        border-radius:999px;
        overflow:hidden;
        flex-shrink:0;
    }

    .cart-row-stepper button {
        font-family: 'DM Sans', sans-serif;
        width: 28px;
        height: 28px;
        border: none;
        background: none;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1A1A1A;
    }

    .cart-row-stepper .qty-val {
        font-size: 13px;
        font-weight: 700;
        min-width: 16px;
        text-align: center;
    }

    .cart-row-name {
        flex: 1;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.3;
    }

    .cart-row-price {
        font-size: 14px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .cart-footer {
        padding: 16px 20px;
        border-top: 1px solid #EAEAEA;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
    }

    .cart-footer-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #757575;
    }

    .cart-footer-row span:last-child {
        color: #1A1A1A;
        font-weight: 600;
    }

    .btn-checkout {
        font-family: 'DM Sans', sans-serif;
        width: 100%;
        padding: 14px 18px;
        border: none;
        background: #000;
        color: #fff;
        border-radius: 500px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
    }

    .btn-checkout:hover { background: #333; color: #fff; }

    /* ============================================================
    ITEM DETAIL MODAL (desktop)
    ============================================================ */
    .item-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.5);
        z-index: 9000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-modal-box {
        width: 580px;
        max-height: 85vh;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .item-modal-img-wrap {
        position: relative;
        height: 260px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .item-modal-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-modal-img-placeholder {
        width: 100%;
        height: 100%;
        background: #E8E8E8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 14px;
    }

    .item-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,.9);
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #1A1A1A;
        box-shadow: 0 2px 8px rgba(0,0,0,.15);
    }

    .item-modal-body {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .item-modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #EAEAEA;
        display: flex;
        gap: 14px;
        align-items: center;
        flex-shrink: 0;
    }

    .modal-qty-stepper {
        display: flex;
        align-items: center;
        border: 1.5px solid #1A1A1A;
        border-radius: 500px;
        overflow: hidden;
    }

    .modal-qty-stepper button {
        font-family: 'DM Sans', sans-serif;
        width: 42px;
        height: 42px;
        border: none;
        background: none;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-qty-stepper .qty-val {
        font-size: 16px;
        font-weight: 700;
        min-width: 24px;
        text-align: center;
    }

    .btn-add-to-order {
        flex: 1;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        font-weight: 700;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 500px;
        padding: 14px 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
    }

    .btn-add-to-order:hover { background: #333; }

    /* ============================================================
    VARIANT / ADDON MODAL (your existing, restyled)
    ============================================================ */
    #variantModal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.6);
        z-index: 99999;
        align-items: center;
        justify-content: center;
    }

    #variantModal.open {
        display: flex;
    }

    .variant-modal-box {
        background: #fff;
        width: 440px;
        max-width: 95%;
        border-radius: 20px;
        padding: 24px;
        max-height: 85vh;
        overflow-y: auto;
    }

    .variant-modal-box h3 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 20px;
    }

    .variant-modal-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    /* ============================================================
    CART REPLACE MODAL
    ============================================================ */
    #cartReplaceModal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.6);
        z-index: 99999;
        align-items: center;
        justify-content: center;
    }

    #cartReplaceModal.open {
        display: flex;
    }

    /* ============================================================
    UTILITY BUTTONS
    ============================================================ */
    .btn-black {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #0D0D0D;
        color: #fff;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        transition: background .2s;
        cursor: pointer;
        border: none;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-black:hover { background: #2a2a2a; }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: #000;
        color: #fff;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        transition: background .2s;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-primary:hover { background: #333; }

    /* ============================================================
    VEG ONLY TOGGLE
    ============================================================ */
    .veg-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 500px;
        cursor: pointer;
        border: 1.5px solid #E0E0E0;
        background: #fff;
        color: #1A1A1A;
        transition: all .2s;
    }

    .veg-toggle.active {
        border-color: #06C167;
        background: #E7F5EE;
        color: #1E7A45;
    }

    .veg-toggle .veg-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #D0D0D0;
        transition: background .2s;
    }

    .veg-toggle.active .veg-dot { background: #06C167; }

    /* ============================================================
    SEARCH INPUT
    ============================================================ */
    .search-wrap {
        flex: 1;
        max-width: 460px;
        position: relative;
    }

    .search-wrap svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .search-wrap input {
        width: 100%;
        padding: 10px 14px 10px 40px;
        border-radius: 500px;
        border: none;
        background: #F6F6F6;
        font-size: 14px;
        color: #1A1A1A;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
    }

    .search-wrap input:focus { outline: none; background: #EFEFEF; }

    /* ============================================================
    HYGIENE / OFFER BADGE STRIPS
    ============================================================ */
    .hygiene-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #ECFDF5;
        border: 1px solid #BBF7D0;
        padding: 8px 14px;
        border-radius: 12px;
    }

    /* ============================================================
    EXCLUSIVE OFFER CARD
    ============================================================ */
    .exclusive-offer-card {
        background: #fff;
        border: 1px solid #F0F0EC;
        border-left: 5px solid #1A1A1A;
        border-radius: 20px;
        padding: 22px;
        margin-bottom: 28px;
        box-shadow: 0 4px 16px rgba(0,0,0,.05);
    }

    /* ============================================================
    MOBILE: bottom cart bar
    ============================================================ */
    .mobile-cart-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 12px 16px 20px;
        background: linear-gradient(transparent, #F6F6F6 30%);
        z-index: 500;
        display: none;
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 700px) {
        .cart-sidebar { display: none; }
        .mobile-cart-bar { display: block; }
        .items-column { padding: 20px 16px; }
        .res-category-bar-inner { padding: 0 16px; }
        .promo-bar { padding: 10px 16px; }
        .item-thumb-wrap { width: 96px; }
        .item-thumb-wrap img { width: 96px; height: 96px; }
        .item-thumb-placeholder { width: 96px; height: 96px; }
        .menu-item-name { font-size: 15px; }
        .menu-item-desc { font-size: 12.5px; }
    }

    @media (max-width: 560px) {
        .cat-tab { font-size: 13px; padding: 13px 14px; }
        .menu-item-name { font-size: 14px; }
    }

    /* ============================================================
    SEARCH LOADER
    ============================================================ */
    #searchLoader { display:none; font-size:12px; color:#757575; margin-top:4px; }

    /* ============================================================
    SPICE LEVEL BUTTONS (inside modal)
    ============================================================ */
    .spice-btns { display: flex; gap: 10px; }
    .spice-btn {
        flex: 1;
        padding: 10px;
        border-radius: 10px;
        border: 1.5px solid #EAEAEA;
        background: #fff;
        color: #1A1A1A;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all .15s;
    }

    .spice-btn.selected {
        background: #1A1A1A;
        color: #fff;
        border-color: #1A1A1A;
    }

    /* ============================================================
    FAVORITE MODAL (your existing logic, restyled)
    ============================================================ */
    #favoriteModal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.6);
        z-index: 50;
        display: none;
        align-items: center;
        justify-content: center;
    }

    #favoriteModal.open { display: flex; }

    .fav-modal-box {
        background: #fff;
        border-radius: 24px;
        padding: 32px;
        max-width: 420px;
        width: 95%;
    }

</style>
<style>
    /* ============================================================
   REPLACE your second <style> block content with this entire block
   ============================================================ */

    /* ── Responsive Grid ── */
    .menu-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 16px;
        margin-bottom: 8px;
        width: 100%;
    }

    @media (max-width: 1100px) {
        .menu-cards-grid {
            grid-template-columns: 1fr !important;
        }
    }

    @media (min-width: 1025px) and (max-width: 1280px) {
        .menu-cards-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px;
        }
    }

    /* ── Card: horizontal layout, image LEFT + text RIGHT ── */
    .menu-card {
        background: #fff;
        border: 1px solid #F0EDE8;
        border-radius: 18px;
        overflow: hidden;
        cursor: pointer;
        transition: box-shadow .2s, transform .18s;

        display: flex !important;
        flex-direction: row !important;   /* side-by-side */
        align-items: stretch;
        min-height: 125px;
        height: auto;
        width: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,.03);
    }

    .menu-card:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,.1);
        transform: translateY(-2px);
    }

    /* ── Left: fluid square image ── */
    .menu-card-img {
        width: 130px !important;
        min-width: 100px !important;
        max-width: 130px !important;
        flex-shrink: 0;
        overflow: hidden;
        position: relative;
    }

    .menu-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .4s ease;
    }

    .menu-card:hover .menu-card-img img {
        transform: scale(1.05);
    }

    /* ── Right: text body ── */
    .menu-card-body {
        flex: 1;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 6px;
        min-width: 0;
        overflow: hidden;
    }

    /* ── Name row ── */
    .menu-card-name-row {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        flex-wrap: wrap;
        min-width: 0;
    }

    .menu-card-name {
        font-size: 14px;
        font-weight: 700;
        color: #0D0D0D;
        letter-spacing: -.1px;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
        overflow-wrap: break-word;
        flex: 1;
        min-width: 0;
    }

    /* ── Description ── */
    .menu-card-desc {
        font-size: 12px;
        color: #6B7280;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
    }

    /* ── Tags ── */
    .menu-item-tags {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }

    .item-tag        { font-size: 10px; font-weight: 600; padding: 1px 6px; border-radius: 4px; }
    .item-tag.mild-tag  { background: #FFF8EC; color: #946C00; }
    .item-tag.spicy-tag { background: #FEF0EF; color: #A93A2C; }

    /* ── Allergy tooltip ── */
    .info-tooltip { position: relative; display: inline-block; cursor: pointer; }
    .details-link {
        font-size: 10px; color: #9CA3AF; font-weight: 600;
        border-bottom: 1px dotted #D1D5DB; line-height: 1; white-space: nowrap;
    }
    .details-link:hover { color: #374151; }
    .tooltip-content {
        position: absolute; bottom: 20px; left: 0;
        width: 200px; max-width: calc(100vw - 20px);
        background: #fff; border: 1px solid #E5E7EB; border-radius: 12px; padding: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,.15); z-index: 99999; display: none; text-align: left;
    }
    .info-tooltip:hover .tooltip-content { display: block; }
    .tooltip-content h6 { margin: 0 0 3px; font-size: 11px; font-weight: 700; color: #111827; }
    .tooltip-content p, .tooltip-content li { font-size: 11px; color: #6B7280; line-height: 1.4; margin: 0 0 3px; }

    /* ── Price + Add row ── */
    .menu-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 4px;
        gap: 8px;
        min-width: 0;
    }

    .menu-card-price {
        font-size: 14px;
        font-weight: 800;
        color: #0D0D0D;
        white-space: nowrap;
    }

    /* ── Add (+) button: orange circle ── */
    .menu-card-add-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #C25A2A;
        color: #fff;
        font-size: 20px;
        font-weight: 300;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        flex-shrink: 0;
        font-family: 'DM Sans', sans-serif;
        transition: background .2s, transform .15s;
        box-shadow: 0 3px 8px rgba(194,90,42,.35);
    }

    .menu-card-add-btn:hover {
        background: #a6481f;
        transform: scale(1.1);
    }

    /* ── Veg dot ── */
    .veg-dot-wrap {
        width: 14px; height: 14px; border-radius: 3px;
        display: grid; place-items: center; flex-shrink: 0; margin-top: 2px;
    }
    .veg-dot-wrap.veg    { border: 1.5px solid #1E7A45; }
    .veg-dot-wrap.nonveg { border: 1.5px solid #A93A2C; }
    .veg-dot-wrap.bev    { border: 1.5px solid #C25A2A; }
    .veg-dot-wrap span   { width: 7px; height: 7px; border-radius: 50%; display: block; }
    .veg-dot-wrap.veg span    { background: #1E7A45; }
    .veg-dot-wrap.nonveg span { background: #A93A2C; }
    .veg-dot-wrap.bev span    { background: #C25A2A; }

    /* ── Popular badge ── */
    .popular-badge {
        font-size: 10px; font-weight: 700;
        background: #FFF3CD; color: #946C00;
        padding: 1px 6px; border-radius: 4px; flex-shrink: 0; margin-top: 2px;
    }

    /* ── Section heading ── */
    .menu-section       { margin-bottom: 32px; }
    .menu-section-title { font-size: 20px; font-weight: 700; letter-spacing: -.3px; margin: 0 0 14px; }

    /* ── productsGrid must NOT be a grid itself ── */
    #productsGrid { display: block !important; }

    /* ── items-column must allow full width ── */
    .items-column {
        flex: 1 !important;
        min-width: 0 !important;
        padding: 24px 28px !important;
    }

    /* ── Cart Sidebar & Mobile Bar Responsive ── */
    .mobile-cart-bar { display: none !important; }
    
    @media (max-width: 1024px) {
        .cart-sidebar { display: none !important; }
        .mobile-cart-bar { display: block !important; }
        .items-column { padding: 18px 16px !important; }
    }

    /* ── Mobile layout ── */
    @media (max-width: 640px) {
        .menu-cards-grid {
            grid-template-columns: 1fr !important;
        }
        .items-column {
            padding: 14px 12px !important;
        }
        .menu-card-img {
            width: 105px !important;
            min-width: 95px !important;
            max-width: 110px !important;
        }
        .menu-card-body {
            padding: 10px 12px;
        }
        .menu-card-name {
            font-size: 13.5px;
        }
    }
</style>

{{-- Google Font --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

@php
    $isAdmin = auth()->check() &&
        in_array(auth()->user()->role, ['super_admin', 'restaurant_admin']);
    $activeCat = request()->segment(3);
@endphp

{{-- ── BOTTOM BAR (existing) ── --}}
{{-- <div>
    @include('front.layouts.bottombars')
</div> --}}


<section style="position:relative; height:240px; overflow:hidden; flex-shrink:0;">

    @if($restaurant->banners->count())
        <div class="hero-slider">
            @foreach($restaurant->banners as $banner)
                <div class="hero-slide">
                    <img src="{{ asset($banner->image) }}" alt="{{ $restaurant->name }}">
                    <div style="position:absolute; "></div>
                </div>
            @endforeach
        </div>
    @elseif($restaurant->image)
        <img src="{{ asset('storage/' . $restaurant->image) }}"
             style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; ">
        <div style="position:absolute; "></div>
    @else
        <div style="position:absolute; inset:0;"></div>
    @endif

    {{-- Hero content --}}
    <div style="position:absolute; bottom:0; left:0; right:0; padding:24px 32px; display:flex; align-items:flex-end; justify-content:space-between; z-index:1;">
        <div style="display:flex; flex-direction:column; gap:6px;">
            <h1 style="margin:0; font-size:32px; font-weight:700; color:#fff; letter-spacing:-.5px;">
                {{ $restaurant->name }}
            </h1>
            <div style="display:flex; align-items:center; gap:14px; font-size:14px; color:rgba(255,255,255,.85); font-weight:500; flex-wrap:wrap;">
                <span style="display:flex; align-items:center; gap:5px;">
                    <span style="color:#06C167; font-weight:700;">★ {{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}</span>
                    ({{ $restaurant->reviews->count() }}+)
                </span>
                <span>·</span>
                <span>{{ $restaurant->cuisine ?? 'Restaurant' }}</span>
                <span>·</span>
                <span>{{ $restaurant->delivery_time ?? '25–35 min' }}</span>
                <span>·</span>
                {{-- <span>£{{ number_format($restaurant->delivery_fee ?? 1.99, 2) }} delivery</span> --}}
                @if($restaurant->location)
                    <span>·</span>
                    <span>📍 {{ $restaurant->location }}</span>
                @endif
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:12px;">
            @if($restaurant->hygiene_rating)
                <div style="background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.25); backdrop-filter:blur(12px); border-radius:12px; padding:10px 16px; text-align:center; color:#fff; flex-shrink:0;">
                    <div style="font-size:11px; letter-spacing:.1em; text-transform:uppercase; opacity:.7; font-weight:600;">Hygiene</div>
                    <div style="font-size:18px; font-weight:700;">{{ $restaurant->hygiene_rating }} / 5</div>
                </div>
            @endif

            @auth
                <button onclick="saveFavorite()" id="favoriteToggleBtn"
                    style="display:flex; align-items:center; gap:8px; background:rgba(255,255,255,.12); border:1.5px solid rgba(255,255,255,.25); color:#fff; padding:10px 18px; border-radius:14px; font-family:'DM Sans',sans-serif; font-weight:600; font-size:13px; cursor:pointer;">
                    <span id="favoriteToggleIcon">{{ (auth()->check() && \App\Models\RestaurantFavorite::where('restaurant_id', $restaurant->id)->where('user_id', auth()->id())->exists()) ? '★' : '☆' }}</span>
                    <span id="favoriteToggleLabel">{{ (auth()->check() && \App\Models\RestaurantFavorite::where('restaurant_id', $restaurant->id)->where('user_id', auth()->id())->exists()) ? 'Saved' : 'Save' }}</span>
                </button>
            @endauth
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slides = document.querySelectorAll(".hero-slide");
            if (slides.length <= 1) {
                if (slides.length === 1) slides[0].classList.add("active");
                return;
            }
            let current = 0;
            slides[current].classList.add("active");
            setInterval(function () {
                slides[current].classList.remove("active");
                current = (current + 1) % slides.length;
                slides[current].classList.add("active");
            }, 4000);
        });
    </script>
</section>

@if($restaurant->coupons->count())

<div style="padding:24px 32px;background:#fff;border-bottom:1px solid #eee;">

    <h3 style="
        font-size:22px;
        font-weight:700;
        margin-bottom:18px;
    ">
        🎉 Available Offers
    </h3>

    <div style="
        display:flex;
        gap:16px;
        overflow-x:auto;
        padding-bottom:6px;
    ">

        @foreach($restaurant->coupons as $coupon)

            <div style="
                min-width:320px;
                border:2px dashed #C25A2A;
                border-radius:18px;
                background:#FFF8F4;
                padding:18px;
                flex-shrink:0;
            ">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:12px;
                ">

                    <span style="
                        background:#C25A2A;
                        color:white;
                        padding:6px 12px;
                        border-radius:999px;
                        font-size:12px;
                        font-weight:700;
                    ">
                        {{ strtoupper($coupon->code) }}
                    </span>

                    <button
                        type="button"
                        class="copy-coupon-btn"
                        onclick="copyCoupon(this,'{{ $coupon->code }}')"
                        style="
                            border:none;
                            background:#111;
                            color:white;
                            padding:6px 14px;
                            border-radius:10px;
                            cursor:pointer;
                            min-width:80px;
                            transition:.3s;
                        ">
                        Copy
                    </button>

                </div>

                <h4 style="
                    font-size:18px;
                    font-weight:700;
                    margin-bottom:6px;
                ">

                    @if($coupon->type=='percentage')

                        {{ $coupon->value }}% OFF

                    @else

                        £{{ number_format($coupon->value,2) }} OFF

                    @endif

                </h4>

                <p style="
                    color:#666;
                    font-size:14px;
                    margin-bottom:10px;
                ">
                    Minimum order £{{ number_format($coupon->min_order_amount,2) }}
                </p>

                @if($coupon->expires_at)

                    <div style="
                        font-size:12px;
                        color:#888;
                    ">
                        Valid until
                        {{ $coupon->expires_at->format('d M Y') }}
                    </div>

                @endif

            </div>

        @endforeach

    </div>

</div>

<script>
function copyCoupon(button, code) {

    navigator.clipboard.writeText(code).then(() => {

        const originalText = button.innerHTML;

        button.innerHTML = "✓ Copied";
        button.style.background = "#16A34A";

        setTimeout(() => {
            button.innerHTML = originalText;
            button.style.background = "#111";
        }, 2000);

    });

}
</script>

@endif

{{-- ════════════════════════════════════════════
     PROMO BANNER
     ════════════════════════════════════════════ --}}
@if($eligibleOffer ?? false)
    <div class="promo-bar">
        <span style="background:#06C167; color:#fff; padding:2px 10px; border-radius:4px; font-size:12px; font-weight:700; flex-shrink:0;">OFFER</span>
        <span>{{ $eligibleOffer->title }}
            @if($eligibleOffer->value_type === 'percentage')
                — {{ rtrim(rtrim($eligibleOffer->value,'0'),'.') }}% OFF
            @else
                — £{{ rtrim(rtrim($eligibleOffer->value,'0'),'.') }} OFF
            @endif
            · min order £{{ number_format($eligibleOffer->min_order_value, 2) }} · valid until {{ \Carbon\Carbon::parse($eligibleOffer->end_date)->format('d M Y') }}
        </span>
    </div>
@endif

{{-- ════════════════════════════════════════════
     CATEGORY CHIPS
     ════════════════════════════════════════════ --}}
<div class="res-category-bar">
    <div class="res-category-bar-inner">
        <a href="{{ url('/restaurant/' . $restaurant->slug) }}"
           class="cat-tab {{ !$activeCat ? 'active' : '' }}"
           data-slug=""
           data-name="All Items">All</a>

        @foreach($categories as $cat)
            <a href="{{ url('/restaurant/' . $restaurant->slug . '/' . $cat->slug) }}"
               class="cat-tab {{ $activeCat === $cat->slug ? 'active' : '' }}"
               data-slug="{{ $cat->slug }}"
               data-name="{{ $cat->name }}">{{ $cat->name }}</a>
        @endforeach
    </div>
</div>

{{-- ════════════════════════════════════════════
     MAIN CONTENT AREA
     ════════════════════════════════════════════ --}}
<div style="display:flex; align-items:flex-start; background:#fff; min-height:600px; width:100%; position:relative;">

    {{-- ── ITEMS COLUMN ── --}}
    <div class="items-column" id="itemsColumn">

        {{-- Search bar (inline, above items) --}}
        <div style="margin-bottom:20px; display:flex; gap:10px; align-items:center;">
            <div class="search-wrap" style="max-width:100%;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#999" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" id="liveSearchInput2" value="{{ request('search') }}"
                       placeholder="Search dishes…" autocomplete="off"
                       style="max-width:400px;">
            </div>
            <button id="clearSearchBtn" class="btn-black"
                    style="display:{{ request()->filled('search') ? 'inline-flex' : 'none' }}; padding:9px 16px;">
                Clear
            </button>
            <span id="productCount" style="background:#F0F0EC; padding:6px 16px; border-radius:999px; font-size:13px; font-weight:600; color:#6B7280; white-space:nowrap;">
                {{ $products->count() }} {{ Str::plural('item', $products->count()) }}
            </span>
        </div>

        <div id="searchLoader">Searching…</div>

        {{-- 
                DROP-IN REPLACEMENT for the #productsGrid div in restaurant-productsnew.blade.php
                Fix: wraps items in .menu-cards-grid so 2-column layout works
            --}}
            <div id="productsGrid">

                @foreach($categories as $category)
                    @php
                        $catProducts = $products->where('category_id', $category->id);
                    @endphp
                    @if($catProducts->count())
                        <div class="menu-section" data-section="{{ $category->id }}">
                            <h2 class="menu-section-title">{{ $category->name }}</h2>

                            {{-- ✅ THIS IS THE KEY FIX: wrap items in the 2-col grid --}}
                            <div class="menu-cards-grid">
                                @foreach($catProducts as $product)
                                    @include('front.partials.restaurant-menu-item', [
                                        'product'  => $product,
                                        'isAdmin'  => $isAdmin,
                                    ])
                                @endforeach
                            </div>

                        </div>
                    @endif
                @endforeach

                @if($products->isEmpty())
                    <div style="text-align:center; padding:64px 24px; color:#999; font-size:15px;">
                        No dishes match — try clearing your search or filter.
                    </div>
                @endif

            </div>

    </div>

    {{-- ── CART SIDEBAR ── --}}
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>Your order</h3>
            {{-- <p>{{ $restaurant->name }}</p> --}}
             <p id="cartRestaurantName">{{ $restaurant->name }}</p>
        </div>

        {{-- Empty state --}}
        <div class="cart-empty-state" id="cartEmptyState">
            <div class="cart-empty-icon">
                <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#CCC" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
            </div>
            <div style="font-size:15px; font-weight:600; color:#1A1A1A;">No items yet</div>
            <div style="font-size:13px; color:#999;">Add dishes from the menu to start your order.</div>
        </div>

        {{-- Cart items (shown when cart has items) --}}
        <div id="cartItemsContainer" style="display:none; flex:1; overflow-y:auto; flex-direction:column;">
            <div class="cart-items-list" id="cartItemsList"></div>
            <div class="cart-footer">
                <div class="cart-footer-row">
                    <span>Subtotal</span>
                    <span id="cartSubtotal">£0.00</span>
                </div>
                {{-- <div class="cart-footer-row">
                    <span>Delivery</span>
                    <span>£{{ number_format($restaurant->delivery_fee ?? 0) }}</span>
                </div> --}}
                <a href="{{ route('cart.index') }}" class="btn-checkout">
                    <span>Go to checkout</span>
                    <span id="cartTotal">£0.00</span>
                </a>
            </div>
        </div>
    </div>

</div>

{{-- ════════════════════════════════════════════
     MOBILE CART BAR
     ════════════════════════════════════════════ --}}
<div class="mobile-cart-bar" id="mobileCartBar" style="display:none;">
    <a href="{{ route('cart.index') }}" style="font-family:'DM Sans',sans-serif; width:100%; padding:16px 20px; border:none; background:#000; color:#fff; border-radius:14px; font-size:15px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:space-between; text-decoration:none;">
        <span id="mobileCartCountBadge" style="background:#fff; color:#000; width:26px; height:26px; border-radius:6px; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:800;">0</span>
        <span>View cart</span>
        <span id="mobileCartTotalBadge">£0.00</span>
    </a>
</div>

{{-- ════════════════════════════════════════════
     ITEM DETAIL MODAL
     ════════════════════════════════════════════ --}}
<div class="item-modal-overlay" id="itemDetailModal" style="display:none;" onclick="closeItemModal(event)">
    <div class="item-modal-box" onclick="event.stopPropagation()">
        <div class="item-modal-img-wrap">
            <div class="item-modal-img-placeholder" id="modalImgWrap">
                <img id="modalImg" src="" alt="" style="display:none; width:100%; height:100%; object-fit:cover;">
                <span id="modalImgPlaceholder" style="color:#999; font-size:14px;">No photo</span>
            </div>
            <button class="item-modal-close" onclick="document.getElementById('itemDetailModal').style.display='none'">✕</button>
        </div>

        <div class="item-modal-body">
            <div style="display:flex; align-items:flex-start; gap:10px; justify-content:space-between;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                        <span class="veg-dot-wrap" id="modalVegWrap">
                            <span></span>
                        </span>
                        <h2 style="margin:0; font-size:22px; font-weight:700; letter-spacing:-.3px;" id="modalName"></h2>
                    </div>
                    <div style="font-size:16px; font-weight:700; margin-bottom:6px;" id="modalPrice"></div>

                    {{-- 1. Alergic --}}
                    <div id="modalAllergySection" style="font-size:13px; color:#555; margin-bottom:6px; line-height:1.4;">
                        <strong style="color:#222; font-weight:600;">Alergic:</strong>
                        <span id="modalAllergy" style="color:#666; margin-left:4px;"></span>
                    </div>

                    {{-- 2. Diatry --}}
                    <div id="modalDietarySection" style="font-size:13px; color:#555; margin-bottom:8px; line-height:1.4;">
                        <strong style="color:#222; font-weight:600;">Diatry:</strong>
                        <span id="modalDietary" style="color:#666; margin-left:4px;"></span>
                    </div>

                    {{-- 3. Description --}}
                    <div style="font-size:14px; color:#757575; line-height:1.55;" id="modalDesc"></div>
                </div>
                <div style="font-size:13px; font-weight:600; color:#06C167; flex-shrink:0;" id="modalRating"></div>
            </div>

            
        </div>

        <div class="item-modal-footer">
            <div class="modal-qty-stepper">
                <button onclick="modalQtyChange(-1)">−</button>
                <span class="qty-val" id="modalQty">1</span>
                <button onclick="modalQtyChange(1)">+</button>
            </div>
            <button class="btn-add-to-order" id="modalAddBtn" onclick="modalAddToCart()">
                <span id="modalAddLabel">Add to order</span>
                <span id="modalAddPrice">£0.00</span>
            </button>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════
     VARIANT / ADDON MODAL (your existing logic)
     ════════════════════════════════════════════ --}}
<div id="variantModal">
    <div class="variant-modal-box">
        <h3>Customise your order</h3>
        <div id="variantOptions"></div>
        <div class="variant-modal-actions">
            <button onclick="closeVariantModal()" class="btn-black" style="flex:1;">Cancel</button>
            <button onclick="confirmVariant()" class="btn-primary" style="flex:1;">Add to cart</button>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════
     CART REPLACE MODAL
     ════════════════════════════════════════════ --}}
<div id="cartReplaceModal">
    <div style="background:#fff; width:420px; max-width:95%; border-radius:20px; padding:25px;">
        <h3 style="margin:0 0 10px; font-size:22px; font-weight:700;">Replace Cart?</h3>
        <p id="cartReplaceText" style="color:#666; line-height:1.6; margin-bottom:25px;">
            Your cart contains items from another restaurant.
        </p>
        <div style="display:flex; gap:12px;">
            <button type="button" onclick="closeCartReplaceModal()" class="btn-black" style="flex:1;">Cancel</button>
            <button type="button" id="confirmReplaceCart" class="btn-primary" style="flex:1;">Replace Cart</button>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════
     FAVOURITE MODAL
     ════════════════════════════════════════════ --}}
<div id="favoriteModal">
    <div class="fav-modal-box">
        <h2 style="font-size:22px; font-weight:800; margin-bottom:10px; color:#0D0D0D;">⭐ Save to Favourites</h2>
        <p style="color:#6B7280; margin-bottom:24px; font-size:14px;">Add this restaurant to your favourites?</p>
        <div style="display:flex; gap:12px;">
            <button onclick="saveFavorite()" class="btn-primary" style="flex:1;">Yes, save it</button>
            <button onclick="closeFavoritePopup()" class="btn-black" style="flex:1;">No thanks</button>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════
     AR MODAL (your existing)
     ════════════════════════════════════════════ --}}
<div id="arModal" style="display:none; position:fixed; inset:0; background:#000; z-index:999999;">
    <span onclick="closeAR()"
        style="position:fixed; top:15px; left:15px; z-index:99999; background:#fff; color:rgba(0,0,0,0.7); width:42px; height:42px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:20px;">✖</span>
    <video id="camera" autoplay playsinline style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"></video>
    <div style="position:relative; z-index:10; width:100%; height:100%; display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <div style="width:min(80vw,350px); height:min(80vw,350px); perspective:1000px;">
            <div id="pizza" style="width:100%; height:100%; background-size:contain; background-repeat:no-repeat; background-position:center; transform-style:preserve-3d; transition:transform .2s ease; cursor:grab;"></div>
        </div>
        <p style="color:#fff; margin-top:15px; font-size:14px; background:rgba(0,0,0,0.6); padding:8px 14px; border-radius:30px;">Drag to rotate</p>
    </div>
</div>

{{-- ════════════════════════════════════════════
     JAVASCRIPT
     ════════════════════════════════════════════ --}}
<script>
/* ─────────────────────────────────────────
   GLOBALS
───────────────────────────────────────── */
window.restaurantId = @json($restaurant->id);
window.restaurantSlug = @json($restaurant->slug);
window.deliveryFee = {{ $restaurant->delivery_fee ?? 1.99 }};
window.isFavorite = @json(
    auth()->check()
        ? \App\Models\RestaurantFavorite::where('restaurant_id', $restaurant->id)
              ->where('user_id', auth()->id())->exists()
        : false
);

/* =====================================================
   COMPLETE JS — replace the entire <script> block
   in restaurant-productsnew.blade.php
   ===================================================== */

/* ── GLOBALS (set by Blade above this script) ──
   window.restaurantId, window.restaurantSlug,
   window.deliveryFee, window.isFavorite
*/

/* ── STATE ── */
let isVegOnly       = false;
let currentUrl      = window._currentUrl  || location.href;
let currentSlug     = window._currentSlug || '';
let activeForm      = null;
let pendingCartForm = null;
let selectedSpice   = 'Medium';
let modalCurrentProductId    = null;
let modalCurrentProductPrice = 0;
let modalCurrentQty          = 1;
let variantQty = 1;
window.selectedAddons = [];



/* ══════════════════════════════════════════
   VEG FILTER
══════════════════════════════════════════ */
function toggleVeg() {
    isVegOnly = !isVegOnly;
    const btn = document.getElementById('vegToggle');
    if (btn) btn.classList.toggle('active', isVegOnly);
    filterProductsLocally();
}

function filterProductsLocally() {
    document.querySelectorAll('.menu-card').forEach(card => {
        const veg = card.dataset.veg === '1';
        card.style.display = (isVegOnly && !veg) ? 'none' : '';
    });
    document.querySelectorAll('.menu-section').forEach(sec => {
        const visible = [...sec.querySelectorAll('.menu-card')]
            .some(c => c.style.display !== 'none');
        sec.style.display = visible ? '' : 'none';
    });
}

/* ══════════════════════════════════════════
   CATEGORY TABS
══════════════════════════════════════════ */
function setActiveTab(slug) {
    document.querySelectorAll('.cat-tab').forEach(t =>
        t.classList.toggle('active', t.dataset.slug === slug));
    if (slug) {
        const bar = document.querySelector('.res-category-bar-inner');
        const all = bar?.querySelector('.cat-tab[data-slug=""]');
        const sel = bar?.querySelector(`.cat-tab[data-slug="${slug}"]`);
        if (all && sel && all.nextElementSibling !== sel)
            all.insertAdjacentElement('afterend', sel);
    }
}

/* ══════════════════════════════════════════
   AJAX: FETCH PRODUCTS
══════════════════════════════════════════ */
let searchDebounce;

function fetchProducts(baseUrl, search, slug, catName) {
    const loader = document.getElementById('searchLoader');
    if (loader) loader.style.display = 'block';

    const url = new URL(baseUrl, window.location.origin);
    search ? url.searchParams.set('search', search)
           : url.searchParams.delete('search');

    fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            document.getElementById('productsGrid').innerHTML = data.html;
            const countEl = document.getElementById('productCount');
            if (countEl) countEl.textContent =
                data.count + (data.count === 1 ? ' item' : ' items');
            currentUrl  = baseUrl;
            currentSlug = slug;
            setActiveTab(slug);
            window.history.pushState({}, '', url.toString());
            bindAddCartForms();
            if (isVegOnly) filterProductsLocally();
        })
        .catch(console.error)
        .finally(() => { if (loader) loader.style.display = 'none'; });
}

/* Category tab clicks */
document.querySelectorAll('.cat-tab').forEach(tab => {
    tab.addEventListener('click', function (e) {
        e.preventDefault();
        const search = document.getElementById('liveSearchInput2')?.value || '';
        fetchProducts(
            this.getAttribute('href'),
            search,
            this.dataset.slug,
            this.dataset.name || 'All Items'
        );
        this.scrollIntoView({ behavior: 'smooth', inline: 'nearest', block: 'nearest' });
    });
});

/* Live search */
const _searchInput = document.getElementById('liveSearchInput2');
const _clearBtn    = document.getElementById('clearSearchBtn');

_searchInput?.addEventListener('input', function () {
    if (_clearBtn) _clearBtn.style.display = this.value ? 'inline-flex' : 'none';
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() =>
        fetchProducts(currentUrl, this.value, currentSlug), 400);
});

_clearBtn?.addEventListener('click', function () {
    if (_searchInput) _searchInput.value = '';
    this.style.display = 'none';
    fetchProducts(currentUrl, '', currentSlug);
});

/* ══════════════════════════════════════════
   ITEM DETAIL MODAL
══════════════════════════════════════════ */
function openItemModal(productId, name, price, desc, imgUrl, isVeg, hasCustom, rating, arImg, allergies, dietaries) {
    modalCurrentProductId    = productId;
    modalCurrentProductPrice = parseFloat(price) || 0;
    modalCurrentQty          = 1;

    if (typeof allergies === 'string') {
        try { allergies = JSON.parse(allergies); } catch (e) { allergies = allergies ? [allergies] : []; }
    }
    if (!Array.isArray(allergies)) allergies = [];

    if (typeof dietaries === 'string') {
        try { dietaries = JSON.parse(dietaries); } catch (e) { dietaries = dietaries ? [dietaries] : []; }
    }
    if (!Array.isArray(dietaries)) dietaries = [];

    const setElText = (id, txt) => {
        const el = document.getElementById(id);
        if (el) el.textContent = txt;
    };

    setElText('modalName', name || '');
    setElText('modalPrice', '£' + (parseFloat(price) || 0).toFixed(2));

    // 1. Alergic
    const allergyEl = document.getElementById('modalAllergy');
    if (allergyEl) {
        allergyEl.textContent = allergies.length > 0 ? allergies.join(', ') : 'May contain common allergens';
    }

    // 2. Diatry
    const dietaryEl = document.getElementById('modalDietary');
    if (dietaryEl) {
        dietaryEl.textContent = dietaries.length > 0 ? dietaries.join(', ') : (isVeg ? 'Vegetarian' : 'Non-Vegetarian');
    }

    // 3. Description
    setElText('modalDesc', desc || '');
    setElText('modalRating', rating ? '★ ' + rating : '');
    setElText('modalQty', 1);
    setElText('modalAddLabel', 'Add to order');
    setElText('modalAddPrice', '£' + (parseFloat(price) || 0).toFixed(2));

    const vegWrap = document.getElementById('modalVegWrap');
    if (vegWrap) {
        vegWrap.className = 'veg-dot-wrap ' + (isVeg ? 'veg' : 'nonveg');
        vegWrap.innerHTML = '<span></span>';
    }

    const img = document.getElementById('modalImg');
    const ph  = document.getElementById('modalImgPlaceholder');
    if (img) {
        if (imgUrl) {
            img.src = imgUrl;
            img.style.display = 'block';
            if (ph) ph.style.display = 'none';
        } else {
            img.style.display = 'none';
            if (ph) ph.style.display = 'block';
        }
    }

    const spiceSec = document.getElementById('modalSpiceSection');
    if (spiceSec) {
        spiceSec.style.display = hasCustom ? 'block' : 'none';
    }

    document.querySelectorAll('.spice-btn').forEach(b =>
        b.classList.toggle('selected', b.textContent === 'Medium'));
    selectedSpice = 'Medium';

    const modal = document.getElementById('itemDetailModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeItemModal(e) {
    if (!e || e.target === document.getElementById('itemDetailModal'))
        document.getElementById('itemDetailModal').style.display = 'none';
}

function modalQtyChange(d) {
    modalCurrentQty = Math.max(1, modalCurrentQty + d);
    document.getElementById('modalQty').textContent      = modalCurrentQty;
    document.getElementById('modalAddPrice').textContent =
        '£' + (modalCurrentProductPrice * modalCurrentQty).toFixed(2);
}

function selectSpice(btn, level) {
    selectedSpice = level;
    document.querySelectorAll('.spice-btn')
        .forEach(b => b.classList.toggle('selected', b === btn));
}

function modalAddToCart() {
    if (!modalCurrentProductId) return;
    const form = document.querySelector(
        `.addCartForm[data-product-id="${modalCurrentProductId}"]`);
    if (form) {
        const qi = form.querySelector('[name="quantity"]');
        if (qi) qi.value = modalCurrentQty;
        
        // If has variants/addons, open that modal instead
        const variants = JSON.parse(form.dataset.variants || '[]');
        const addons   = JSON.parse(form.dataset.addons   || '[]');
        if (variants.length || addons.length) {
            activeForm = form;
            buildVariantAddonModal(form);
        } else {
            
            submitCart(form);
        }
    }
    document.getElementById('itemDetailModal').style.display = 'none';
}

/* ══════════════════════════════════════════
   VARIANT / ADDON MODAL
══════════════════════════════════════════ */
function buildVariantAddonModal(form) {
    const variants = JSON.parse(form.dataset.variants || '[]');
    const addons   = JSON.parse(form.dataset.addons   || '[]');
    let html = '';

    /* Variants */
    if (variants.length) {
        html += `<div style="margin-bottom:20px;">
            <h3 style="margin-bottom:10px;font-size:16px;font-weight:bold;">Select Variant</h3>
            <select id="variantSelect" style="width:100%;padding:14px 16px;border:2px solid #E5E7EB;border-radius:12px;font-size:14px;outline:none;background:#fff;cursor:pointer;">`;
        variants.forEach((v, i) => {
            const isRegular = (v.name || '').toLowerCase() === 'regular';
            const firstFallback = !variants.some(x => (x.name || '').toLowerCase() === 'regular') && i === 0;
            const sel = (isRegular || firstFallback) ? 'selected' : '';
            html += `<option value="${v.id}" ${sel}>${v.name} — £${parseFloat(v.price).toFixed(2)}</option>`;
        });
        html += `</select></div>`;
    }

    /* Addons */
    if (addons.length) {
        /* addons may have category_name or addon_category.name */
        const grouped = {};
        addons.forEach(a => {
            const cat = a.category_name
                || a.addon_category?.name
                || (a.addon_category ? a.addon_category : null)
                || 'Extras';
            (grouped[cat] = grouped[cat] || []).push(a);
        });

        Object.entries(grouped).forEach(([cat, items]) => {
            html += `<h3 style="margin-top:20px;margin-bottom:10px;font-size:16px;font-weight:bold;">${cat}</h3>
                     <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">`;
            items.forEach(a => {
                const addonName  = a.addon_name || a.name || '';
                const addonPrice = parseFloat(a.price || 0).toFixed(2);
                html += `<div class="addon-card" data-id="${a.id}" data-name="${addonName}" data-price="${addonPrice}"
                              style="border:2px solid #E5E7EB;border-radius:12px;padding:12px;cursor:pointer;transition:.2s;">
                              <div style="font-weight:600;font-size:13px;">${addonName}</div>
                              <div style="margin-top:6px;color:#777;font-size:12px;">+£${addonPrice}</div>
                          </div>`;
            });
            html += `</div>`;
        });
    }

    /* Quantity */
    variantQty = 1;

    html += `
    <div style="margin-top:25px;">
        <h3 style="margin-bottom:10px;font-size:16px;font-weight:bold;">
            Quantity
        </h3>

        <div style="
            display:flex;
            align-items:center;
            width:130px;
            border:2px solid #E5E7EB;
            border-radius:999px;
            overflow:hidden;
        ">
            <button
                type="button"
                onclick="changeVariantQty(-1)"
                style="
                    width:40px;
                    height:40px;
                    border:none;
                    background:#fff;
                    cursor:pointer;
                    font-size:20px;
                    font-weight:bold;
                ">−</button>

            <span
                id="variantQty"
                style="
                    flex:1;
                    text-align:center;
                    font-size:16px;
                    font-weight:700;
                ">1</span>

            <button
                type="button"
                onclick="changeVariantQty(1)"
                style="
                    width:40px;
                    height:40px;
                    border:none;
                    background:#fff;
                    cursor:pointer;
                    font-size:20px;
                    font-weight:bold;
                ">+</button>
        </div>
    </div>
    `;

    document.getElementById('variantOptions').innerHTML = html;
    window.selectedAddons = [];

    document.querySelectorAll('.addon-card').forEach(card => {
        card.onclick = function () {
            const id  = this.dataset.id;
            const idx = window.selectedAddons.findIndex(a => a.id === id);
            if (idx > -1) {
                window.selectedAddons.splice(idx, 1);
                this.style.borderColor = '#E5E7EB';
                this.style.background  = '#fff';
            } else {
                window.selectedAddons.push({
                    id,
                    name:  this.dataset.name,
                    price: this.dataset.price
                });
                this.style.borderColor = '#C25A2A';
                this.style.background  = '#FFF5F0';
            }
        };
    });

    document.getElementById('variantModal').classList.add('open');
}


function changeVariantQty(change) {

    variantQty += change;

    if (variantQty < 1) {
        variantQty = 1;
    }

    document.getElementById('variantQty').textContent = variantQty;
}
function closeVariantModal() {
    document.getElementById('variantModal').classList.remove('open');
}

function confirmVariant() {
    activeForm?.querySelectorAll('.addonInput').forEach(e => e.remove());

    /* Set variant */
    const vs = document.getElementById('variantSelect');
    if (vs?.value) {
        const vi = activeForm.querySelector('.variantId');
        if (vi) vi.value = vs.value;
    }

    /* Append addon hidden inputs */
    (window.selectedAddons || []).forEach(a => {
        const inp = document.createElement('input');
        inp.type = 'hidden';
        inp.name = 'addons[]';
        inp.value = a.id;
        inp.className = 'addonInput';
        activeForm.appendChild(inp);
    });

    const qtyInput = activeForm.querySelector('[name="quantity"]');

    if (qtyInput) {
        qtyInput.value = variantQty;
    }

    closeVariantModal();
    submitCart(activeForm);
}

/* ══════════════════════════════════════════
   CART: SUBMIT
══════════════════════════════════════════ */
async function submitCart(form) {
    try {
        if (typeof window.showGlobalLoader === 'function') {
            window.showGlobalLoader('Adding to Cart...', 'Please wait', 3500);
        }
        const res  = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(form)
        });
        const data = await res.json();

        if (typeof window.hideGlobalLoader === 'function') {
            window.hideGlobalLoader();
        }

        if (data.different_restaurant) {
            showCartReplaceModal(data.message, form);
            return;
        }
        if (data.success) {
            closeVariantModal();
            updateCounts(data.count);
            refreshCartSidebar();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Item added to cart',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    } catch (e) {
        console.error(e);
        if (typeof window.hideGlobalLoader === 'function') {
            window.hideGlobalLoader();
        }
    }
}

/* ══════════════════════════════════════════
   CART SIDEBAR
══════════════════════════════════════════ */
function updateCounts(count) {
    const num = parseInt(count, 10) || 0;
    document.querySelectorAll('#cartCount, #mobileCartCount, #mobileToggleCartCount, #bottomBarCartCount, .cart-count-badge, .cart-count').forEach(el => {
        el.textContent = num;
        if (num > 0) {
            el.style.display = (el.id === 'mobileToggleCartCount' || el.style.position === 'absolute') ? 'flex' : 'inline-flex';
        } else {
            el.style.display = 'none';
        }
    });
    const badge = document.getElementById('mobileCartCountBadge');
    if (badge) badge.textContent = num;
    const bar = document.getElementById('mobileCartBar');
    if (bar) bar.style.display = num > 0 ? 'block' : 'none';
}

async function refreshCartSidebar() {
    try {
        const res = await fetch('/cart/summary', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) return;
        renderCartSidebar(await res.json());
    } catch (e) {}
}

function renderCartSidebar(data) {
    const empty = document.getElementById('cartEmptyState');
    const cont = document.getElementById('cartItemsContainer');
    const list = document.getElementById('cartItemsList');



    if (!data.items || data.items.length === 0) {
        empty.style.display = 'flex';
        cont.style.display = 'none';
        return;
    }

    const restaurantName = document.getElementById('cartRestaurantName');

    if (restaurantName) {
        restaurantName.textContent = data.restaurant_name ?? '';
    }

    empty.style.display = 'none';
    cont.style.display = 'flex';

    list.innerHTML = data.items.map(item => {

        let addonsHtml = '';

        if (item.addons && item.addons.length) {

            const grouped = {};

            item.addons.forEach(addon => {

                if (!grouped[addon.category_name]) {
                    grouped[addon.category_name] = [];
                }

                grouped[addon.category_name].push(addon);

            });

            addonsHtml = Object.keys(grouped).map(category => `

                <div style="margin-top:8px;">

                    <div style="
                        font-size:12px;
                        font-weight:700;
                        color:#333;
                        margin-bottom:5px;
                    ">
                        ${category}
                    </div>

                    ${grouped[category].map(addon => `

                        <div style="
                            display:flex;
                            align-items:center;
                            justify-content:space-between;
                            background:#F8F8F8;
                            border:1px solid #ECECEC;
                            border-radius:20px;
                            padding:5px 10px;
                            margin-bottom:5px;
                        ">

                            <span style="font-size:12px;">
                                ${addon.name}
                            </span>

                            <span style="
                                color:#C25A2A;
                                font-size:12px;
                                font-weight:600;
                            ">
                                +£${parseFloat(addon.price).toFixed(2)}
                            </span>

                        </div>

                    `).join('')}

                </div>

            `).join('');

        }

        return `

        <div class="cart-row">

            <div class="cart-row-name">

                <div style="
                    font-weight:600;
                    font-size:15px;
                    margin-bottom:2px;
                ">
                    ${item.name}
                </div>

                ${item.variant_name
                    ? `<div style="font-size:12px;color:#777;">${item.variant_name}</div>`
                    : ''
                }

                ${addonsHtml}

                <div class="cart-row-stepper" style="margin-top:10px;">

                    <button onclick="cartAdjust('${item.cart_key}',-1)">−</button>

                    <span class="qty-val">
                        ${item.qty}
                    </span>

                    <button onclick="cartAdjust('${item.cart_key}',1)">+</button>

                </div>

            </div>

            <div style="text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:8px;">

                <div style="
                    font-size:16px;
                    font-weight:700;
                    color:#C25A2A;
                ">
                    £${parseFloat(item.line_total).toFixed(2)}
                </div>

                <div style="
                    font-size:12px;
                    color:#888;
                ">
                    £${parseFloat(item.price).toFixed(2)} each
                </div>

                <button
                    onclick="removeCartItem('${item.cart_key}')"
                    style="
                        display:flex;
                        align-items:center;
                        gap:4px;
                        background:none;
                        border:none;
                        color:#d32f2f;
                        font-size:13px;
                        cursor:pointer;
                        padding:0;
                    "
                >
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                    Remove
                </button>

            </div>

        </div>

        `;

    }).join('');

    const subtotal = parseFloat(data.subtotal || 0);

    const total = subtotal;

    document.getElementById('cartSubtotal').innerHTML =
        '£' + subtotal.toFixed(2);

    document.getElementById('cartTotal').innerHTML =
        '£' + total.toFixed(2);

    const mobile = document.getElementById('mobileCartTotalBadge');

    if (mobile) {
        mobile.innerHTML = '£' + total.toFixed(2);
    }
}

async function cartAdjust(cartKey, delta) {
    if (typeof window.showGlobalLoader === 'function') {
        window.showGlobalLoader('Updating Cart...', 'Please wait', 2000);
    }
    try {
        await fetch(`/cart/${delta > 0 ? 'increase' : 'decrease'}/${cartKey}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const d = await fetch('/cart-count').then(r => r.json());
        updateCounts(d.count);
        await refreshCartSidebar();
    } catch(e) {}
    if (typeof window.hideGlobalLoader === 'function') {
        window.hideGlobalLoader();
    }
}

async function removeCartItem(cartKey) {
    if (!confirm('Remove this item from cart?')) {
        return;
    }
    if (typeof window.showGlobalLoader === 'function') {
        window.showGlobalLoader('Removing Item...', 'Please wait', 2000);
    }
    try {
        await fetch(`/cart/remove/${cartKey}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        await refreshCartSidebar();
    } catch(e) {}
    if (typeof window.hideGlobalLoader === 'function') {
        window.hideGlobalLoader();
    }
}

/* ══════════════════════════════════════════
   CART REPLACE MODAL
══════════════════════════════════════════ */
function showCartReplaceModal(message, form) {
    pendingCartForm = form;
    document.getElementById('cartReplaceText').textContent = message;
    document.getElementById('cartReplaceModal').classList.add('open');
}

function closeCartReplaceModal() {
    document.getElementById('cartReplaceModal').classList.remove('open');
}

document.getElementById('confirmReplaceCart')?.addEventListener('click', async function () {
    closeCartReplaceModal();
    await fetch('/cart/clear', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    });
    submitCart(pendingCartForm);
});

/* ══════════════════════════════════════════
   BIND ADD-TO-CART FORMS
══════════════════════════════════════════ */
function bindAddCartForms() {
    document.querySelectorAll('.addCartForm').forEach(form => {
        if (form.dataset.bound === '1') return;
        form.dataset.bound = '1';

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const variants = JSON.parse(form.dataset.variants || '[]');
            const addons   = JSON.parse(form.dataset.addons   || '[]');

            if (!variants.length && !addons.length) {
                submitCart(form);
                return;
            }
            activeForm = form;
            buildVariantAddonModal(form);
        });
    });
}

/* ══════════════════════════════════════════
   FAVOURITE
══════════════════════════════════════════ */
function closeFavoritePopup() {
    document.getElementById('favoriteModal').classList.remove('open');
}

function saveFavorite() {
    fetch(`/restaurant/${window.restaurantId}/favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    }).then(r => r.json()).then(() => {
        window.isFavorite = true;
        closeFavoritePopup();
        const i = document.getElementById('favoriteToggleIcon');
        const l = document.getElementById('favoriteToggleLabel');
        if (i) i.textContent = '★';
        if (l) l.textContent = 'Saved';
    });
}

/* ══════════════════════════════════════════
   AR / 3D
══════════════════════════════════════════ */
const _video = document.getElementById('camera');
const _pizza = document.getElementById('pizza');
let _rotY = 0, _dragging = false, _startX = 0;

async function openAR(img) {
    document.getElementById('arModal').style.display = 'block';
    _pizza.style.backgroundImage = `url('${img}')`;
    try {
        const s = await navigator.mediaDevices.getUserMedia(
            { video: { facingMode: 'environment' }, audio: false });
        _video.srcObject = s;
    } catch (e) { alert('Please allow camera access'); }
}

function closeAR() {
    document.getElementById('arModal').style.display = 'none';
    if (_video.srcObject) _video.srcObject.getTracks().forEach(t => t.stop());
}

_pizza.addEventListener('mousedown',  e => { _dragging = true;  _startX = e.clientX; });
document.addEventListener('mouseup',  ()  => _dragging = false);
document.addEventListener('mousemove', e => {
    if (!_dragging) return;
    _rotY += (e.clientX - _startX) * 0.7;
    _pizza.style.transform = `rotateY(${_rotY}deg)`;
    _startX = e.clientX;
});
_pizza.addEventListener('touchstart', e => { _dragging = true; _startX = e.touches[0].clientX; });
_pizza.addEventListener('touchend',   ()  => _dragging = false);
_pizza.addEventListener('touchmove',  e => {
    if (!_dragging) return;
    _rotY += (e.touches[0].clientX - _startX) * 0.7;
    _pizza.style.transform = `rotateY(${_rotY}deg)`;
    _startX = e.touches[0].clientX;
});

/* ══════════════════════════════════════════
   INIT
══════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
    bindAddCartForms();
    refreshCartSidebar();
    fetch('/cart-count').then(r => r.json()).then(d => updateCounts(d.count));
});
</script>

@endsection