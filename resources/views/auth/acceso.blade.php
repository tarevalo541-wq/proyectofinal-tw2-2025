@extends('layouts.baseacceso')

@section('titulo' , 'Iniciar Sesion')

@push('CSS')
<style>
    .login-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

    }
    .login-card {
        backdrop-filter: blur(1opx);
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    brand-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
    }
</style>
@endpush

@section('contenido')
<div class="login-container d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-0 login-card">
                    <div class="col-md-6 d-flex align-items-center justify-content-center brand-section text-black p-5">
                        <div class="text-center">
                            <h1 class="display-4 mb-4">
                                <i class="bi bi-motarboard-fill"></i>
                            </h1>
                            <h2 class="mb-3">Sistema de Calificaciones</h2>
                            <p class="lead">Gestiona las calificaciones de manera eficiente y segura</p>
                        </div>
                    </div>
                    <div class="col-md-6 p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-primary">Iniciar Sesion</h3>
                            <p class="text-muted">Ingresa tus credenciales para acceder</p>
                        </div>
                        <form id="frAcceso" method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope text-primary"></i>Correo Electronico
                                </label>
                                <input type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="ejemplo@correo.com"
                                required>
                            @error('email')
                                 <div class="invalid-feedback">{{ $message }}</div>
                            @enderror     
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock text-primary"></i>Contraseña
                                </label>
                                <input type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Ingresa tu contraseña"
                                required>
                            @error('password')
                                 <div class="invalid-feedback">{{ $message }}</div>
                            @enderror     
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" id="btnAcceso">
                                    <i class="bi bi-box-arrow-in-right"></i>Iniciar Sesion
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="bi bi-shield-check"></i> Acceso seguro y protegido
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('JS')
<script>
    function cambiarEstadoBoton(cargando){
        const btn = $("#btnAcceso");
        if( cargando ){
            btn.html('<i class="bi bi-hourglass-split"></i> Verificando...').prop("disabled", true);
        }
        else {
            btn.html('<i class="bi bi-box-arrow-in-right"></i>Iniciar Sesion').prop("disabled", false);
        }
    }
</script>
@endpush

@push('JSOR')
$("#frmAcceso").on("submit", function(e){
    e.preventDefault();
    cambiarEstadoBoton(true);
    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: $(this).serialize(),
        succes: function(response){
            Swal.fire({
                icon: "succes",
                title: "Bienvenido!",
                text: "Acceso concedido correctamente",
                timer: 1500,
                showConfirmButton: false,
                timeProgressBar: true
            }).then(() => {
                window.location.href = response.redirect || "/dashboard";
            });
        },
        error: function(xhr){
            cambiarEstadoBoton(false);
            if( xhr.status == 422 ){
                location.reload();
            }
            else if( xhr.status == 401 ){
                    Swal.fire({
                        icon: "error",
                        title: "Acceso Denegado",
                        text: "Las credenciales ingresadas son incorrectas",
                        confirButtonText: "Intentar de nuevo"
                    });
            }
            else{
                    Swal.fire({
                        icon: "error",
                        title: "Error del sistema",
                        text: "Ocurrio un problema, intenta mas tarde",
                        confirButtonText: "Aceptar"
                    });
            }
        }
    });
});
@endpush