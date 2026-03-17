{{ $item->registrations->count() }}
@if($item->registrations->count() > 0)
    <a href="{{ route('events.registrations.index', $item->id) }}" class="btn btn-sm btn-info ms-2">
        <i class="fas fa-users"></i> View
    </a>
@endif