@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <div>
            <h1 class="text-2xl font-medium">Edit auction</h1>
            <p class="text-zinc-500">Change your item information</p>
        </div>
        @livewire('create-auction-form', ['auctionId' => request()->input('auctionId')])
    </div>
@endsection
