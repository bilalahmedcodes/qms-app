<h3>The Escalation Feedback of your Agent:</h3>
Agent Name: {{ $voice_audit->associate->name }} <br>
Campaign: {{ $voice_audit->campaign->name }} <br>
Project Evaluated: {{ $voice_audit->project->name }} <br>
QA Score: {{ $voice_audit->percentage }} <br>
Phone Number: {{ $voice_audit->customer_phone }} <br>
Date of Evaluation: {{ $voice_audit->created_at->format('m-d-Y g:i:s A') }}
<h5>QA Notes: </h5>
<p>{{ $voice_audit->notes }}</p>
