import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // 🌌 Primarios - Azul institucional (inspirado en trajes espaciales y naves)
                primary: {
                  100: '#E6F0FF', // Azul Aurora (fondos claros)
                  300: '#0066CC', // Azul Propulsión
                  500: '#004080', // Azul Ionizante
                  700: '#001A3A', // Azul Profundo Espacial
                  DEFAULT: '#002D62'  // Azul Orbital (NASA Blue)
                },
              
                // 🚀 Secundarios - Naranjas de ingeniería (inspirados en cohetes)
                secondary: {
                  100: '#FFF0E6', // Naranja Amanecer (fondos claros)
                  300: '#FFB366', // Naranja Atmósfera
                  500: '#FF8C00', // Naranja Ignición
                  700: '#CC4500', // Naranja Combustión
                  DEFAULT: '#FF5800'  // Naranja Cohete
                },
              
                // 🌠 Colores técnicos y de alta visibilidad
                accent: {
                  100: '#B3E9F2', // Cian Nebular (Suave)
                  300: '#00B4D8', // Cian Astronauta
                  500: '#0096C7', // Azul Traje Espacial
                  700: '#FF443A', // Rojo Alerta (Sistemas Críticos)
                  900: '#FFD700'  // Oro Estelar (Advertencias)
                },
              
                // 🛰️ Escala de Grises Tecnológicos
                tech: {
                  100: '#F8F9FC', // Gris Nube Lunar (fondos)
                  300: '#D1D5DB', // Gris Antena
                  500: '#6C7180', // Gris Panel de Control
                  700: '#2B2D35', // Gris Cápsula
                  DEFAULT: '#4A4E5B'  // Gris Satélite
                },
              
                // 🌑 Fondos Espaciales Profundos
                cosmic: {
                  100: '#1A1F34', // Nebulosa Galáctica
                  300: '#0A0F1D', // Negro Cosmos
                  500: '#060912', // Negro Agujero de Gusano
                  700: '#02050B', // Negro Interestelar
                  DEFAULT: '#000000'  // Negro Absoluto
                },
              
                // ✨ Nueva categoría: Colores espaciales inspirados en galaxias y nebulosas
                galactic: {
                  100: '#F4E1FF', // Rosa Nebular
                  300: '#B05EFF', // Púrpura Cuásar
                  500: '#6829C3', // Violeta Pulsar
                  700: '#3D1A7E', // Azul Oscuro Estelar
                  900: '#1C0F42'  // Indigo Interestelar
                }
              },
            backgroundColor: theme => ({
                ...theme('colors'),
                'gradient-primary': 'linear-gradient(135deg, #0047AB 0%, #002D6D 100%)',
                'gradient-secondary': 'linear-gradient(135deg, #FF6B00 0%, #CC5500 100%)',
            }),
            textColor: {
                'primary': '#F4F8FF',      // Blanco para legibilidad
                'secondary': '#C4C9E2',    // Gris claro para descripciones
                'accent': '#00E0FF',       // Azul eléctrico para resaltar
                'danger': '#FF4C4C',       // Rojo para alertas
            },
            borderColor: theme => ({
                ...theme('colors'),
                'primary': '#0047AB',
                'secondary': '#FF6B00',
                'gray': '#A1A6B4',
            }),
            animation: {
                'pulse-thrust': 'pulse-thrust 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'nebula-flow': 'nebula-flow 4s alternate infinite',
                'hover-glow': 'hover-glow 3s ease-in-out infinite',
            },
            keyframes: {
                'pulse-thrust': {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.5' }
                },
                'nebula-flow': {
                    'from': { 'background-position': '0% 50%' },
                    'to': { 'background-position': '100% 50%' }
                },
                'hover-glow': {
                    '0%, 100%': { textShadow: '0 0 10px rgba(69, 161, 255, 0.8)' },
                    '50%': { textShadow: '0 0 20px rgba(69, 161, 255, 1)' }
                }
            },
            backdropBlur: {
                'cosmic': '15px'
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        function({ addUtilities }) {
            addUtilities({
                '.aero-glow': {
                    'box-shadow': '0 0 15px rgba(69, 161, 255, 0.4)'
                },
                '.space-gradient': {
                    'background-image': 'linear-gradient(45deg, #0047AB 0%, #002D6D 50%, #0A1128 100%)'
                },
                '.ion-thrust': {
                    'background-image': 'linear-gradient(90deg, #00E0FF 0%, #0047AB 100%)'
                }
            })
        }
    ],
};
