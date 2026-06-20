<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión Escolar - Secundaria</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Instrument Sans', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Contenedor principal */
        .container {
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
        }

        /* Header con navegación */
        .header {
            padding: 1.5rem 2rem;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .logo-sub {
            font-size: 0.75rem;
            color: #64748b;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-login {
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            background: white;
            color: #334155;
        }

        .btn-login:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .btn-register {
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.4);
        }

        /* Main content */
        .main-content {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        /* Lado izquierdo - texto */
        .info-side {
            flex: 1;
            padding: 3rem;
            background: white;
        }

        .badge {
            display: inline-block;
            background: #ede9fe;
            color: #6b21a5;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: #1e293b;
        }

        .title span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .description {
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #334155;
        }

        .feature-icon {
            width: 24px;
            height: 24px;
            background: #e0e7ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-size: 0.875rem;
        }

        .stats {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #64748b;
        }

        /* Lado derecho - imágenes */
        .image-side {
            flex: 1;
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .image-grid {
            position: relative;
            width: 100%;
            max-width: 380px;
        }

        /* Espacio para imagen principal */
        .main-image-placeholder {
            width: 100%;
            aspect-ratio: 1 / 1;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
            border: 2px dashed #c7d2fe;
            margin-bottom: 1rem;
        }

        .main-image-placeholder .placeholder-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .main-image-placeholder .placeholder-text {
            color: #818cf8;
            font-size: 0.75rem;
        }

        /* Espacio para imágenes pequeñas */
        .thumbnails {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .thumb-placeholder {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px dashed #c7d2fe;
            backdrop-filter: blur(2px);
        }

        .thumb-placeholder .placeholder-icon {
            font-size: 1.5rem;
        }

        .thumb-placeholder .placeholder-text {
            font-size: 0.6rem;
            color: #818cf8;
        }

        /* Footer */
        .footer {
            padding: 1rem 2rem;
            background: #f8fafc;
            text-align: center;
            font-size: 0.75rem;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .info-side {
                padding: 2rem;
            }
            
            .title {
                font-size: 1.75rem;
            }
            
            .stats {
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .thumb-placeholder {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header con navegación -->
        <div class="header">
            <div class="logo-area">
                <div class="logo-icon">📚</div>
                <div>
                    <div class="logo-text">EduSecundaria</div>
                    <div class="logo-sub">Gestión Académica</div>
                </div>
            </div>
            @if (Route::has('login'))
                <div class="nav-buttons">
                    @auth
                        <a href="{{ url('/home') }}" class="btn-login">Panel de control</a>
                    @else
                        <a 
                        href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <h2>-</h2>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <!-- Contenido principal -->
        <div class="main-content">
            <!-- Lado izquierdo - información -->
            <div class="info-side">
                <div class="badge">🏫 Bienvenidos al ciclo 2026</div>
                <h1 class="title">
                    La mejor educación para tu <span>futuro</span>
                </h1>
                <p class="description">
                    Sistema integral de gestión académica para escuelas secundarias. 
                    Control de notas, asistencia, calificaciones por trimestre y mucho más.
                </p>
                
                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Gestión de notas por trimestre</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Asignación de materias y docentes</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Reportes automáticos de rendimiento</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Control de inscripciones por gestión</span>
                    </div>
                </div>

                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">1,200+</div>
                        <div class="stat-label">Estudiantes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">60+</div>
                        <div class="stat-label">Docentes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">30+</div>
                        <div class="stat-label">Cursos</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Trimestres</div>
                    </div>
                </div>
            </div>

            <!-- Lado derecho - imágenes (espacios para fotos) -->
            <div class="image-side">
                <div class="image-grid">
                    <!-- Espacio para imagen principal -->
                    <div class="main-image-placeholder">
                        <div class="placeholder-icon">🏫</div>
                        <div class="placeholder-text">Foto: Fachada de la escuela</div>
                        <div class="placeholder-text" style="font-size: 0.6rem;">(800x800px recomendado)</div>
                    </div>
                    
                    <!-- Espacio para imágenes pequeñas -->
                    <div class="thumbnails">
                        <div class="thumb-placeholder">
                            <div class="placeholder-icon">👩‍🏫</div>
                            <div class="placeholder-text">Docentes</div>
                        </div>
                        <div class="thumb-placeholder">
                            <div class="placeholder-icon">👨‍🎓</div>
                            <div class="placeholder-text">Estudiantes</div>
                        </div>
                        <div class="thumb-placeholder">
                            <div class="placeholder-icon">📖</div>
                            <div class="placeholder-text">Aulas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            © 2026 EduSecundaria - Sistema de Gestión Escolar | Todos los derechos reservados
        </div>
    </div>
</body>
</html>