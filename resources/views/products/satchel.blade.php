@extends('layouts.app')

@section('title', 'The Artisan Satchel - An Ethical Journey')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background: #FEFDF8;
        color: #2C2416;
        overflow-x: hidden;
    }
    
    .progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #8B7355, #D4AF77);
        width: 0%;
        z-index: 1000;
        transition: width 0.1s ease;
    }
    
    .nav {
        position: fixed;
        top: 0;
        width: 100%;
        padding: 2rem 4rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 999;
        background: linear-gradient(180deg, rgba(254,253,248,0.95) 0%, rgba(254,253,248,0) 100%);
    }
    
    .nav-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-decoration: none;
        color: #2C2416;
    }
    
    .nav-trust {
        font-size: 0.85rem;
        color: #8B7355;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    
    section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 4rem 2rem;
    }
    
    /* Hero Section */
    .hero {
        background: linear-gradient(180deg, #2C2416 0%, #4A3C2A 100%);
        color: #FEFDF8;
        flex-direction: column;
        text-align: center;
    }
    
    .hero-video {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.3;
        filter: grayscale(20%);
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
    }
    
    .hero-subtitle {
        font-size: 0.95rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        margin-bottom: 2rem;
        opacity: 0.8;
    }
    
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 5rem;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 2rem;
    }
    
    .hero-description {
        font-size: 1.25rem;
        line-height: 1.8;
        font-weight: 300;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .scroll-indicator {
        position: absolute;
        bottom: 3rem;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.85rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        opacity: 0.6;
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(-10px); }
    }
    
    /* Origins Section */
    .origins {
        background: #FEFDF8;
        flex-direction: column;
    }
    
    .origins-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        max-width: 1200px;
        width: 100%;
        align-items: center;
    }
    
    .origins-image {
        width: 100%;
        height: 500px;
        background: linear-gradient(135deg, #E5DCC5 0%, #C9B896 100%);
        border-radius: 2px;
        position: relative;
        overflow: hidden;
    }
    
    .origins-image::after {
        content: '🐄';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 4rem;
        opacity: 0.3;
    }
    
    .origins-text h2 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        margin-bottom: 2rem;
        line-height: 1.2;
    }
    
    .origins-text p {
        font-size: 1.1rem;
        line-height: 1.9;
        color: #5A4A3A;
        margin-bottom: 1.5rem;
    }
    
    .origins-stat {
        display: inline-block;
        margin-top: 2rem;
        padding: 1rem 2rem;
        background: #F5F2EA;
        border-left: 3px solid #8B7355;
    }
    
    .origins-stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #8B7355;
    }
    
    .origins-stat-label {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #5A4A3A;
    }
    
    /* Timeline Section */
    .timeline {
        background: #F5F2EA;
        flex-direction: column;
        padding: 8rem 2rem;
    }
    
    .timeline-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        text-align: center;
        margin-bottom: 5rem;
    }
    
    .timeline-container {
        max-width: 1000px;
        width: 100%;
        position: relative;
    }
    
    .timeline-line {
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #D4C4A8;
        transform: translateX(-50%);
    }
    
    .timeline-item {
        display: flex;
        margin-bottom: 4rem;
        position: relative;
    }
    
    .timeline-item:nth-child(even) {
        flex-direction: row-reverse;
    }
    
    .timeline-content {
        width: 45%;
        padding: 2rem;
        background: #FEFDF8;
        border-radius: 2px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    
    .timeline-number {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        color: #D4AF77;
        opacity: 0.3;
        margin-bottom: 1rem;
    }
    
    .timeline-step {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .timeline-description {
        font-size: 1rem;
        line-height: 1.7;
        color: #5A4A3A;
    }
    
    .timeline-dot {
        position: absolute;
        left: 50%;
        top: 2rem;
        width: 16px;
        height: 16px;
        background: #8B7355;
        border: 4px solid #F5F2EA;
        border-radius: 50%;
        transform: translateX(-50%);
    }
    
    /* Ledger Section */
    .ledger {
        background: #2C2416;
        color: #FEFDF8;
        flex-direction: column;
        padding: 8rem 2rem;
    }
    
    .ledger-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .ledger-subtitle {
        text-align: center;
        font-size: 1.1rem;
        opacity: 0.7;
        margin-bottom: 5rem;
        font-style: italic;
    }
    
    .ledger-container {
        max-width: 900px;
        width: 100%;
    }
    
    .ledger-total {
        text-align: center;
        margin-bottom: 4rem;
    }
    
    .ledger-price {
        font-family: 'Playfair Display', serif;
        font-size: 5rem;
        color: #D4AF77;
        font-weight: 700;
    }
    
    .ledger-breakdown {
        background: rgba(255,255,255,0.03);
        border-radius: 2px;
        padding: 3rem;
        backdrop-filter: blur(10px);
    }
    
    .ledger-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .ledger-item:hover {
        padding-left: 1rem;
        background: rgba(212,175,119,0.05);
    }
    
    .ledger-item:last-child {
        border-bottom: none;
    }
    
    .ledger-item-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .ledger-icon {
        font-size: 2rem;
    }
    
    .ledger-item-info h3 {
        font-size: 1.3rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .ledger-item-info p {
        font-size: 0.9rem;
        opacity: 0.6;
        line-height: 1.5;
    }
    
    .ledger-amount {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #D4AF77;
        font-weight: 600;
    }
    
    .ledger-percentage {
        font-size: 1rem;
        opacity: 0.5;
        margin-left: 1rem;
    }
    
    /* Impact Section */
    .impact {
        background: #FEFDF8;
        flex-direction: column;
        padding: 8rem 2rem;
    }
    
    .impact-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        text-align: center;
        margin-bottom: 5rem;
    }
    
    .impact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3rem;
        max-width: 1200px;
        width: 100%;
    }
    
    .impact-card {
        text-align: center;
        padding: 3rem 2rem;
        background: #F5F2EA;
        border-radius: 2px;
        transition: transform 0.3s ease;
    }
    
    .impact-card:hover {
        transform: translateY(-10px);
    }
    
    .impact-icon {
        font-size: 3rem;
        margin-bottom: 1.5rem;
    }
    
    .impact-number {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        color: #8B7355;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .impact-label {
        font-size: 1rem;
        color: #5A4A3A;
        line-height: 1.6;
    }
    
    /* CTA Section */
    .cta {
        background: linear-gradient(135deg, #8B7355 0%, #A68968 100%);
        color: #FEFDF8;
        flex-direction: column;
        text-align: center;
    }
    
    .cta-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        margin-bottom: 2rem;
        line-height: 1.2;
    }
    
    .cta-description {
        font-size: 1.2rem;
        line-height: 1.8;
        margin-bottom: 3rem;
        max-width: 600px;
        opacity: 0.9;
    }
    
    .cta-button {
        display: inline-block;
        padding: 1.5rem 4rem;
        background: #FEFDF8;
        color: #2C2416;
        font-size: 1.1rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 2px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .cta-button:hover {
        background: #D4AF77;
        color: #FEFDF8;
        transform: scale(1.05);
    }
    
    @media (max-width: 768px) {
        .hero-title { font-size: 3rem; }
        .origins-grid { grid-template-columns: 1fr; }
        .timeline-item { flex-direction: column !important; }
        .timeline-content { width: 100%; }
        .timeline-line { display: none; }
        .impact-grid { grid-template-columns: 1fr; }
        .nav { padding: 1rem 2rem; }
    }
</style>
@endpush

@section('content')
    <div class="progress-bar" id="progressBar"></div>
    
    <nav class="nav">
        <a href="{{ route('home') }}" class="nav-logo">ATELIER VÉRIDIQUE</a>
        <div class="nav-trust">Radical Transparency</div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1920' height='1080'%3E%3Crect fill='%234A3C2A' width='1920' height='1080'/%3E%3C/svg%3E" type="video/mp4">
        </video>
        <div class="hero-content">
            <div class="hero-subtitle">The Origin Story</div>
            <h1 class="hero-title">The Artisan Satchel</h1>
            <p class="hero-description">
                From pasture to your hands. A journey of radical transparency through ethical craftsmanship.
            </p>
        </div>
        <div class="scroll-indicator">Scroll to discover ↓</div>
    </section>
    
    <!-- Origins Section -->
    <section class="origins">
        <div class="origins-grid">
            <div class="origins-image"></div>
            <div class="origins-text">
                <h2>Where It All Begins</h2>
                <p>
                    In the rolling hills of Normandy, heritage cattle graze freely on regenerative pastures. This is where our leather begins its journey—not in a factory, but in harmony with nature.
                </p>
                <p>
                    We work exclusively with tanneries that practice vegetable tanning, a 4,000-year-old technique using oak bark and chestnut. The process takes 60 days, compared to 24 hours for chemical tanning. Why? Because beauty should never come at the cost of the earth.
                </p>
                <div class="origins-stat">
                    <div class="origins-stat-number">0%</div>
                    <div class="origins-stat-label">Chrome or toxic chemicals</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Timeline Section -->
    <section class="timeline">
        <h2 class="timeline-title">The Transformation</h2>
        <div class="timeline-container">
            <div class="timeline-line"></div>
            
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-number">01</div>
                    <h3 class="timeline-step">Selection</h3>
                    <p class="timeline-description">
                        Each hide is carefully inspected by master craftsmen. Only 30% meet our exacting standards for grain quality and natural beauty.
                    </p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-number">02</div>
                    <h3 class="timeline-step">Cutting</h3>
                    <p class="timeline-description">
                        Using patterns refined over 40 years, artisans hand-cut each piece to maximize leather usage and minimize waste. Every scrap is repurposed.
                    </p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-number">03</div>
                    <h3 class="timeline-step">Stitching</h3>
                    <p class="timeline-description">
                        3,847 hand stitches using waxed linen thread. Each stitch is a small act of defiance against planned obsolescence. This bag is built to outlive trends.
                    </p>
                </div>
                <div class="timeline-dot"></div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-number">04</div>
                    <h3 class="timeline-step">Finishing</h3>
                    <p class="timeline-description">
                        Edges are burnished, hardware is attached by hand, and the leather receives a final coat of natural beeswax. The entire process takes 18 hours per bag.
                    </p>
                </div>
                <div class="timeline-dot"></div>
            </div>
        </div>
    </section>
    
    <!-- Ledger Section -->
    <section class="ledger">
        <h2 class="ledger-title">The Live Ledger</h2>
        <p class="ledger-subtitle">"With the lamp of truth, we illuminate every euro"</p>
        
        <div class="ledger-container">
            <div class="ledger-total">
                <div class="ledger-price">€420</div>
            </div>
            
            <div class="ledger-breakdown">
                <div class="ledger-item">
                    <div class="ledger-item-left">
                        <div class="ledger-icon">👤</div>
                        <div class="ledger-item-info">
                            <h3>Artisan Compensation</h3>
                            <p>Fair wages for 18 hours of skilled labor at €25/hour</p>
                        </div>
                    </div>
                    <div>
                        <span class="ledger-amount">€168</span>
                        <span class="ledger-percentage">40%</span>
                    </div>
                </div>
                
                <div class="ledger-item">
                    <div class="ledger-item-left">
                        <div class="ledger-icon">🌿</div>
                        <div class="ledger-item-info">
                            <h3>Sustainable Materials</h3>
                            <p>Vegetable-tanned leather, organic linen thread, recycled brass hardware</p>
                        </div>
                    </div>
                    <div>
                        <span class="ledger-amount">€105</span>
                        <span class="ledger-percentage">25%</span>
                    </div>
                </div>
                
                <div class="ledger-item">
                    <div class="ledger-item-left">
                        <div class="ledger-icon">📦</div>
                        <div class="ledger-item-info">
                            <h3>Packaging & Logistics</h3>
                            <p>Plastic-free packaging, carbon-neutral shipping, quality control</p>
                        </div>
                    </div>
                    <div>
                        <span class="ledger-amount">€42</span>
                        <span class="ledger-percentage">10%</span>
                    </div>
                </div>
                
                <div class="ledger-item">
                    <div class="ledger-item-left">
                        <div class="ledger-icon">🏢</div>
                        <div class="ledger-item-info">
                            <h3>Operations</h3>
                            <p>Workshop rent, utilities, equipment maintenance, insurance</p>
                        </div>
                    </div>
                    <div>
                        <span class="ledger-amount">€63</span>
                        <span class="ledger-percentage">15%</span>
                    </div>
                </div>
                
                <div class="ledger-item">
                    <div class="ledger-item-left">
                        <div class="ledger-icon">💡</div>
                        <div class="ledger-item-info">
                            <h3>Brand Margin</h3>
                            <p>Reinvested in R&D, artisan training programs, and sustainable growth</p>
                        </div>
                    </div>
                    <div>
                        <span class="ledger-amount">€42</span>
                        <span class="ledger-percentage">10%</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Impact Section -->
    <section class="impact">
        <h2 class="impact-title">The Impact</h2>
        <div class="impact-grid">
            <div class="impact-card">
                <div class="impact-icon">🌍</div>
                <div class="impact-number">-78%</div>
                <div class="impact-label">Carbon footprint vs. traditional leather goods</div>
            </div>
            
            <div class="impact-card">
                <div class="impact-icon">💧</div>
                <div class="impact-number">-92%</div>
                <div class="impact-label">Water consumption through vegetable tanning</div>
            </div>
            
            <div class="impact-card">
                <div class="impact-icon">♻️</div>
                <div class="impact-number">100%</div>
                <div class="impact-label">Biodegradable materials used throughout</div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta">
        <h2 class="cta-title">Join the Ethical Journey</h2>
        <p class="cta-description">
            This isn't just a purchase. It's a partnership in building a more transparent, sustainable future. Every bag comes with a lifetime repair guarantee.
        </p>
        <a href="{{ route('reservation.personalize') }}" class="cta-button">Reserve Your Satchel</a>
    </section>
@endsection

@push('scripts')
<script>
    // Progress bar
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.getElementById('progressBar').style.width = scrolled + '%';
    });
    
    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.timeline-item, .ledger-item, .impact-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
    
    // Ledger hover effect
    document.querySelectorAll('.ledger-item').forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.style.transform = 'scale(1.02)';
        });
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'scale(1)';
        });
    });
</script>
@endpush