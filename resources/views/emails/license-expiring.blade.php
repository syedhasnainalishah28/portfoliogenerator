@extends('emails.layout')

@section('content')
<h1>Action Required: License Expiring Soon!</h1>

<p>Hi {{ $user->name }},</p>

<p>This is an automated notification from HA Tech to let you know that your current access license for the Portfolio Generator is expiring in <strong>3 Days</strong>.</p>

<div class="panel" style="border-left: 4px solid #ef4444;">
    <strong>Current License:</strong> <br>
    <code style="color: #ef4444;">{{ $license->license_key }}</code><br><br>
    <strong>Expiry Date:</strong> <br>
    {{ $license->expires_at->format('F j, Y, g:i A') }}
</div>

<p>Once your license expires, you will instantly lose access to the dashboard and generator. Any previously generated portfolios hosted externally will remain untouched, but you will not be able to create new ones or edit existing layouts through our app.</p>

<div style="text-align: center;">
    <a href="{{ route('purchase.plans') }}" class="btn">Renew or Upgrade Plan</a>
</div>

<p>If you have already submitted a manual payment that is pending review, please disregard this email.</p>

<br>
<p>Regards,<br>
The HA Tech Team</p>
@endsection
