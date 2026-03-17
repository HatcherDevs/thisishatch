@extends('theme.base::layouts.master')
@section('content')
<h1>فرص العمل</h1>
<ul>
    @foreach($opportunities as $opportunity)
        <li>
            <a
                href="{{ route('opportunity.single', $opportunity->slug) }}">{{ $opportunity->name }}</a>
        </li>
    @endforeach
</ul>
@endsection
