@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Contenido -->
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Bienvenido') }}</div>

                        <div class="card-body">
                            <div id="welcome-message">
                                {{ __('Sesion Iniciada') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showForm() {
        document.getElementById('form-container').style.display = 'block';
        document.getElementById('welcome-message').style.display = 'none';
    }
</script>
@endsection
