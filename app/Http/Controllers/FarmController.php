<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FarmController extends Controller
{
   
    // Halaman utama
    public function index()
    {
        return view('farm', ['data' => null]);
    }

    // Halaman Analisis Tani
    public function analisis()
    {
        return view('analisis_tani');
    }


    // Proses form petani
    public function search(Request $request)
    {
        $request->validate([
            'city'      => 'required|string|max:100',
            'luas'      => 'required|numeric|min:0.1',
            'komoditas' => 'required|in:padi,jagung',
        ]);

        $city      = $request->input('city');
        $luas      = $request->input('luas');
        $komoditas = $request->input('komoditas');

        $apiKey = config('weather.api_key');

        try {
            // Ambil prakiraan 5 hari dari OpenWeatherMap
            $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
                'q'     => $city,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang'  => 'id',
                'cnt'   => 40,
            ]);

            if ($response->status() === 404) {
                return view('farm', ['data' => null, 'error' => "Kota \"$city\" tidak ditemukan!"]);
            }

            if (!$response->successful()) {
                return view('farm', ['data' => null, 'error' => 'Gagal mengambil data. Cek API key Anda.']);
            }

            // Susun prakiraan per hari
            $forecastRaw = $response->json()['list'];
            $forecast    = [];
            $seen        = [];

            foreach ($forecastRaw as $item) {
                $date = date('Y-m-d', $item['dt']);
                if (!in_array($date, $seen) && count($seen) < 5) {
                    $seen[] = $date;

                    $cuaca       = strtolower($item['weather'][0]['main']);
                    $description = $item['weather'][0]['description'];
                    $temp        = round($item['main']['temp']);
                    $humidity    = $item['main']['humidity'];
                    $rain        = isset($item['rain']['3h']) ? $item['rain']['3h'] : 0;

                   
                    $rekomendasi = $this->getRekomendasi($cuaca, $temp, $humidity, $rain, $komoditas);

                    $forecast[] = [
                        'date'        => date('D, d M Y', $item['dt']),
                        'icon'        => $item['weather'][0]['icon'],
                        'description' => ucfirst($description),
                        'temp'        => $temp,
                        'humidity'    => $humidity,
                        'rain'        => $rain,
                        'cuaca'       => $cuaca,
                        'rekomendasi' => $rekomendasi['teks'],
                        'status'      => $rekomendasi['status'], 
                    ];
                }
            }

            return view('farm', [
                'data' => [
                    'city'      => $city,
                    'luas'      => $luas,
                    'komoditas' => $komoditas,
                    'forecast'  => $forecast,
                ],
                'error' => null,
            ]);

        } catch (\Exception $e) {
            return view('farm', ['data' => null, 'error' => 'Terjadi kesalahan koneksi.']);
        }
    }

   
    private function getRekomendasi(string $cuaca, int $temp, int $humidity, float $rain, string $komoditas): array
    {
        $isHujan  = in_array($cuaca, ['rain', 'drizzle', 'thunderstorm']) || $rain > 0;
        $isPanas  = $temp >= 33;
        $isMendung = $cuaca === 'clouds' && $temp < 33;

        // --- Logika untuk PADI ---
        if ($komoditas === 'padi') {
            if ($isHujan) {
                return ['status' => 'tunda', 'teks' => '🚫 Tunda pemupukan — hujan akan melarutkan pupuk. Cukupi drainase sawah.'];
            } elseif ($isPanas && $humidity < 60) {
                return ['status' => 'siram', 'teks' => '💧 Lakukan penyiraman — cuaca panas & kering, sawah butuh air tambahan.'];
            } elseif ($isPanas) {
                return ['status' => 'siram', 'teks' => '💧 Pantau ketersediaan air sawah — suhu tinggi meningkatkan evaporasi.'];
            } elseif ($isMendung) {
                return ['status' => 'aman', 'teks' => '✅ Cuaca mendung — cocok untuk pemupukan. Pupuk terserap optimal.'];
            } else {
                return ['status' => 'aman', 'teks' => '✅ Cuaca cerah — waktu ideal untuk pemupukan dan perawatan padi.'];
            }
        }

        // --- Logika untuk JAGUNG ---
        if ($komoditas === 'jagung') {
            if ($isHujan) {
                return ['status' => 'tunda', 'teks' => '🚫 Tunda pemupukan — hujan akan mengikis pupuk dari tanah jagung.'];
            } elseif ($isPanas && $humidity < 50) {
                return ['status' => 'siram', 'teks' => '💧 Segera lakukan penyiraman — jagung rentan layu di suhu panas & kering.'];
            } elseif ($isPanas) {
                return ['status' => 'siram', 'teks' => '💧 Lakukan penyiraman sore hari — suhu tinggi tidak ideal untuk jagung.'];
            } elseif ($isMendung) {
                return ['status' => 'aman', 'teks' => '✅ Cuaca mendung — aman untuk pemupukan. Hindari pupuk cair berlebihan.'];
            } else {
                return ['status' => 'aman', 'teks' => '✅ Cuaca cerah — waktu terbaik pemupukan dan penyemprotan pestisida jagung.'];
            }
        }

        return ['status' => 'aman', 'teks' => '✅ Cuaca normal — lanjutkan aktivitas bertani seperti biasa.'];
    }
}