<h1>New contact message</h1>

<p><strong>Name:</strong> {{ $contactMessage->name }}</p>
<p><strong>Email:</strong> {{ $contactMessage->email }}</p>
<p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>

<h2>Message</h2>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>
