@props(['items'])

@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($items)->values()->map(fn ($it, $i) => array_filter([
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $it[0],
            'item' => $it[1] ? url($it[1]) : null,
        ]))->all(),
    ];
@endphp

<nav aria-label="Breadcrumb" class="crumb">
    <ol>
        @foreach($items as [$label, $href])
            <li>@if($href)<a href="{{ $href }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif</li>
        @endforeach
    </ol>
</nav>
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>