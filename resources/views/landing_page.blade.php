<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atelier Véridique | Ethical Leather Goods</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Vite CSS -->
    @vite(['resources/css/landing_page.css'])
</head>
<body>
    <!-- Navigation -->
    <nav class="nav">
        <a href="{{ url('/') }}" class="nav-logo">ATELIER VÉRIDIQUE</a>
        <div class="nav-menu">
            <a href="#story" class="nav-link">Our Story</a>
            <a href="#craftsmanship" class="nav-link">Craftsmanship</a>
            <a href="#transparency" class="nav-link">Transparency</a>
            <a href="{{ route('products.satchel') }}" class="nav-link">The Satchel</a>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-video"></div>
        <div class="hero-content">
            <div class="hero-subtitle">Radical Transparency in Craftsmanship</div>
            <h1 class="hero-title animate-in">Where Ethics Meet Artistry</h1>
            <p class="hero-description animate-in">
                Each piece tells a story of sustainable materials, fair artisan wages, 
                and uncompromising quality. Discover leather goods that are built to last 
                a lifetime, not just a season.
            </p>
            <div class="hero-buttons animate-in">
                <a href="{{ route('products.satchel') }}" class="btn-primary">Explore The Satchel</a>
                <a href="#story" class="btn-secondary">Discover Our Story</a>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features" id="story">
        <h2 class="section-title animate-in">Our Commitments</h2>
        <div class="features-grid">
            <div class="feature-card animate-in">
                <div class="feature-icon">🌱</div>
                <h3 class="feature-title">Sustainable Materials</h3>
                <p class="feature-description">
                    100% vegetable-tanned leather from regenerative farms. No chrome, no toxins, 
                    just pure natural beauty that ages gracefully.
                </p>
            </div>
            
            <div class="feature-card animate-in" style="animation-delay: 0.2s">
                <div class="feature-icon">👐</div>
                <h3 class="feature-title">Fair Artisan Wages</h3>
                <p class="feature-description">
                    40% of every purchase goes directly to our artisans, ensuring living wages 
                    and preserving traditional craftsmanship for generations.
                </p>
            </div>
            
            <div class="feature-card animate-in" style="animation-delay: 0.4s">
                <div class="feature-icon">🔧</div>
                <h3 class="feature-title">Lifetime Guarantee</h3>
                <p class="feature-description">
                    Every piece comes with free lifetime repairs. We believe in creating 
                    heirlooms, not disposable fashion.
                </p>
            </div>
        </div>
    </section>
    
    <!-- Product Preview -->
    <section class="product-preview" id="craftsmanship">
        <div class="product-content">
            <div class="product-image animate-in">
                Handcrafted Excellence
            </div>
            <div class="product-info animate-in" style="animation-delay: 0.3s">
                <h2>The Artisan Satchel</h2>
                <p>
                    Crafted over 18 hours by master artisans using techniques refined over 
                    four decades. Each satchel features 3,847 hand stitches and develops 
                    a unique patina that tells your story.
                </p>
                <p>
                    From pasture to workshop, we illuminate every step of the journey. 
                    Our Live Ledger shows exactly where every euro goes.
                </p>
                <div class="hero-buttons" style="justify-content: flex-start; margin-top: 2rem;">
                    <a href="{{ route('products.satchel') }}" class="btn-primary">Discover the Journey</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section" id="transparency">
        <h2 class="cta-title animate-in">Ready to Invest in Craftsmanship?</h2>
        <p class="cta-description animate-in">
            Join over 2,000 conscious customers who have chosen quality over quantity, 
            ethics over expediency, and craftsmanship over mass production.
        </p>
        <div class="hero-buttons animate-in">
            <a href="{{ route('products.satchel') }}" class="btn-primary">Begin Your Journey</a>
            <a href="{{ route('reservation.personalize') }}" class="btn-secondary">Start Customizing</a>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <a href="#story" class="footer-link">Our Story</a>
            <a href="#craftsmanship" class="footer-link">Artisan Profiles</a>
            <a href="#transparency" class="footer-link">Sustainability Report</a>
            <a href="#" class="footer-link">Contact</a>
            <a href="#" class="footer-link">FAQ</a>
        </div>
        <p class="footer-copyright">
            © {{ date('Y') }} Atelier Véridique. Handcrafted in France. Each piece tells a story.
        </p>
    </footer>
    
    <!-- Vite JS -->
    @vite(['resources/js/landing_page.js'])
</body>
</html>