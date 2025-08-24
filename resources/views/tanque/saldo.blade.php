


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tanques de Combustível</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }
        h1 {
            color: #333;
            margin-bottom: 40px;
        }
        .tanks-container {
            display: flex;
            justify-content: center;
            gap: 50px;
            flex-wrap: wrap; 
        }
        .tank-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            width: 200px;
        }
        .tank-name {
            font-size: 1.5em;
            color: #555;
            margin-bottom: 10px; /* Espaço menor antes da capacidade */
        }
        .tank-capacity {
            font-size: 1em;
            color: #777;
            margin-bottom: 20px; /* Espaço entre a capacidade e o tanque */
        }
        .tank-image-container {
            position: relative;
            width: 200px;
            height: 100px;
            border: 2px solid #333;
            border-radius: 10px;
            margin: 0 auto 20px;
            background-color: #eee;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
        }
        .fuel-level {
            width: 100%;
            background-color: #007bff;
            transition: height 0.5s ease-in-out;
        }
        .percentage-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2em;
            color: white;
            text-shadow: 1px 1px 2px black;
            z-index: 1; /* Garante que o texto fique acima do nível de combustível */
        }
    </style>
</head>
<body>
    <h1>Níveis de Combustível</h1>
    <div class="tanks-container">
        
        {{-- Itera sobre os dados dos tanques passados do controlador --}}
        @foreach ($tanques as $tank)
            <div class="tank-card">
                <div class="tank-name">{{ $tank['descricao_tanque'] }}</div>
                <div class="tank-capacity">Capacidade: {{ $tank['capacidade'] }}L</div>
                <div class="tank-image-container">
                    @php
                        // Calcula a porcentagem com base na posição e capacidade
                        $percentage = ($tank['posicao'] / $tank['capacidade']) * 100;
                        $percentage = max(0, min(100, $percentage));
                        $color = '';
                        if ($percentage < 20) {
                            $color = '#dc3545';
                        } elseif ($percentage < 50) {
                            $color = '#ffc107';
                        } else {
                            $color = '#28a745';
                        }
                    @endphp
                    <div class="fuel-level" style="height: {{ $percentage }}%; background-color: {{ $color }};"></div>
                    <div class="percentage-text">{{ round($percentage, 0) }}%</div>
                </div>
                <div class="volume-text">Volume: {{ round($tank['posicao'], 1) }}L</div>
            </div>
        @endforeach

    </div>
</body>
</html>