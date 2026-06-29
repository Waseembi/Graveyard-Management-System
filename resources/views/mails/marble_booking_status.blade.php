<p>Dear {{ $booking->user->name }},</p>

<p>Your marble service booking (Grave ID: {{ $booking->grave_id }}) has been updated.</p>

<p><strong>New Status:</strong> {{ ucfirst($booking->status) }}</p>

@if($booking->status === 'approved')
    <p>Your payment has been recorded. Work will begin soon.</p>
@elseif($booking->status === 'rejected')
    <p>Unfortunately, your request has been rejected.</p>
@elseif($booking->status === 'inprocess')
    <p>Your marble service is currently in process.</p>
@elseif($booking->status === 'completed')
    <p>Your marble service has been completed successfully.</p>
@endif

<p>Thank you,<br>Graveyard Management Team</p>
