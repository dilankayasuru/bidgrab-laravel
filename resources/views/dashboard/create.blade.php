@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <div>
            <h1 class="text-2xl font-medium">Create new auction</h1>
            <p class="text-zinc-500">Enter you auction item information</p>
        </div>
        @livewire('create-auction-form')
    </div>
@endsection