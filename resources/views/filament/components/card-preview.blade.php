<div class="flex justify-center p-4">
    <div
        style="
            position: relative;
            width: 320px;
            height: 200px;
            border-radius: 12px;
            background: {{ $color_secondary ?? '#f3f4f6' }};
            border: 2px solid {{ $color_primary ?? '#6d28d9' }};
            overflow: hidden;
            font-family: system-ui, sans-serif;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        "
    >
        {{-- Header --}}
        <div
            style="
                background: {{ $color_primary ?? '#6d28d9' }};
                color: #fff;
                padding: 12px;
                text-align: center;
                font-size: 13px;
                font-weight: bold;
            "
        >
            {{ $app_name ?? 'ASSOCIAZIONE' }}
        </div>

        {{-- Body --}}
        <div style="padding: 12px 16px; font-size: 11px;">
            <div style="margin-bottom: 8px;">
                <div
                    style="
                        font-size: 9px;
                        margin-bottom: 2px;
                        color: {{ $color_label ?? '#1e40af' }};
                        text-transform: uppercase;
                    "
                >
                    Nome e Cognome
                </div>
                <div
                    style="
                        font-weight: bold;
                        font-size: 14px;
                        color: {{ $color_accent ?? '#1e40af' }};
                    "
                >
                    Mario Rossi
                </div>
            </div>

            <div style="margin-bottom: 8px;">
                <div
                    style="
                        font-size: 9px;
                        margin-bottom: 2px;
                        color: {{ $color_label ?? '#1e40af' }};
                        text-transform: uppercase;
                    "
                >
                    Codice
                </div>
                <div
                    style="
                        font-weight: bold;
                        font-size: 12px;
                        font-family: monospace;
                        color: {{ $color_accent ?? '#1e40af' }};
                    "
                >
                    ABC-12345
                </div>
            </div>

            <div style="margin: 2px 0">
                <div
                    style="
                        font-size: 9px;
                        margin-bottom: 2px;
                        color: {{ $color_label ?? '#1e40af' }};
                        text-transform: uppercase;
                    "
                >
                    Anno
                </div>
                <span
                    style="
                        display: inline-block;
                        padding: 2px 8px;
                        background: {{ $color_accent ?? '#1e40af' }};
                        color: {{ $color_secondary ?? '#f3f4f6' }};
                        font-size: 10px;
                        font-weight: bold;
                        border-radius: 6px;
                        "
                >
                    2026
                </span>
            </div>
        </div>

        {{-- Footer --}}
        <div
            style="
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                background: {{ $color_primary ?? '#6d28d9' }};
                color: {{ $color_secondary ?? '#f3f4f6' }};
                font-size: 9px;
                padding: 6px 12px;
                text-align: right;
            "
        >
            <strong>{{ $nome ?? 'Livello' }}</strong>
            @if ($descrizione)
                - {{ $descrizione }}
            @endif
        </div>
    </div>
</div>
