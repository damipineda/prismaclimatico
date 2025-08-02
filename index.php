<?php
require_once 'config/app.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beca Voces por el Planeta - Bienvenida</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mobile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .welcome-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .welcome-content {
            text-align: center;
            color: white;
            z-index: 2;
            position: relative;
            max-width: 800px;
            padding: 2rem;
        }

        .welcome-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease-out;
        }

        .welcome-subtitle {
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .welcome-description {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 3rem;
            opacity: 0.8;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 1rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            background: linear-gradient(45deg, #20c997, #28a745);
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }

        .floating-element i {
            font-size: 3rem;
            color: white;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
            animation: fadeInUp 1s ease-out 0.8s both;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #28a745;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .welcome-title {
                font-size: 2.5rem;
            }
            
            .welcome-subtitle {
                font-size: 1.2rem;
            }
            
            .welcome-description {
                font-size: 1rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-section">
        <div class="floating-elements">
            <div class="floating-element">
                <i class="fas fa-paint-brush"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-leaf"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-heart"></i>
            </div>
        </div>
        
        <div class="welcome-content">
            <h1 class="welcome-title">Beca Voces por el Planeta</h1>
            <h2 class="welcome-subtitle">ARTE - DERECHOS - CLIMA</h2>
            <p class="welcome-description">
                Estamos construyendo una nueva experiencia para democratizar el debate sobre la crisis climática en Paraguay. 
                Utilizamos el poder transformador del arte y el activismo para amplificar las voces de colectivos históricamente marginados.
            </p>
            
            <a href="views/vocesporelplaneta.php" class="cta-button">
                <i class="fas fa-paper-plane"></i> ¡Postúlate Ahora!
            </a>
            
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>Financiamiento</h3>
                    <p>USD 1,200 para tu proyecto artístico</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-hands-helping"></i>
                    <h3>Mentoría</h3>
                    <p>Acompañamiento técnico y artístico</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                    <h3>Comunidad</h3>
                    <p>Conecta con otros artistas y activistas</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>
</html> 