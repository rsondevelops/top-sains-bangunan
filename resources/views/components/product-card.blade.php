@props(['product'])

<article class="pcard">
    <a href="{{ $product->url }}" class="pcard-img" aria-label="{{ $product->display_name }}">
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->display_name }} {{ $product->category->name }}" width="600" height="600" loading="lazy">
        @else
            <span class="ph">{{ $product->sku ?: $product->name }}</span>
        @endif
        @if($product->is_best_seller)<span class="tag">Best Seller</span>@endif
    </a>
    <div class="pcard-body">
        <div class="eyebrow">{{ $product->category->name }}</div>
        <h3><a href="{{ $product->url }}">{{ $product->display_name }}</a></h3>
        <p class="price">{{ $product->price ? rupiah($product->price) : 'Tanya harga' }}</p>
        <a href="{{ product_wa($product) }}" target="_blank" rel="noopener" class="link-wa">Tanya Harga &amp; Ketersediaan →</a>
    </div>
</article>