@extends('emails.layout')

@section('content')
<h1>{{ $subjectLine }}</h1>

<p>Hi {{ $user->name }},</p>

<!-- Raw HTML output for admin-defined templates -->
<div class="custom-content">
    {!! $bodyContent !!}
</div>

<br>
<p>Regards,<br>
The HA Tech Team</p>
@endsection
