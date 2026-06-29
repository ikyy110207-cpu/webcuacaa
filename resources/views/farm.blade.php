<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌾 CuacaTani</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            background: linear-gradient(135deg, #1a3a1a, #2d5a1b, #1a4a0a);
            color:#fff;
            padding:20px;
        }

        .stars { position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:0; overflow:hidden; }
        .star  { position:absolute; background:rgba(255,255,255,0.6); border-radius:50%; animation:twinkle linear infinite; }
        @keyframes twinkle { 0%,100%{opacity:0} 50%{opacity:1} }

        .container { max-width:900px; margin:0 auto; position:relative; z-index:1; }

        /* Header */
        .app-header { text-align:center; margin-bottom:30px; padding-top:20px; }
        .app-header h1 { font-size:2.5rem; font-weight:800; background:linear-gradient(90deg,#a8f5a0,#f5e642); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .app-header p { color:rgba(255,255,255,0.6); font-size:0.9rem; margin-top:6px; }

        /* Navigasi balik */
        .back-link { display:inline-flex; align-items:center; gap:6px; color:rgba(255,255,255,0.6); font-size:0.85rem; text-decoration:none; margin-bottom:20px; transition:color 0.2s; }
        .back-link:hover { color:#fff; }

        /* Form */
        .form-card {
            background:rgba(255,255,255,0.1);
            backdrop-filter:blur(20px);
            border:1px solid rgba(255,255,255,0.2);
            border-radius:24px;
            padding:30px;
            margin-bottom:24px;
        }
        .form-card h2 { font-size:1rem; font-weight:600; margin-bottom:20px; color:rgba(255,255,255,0.9); }
        .form-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:20px; }
        .form-group label { display:block; font-size:0.75rem; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; }
        .form-group input,
        .form-group select {
            width:100%; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2);
            border-radius:12px; padding:10px 14px; color:#fff;
            font-family:'Poppins',sans-serif; font-size:0.9rem; outline:none;
            transition:border-color 0.2s;
        }
        .form-group input:focus,
        .form-group select:focus { border-color:rgba(168,245,160,0.6); }
        .form-group select option { background:#2d5a1b; color:#fff; }
        .form-group input::placeholder { color:rgba(255,255,255,0.4); }
        .submit-btn {
            width:100%; background:linear-gradient(135deg,#a8f5a0,#f5e642); color:#1a3a1a;
            border:none; padding:14px; border-radius:14px; font-weight:700;
            font-family:'Poppins',sans-serif; font-size:1rem; cursor:pointer; transition:transform 0.2s;
        }
        .submit-btn:hover { transform:scale(1.02); }

        /* Error */
        .error-card { background:rgba(255,80,80,0.2); border:1px solid rgba(255,80,80,0.4); border-radius:20px; padding:20px; text-align:center; margin-bottom:20px; }

        /* Info Lahan */
        .lahan-info {
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.15);
            border-radius:20px;
            padding:20px 24px;
            margin-bottom:20px;
            display:flex;
            gap:30px;
            flex-wrap:wrap;
        }
        .lahan-item .lahan-label { font-size:0.7rem; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; }
        .lahan-item .lahan-value { font-size:1.1rem; font-weight:700; }

        /* Kartu Prakiraan */
        .forecast-title { font-size:0.85rem; text-transform:uppercase; letter-spacing:2px; color:rgba(255,255,255,0.5); margin-bottom:14px; }

        .forecast-card {
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.12);
            border-radius:20px;
            padding:20px;
            margin-bottom:14px;
            display:grid;
            grid-template-columns:100px 80px 1fr;
            gap:16px;
            align-items:center;
        }

        .fc-left .fc-date { font-size:0.75rem; color:rgba(255,255,255,0.5); }
        .fc-left .fc-desc { font-size:0.85rem; font-weight:500; margin-top:2px; }
        .fc-left img { width:50px; height:50px; }

        .fc-mid .fc-temp { font-size:1.5rem; font-weight:800; }
        .fc-mid .fc-hum  { font-size:0.75rem; color:rgba(255,255,255,0.5); margin-top:2px; }

        .rekomendasi {
            padding:12px 16px;
            border-radius:12px;
            font-size:0.85rem;
            font-weight:500;
            line-height:1.5;
        }
        .rekomendasi.aman  { background:rgba(80,200,80,0.2);  border:1px solid rgba(80,200,80,0.4); }
        .rekomendasi.tunda { background:rgba(255,80,80,0.2);  border:1px solid rgba(255,80,80,0.4); }
        .rekomendasi.siram { background:rgba(80,160,255,0.2); border:1px solid rgba(80,160,255,0.4); }

        footer { text-align:center; margin-top:30px; padding-bottom:20px; color:rgba(255,255,255,0.3); font-size:0.8rem; }

        @media(max-width:600px) {
            .form-grid { grid-template-columns:1fr; }
            .forecast-card { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<div class="stars" id="stars"></div>

<div class="container">

    <header class="app-header">
        <h1>🌾 CuacaTani</h1>
        <p>Kalender Tanam & Rekomendasi Pemupukan untuk Petani</p>
    </header>

    <a href="{{ route('weather.index') }}" class="back-link">← Kembali ke Cuaca Umum</a>

    {{-- FORM INPUT PETANI --}}
    <div class="form-card">
        <h2>📋 Masukkan Data Lahan Anda</h2>
        <form action="{{ route('farm.search') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Kota / Lokasi Lahan</label>
                    <input type="text" name="city" placeholder="contoh: Purwakarta"
                        value="{{ isset($data['city']) ? $data['city'] : old('city') }}"
                        required autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Luas Lahan (Hektar)</label>
                    <input type="number" name="luas" placeholder="contoh: 2.5" step="0.1" min="0.1"
                        value="{{ isset($data['luas']) ? $data['luas'] : old('luas') }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Komoditas</label>
                    <select name="komoditas">
                        <option value="padi"   {{ (isset($data['komoditas']) && $data['komoditas']==='padi')   ? 'selected' : '' }}>🌾 Padi</option>
                        <option value="jagung" {{ (isset($data['komoditas']) && $data['komoditas']==='jagung') ? 'selected' : '' }}>🌽 Jagung</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="submit-btn">🔍 Lihat Prakiraan & Rekomendasi</button>
        </form>
    </div>

    {{-- ERROR --}}
    @if(isset($error) && $error)
        <div class="error-card">😕 {{ $error }}</div>
    @endif

    {{-- HASIL --}}
    @if(isset($data) && $data)

        {{-- Info Lahan --}}
        <div class="lahan-info">
            <div class="lahan-item">
                <div class="lahan-label">📍 Lokasi</div>
                <div class="lahan-value">{{ $data['city'] }}</div>
            </div>
            <div class="lahan-item">
                <div class="lahan-label">📐 Luas Lahan</div>
                <div class="lahan-value">{{ $data['luas'] }} Hektar</div>
            </div>
            <div class="lahan-item">
                <div class="lahan-label">🌿 Komoditas</div>
                <div class="lahan-value">{{ ucfirst($data['komoditas']) }}</div>
            </div>
        </div>

        {{-- Prakiraan 5 Hari + Rekomendasi --}}
        <p class="forecast-title">📅 Prakiraan 5 Hari & Rekomendasi Bertani</p>

        @foreach($data['forecast'] as $day)
        <div class="forecast-card">
            <div class="fc-left">
                <div class="fc-date">{{ $day['date'] }}</div>
                <img src="https://openweathermap.org/img/wn/{{ $day['icon'] }}@2x.png" alt="cuaca">
                <div class="fc-desc">{{ $day['description'] }}</div>
            </div>
            <div class="fc-mid">
                <div class="fc-temp">{{ $day['temp'] }}°C</div>
                <div class="fc-hum">💧 {{ $day['humidity'] }}%</div>
            </div>
            <div class="rekomendasi {{ $day['status'] }}">
                {{ $day['rekomendasi'] }}
            </div>
        </div>
        @endforeach

    @endif

    <footer>
        <p>Data dari OpenWeatherMap API • CuacaTani — Sistem Kalender Tanam Laravel</p>
    </footer>

</div>

<script>
    const s = document.getElementById('stars');
    for(let i=0;i<60;i++){
        const el=document.createElement('div');
        el.classList.add('star');
        const sz=Math.random()*2+1;
        el.style.cssText=`width:${sz}px;height:${sz}px;left:${Math.random()*100}%;top:${Math.random()*100}%;animation-duration:${Math.random()*4+2}s;animation-delay:${Math.random()*4}s`;
        s.appendChild(el);
    }
</script>

</body>
</html>