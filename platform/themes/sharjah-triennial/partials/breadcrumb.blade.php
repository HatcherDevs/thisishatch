@php
    $breadcrumbs = Theme::breadcrumb()->getCrumbs();
@endphp

@if(count($breadcrumbs) > 1)
    <section class="breadcrumb-section"
        style="background: linear-gradient(135deg, rgba(26,26,46,0.05) 0%, rgba(22,33,62,0.05) 100%); border-bottom: 1px solid rgba(0,0,0,0.05);">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 bg-transparent">
                            @foreach($breadcrumbs as $crumb)
                                @if(!$loop->last)
                                    <li class="breadcrumb-item">
                                        <a href="{{ $crumb['url'] }}" class="text-decoration-none">
                                            @if($loop->first)
                                                <i class="fas fa-home me-2"></i>
                                            @endif
                                            {{ $crumb['label'] }}
                                        </a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item active fw-semibold" aria-current="page">
                                        {{ $crumb['label'] }}
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 text-md-end">
                    <small class="text-muted">
                        <i class="far fa-clock me-1"></i>
                        {{ now()->format('M d, Y') }}
                    </small>
                </div>
            </div>
        </div>
    </section>
@endif

<style>
    .breadcrumb-section .breadcrumb-item a {
        color: #666;
        transition: color 0.3s ease;
    }

    .breadcrumb-section .breadcrumb-item a:hover {
        color: #0f3460;
    }

    .breadcrumb-section .breadcrumb-item.active {
        color: #1a1a2e;
    }

    .breadcrumb-section .breadcrumb-item+.breadcrumb-item::before {
        content: '›';
        color: #999;
        font-size: 1.2em;
    }
</style>