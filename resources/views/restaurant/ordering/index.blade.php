@extends('layouts.app')

@section('content')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        :root {
            --cream: #F6F1E8;
            --cream2: #EDE5D4;
            --cream3: #E0D5C0;
            --terra: #C25A2A;
            --terra-l: #D97040;
            --terra-d: #8C3D1A;
            --terra-bg: rgba(194, 90, 42, 0.08);
            --terra-bg2: rgba(194, 90, 42, 0.14);
            --ink: #1A1208;
            --ink2: #2E2318;
            --muted: #8A7A62;
            --muted2: #6B5C46;
            --green: #3D8C5A;
            --green-bg: rgba(61, 140, 90, 0.1);
            --red: #C23A2A;
            --red-bg: rgba(194, 58, 42, 0.08);
            --blue: #2A6CC2;
            --blue-bg: rgba(42, 108, 194, 0.08);
            --gold: #C99A3C;
            --border: rgba(194, 90, 42, 0.12);
            --border2: rgba(194, 90, 42, 0.22);
            --shadow: 0 2px 16px rgba(26, 18, 8, 0.08);
            --shadow2: 0 8px 32px rgba(26, 18, 8, 0.12);
            --ease: cubic-bezier(0.16, 1, 0.3, 1);
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: var(--cream2);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--terra);
            border-radius: 4px;
        }

        .oo-wrap {
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        .pg-header {
            margin-bottom: 28px;
        }

        .pg-eyebrow {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--terra);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pg-eyebrow::before {
            content: '';
            width: 16px;
            height: 2px;
            background: var(--terra);
            border-radius: 2px;
        }

        .pg-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.15;
        }

        .pg-header h1 span {
            color: var(--terra);
        }

        .pg-sub {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
            font-weight: 400;
        }

        /* ── Card ── */
        .oo-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp .5s var(--ease) both;
        }

        .oo-card-header {
            padding: 18px 24px;
            background: var(--cream);
            border-bottom: 1px solid var(--border);
        }

        .oo-card-header h4 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin: 0;
        }

        .oo-card-body {
            padding: 32px 24px;
        }

        .oo-chart-wrap {
            max-width: 420px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .oo-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
            font-size: 13.5px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media(max-width:640px) {
            .pg-header h1 {
                font-size: 24px;
            }

            .oo-card-body {
                padding: 22px 16px;
            }
        }
        /* TWO GRAPH GRID */

.oo-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
}

.oo-chart-wrap {
    position: relative;
    width: 100%;
    max-width: 420px;
    height: 330px;
    margin: 0 auto;
}

@media(max-width: 900px) {

    .oo-grid {
        grid-template-columns: 1fr;
    }

}

@media(max-width: 640px) {

    .oo-chart-wrap {
        height: 280px;
    }

}
    </style>

    <div class="oo-wrap">

        <div class="pg-header">
            <div class="pg-eyebrow">Restaurant Panel</div>
            <h1>Online <span>Ordering</span></h1>
            <p class="pg-sub">Breakdown of orders by type</p>
        </div>

       <div class="oo-grid">

    {{-- ORDER TYPE GRAPH --}}

    <div class="oo-card">

        <div class="oo-card-header">

            <h4>
                Order Type Distribution
            </h4>

        </div>

        <div class="oo-card-body">

            @if($orderTypes->count())

                <div class="oo-chart-wrap">

                    <canvas id="orderTypeChart"></canvas>

                </div>

            @else

                <div class="oo-empty">

                    No Order Type Data Found

                </div>

            @endif

        </div>

    </div>


    {{-- WEB AND APP GRAPH --}}

    <div class="oo-card">

        <div class="oo-card-header">

            <h4>
                Web vs App Orders
            </h4>

        </div>

        <div class="oo-card-body">

            @if($orderSources->count())

                <div class="oo-chart-wrap">

                    <canvas id="orderSourceChart"></canvas>

                </div>

            @else

                <div class="oo-empty">

                    No Web or App Orders Found

                </div>

            @endif

        </div>

    </div>

</div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    /*
    |--------------------------------------------------------------------------
    | FIRST GRAPH — ORDER TYPE
    |--------------------------------------------------------------------------
    */

    @if($orderTypes->count() > 0)

        const orderTypeCanvas =
            document.getElementById("orderTypeChart");

        if (orderTypeCanvas) {

           const orderTypeLabels = [
    @foreach($orderTypes as $item)
        @php
            $typeLabels = [
                'delivery' => 'Cash On Delivery',
                'dine'     => 'DineIn',
                'take'     => 'TakeAway',
            ];

            $displayLabel = $typeLabels[$item->order_type] ?? ucfirst($item->order_type ?? 'Unknown');
        @endphp
        "{{ $displayLabel }}",
    @endforeach
];

            const orderTypeTotals = [
                @foreach($orderTypes as $item)
                    {{ $item->total }},
                @endforeach
            ];

            new Chart(orderTypeCanvas, {

                type: "pie",

                data: {

                    labels: orderTypeLabels,

                    datasets: [{

                        data: orderTypeTotals,

                        backgroundColor: [

                            "#C25A2A",

                            "#3D8C5A",

                            "#2A6CC2",

                            "#C99A3C",

                            "#8C3D1A",

                            "#6B5C46"

                        ],

                        borderColor: "#FFFFFF",

                        borderWidth: 3,

                        hoverOffset: 8

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            position: "bottom",

                            labels: {

                                color: "#2E2318",

                                padding: 18,

                                usePointStyle: true,

                                pointStyle: "circle",

                                font: {

                                    family: "'Poppins', sans-serif",

                                    size: 12,

                                    weight: "600"

                                }

                            }

                        },

                        tooltip: {

                            backgroundColor: "#1A1208",

                            padding: 12,

                            cornerRadius: 8

                        }

                    }

                }

            });

        }

    @endif


    /*
    |--------------------------------------------------------------------------
    | SECOND GRAPH — WEB VS APP
    |--------------------------------------------------------------------------
    */

    @if($orderSources->count() > 0)

        const orderSourceCanvas =
            document.getElementById("orderSourceChart");

        if (orderSourceCanvas) {

            const sourceLabels = [

                @foreach($orderSources as $item)

                    "{{ strtolower($item->order_from) === 'web'
                        ? 'Web Orders'
                        : 'App Orders' }}",

                @endforeach

            ];


            const sourceTotals = [

                @foreach($orderSources as $item)

                    {{ $item->total }},

                @endforeach

            ];


            new Chart(orderSourceCanvas, {

                type: "doughnut",

                data: {

                    labels: sourceLabels,

                    datasets: [{

                        data: sourceTotals,

                        backgroundColor: [

                            "#2A6CC2",

                            "#3D8C5A"

                        ],

                        borderColor: "#FFFFFF",

                        borderWidth: 4,

                        hoverOffset: 10

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    cutout: "60%",

                    plugins: {

                        legend: {

                            position: "bottom",

                            labels: {

                                color: "#2E2318",

                                padding: 18,

                                usePointStyle: true,

                                pointStyle: "circle",

                                font: {

                                    family: "'Poppins', sans-serif",

                                    size: 12,

                                    weight: "600"

                                }

                            }

                        },

                        tooltip: {

                            backgroundColor: "#1A1208",

                            padding: 12,

                            cornerRadius: 8,

                            callbacks: {

                                label: function (context) {

                                    return context.label
                                        + ": "
                                        + context.raw
                                        + " Orders";

                                }

                            }

                        }

                    }

                }

            });

        }

    @endif

});

</script>

@endsection