<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        $weatherData = $this->getWeather('Jakarta');
        return view('weather', ['weather' => $weatherData]);
    }

    public function search(Request $request)
    {
        $request->validate(['city' => 'required|string|max:100']);
        $weatherData = $this->getWeather($request->input('city'));
        return view('weather', ['weather' => $weatherData]);
    }

    private function getWeather(string $city): array
    {
        $apiKey = config('weather.api_key');

        try {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q'     => $city,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang'  => 'id',
            ]);

            if ($response->status() === 404) return ['error' => "Kota \"$city\" tidak ditemukan!"];
            if (!$response->successful())   return ['error' => 'Gagal mengambil data. Cek API key Anda.'];

            $data = $response->json();

            // Prakiraan 5 hari
            $forecast = [];
            $forecastRes = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
                'q' => $city, 'appid' => $apiKey, 'units' => 'metric', 'lang' => 'id', 'cnt' => 40,
            ]);

            if ($forecastRes->successful()) {
                $seen = [];
                foreach ($forecastRes->json()['list'] as $item) {
                    $date = date('Y-m-d', $item['dt']);
                    if ($date !== date('Y-m-d') && !in_array($date, $seen) && count($seen) < 5) {
                        $seen[] = $date;
                        $forecast[] = [
                            'date'     => date('D, d M', $item['dt']),
                            'temp_min' => round($item['main']['temp_min']),
                            'temp_max' => round($item['main']['temp_max']),
                            'icon'     => $item['weather'][0]['icon'],
                        ];
                    }
                }
            }

            return [
                'city'        => $data['name'],
                'country'     => $data['sys']['country'],
                'temp'        => round($data['main']['temp']),
                'feels_like'  => round($data['main']['feels_like']),
                'temp_min'    => round($data['main']['temp_min']),
                'temp_max'    => round($data['main']['temp_max']),
                'description' => ucfirst($data['weather'][0]['description']),
                'icon'        => $data['weather'][0]['icon'],
                'humidity'    => $data['main']['humidity'],
                'wind_speed'  => round($data['wind']['speed'] * 3.6, 1),
                'visibility'  => isset($data['visibility']) ? round($data['visibility'] / 1000, 1) : '-',
                'pressure'    => $data['main']['pressure'],
                'sunrise'     => date('H:i', $data['sys']['sunrise'] + $data['timezone']),
                'sunset'      => date('H:i', $data['sys']['sunset']  + $data['timezone']),
                'forecast'    => $forecast,
                'error'       => null,
            ];

        } catch (\Exception $e) {
            return ['error' => 'Terjadi kesalahan koneksi.'];
        }
    }
}