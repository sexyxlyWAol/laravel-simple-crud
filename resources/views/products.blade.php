@if(session('authenticated'))
    <p>Welcome, you are logged in!</p>
@else
    <p>You are not logged in.</p>
@endif
