<p><strong>Podnik:</strong> {{ $service->business->name ?? 'Neznámý podnik' }}</p>
<p><strong>Služba:</strong> {{ $service->name }}</p>
<p><strong>Popis:</strong> {{ $service->description }}</p>
<p><strong>Délka:</strong> {{ $service->duration_minutes }} minut</p>
<p><strong>Cena:</strong> {{ number_format($service->price) }} Kč</p>
<p><strong>Vybrané datum:</strong> {{ $date ?? '–' }}</p>
<p><strong>Vybraný čas:</strong> {{ $time ?? '–' }}</p>
