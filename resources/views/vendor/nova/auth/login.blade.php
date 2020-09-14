@extends('nova::auth.layout')

@section('content')

@include('nova::auth.partials.header')

<form
	class="bg-white shadow rounded-lg p-8 max-w-login mx-auto"
	method="POST"
	action="{{ route('nova.login') }}"
>
	{{ csrf_field() }}

	@component('nova::auth.partials.heading')
		@lang('Welcome Back!')
	@endcomponent

	@if ($errors->any())
	<p class="text-center font-semibold text-danger my-3">
		@if ($errors->has('phone'))
			{{ $errors->first('phone') }}
		@else
			{{ $errors->first('password') }}
		@endif
		</p>
	@endif

	<div class="mb-6 {{ $errors->has('phone') ? ' has-error' : '' }}">
		<label class="block font-bold mb-2" for="phone">@lang('Phone Number')</label>
		<input class="form-control form-input form-input-bordered w-full" id="phone" type="tel" pattern="^\+?[0-9]+$" name="phone" value="{{ old('phone') }}" required autofocus placeholder="+123456789">
	</div>

	<div class="mb-6 {{ $errors->has('password') ? ' has-error' : '' }}">
		<label class="block font-bold mb-2" for="password">@lang('Password')</label>
		<input class="form-control form-input form-input-bordered w-full" id="password" type="password" name="password" required>
	</div>

	<div class="flex mb-6">
		<label class="flex items-center block text-xl font-bold">
			<input class="" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
			<span class="text-base ml-2">@lang('Remember Me')</span>
		</label>
	</div>

	<button class="w-full btn btn-default btn-primary hover:bg-primary-dark" type="submit">
		@lang('Login')
	</button>
</form>
@endsection
