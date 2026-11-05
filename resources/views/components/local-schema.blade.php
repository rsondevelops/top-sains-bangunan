@if(setting('address'))
@php
    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Top Sains Bangunan',
        'url' => url('/'),
        'image' => asset('img/logo.svg'),
        'telephone' => setting('phone') ?: setting('whatsapp_number'),
        'address' => ['@type' => 'PostalAddress', 'streetAddress' => str_replace(["\r\n", "\n"], ', ', setting('address')), 'addressCountry' => 'ID'],
        'areaServed' => ['Bogor', 'Jakarta', 'BSD', 'Tangerang'],
        'hasMap' => setting('maps_url'),
        'sameAs' => setting('instagram') ? [setting('instagram')] : null,
        '@type' => 'HomeGoodsStore',
        'geo' => ['@type' => 'GeoCoordinates', 'latitude' => -6.6380696, 'longitude' => 106.8289051],
        'openingHoursSpecification' => [[
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
            'opens' => '08:00', 'closes' => '17:00',
        ]],
    ]);
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endif