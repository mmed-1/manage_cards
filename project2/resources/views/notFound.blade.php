<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 100%);
            color: #fff;
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Floating particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(138, 43, 226, 0.2);
            pointer-events: none;
        }

        /* Main content */
        .container {
            text-align: center;
            z-index: 10;
            padding: 2rem;
            position: relative;
        }

        .error-code {
            font-size: 12rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 1rem;
            position: relative;
            background: linear-gradient(to right, #9c27b0, #e91e63);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: pulse 5s infinite ease-in-out;
            text-shadow: 0 0 20px rgba(156, 39, 176, 0.3);
        }

        .error-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            animation: fadeIn 1s ease-out 0.3s both;
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            color: #b8b8d4;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeIn 1s ease-out 0.9s both;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(to right, #9c27b0, #e91e63);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(156, 39, 176, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(156, 39, 176, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: #9c27b0;
            border: 2px solid #9c27b0;
        }

        .btn-secondary:hover {
            background: rgba(156, 39, 176, 0.1);
            transform: translateY(-3px);
        }

        /* Cursor follower */
        .cursor-follower {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(156, 39, 176, 0.2) 0%, rgba(233, 30, 99, 0.1) 50%, transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            filter: blur(40px);
            z-index: 0;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        /* Glitch effect */
        .glitch {
            position: relative;
        }

        .glitch::before,
        .glitch::after {
            content: "404";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, #9c27b0, #e91e63);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .glitch::before {
            left: 2px;
            text-shadow: -2px 0 #00ffff;
            animation: glitch-anim-1 2s infinite linear alternate-reverse;
        }

        .glitch::after {
            left: -2px;
            text-shadow: 2px 0 #ff00ff;
            animation: glitch-anim-2 3s infinite linear alternate-reverse;
        }

        /* Animations */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes glitch-anim-1 {
            0% {
                clip-path: inset(20% 0 80% 0);
            }
            20% {
                clip-path: inset(60% 0 1% 0);
            }
            40% {
                clip-path: inset(25% 0 58% 0);
            }
            60% {
                clip-path: inset(94% 0 2% 0);
            }
            80% {
                clip-path: inset(36% 0 38% 0);
            }
            100% {
                clip-path: inset(82% 0 2% 0);
            }
        }

        @keyframes glitch-anim-2 {
            0% {
                clip-path: inset(59% 0 43% 0);
            }
            20% {
                clip-path: inset(22% 0 68% 0);
            }
            40% {
                clip-path: inset(16% 0 79% 0);
            }
            60% {
                clip-path: inset(5% 0 53% 0);
            }
            80% {
                clip-path: inset(63% 0 3% 0);
            }
            100% {
                clip-path: inset(14% 0 31% 0);
            }
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .error-code {
                font-size: 8rem;
            }
            
            .error-title {
                font-size: 2rem;
            }
            
            .buttons {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .error-code {
                font-size: 6rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-message {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>
    <div class="cursor-follower" id="cursor-follower"></div>
    
    <div class="container">
        <h1 class="error-code glitch">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        <p class="error-message"> La page que vous recherchez a peut-être été supprimée, son nom a changé ou elle est temporairement indisponible.</p>
        
        {{-- <div class="buttons">
            <button class="btn btn-primary" onclick="window.location.href='/'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <a href="{{ route('home') }}" style="text-decoration: none">Go Home</a>
            </button>
        </div> --}}
    </div>

    <script>
        // Create floating particles
        const particlesContainer = document.getElementById('particles');
        const particleCount = 20;
        
        for (let i = 0; i < particleCount; i++) {
            createParticle();
        }
        
        function createParticle() {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Random size between 10px and 80px
            const size = Math.random() * 70 + 10;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            
            // Random position
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            particle.style.left = `${posX}%`;
            particle.style.top = `${posY}%`;
            
            // Random opacity
            particle.style.opacity = (Math.random() * 0.5 + 0.1).toString();
            
            // Animation
            const duration = Math.random() * 20 + 10;
            const delay = Math.random() * 5;
            particle.style.animation = `float ${duration}s ease-in-out ${delay}s infinite`;
            
            particlesContainer.appendChild(particle);
            
            // Set random movement
            animateParticle(particle);
        }
        
        function animateParticle(particle) {
            const startX = parseFloat(particle.style.left);
            const startY = parseFloat(particle.style.top);
            const moveRange = 10; // percentage of viewport
            
            setInterval(() => {
                const newX = startX + (Math.random() * moveRange * 2 - moveRange);
                const newY = startY + (Math.random() * moveRange * 2 - moveRange);
                
                particle.style.left = `${Math.max(0, Math.min(100, newX))}%`;
                particle.style.top = `${Math.max(0, Math.min(100, newY))}%`;
            }, 5000);
        }
        
        // Cursor follower effect
        const cursorFollower = document.getElementById('cursor-follower');
        
        document.addEventListener('mousemove', (e) => {
            cursorFollower.style.opacity = '1';
            cursorFollower.style.left = `${e.clientX}px`;
            cursorFollower.style.top = `${e.clientY}px`;
        });
        
        document.addEventListener('mouseleave', () => {
            cursorFollower.style.opacity = '0';
        });
        
        // Button hover effects
        const buttons = document.querySelectorAll('.btn');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-3px)';
            });
            
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0)';
            });
            
            button.addEventListener('click', () => {
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 100);
            });
        });
        
        // Add 3D tilt effect to 404 text
        const errorCode = document.querySelector('.error-code');
        
        document.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            const tiltX = (y - 0.5) * 10; // -5 to 5 degrees
            const tiltY = (0.5 - x) * 10; // -5 to 5 degrees
            
            errorCode.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale(1.05)`;
        });
        
        document.addEventListener('mouseleave', () => {
            errorCode.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
        });
    </script>
</body>
</html>