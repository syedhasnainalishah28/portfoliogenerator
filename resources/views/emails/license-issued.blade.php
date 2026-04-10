@extends('emails.layout')

@section('content')
<h1>Payment Verified & License Issued!</h1>

<p>Hi {{ $user->name }},</p>

<p>Great news! Your recent payment for the <strong>{{ $license->plan->name }}</strong> has been verified and approved by our team.</p>

<p>Your premium access is now fully unlocked. Below is your unique license key to connect to the generator:</p>

<div class="key-display">
    {{ $license->license_key }}
</div>

<div class="panel">
    <strong>License Details:</strong>
    <ul>
        <li><strong>Plan:</strong> {{ $license->plan->name }}</li>
        <li><strong>Duration:</strong> {{ $license->plan->duration_months }} Months</li>
        <li><strong>Expiry Date:</strong> {{ $license->expires_at->format('F j, Y') }}</li>
    </ul>
</div>

<div style="text-align: center;">
    <a href="{{ route('dashboard') }}" class="btn">Enter Portfolio Generator</a>
</div>

<p>Keep this key secure. If your session expires, you may be asked to re-enter it.</p>

<br>
<p>Enjoy building,<br>
The HA Tech Team</p>
@endsection
