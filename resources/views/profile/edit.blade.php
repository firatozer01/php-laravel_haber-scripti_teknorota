@extends('layouts.site')

@section('title', 'Profilim - News Wrap')

@section('content')
    <div class="py-12 bg-gray-50 dark:bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h1 class="text-3xl font-black uppercase tracking-tighter mb-8 px-4 sm:px-0">Hesap Ayarları</h1>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="max-w-xl">
                     {{-- Delete user form logic can be kept or removed if not needed. Keeping for completeness but usually hidden --}}
                     @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
