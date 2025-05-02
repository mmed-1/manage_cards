<!DOCTYPE html>
<html lang="en">
<x-head>
    <link rel="stylesheet" href="" />
</x-head>
<body>
    <main>
        <form action="{{ route('reset') }}" method="post">
           <div>
            <input 
                type="email" 
                name="email" 
                placeholder="votre email" 
                required 
             />
           </div>

            <div>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="votre password" 
                    required 
                />
            </div>

            <div>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    placeholder="votre password" 
                    required 
                />
            </div>

            <input type="submit" value="Confirmer" />
        </form>
    </main>
</body>
</html>