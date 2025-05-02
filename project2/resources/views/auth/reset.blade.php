<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <h1>Reset ur pssword</h1>  {{--!  don't forget that --}}
    <main>
        <form action="{{ route('reset.verifycation') }}" method="post">
            <input type="email" name="email" placeholder="something@example.com" required />
            <button type="submit">Confirm</button>
        </form>
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </main>
</body>
</html>