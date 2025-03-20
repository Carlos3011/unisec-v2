<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estamos trabajando en la nueva versión</title>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #0a0f1a 0%, #1a1f2e 100%);
            position: relative;
            overflow: hidden;
        }

        .message {
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 2;
            position: relative;
            max-width: 600px;
            width: 90%;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            color: #fff;
            font-size: 2.8em;
            margin-bottom: 30px;
            text-shadow: 0 0 15px rgba(255,255,255,0.3);
            font-weight: 600;
            letter-spacing: -1px;
        }

        img {
            max-width: 500px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.05);
        }

        p {
            color: #d1d1d1;
            font-size: 1.4em;
            line-height: 1.6;
            font-weight: 300;
            margin: 25px 0;
        }

        #countdown {
            background: rgba(76, 175, 80, 0.1);
            padding: 20px;
            border-radius: 15px;
            color: #4CAF50;
            font-size: 2.2em;
            margin: 30px 0;
            font-weight: bold;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .timer-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255,255,255,0.05);
            padding: 15px;
            border-radius: 10px;
            min-width: 80px;
            transition: transform 0.3s ease;
        }

        .timer-section:hover {
            transform: translateY(-5px);
        }

        .timer-label {
            color: #a0a0a0;
            font-size: 0.4em;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            .message {
                padding: 30px;
                margin: 20px;
            }
            h1 {
                font-size: 2em;
            }
            #countdown {
                font-size: 1.8em;
            }
            .timer-section {
                min-width: 60px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="message">
        <h1>¡Estamos trabajando en la nueva imagen!</h1>
        <img src="logo.png" alt="UNISEC">
        <h1>Tiempo restante de mantenimiento</h1>
        <div id="countdown">
            <div class="timer-section">
                <span id="days">00</span>
                <div class="timer-label">Días</div>
            </div>
            <div class="timer-section">
                <span id="hours">00</span>
                <div class="timer-label">Horas</div>
            </div>
            <div class="timer-section">
                <span id="minutes">00</span>
                <div class="timer-label">Minutos</div>
            </div>
            <div class="timer-section">
                <span id="seconds">00</span>
                <div class="timer-label">Segundos</div>
            </div>
        </div>
        <h1>Pronto estaremos listos con una nueva experiencia.</h1>
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

        // Add countdown timer script
        const endDate = new Date('2025-03-20T18:00:00').getTime(); // Set your target date/time here

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = endDate - now;

            if (timeLeft <= 0) {
                document.getElementById('countdown').innerHTML = '<span style="color: #4CAF50;">¡Mantenimiento completado!</span>';
                return;
            }

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>
</html>
