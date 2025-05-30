<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCatalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="">
    <div class="w-100 align-items-center justify-content-center d-flex" style="height: 100vh;">
        <div class="" style="width: 25em;">
            <form action="{{route('auth.login')}}" method="POST">
                @csrf
                <div data-mdb-input-init class="form-outline form-white mb-4">
                    <label class="form-label" for="typeEmailX">Email</label>
                    <input name="email" type="email" id="typeEmailX" value="{{old('email')}}" class="form-control form-control-lg @error('email') is-invalid @enderror" />
                    @error('email')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>

                <div data-mdb-input-init class="form-outline form-white mb-4">
                    <label class="form-label" for="typePasswordX">Password</label>
                    <input name="password" type="password" id="typePasswordX" value="{{old('password')}}" class="form-control form-control-lg @error('password') is-invalid @enderror" />
                    @error('password')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4 align-items-center">Se Connecter</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
