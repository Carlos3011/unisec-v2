<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estamos trabajando en la nueva versión</title>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #0a0f1a;
            position: relative;
            overflow: hidden;
        }
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .message {
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 2;
            position: relative;
            transition: all 0.3s ease;
        }
        .message:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .message img {
            width: 180px;
            height: auto;
            margin: 1.5rem 0;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
            transition: filter 0.3s ease;
        }
        .message img:hover {
            filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.5));
        }
        h1 {
            color: #fff;
            font-size: 2.75em;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            letter-spacing: -0.5px;
            animation: pulse 2s infinite;
        }
        p {
            color: #d1d1d1;
            font-size: 1.4em;
            line-height: 1.6;
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto;
        }
        @keyframes pulse {
            0% { text-shadow: 0 0 15px rgba(255, 255, 255, 0.4); }
            50% { text-shadow: 0 0 25px rgba(255, 255, 255, 0.6); }
            100% { text-shadow: 0 0 15px rgba(255, 255, 255, 0.4); }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="particles-js"></div>
    <div class="message">
        <h1>¡Estamos trabajando en la nueva versión!</h1>
        <img src="logo.png" alt="UNISEC">
        <p>Pronto estaremos listos con una nueva experiencia.</p>
    </div>
    <script>
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 100,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#ffffff'
                },
                shape: {
                    type: 'circle'
                },
                opacity: {
                    value: 0.5,
                    random: true
                },
                size: {
                    value: 3,
                    random: true
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: true,
                    out_mode: 'out'
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'grab'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    },
                    resize: true
                }
            },
            retina_detect: true
        });
    </script>
</body>
</html>
