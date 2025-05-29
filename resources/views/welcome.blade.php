<x-guest-layout>
    <div
        class="h-screen w-screen min-h-full max-h-full bg-black flex flex-col items-center justify-center relative overflow-hidden m-0 p-0">
        <!-- Canvas for particle effect -->
        <canvas id="particleCanvas" class="absolute inset-0 z-0"></canvas>
        <!-- Gradient overlay for depth -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/60 via-blue-700/60 to-blue-500/60 z-10"></div>

        <!-- Content container -->
        <div class="text-center z-20 w-full h-full flex flex-col items-center justify-center">
            <h1
                class="text-2xl sm:text-3xl md:text-5xl font-extrabold text-white mb-6 animate-typewriter tracking-tight px-4">
                Empowering Communities with ESYC E-Government
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-white/90 mb-8 animate-fade-in-delay max-w-3xl mx-auto px-4">
                Access emergency support, scholarships, youth services, and virtual assistance—connecting our community
                with innovative e-government solutions.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6 sm:gap-8 animate-fade-in-delay-2 px-4">
                <button onclick="openModal('loginModal')"
                    class="relative bg-blue-600 text-white font-semibold py-4 px-10 rounded-full shadow-xl hover:bg-blue-500 hover:scale-110 transition-all duration-300 overflow-hidden group">
                    <span class="relative z-10">Login</span>
                    <span
                        class="absolute inset-0 bg-blue-400 opacity-0 group-hover:opacity-30 transition-opacity duration-300"></span>
                </button>

                <button
                    class="relative bg-transparent border-2 border-white text-white font-semibold py-4 px-10 rounded-full shadow-xl hover:bg-white hover:text-blue-600 hover:scale-110 transition-all duration-300 group">
                    <span class="relative z-10">Sign Up</span>
                    <span
                        class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                </button>
            </div>
        </div>
        <!-- Login Modal -->
        <div id="loginModal"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md relative animate-fade-in">
                <button onclick="closeModal('loginModal')"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl font-bold">&times;</button>
                <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Login</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                            id="email" placeholder="Enter your email" name="email" value="{{ old('email') }}"
                            required>
                        <label for="email">Email Address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror"
                            id="password" placeholder="Enter your password" name="password" required>
                        <label for="password">Password</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="text-decoration-none text-primary">Forgot password?</a>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 gap-1">
                        <button type="submit" class="btn btn-primary w-50 py-3 rounded-3 fw-semibold">
                            Login
                        </button>
                        <button type="button" class="btn btn-secondary w-50 py-3 rounded-3 fw-semibold"
                            onclick="closeModal('loginModal')">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Particle effect JavaScript -->
        <script>
            const canvas = document.getElementById('particleCanvas');
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const particles = [];
            const particleCount = 100;

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 3 + 1;
                    this.speedX = Math.random() * 0.5 - 0.25;
                    this.speedY = Math.random() * 0.5 - 0.25;
                    this.opacity = Math.random() * 0.5 + 0.3;
                }

                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
                }

                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(255, 255, 255, ${this.opacity})`;
                    ctx.fill();
                }
            }

            function initParticles() {
                for (let i = 0; i < particleCount; i++) {
                    particles.push(new Particle());
                }
            }

            function animateParticles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(particle => {
                    particle.update();
                    particle.draw();
                });
                requestAnimationFrame(animateParticles);
            }

            initParticles();
            animateParticles();

            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        </script>

        <!-- Custom CSS for animations -->
        <style>
            @keyframes typewriter {
                from {
                    width: 0;
                    opacity: 0;
                }

                50% {
                    opacity: 1;
                }

                to {
                    width: 100%;
                    opacity: 1;
                }
            }

            @keyframes fadeInDelay {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInDelay2 {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-typewriter {
                animation: typewriter 2s ease-out forwards;
                overflow: hidden;
                white-space: nowrap;
                display: inline-block;
            }

            .animate-fade-in-delay {
                animation: fadeInDelay 1s ease-out 0.5s forwards;
                opacity: 0;
            }

            .animate-fade-in-delay-2 {
                animation: fadeInDelay2 1s ease-out 1s forwards;
                opacity: 0;
            }

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                height: 100%;
                width: 100%;
                overflow: hidden;
                box-sizing: border-box;
            }

            * {
                box-sizing: border-box;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.3s ease-out;
            }
        </style>

        <script>
            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }
        </script>

</x-guest-layout>
