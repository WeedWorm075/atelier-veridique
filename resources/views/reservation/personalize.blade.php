@extends('layouts.app')

@section('title', 'Reserve Your Artisan Satchel - Personalization')

@push('styles')
<style>
    /* Navigation */
    .nav {
        position: fixed;
        top: 0;
        width: 100%;
        padding: 1.5rem 4rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 999;
        background: rgba(254, 253, 248, 0.98);
        border-bottom: 1px solid var(--border-light);
        backdrop-filter: blur(10px);
    }
    
    .nav-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        letter-spacing: 1px;
        color: var(--primary-dark);
        text-decoration: none;
    }
    
    .nav-back {
        font-size: 0.9rem;
        color: var(--accent-tan);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .nav-back:hover {
        color: var(--primary-dark);
    }
    
    .nav-trust {
        font-size: 0.85rem;
        color: var(--accent-tan);
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    
    /* Main Container - Revised Structure */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 8rem 2rem 4rem;
        display: grid;
        grid-template-columns: 1fr;
        gap: 4rem;
    }
    
    /* Customization Grid */
    .customization-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 4rem;
        align-items: start;
    }
    
    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 4rem;
        position: relative;
    }
    
    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary-dark);
    }
    
    .page-subtitle {
        font-size: 1.2rem;
        color: var(--neutral-medium);
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Customization Column */
    .customization-column {
        display: flex;
        flex-direction: column;
        gap: 4rem;
    }
    
    /* Customization Section */
    .customization-section {
        background: var(--primary-light);
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 2.5rem;
        transition: all 0.3s ease;
    }
    
    .customization-section:hover {
        border-color: var(--border-medium);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--neutral-light);
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--primary-dark);
    }
    
    .section-price {
        font-size: 1.3rem;
        color: var(--accent-gold);
        font-weight: 600;
    }
    
    .section-description {
        color: var(--neutral-medium);
        margin-bottom: 2rem;
        line-height: 1.8;
    }
    
    /* Option Grids */
    .option-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .option-card {
        border: 2px solid var(--border-light);
        border-radius: 6px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .option-card:hover {
        border-color: var(--accent-tan);
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(44, 36, 22, 0.1);
    }
    
    .option-card.selected {
        border-color: var(--accent-gold);
        background: linear-gradient(to bottom, rgba(212, 175, 119, 0.05), rgba(212, 175, 119, 0.02));
        box-shadow: 0 4px 20px rgba(212, 175, 119, 0.15);
    }
    
    .option-color {
        width: 100%;
        height: 120px;
        border-radius: 4px;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .option-color::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 0%, rgba(255,255,255,0.2) 100%);
    }
    
    .color-heritage {
        background: linear-gradient(135deg, #2C2416 0%, #4A3C2A 100%);
    }
    
    .color-chestnut {
        background: linear-gradient(135deg, #8B7355 0%, #A68968 100%);
    }
    
    .color-walnut {
        background: linear-gradient(135deg, #5A4A3A 0%, #7A6A5A 100%);
    }
    
    .option-card-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--primary-dark);
    }
    
    .option-card-desc {
        font-size: 0.9rem;
        color: var(--neutral-medium);
        line-height: 1.6;
        flex-grow: 1;
    }
    
    /* Hardware Options */
    .hardware-option {
        text-align: center;
        padding: 1.5rem;
    }
    
    .hardware-icon {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Monogram Section */
    .monogram-section {
        background: var(--neutral-light);
        border-radius: 8px;
        padding: 2.5rem;
        margin-top: 1rem;
    }
    
    .monogram-input-group {
        display: flex;
        gap: 1rem;
        margin: 2rem 0;
        justify-content: center;
    }
    
    .monogram-input {
        width: 80px;
        height: 80px;
        border: 2px solid var(--border-medium);
        background: var(--primary-light);
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        text-align: center;
        text-transform: uppercase;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .monogram-input:focus {
        outline: none;
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 3px rgba(212, 175, 119, 0.2);
    }
    
    .monogram-preview {
        text-align: center;
        padding: 2rem;
        background: var(--primary-light);
        border-radius: 8px;
        margin-top: 2rem;
    }
    
    .preview-monogram {
        color: var(--accent-gold);
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 600;
        letter-spacing: 2px;
        margin-bottom: 1rem;
    }
    
    /* Fixed Order Summary */
    .order-summary-fixed {
        position: sticky;
        top: 120px;
        background: var(--primary-light);
        border: 1px solid var(--border-medium);
        border-radius: 12px;
        padding: 2.5rem;
        box-shadow: 0 8px 40px rgba(44, 36, 22, 0.1);
        overflow: hidden;
    }
    
    .summary-header {
        text-align: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--neutral-light);
        position: relative;
    }
    
    .summary-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 25%;
        width: 50%;
        height: 2px;
        background: var(--accent-gold);
    }
    
    .summary-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .summary-subtitle {
        color: var(--neutral-medium);
        font-size: 0.9rem;
    }
    
    .summary-items {
        margin-bottom: 2rem;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-light);
    }
    
    .summary-item:last-child {
        border-bottom: none;
    }
    
    .item-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .item-icon {
        font-size: 1.2rem;
        opacity: 0.8;
    }
    
    .item-price {
        font-weight: 600;
        color: var(--accent-tan);
    }
    
    .summary-total {
        background: linear-gradient(135deg, var(--neutral-light) 0%, rgba(245, 242, 234, 0.5) 100%);
        border-radius: 8px;
        padding: 1.5rem;
        margin: 2rem 0;
        border: 1px solid var(--border-light);
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .total-label {
        font-size: 1.2rem;
        font-weight: 500;
    }
    
    .total-price {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: var(--accent-gold);
        font-weight: 700;
    }
    
    /* Production Timeline */
    .production-timeline {
        background: rgba(139, 115, 85, 0.05);
        border-radius: 8px;
        padding: 1.5rem;
        margin: 2rem 0;
        border: 1px solid var(--border-light);
    }
    
    .timeline-title {
        font-weight: 600;
        color: var(--accent-tan);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .timeline-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding-top: 0.5rem;
    }
    
    .timeline-steps::before {
        content: '';
        position: absolute;
        top: 12px;
        left: 12px;
        right: 12px;
        height: 2px;
        background: var(--border-light);
    }
    
    .timeline-step {
        position: relative;
        text-align: center;
        flex: 1;
    }
    
    .step-number {
        width: 24px;
        height: 24px;
        background: var(--primary-light);
        border: 2px solid var(--accent-tan);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--accent-tan);
        position: relative;
        z-index: 2;
    }
    
    .step-label {
        font-size: 0.75rem;
        color: var(--neutral-medium);
        line-height: 1.3;
    }
    
    /* Reserve Button */
    .reserve-cta {
        width: 100%;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--accent-tan) 0%, #A68968 100%);
        color: var(--primary-light);
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .reserve-cta:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #4A3C2A 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(44, 36, 22, 0.2);
    }
    
    .cta-price {
        font-size: 1.4rem;
        font-weight: 700;
        margin-left: 0.5rem;
    }
    
    /* Checkout Form */
    .checkout-note {
        background: rgba(212, 175, 119, 0.05);
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 2rem;
        text-align: center;
        border: 1px solid rgba(212, 175, 119, 0.2);
    }
    
    .note-text {
        color: var(--neutral-medium);
        font-size: 0.9rem;
        line-height: 1.6;
    }
    
    /* Footer */
    .footer {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 1px solid var(--neutral-light);
        text-align: center;
        color: var(--neutral-medium);
        font-size: 0.9rem;
    }
    
    .footer-links {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 2rem;
        margin-bottom: 1rem;
    }
    
    .footer-link {
        color: var(--accent-tan);
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.9rem;
    }
    
    .footer-link:hover {
        color: var(--primary-dark);
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .customization-grid {
            grid-template-columns: 1fr;
            gap: 3rem;
        }
        
        .order-summary-fixed {
            position: static;
            margin-top: 2rem;
        }
    }
    
    @media (max-width: 768px) {
        .nav {
            padding: 1rem 2rem;
        }
        
        .main-container {
            padding: 6rem 1rem 2rem;
        }
        
        .page-title {
            font-size: 2.5rem;
        }
        
        .customization-section {
            padding: 1.5rem;
        }
        
        .option-grid {
            grid-template-columns: 1fr;
        }
        
        .monogram-input-group {
            gap: 0.5rem;
        }
        
        .monogram-input {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .order-summary-fixed {
            padding: 1.5rem;
        }
        
        .timeline-steps {
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .timeline-step {
            flex: 0 0 calc(50% - 0.5rem);
        }
        
        .footer-links {
            flex-direction: column;
            gap: 1rem;
        }
    }
    
    @media (max-width: 480px) {
        .timeline-step {
            flex: 0 0 100%;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .timeline-steps::before {
            display: none;
        }
    }
    
    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--neutral-light);
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--accent-tan);
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: var(--accent-gold);
    }
</style>
@endpush

@section('content')
    <nav class="nav">
        <a href="{{ route('home') }}" class="nav-logo">ATELIER VÉRIDIQUE</a>
        <a href="{{ route('products.satchel') }}" class="nav-back">
            ← Back to Journey
        </a>
        <div class="nav-trust">Personalization</div>
    </nav>
    
    <main class="main-container">
        <header class="page-header animate-in">
            <h1 class="page-title">Craft Your Satchel</h1>
            <p class="page-subtitle">
                Each choice reflects our commitment to transparency and craftsmanship. 
                Your satchel will be handcrafted to order, beginning within 48 hours of reservation.
            </p>
        </header>
        
        <!-- Revised Grid Structure -->
        <div class="customization-grid">
            <!-- Left Column: Customization -->
            <div class="customization-column">
                <!-- Leather Section -->
                <section class="customization-section animate-in" style="animation-delay: 0.1s">
                    <div class="section-header">
                        <h2 class="section-title">Leather Selection</h2>
                        <div class="section-price">Included</div>
                    </div>
                    <p class="section-description">
                        Choose from our range of naturally tanned leathers, each developing a unique patina over time.
                    </p>
                    
                    <div class="option-grid">
                        <div class="option-card selected" onclick="selectOption(this, 'leather')" data-value="heritage" data-label="Heritage Brown Leather">
                            <div class="option-color color-heritage"></div>
                            <div class="option-card-label">Heritage Brown</div>
                            <div class="option-card-desc">Classic full-grain, develops rich character over decades</div>
                        </div>
                        
                        <div class="option-card" onclick="selectOption(this, 'leather')" data-value="chestnut" data-label="Chestnut Leather">
                            <div class="option-color color-chestnut"></div>
                            <div class="option-card-label">Chestnut</div>
                            <div class="option-card-desc">Medium tan with warm undertones, ages to honey tones</div>
                        </div>
                        
                        <div class="option-card" onclick="selectOption(this, 'leather')" data-value="walnut" data-label="Walnut Leather">
                            <div class="option-color color-walnut"></div>
                            <div class="option-card-label">Walnut</div>
                            <div class="option-card-desc">Deep brown with chocolate hues, formal and distinguished</div>
                        </div>
                    </div>
                </section>
                
                <!-- Hardware Section -->
                <section class="customization-section animate-in" style="animation-delay: 0.2s">
                    <div class="section-header">
                        <h2 class="section-title">Hardware & Details</h2>
                        <div class="section-price">Included</div>
                    </div>
                    <p class="section-description">
                        Select hardware that complements your leather choice and personal style.
                    </p>
                    
                    <div class="option-grid">
                        <div class="option-card" onclick="selectOption(this, 'hardware')" data-value="polished" data-label="Polished Brass Hardware">
                            <div class="hardware-option">
                                <div class="hardware-icon">✨</div>
                                <div class="option-card-label">Polished Brass</div>
                                <div class="option-card-desc">Classic shine, develops natural patina over time</div>
                            </div>
                        </div>
                        
                        <div class="option-card selected" onclick="selectOption(this, 'hardware')" data-value="antique" data-label="Antique Brass Hardware">
                            <div class="hardware-option">
                                <div class="hardware-icon">🛡️</div>
                                <div class="option-card-label">Antique Brass</div>
                                <div class="option-card-desc">Matte finish with vintage appeal, pre-aged look</div>
                            </div>
                        </div>
                        
                        <div class="option-card" onclick="selectOption(this, 'hardware')" data-value="blackened" data-label="Blackened Steel Hardware">
                            <div class="hardware-option">
                                <div class="hardware-icon">⚫</div>
                                <div class="option-card-label">Blackened Steel</div>
                                <div class="option-card-desc">Modern, durable finish with industrial character</div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Monogram Section -->
                <section class="monogram-section animate-in" style="animation-delay: 0.3s">
                    <div class="section-header">
                        <h2 class="section-title">Personal Monogram</h2>
                        <div class="section-price">+ €25</div>
                    </div>
                    <p class="section-description">
                        Add initials to make your satchel uniquely yours. Hand-stamped by our artisans.
                    </p>
                    
                    <div class="monogram-input-group">
                        <input type="text" maxlength="1" class="monogram-input" placeholder="F" oninput="updateMonogram()" id="initialFirst">
                        <input type="text" maxlength="1" class="monogram-input" placeholder="•" readonly>
                        <input type="text" maxlength="1" class="monogram-input" placeholder="L" oninput="updateMonogram()" id="initialLast">
                    </div>
                    
                    <div class="monogram-preview">
                        <div class="preview-monogram" id="monogramPreview">F•L</div>
                        <p><strong>Hand-Stamped Process:</strong> Each letter is individually stamped using traditional brass dies, creating a subtle impression that deepens with time.</p>
                    </div>
                </section>
            </div>
            
            <!-- Right Column: Order Summary -->
            <div class="order-summary-fixed animate-in" style="animation-delay: 0.4s">
                <div class="summary-header">
                    <h2 class="summary-title">Your Satchel</h2>
                    <p class="summary-subtitle">Summary & Reservation</p>
                </div>
                
                <div class="summary-items">
                    <div class="summary-item">
                        <div class="item-label">
                            <span class="item-icon">🎒</span>
                            <span>Artisan Satchel</span>
                        </div>
                        <span class="item-price">€420</span>
                    </div>
                    
                    <div class="summary-item">
                        <div class="item-label">
                            <span class="item-icon">🧥</span>
                            <span id="leatherLabel">Heritage Brown Leather</span>
                        </div>
                        <span class="item-price">Included</span>
                    </div>
                    
                    <div class="summary-item">
                        <div class="item-label">
                            <span class="item-icon">⚙️</span>
                            <span id="hardwareLabel">Antique Brass Hardware</span>
                        </div>
                        <span class="item-price">Included</span>
                    </div>
                    
                    <div class="summary-item">
                        <div class="item-label">
                            <span class="item-icon">✏️</span>
                            <span id="monogramLabel">Personal Monogram</span>
                        </div>
                        <span class="item-price" id="monogramPrice">+ €25</span>
                    </div>
                    
                    <div class="summary-item">
                        <div class="item-label">
                            <span class="item-icon">🔧</span>
                            <span>Lifetime Repair Guarantee</span>
                        </div>
                        <span class="item-price">Included</span>
                    </div>
                </div>
                
                <div class="summary-total">
                    <div class="total-row">
                        <span class="total-label">Total Investment</span>
                        <span class="total-price" id="totalPrice">€445</span>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--neutral-medium); text-align: center; margin-top: 0.5rem;">
                        VAT included • Free shipping
                    </p>
                </div>
                
                <div class="production-timeline">
                    <div class="timeline-title">
                        ⏳ Production Timeline: 3-4 weeks
                    </div>
                    <div class="timeline-steps">
                        <div class="timeline-step">
                            <div class="step-number">1</div>
                            <div class="step-label">Reservation</div>
                        </div>
                        <div class="timeline-step">
                            <div class="step-number">2</div>
                            <div class="step-label">Crafting</div>
                        </div>
                        <div class="timeline-step">
                            <div class="step-number">3</div>
                            <div class="step-label">Finishing</div>
                        </div>
                        <div class="timeline-step">
                            <div class="step-number">4</div>
                            <div class="step-label">Delivery</div>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('checkout.confirmation') }}" method="POST">
                    @csrf
                    <input type="hidden" name="leather" value="heritage">
                    <input type="hidden" name="hardware" value="antique">
                    <input type="hidden" name="monogram" value="F•L">
                    <input type="hidden" name="total_price" value="445">
                    
                    <button type="submit" class="reserve-cta">
                        Reserve Your Satchel
                        <span class="cta-price">€445</span>
                    </button>
                </form>
                
                <div class="checkout-note">
                    <p class="note-text">
                        <strong>Next Step:</strong> You'll be taken to our secure checkout to complete your reservation. 
                        No payment required today — just a commitment to craftsmanship.
                    </p>
                </div>
            </div>
        </div>
        
        <footer class="footer">
            <div class="footer-links">
                <a href="{{ route('products.satchel') }}" class="footer-link">Transparency Journey</a>
                <a href="#" class="footer-link">Artisan Profiles</a>
                <a href="#" class="footer-link">Repair Guarantee</a>
                <a href="#" class="footer-link">Contact Our Studio</a>
            </div>
            <p>© {{ now()->year }} Atelier Véridique. Each piece tells a story of ethical craftsmanship.</p>
        </footer>
    </main>
@endsection

@push('scripts')
<script>
    // Initialize total price
    const basePrice = 420;
    const monogramPrice = 25;
    let totalPrice = basePrice + monogramPrice;
    let hasMonogram = true;
    
    // Option selection
    function selectOption(element, type) {
        const parent = element.closest('.customization-section');
        const cards = parent.querySelectorAll('.option-card');
        
        // Remove selected class from all cards in this section
        cards.forEach(card => {
            card.classList.remove('selected');
        });
        
        // Add selected class to clicked card
        element.classList.add('selected');
        
        // Update summary based on selection type
        const value = element.getAttribute('data-value');
        const label = element.getAttribute('data-label');
        
        if (type === 'leather') {
            document.getElementById('leatherLabel').textContent = label;
            document.querySelector('input[name="leather"]').value = value;
        } else if (type === 'hardware') {
            document.getElementById('hardwareLabel').textContent = label;
            document.querySelector('input[name="hardware"]').value = value;
        }
        
        // Animate the update
        element.style.animation = 'none';
        setTimeout(() => {
            element.style.animation = 'pulse 0.5s';
        }, 10);
    }
    
    // Monogram update
    function updateMonogram() {
        const firstInitial = document.getElementById('initialFirst').value.toUpperCase() || 'F';
        const lastInitial = document.getElementById('initialLast').value.toUpperCase() || 'L';
        const monogram = `${firstInitial}•${lastInitial}`;
        
        document.getElementById('monogramPreview').textContent = monogram;
        document.querySelector('input[name="monogram"]').value = monogram;
        
        // Check if monogram is set (not placeholder)
        const hasFirst = document.getElementById('initialFirst').value.trim() !== '';
        const hasLast = document.getElementById('initialLast').value.trim() !== '';
        hasMonogram = hasFirst || hasLast;
        
        // Update summary
        if (hasMonogram) {
            document.getElementById('monogramLabel').textContent = `Personal Monogram (${monogram})`;
            document.getElementById('monogramPrice').textContent = '+ €25';
            totalPrice = basePrice + monogramPrice;
        } else {
            document.getElementById('monogramLabel').textContent = 'No Monogram';
            document.getElementById('monogramPrice').textContent = '—';
            totalPrice = basePrice;
        }
        
        document.querySelector('input[name="total_price"]').value = totalPrice;
        updateTotalPrice();
    }
    
    // Update total price display
    function updateTotalPrice() {
        const totalElement = document.getElementById('totalPrice');
        const ctaPrice = document.querySelector('.cta-price');
        
        totalElement.textContent = `€${totalPrice}`;
        ctaPrice.textContent = `€${totalPrice}`;
        
        // Animate price update
        totalElement.style.transform = 'scale(1.1)';
        ctaPrice.style.transform = 'scale(1.1)';
        
        setTimeout(() => {
            totalElement.style.transform = 'scale(1)';
            ctaPrice.style.transform = 'scale(1)';
        }, 200);
    }
    
    // Initialize page
    document.addEventListener('DOMContentLoaded', () => {
        // Set initial monogram label
        updateMonogram();
        
        // Add CSS for pulse animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
        `;
        document.head.appendChild(style);
        
        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe all animated elements
        document.querySelectorAll('.animate-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    });
</script>
@endpush