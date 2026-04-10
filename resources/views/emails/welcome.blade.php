@extends('emails.layout')

@section('content')
<h1>Welcome to HA Tech</h1>

<p>Hi {{ $user->name }},</p>

<p>Your account has been successfully created. Welcome to the ultimate digital empire builder!</p>

<div class="panel">
    <strong>Next Steps:</strong><br><br>
    To unlock the premium portfolio generator and gain access to all the VIP themes, you will need to activate a license. You can choose from our highly curated plans.
</div>

<div style="text-align: center;">
    <a href="{{ route('purchase.plans') }}" class="btn">View Plans & Upgrade</a>
</div>

<p>If you have any questions or need custom solutions, our support team is always here to assist you.</p>

<br>
<p>Stay hustling,<br>
The HA Tech Team</p>
@endsection
