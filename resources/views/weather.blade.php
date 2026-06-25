<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌤️ CuacaKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            padding: 20px;
        }

        /* --- Bintang Latar Belakang --- */
        .stars { position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:0; }
        .star  { position:absolute; background:white; border-radius:50%; animation:twinkle linear infinite; }
        @keyframes twinkle {
            0%,100% { opacity:0; transform:scale(0.5); }
            50%     { opacity:1; transform:scale(1); }
        }

        .container { max-width:900px; margin:0 auto; position:relative; z-index:1; }

        /* --- Header --- */
        .app-header { text-align:center; margin-bottom:30px; padding-top:20px; }
        .app-header h1 {
            font-size:2.5rem; font-weight:800;
            background: linear-gradient(90deg, #a8edea, #fed6e3);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
        }
        .app-header p { color:rgba(255,255,255,0.6); font-size:0.9rem; margin-top:6px; }

        /* --- Search Box --- */
        .search-box {
            display:flex; gap:12px; margin-bottom:30px;
            background:rgba(255,255,255,0.08); backdrop-filter:blur(20px);
            border:1px solid rgba(255,255,255,0.15); border-radius:50px;
            padding:8px 8px 8px 24px;
        }
        .search-box input {
            flex:1; background:transparent; border:none; outline:none;
            color:#fff; font-family:'Poppins',sans-serif; font-size:1rem;
        }
        .search-box input::placeholder { color:rgba(255,255,255,0.4); }
        .search-box button {
            background:linear-gradient(135deg, #a8edea, #fed6e3); color:#302b63;
            border:none; padding:12px 28px; border-radius:40px;
            font-weight:700; font-family:'Poppins',sans-serif; font-size:0.95rem;
            cursor:pointer; transition:transform 0.2s, box-shadow 0.2s;
        }
        .search-box button:hover { transform:scale(1.05); box-shadow:0 4px 20px rgba(168,237,234,0.4); }

        /* --- Error --- */
        .error-card {
            background:rgba(255,80,80,0.2); border:1px solid rgba(255,80,80,0.4);
            border-radius:20px; padding:20px 30px; text-align:center; margin-bottom:20px;
        }
        .error-card span { font-size:2rem; display:block; margin-bottom:8px; }

        /* --- Cuaca Utama --- */
        .weather-main {
            background:rgba(255,255,255,0.1); backdrop-filter:blur(30px);
            border:1px solid rgba(255,255,255,0.2); border-radius:30px;
            padding:40px; margin-bottom:20px;
            display:grid; grid-template-columns:1fr 1fr; gap:30px; align-items:center;
        }
        .weather-left .city-name   { font-size:1.1rem; font-weight:500; color:rgba(255,255,255,0.7); margin-bottom:4px; }
        .weather-left .country     { font-size:0.8rem; color:rgba(255,255,255,0.4); margin-bottom:16px; }
        .weather-left .temperature { font-size:5rem; font-weight:800; line-height:1; margin-bottom:8px; }
        .weather-left .description { font-size:1.1rem; color:rgba(255,255,255,0.8); margin-bottom:12px; }
        .weather-left .feels-like  { font-size:0.85rem; color:rgba(255,255,255,0.5); }
        .weather-right             { text-align:center; }
        .weather-right .weather-icon { width:120px; height:120px; filter:drop-shadow(0 0 20px rgba(255,255,255,0.3)); margin-bottom:16px; }
        .weather-right .temp-range   { display:flex; justify-content:center; gap:20px; font-size:0.9rem; }
        .temp-min { color:#a8edea; }
        .temp-max { color:#fed6e3; }

        /* --- Detail 4 Kolom --- */
        .details-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:20px; }
        .detail-card {
            background:rgba(255,255,255,0.08); backdrop-filter:blur(20px);
            border:1px solid rgba(255,255,255,0.12); border-radius:20px;
            padding:20px; text-align:center; transition:transform 0.2s;
        }
        .detail-card:hover { transform:translateY(-4px); }
        .detail-card .icon  { font-size:1.8rem; margin-bottom:8px; }
        .detail-card .label { font-size:0.7rem; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px; }
        .detail-card .value { font-size:1.3rem; font-weight:700; }
        .detail-card .unit  { font-size:0.75rem; color:rgba(255,255,255,0.5); }

        /* --- Sunrise & Sunset --- */
        .sun-card {
            background:rgba(255,255,255,0.08); backdrop-filter:blur(20px);
            border:1px solid rgba(255,255,255,0.12); border-radius:20px;
            padding:24px 30px; display:flex; justify-content:space-around; align-items:center; margin-bottom:20px;
        }
        .sun-item { text-align:center; }
        .sun-item .sun-icon  { font-size:2rem; margin-bottom:4px; }
        .sun-item .sun-label { font-size:0.7rem; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; }
        .sun-item .sun-time  { font-size:1.4rem; font-weight:700; }
        .sun-divider { width:1px; height:60px; background:rgba(255,255,255,0.15); }

        /* --- Prakiraan 5 Hari --- */
        .forecast-section h2 { font-size:0.85rem; text-transform:uppercase; letter-spacing:2px; color:rgba(255,255,255,0.5); margin-bottom:14px; }
        .forecast-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:12px; }
        .forecast-card {
            background:rgba(255,255,255,0.08); backdrop-filter:blur(20px);
            border:1px solid rgba(255,255,255,0.12); border-radius:16px;
            padding:16px; text-align:center; transition:transform 0.2s;
        }
        .forecast-card:hover { transform:translateY(-4px); }
        .forecast-card .fc-date { font-size:0.7rem; color:rgba(255,255,255,0.5); margin-bottom:8px; }
        .forecast-card img { width:48px; height:48px; margin-bottom:6px; }
        .forecast-card .fc-max { font-size:1rem; font-weight:700; }
        .forecast-card .fc-min { font-size:0.8rem; color:rgba(255,255,255,0.5); }

        footer { text-align:center; margin-top:30px; padding-bottom:20px; color:rgba(255,255,255,0.3); font-size:0.8rem; }

        /* --- Responsive HP --- */
        @media (max-width:768px) {
            .weather-main  { grid-template-columns:1fr; text-align:center; }
            .weather-left .temperature { font-size:4rem; }
            .details-grid  { grid-template-columns:repeat(2,1fr); }
            .forecast-grid { grid-template-columns:repeat(3,1fr); }
        }
        @media (max-width:480px) {
            .forecast-grid { grid-template-columns:repeat(2,1fr); }
        }
    </style>
</head>
<body>

<div class="stars" id="stars"></div>

<div class="container">

    <header class="app-header">
        <h1>🌤️ CuacaKu</h1>
        <p>Informasi cuaca real-time seluruh Indonesia & dunia</p>
    </header>

    <form action="{{ route('weather.search') }}" method="POST" class="search-box">
        @csrf
        <input type="text" name="city"
            placeholder="Cari kota... contoh: Bandung, Surabaya, Tokyo"
            value="{{ isset($weather['city']) && !isset($weather['error']) ? $weather['city'] : old('city') }}"
            autocomplete="off">
        <button type="submit">🔍 Cari</button>
    </form>

    @if(isset($weather['error']))
        <div class="error-card">
            <span>😕</span>{{ $weather['error'] }}
        </div>

    @elseif(isset($weather['city']))

        <div class="weather-main">
            <div class="weather-left">
                <div class="city-name">📍 {{ $weather['city'] }}</div>
                <div class="country">{{ $weather['country'] }}</div>
                <div class="temperature">{{ $weather['temp'] }}°</div>
                <div class="description">{{ $weather['description'] }}</div>
                <div class="feels-like">Terasa seperti {{ $weather['feels_like'] }}°C</div>
            </div>
            <div class="weather-right">
                <img class="weather-icon"
                    src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@4x.png"
                    alt="{{ $weather['description'] }}">
                <div class="temp-range">
                    <span class="temp-min">↓ {{ $weather['temp_min'] }}°C</span>
                    <span class="temp-max">↑ {{ $weather['temp_max'] }}°C</span>
                </div>
            </div>
        </div>

        <div class="details-grid">
            <div class="detail-card">
                <div class="icon">💧</div>
                <div class="label">Kelembaban</div>
                <div class="value">{{ $weather['humidity'] }}<span class="unit">%</span></div>
            </div>
            <div class="detail-card">
                <div class="icon">💨</div>
                <div class="label">Angin</div>
                <div class="value">{{ $weather['wind_speed'] }}<span class="unit"> km/h</span></div>
            </div>
            <div class="detail-card">
                <div class="icon">👁️</div>
                <div class="label">Jarak Pandang</div>
                <div class="value">{{ $weather['visibility'] }}<span class="unit"> km</span></div>
            </div>
            <div class="detail-card">
                <div class="icon">🌡️</div>
                <div class="label">Tekanan</div>
                <div class="value">{{ $weather['pressure'] }}<span class="unit"> hPa</span></div>
            </div>
        </div>

        <div class="sun-card">
            <div class="sun-item">
                <div class="sun-icon">🌅</div>
                <div class="sun-label">Matahari Terbit</div>
                <div class="sun-time">{{ $weather['sunrise'] }}</div>
            </div>
            <div class="sun-divider"></div>
            <div class="sun-item">
                <div class="sun-icon">🌇</div>
                <div class="sun-label">Matahari Terbenam</div>
                <div class="sun-time">{{ $weather['sunset'] }}</div>
            </div>
        </div>

        @if(!empty($weather['forecast']))
        <div class="forecast-section">
            <h2>📅 Prakiraan 5 Hari ke Depan</h2>
            <div class="forecast-grid">
                @foreach($weather['forecast'] as $day)
                <div class="forecast-card">
                    <div class="fc-date">{{ $day['date'] }}</div>
                    <img src="https://openweathermap.org/img/wn/{{ $day['icon'] }}@2x.png" alt="cuaca">
                    <div class="fc-max">{{ $day['temp_max'] }}°</div>
                    <div class="fc-min">{{ $day['temp_min'] }}°</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    @endif

    <footer>
        <p>Data dari OpenWeatherMap API • Dibuat dengan ❤️ menggunakan Laravel</p>
    </footer>

</div>

<script>
    const s = document.getElementById('stars');
    for (let i = 0; i < 80; i++) {
        const star = document.createElement('div');
        star.classList.add('star');
        const size = Math.random() * 2 + 1;
        star.style.cssText = `
            width:${size}px; height:${size}px;
            left:${Math.random()*100}%;
            top:${Math.random()*100}%;
            animation-duration:${Math.random()*3+2}s;
            animation-delay:${Math.random()*3}s;
        `;
        s.appendChild(star);
    }
</script>

</body>
</html>