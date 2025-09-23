@extends('layouts.app')
@section('title', 'Boardmate Property Details')
@section('content')
@livewire('properties.show', ['id' => $id])
@endsection