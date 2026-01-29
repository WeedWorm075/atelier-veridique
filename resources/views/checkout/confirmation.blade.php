@extends('layouts.app')

@section('title', 'Complete Your Reservation - Atelier Véridique')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background: var(--primary-light);
        color: var(--primary-dark);
        overflow-x: hidden;
        line-height: 1.6;
    }
    
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
    
    /* Main Container */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 8rem 2rem 4rem;
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 4rem;
    }
    
    /* Checkout Progress */
    .checkout-progress {
        grid-column: 1 / -1;
        margin-bottom: 3rem;
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .progress-steps::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: var(--border-light);
        z-index: 1;
    }
    
    .progress-step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }
    
    .step-number {
        width: 48px;
        height: 48px;
        background: var(--primary-light);
        border: 2px solid var(--border-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-weight: 600;
        color: var(--neutral-medium);
        transition: all 0.3s ease;
    }
    
    .progress-step.active .step-number {
        background: var(--accent-gold);
        border-color: var(--accent-gold);
        color: var(--primary-light);
        transform: scale(1.1);
    }
    
    .progress-step.completed .step-number {
        background: var(--success-green);
        border-color: var(--success-green);
        color: var(--primary-light);
    }
    
    .step-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--neutral-medium);
    }
    
    .progress-step.active .step-label {
        color: var(--primary-dark);
        font-weight: 600;
    }
    
    /* Page Header */
    .page-header {
        grid-column: 1 / -1;
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
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
    
    /* Checkout Form Container */
    .checkout-form-container {
        background: var(--primary-light);
        border: 1px solid var(--border-light);
        border-radius: 12px;
        padding: 2.5rem;
        margin-bottom: 2rem;
    }
    
    .form-section {
        margin-bottom: 3rem;
    }
    
    .form-section:last-child {
        margin-bottom: 0;
    }
    
    .form-section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--neutral-light);
    }
    
    .section-icon {
        font-size: 1.5rem;
        width: 48px;
        height: 48px;
        background: var(--neutral-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 600;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--primary-dark);
    }
    
    .required {
        color: var(--accent-gold);
        font-size: 1.2rem;
    }
    
    .form-input {
        padding: 1rem;
        border: 2px solid var(--border-medium);
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--primary-light);
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 3px rgba(212, 175, 119, 0.1);
    }
    
    .form-input.error {
        border-color: #dc3545;
    }
    
    .form-error {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: none;
    }
    
    /* Checkbox and Radio Styles */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .checkbox-input {
        width: 20px;
        height: 20px;
        accent-color: var(--accent-gold);
    }
    
    .radio-group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .radio-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        border: 2px solid var(--border-light);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .radio-option:hover {
        border-color: var(--accent-tan);
        background: rgba(139, 115, 85, 0.02);
    }
    
    .radio-option.selected {
        border-color: var(--accent-gold);
        background: rgba(212, 175, 119, 0.05);
    }
    
    .radio-input {
        width: 20px;
        height: 20px;
        accent-color: var(--accent-gold);
    }
    
    .radio-content {
        flex: 1;
    }
    
    .radio-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .radio-description {
        font-size: 0.9rem;
        color: var(--neutral-medium);
    }
    
    /* Payment Method Styles */
    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .payment-method {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.5rem;
        border: 2px solid var(--border-light);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-method:hover {
        border-color: var(--accent-tan);
    }
    
    .payment-method.selected {
        border-color: var(--accent-gold);
        background: rgba(212, 175, 119, 0.05);
    }
    
    .payment-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }
    
    .payment-label {
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    /* Card Input */
    .card-input-container {
        position: relative;
        margin-top: 1.5rem;
    }
    
    .card-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
    }
    
    /* Order Summary Sidebar */
    .order-summary-sidebar {
        position: sticky;
        top: 120px;
        background: var(--primary-light);
        border: 1px solid var(--border-medium);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 8px 40px rgba(44, 36, 22, 0.08);
        max-height: calc(100vh - 140px);
        overflow-y: auto;
    }
    
    .summary-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--neutral-light);
    }
    
    .summary-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .summary-subtitle {
        color: var(--neutral-medium);
        font-size: 0.9rem;
    }
    
    /* Product Preview */
    .product-preview {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border-light);
    }
    
    .preview-image {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #2C2416 0%, #4A3C2A 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        flex-shrink: 0;
    }
    
    .preview-monogram {
        color: var(--accent-gold);
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .preview-details {
        flex: 1;
    }
    
    .preview-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .preview-features {
        font-size: 0.9rem;
        color: var(--neutral-medium);
        margin-bottom: 0.5rem;
    }
    
    .preview-feature {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }
    
    /* Summary Items */
    .summary-items {
        margin-bottom: 1.5rem;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-light);
    }
    
    .summary-item:last-child {
        border-bottom: none;
    }
    
    .item-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .item-price {
        font-weight: 600;
        color: var(--accent-tan);
    }
    
    .summary-total {
        background: linear-gradient(135deg, var(--neutral-light) 0%, rgba(245, 242, 234, 0.5) 100%);
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1.5rem 0;
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
        font-size: 2rem;
        color: var(--accent-gold);
        font-weight: 700;
    }
    
    /* Ethical Commitment */
    .ethical-commitment {
        background: var(--success-light);
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border: 1px solid rgba(74, 124, 89, 0.2);
    }
    
    .commitment-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: var(--success-green);
        font-weight: 600;
    }
    
    .commitment-list {
        list-style: none;
    }
    
    .commitment-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        color: var(--neutral-medium);
    }
    
    /* Security Badge */
    .security-badge {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--primary-light);
        border: 1px solid var(--border-light);
        border-radius: 8px;
        margin-top: 1.5rem;
    }
    
    .security-icon {
        font-size: 1.5rem;
        color: var(--success-green);
    }
    
    .security-text {
        font-size: 0.85rem;
        color: var(--neutral-medium);
    }
    
    /* CTA Buttons */
    .checkout-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .continue-button {
        flex: 1;
        padding: 1.25rem;
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .continue-button:hover:not(:disabled) {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #4A3C2A 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(44, 36, 22, 0.2);
    }
    
    .continue-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .back-button {
        padding: 1.25rem 2rem;
        background: var(--primary-light);
        color: var(--accent-tan);
        border: 2px solid var(--accent-tan);
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .back-button:hover {
        background: var(--neutral-light);
    }
    
    /* Confirmation Modal */
    .confirmation-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(44, 36, 22, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .confirmation-modal.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-content {
        background: var(--primary-light);
        border-radius: 16px;
        padding: 3rem;
        max-width: 500px;
        width: 90%;
        text-align: center;
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }
    
    .confirmation-modal.active .modal-content {
        transform: translateY(0);
    }
    
    .modal-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
    }
    
    .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--success-green);
    }
    
    .modal-message {
        font-size: 1.1rem;
        color: var(--neutral-medium);
        margin-bottom: 2rem;
        line-height: 1.8;
    }
    
    .modal-order-number {
        background: var(--neutral-light);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        letter-spacing: 2px;
        color: var(--accent-tan);
    }
    
    .modal-button {
        padding: 1rem 2rem;
        background: var(--accent-tan);
        color: var(--primary-light);
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .modal-button:hover {
        background: var(--primary-dark);
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .main-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .order-summary-sidebar {
            position: static;
            max-height: none;
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
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .checkout-form-container {
            padding: 1.5rem;
        }
        
        .payment-methods {
            grid-template-columns: 1fr;
        }
        
        .progress-steps::before {
            display: none;
        }
        
        .progress-steps {
            flex-direction: column;
            gap: 2rem;
        }
        
        .progress-step {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-align: left;
        }
        
        .step-number {
            margin: 0;
            flex-shrink: 0;
        }
        
        .checkout-actions {
            flex-direction: column-reverse;
        }
        
        .product-preview {
            flex-direction: column;
            text-align: center;
        }
        
        .preview-image {
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }
        
        .modal-content {
            padding: 2rem;
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
    
    /* Loading State */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(254, 253, 248, 0.3);
        border-radius: 50%;
        border-top-color: var(--primary-light);
        animation: spin 1s ease infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--neutral-light);
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--accent-tan);
        border-radius: 3px;
    }
</style>
@endpush

@section('content')
    <!-- Navigation -->
    <nav class="nav">
        <a href="{{ route('home') }}" class="nav-logo">ATELIER VÉRIDIQUE</a>
        <a href="{{ route('reservation.personalize') }}" class="nav-back">
            ← Back to Personalization
        </a>
        <div class="nav-trust">Secure Checkout</div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-container">
        <!-- Checkout Progress -->
        <div class="checkout-progress">
            <div class="progress-steps">
                <div class="progress-step completed">
                    <div class="step-number">1</div>
                    <div class="step-label">Personalization</div>
                </div>
                <div class="progress-step active">
                    <div class="step-number">2</div>
                    <div class="step-label">Checkout</div>
                </div>
                <div class="progress-step">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
        </div>
        
        <!-- Page Header -->
        <header class="page-header">
            <h1 class="page-title">Complete Your Reservation</h1>
            <p class="page-subtitle">
                Final step in your ethical journey. Your satchel awaits craftsmanship.
            </p>
        </header>
        
        <!-- Left Column: Checkout Forms -->
        <div class="checkout-column">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf
                
                <!-- Shipping Information -->
                <div class="checkout-form-container animate-in" style="animation-delay: 0.1s">
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="section-icon">📍</div>
                            <h2 class="section-title">Shipping Information</h2>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    First Name
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-input" name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
                                <div class="form-error">Please enter your first name</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    Last Name
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-input" name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
                                <div class="form-error">Please enter your last name</div>
                            </div>
                            
                            <div class="form-group full-width">
                                <label class="form-label">
                                    Email Address
                                    <span class="required">*</span>
                                </label>
                                <input type="email" class="form-input" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                <div class="form-error">Please enter a valid email address</div>
                            </div>
                            
                            <div class="form-group full-width">
                                <label class="form-label">
                                    Street Address
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-input" name="address" value="{{ old('address') }}" required>
                                <div class="form-error">Please enter your street address</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    City
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-input" name="city" value="{{ old('city') }}" required>
                                <div class="form-error">Please enter your city</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    ZIP / Postal Code
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-input" name="zip_code" value="{{ old('zip_code') }}" required>
                                <div class="form-error">Please enter your ZIP/postal code</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    Country
                                    <span class="required">*</span>
                                </label>
                                <select class="form-input" name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>France</option>
                                    <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>Germany</option>
                                    <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="JP" {{ old('country') == 'JP' ? 'selected' : '' }}>Japan</option>
                                    <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
                                </select>
                                <div class="form-error">Please select your country</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    Phone Number
                                    <span class="required">*</span>
                                </label>
                                <input type="tel" class="form-input" name="phone" value="{{ old('phone') }}" required>
                                <div class="form-error">Please enter your phone number</div>
                            </div>
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox-input" id="billingSame" checked>
                            <label for="billingSame">Billing address is the same as shipping address</label>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Method -->
                <div class="checkout-form-container animate-in" style="animation-delay: 0.2s">
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="section-icon">🚚</div>
                            <h2 class="section-title">Shipping Method</h2>
                        </div>
                        
                        <div class="radio-group" id="shippingMethod">
                            <div class="radio-option selected" onclick="selectShipping('standard')">
                                <input type="radio" class="radio-input" name="shipping_method" value="standard" checked>
                                <div class="radio-content">
                                    <div class="radio-title">Standard Shipping</div>
                                    <div class="radio-description">Carbon-neutral delivery in 5-7 business days</div>
                                </div>
                                <div class="item-price">FREE</div>
                            </div>
                            
                            <div class="radio-option" onclick="selectShipping('express')">
                                <input type="radio" class="radio-input" name="shipping_method" value="express">
                                <div class="radio-content">
                                    <div class="radio-title">Express Shipping</div>
                                    <div class="radio-description">Priority delivery in 2-3 business days with tracking</div>
                                </div>
                                <div class="item-price">€15</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Information -->
                <div class="checkout-form-container animate-in" style="animation-delay: 0.3s">
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="section-icon">💳</div>
                            <h2 class="section-title">Payment Information</h2>
                        </div>
                        
                        <div class="payment-methods" id="paymentMethods">
                            <div class="payment-method selected" onclick="selectPaymentMethod('card')">
                                <div class="payment-icon">💳</div>
                                <div class="payment-label">Credit Card</div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPaymentMethod('paypal')">
                                <div class="payment-icon">🤝</div>
                                <div class="payment-label">PayPal</div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPaymentMethod('applepay')">
                                <div class="payment-icon">🍎</div>
                                <div class="payment-label">Apple Pay</div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPaymentMethod('bank')">
                                <div class="payment-icon">🏦</div>
                                <div class="payment-label">Bank Transfer</div>
                            </div>
                        </div>
                        
                        <div id="paymentForm" style="display: block;">
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label class="form-label">
                                        Name on Card
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-input" name="card_name" required>
                                    <div class="form-error">Please enter the name on your card</div>
                                </div>
                                
                                <div class="form-group full-width">
                                    <label class="form-label">
                                        Card Number
                                        <span class="required">*</span>
                                    </label>
                                    <div class="card-input-container">
                                        <input type="text" class="form-input" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                        <div class="card-icon">💳</div>
                                    </div>
                                    <div class="form-error">Please enter a valid card number</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        Expiry Date
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-input" name="expiry_date" placeholder="MM/YY" maxlength="5" required>
                                    <div class="form-error">Please enter expiry date</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        CVC
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-input" name="cvc" placeholder="123" maxlength="4" required>
                                    <div class="form-error">Please enter CVC</div>
                                </div>
                            </div>
                            
                            <div class="checkbox-group">
                                <input type="checkbox" class="checkbox-input" id="saveCard" name="save_card" checked>
                                <label for="saveCard">Save card for future purchases (securely encrypted)</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Review & Submit -->
                <div class="checkout-form-container animate-in" style="animation-delay: 0.4s">
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="section-icon">📋</div>
                            <h2 class="section-title">Review & Agreement</h2>
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox-input" id="terms" name="terms" required>
                            <label for="terms">
                                I agree to the <a href="#" style="color: var(--accent-tan);">Terms of Service</a> and 
                                <a href="#" style="color: var(--accent-tan);">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox-input" id="receipt" name="receipt" checked>
                            <label for="receipt">Email me a receipt and production updates</label>
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox-input" id="newsletter" name="newsletter">
                            <label for="newsletter">Subscribe to our newsletter for stories from the workshop</label>
                        </div>
                        
                        <div class="checkout-actions">
                            <button type="button" class="back-button" onclick="goBack()">Back</button>
                            <button type="submit" class="continue-button" id="submitButton">
                                Complete Reservation
                                <span id="totalAmount">€{{ $totalPrice ?? 445 }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Right Column: Order Summary -->
        <div class="order-summary-sidebar animate-in" style="animation-delay: 0.5s">
            <div class="summary-header">
                <h2 class="summary-title">Your Satchel</h2>
                <p class="summary-subtitle">Reservation Summary</p>
            </div>
            
            <!-- Product Preview -->
            <div class="product-preview">
                <div class="preview-image">
                    <div class="preview-monogram" id="orderMonogram">{{ $monogram ?? 'F•L' }}</div>
                </div>
                <div class="preview-details">
                    <div class="preview-title">Artisan Satchel</div>
                    <div class="preview-features">
                        <div class="preview-feature">
                            <span>🧥</span>
                            <span id="orderLeather">{{ $leather ?? 'Heritage Brown' }} Leather</span>
                        </div>
                        <div class="preview-feature">
                            <span>⚙️</span>
                            <span id="orderHardware">{{ $hardware ?? 'Antique Brass' }} Hardware</span>
                        </div>
                        <div class="preview-feature">
                            <span>✏️</span>
                            <span id="orderMonogramLabel">Monogram: {{ $monogram ?? 'F•L' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Price Breakdown -->
            <div class="summary-items">
                <div class="summary-item">
                    <div class="item-label">Satchel</div>
                    <div class="item-price">€420</div>
                </div>
                
                <div class="summary-item">
                    <div class="item-label">Personal Monogram</div>
                    <div class="item-price">€25</div>
                </div>
                
                <div class="summary-item">
                    <div class="item-label">
                        <span>🚚</span>
                        <span id="shippingLabel">Standard Shipping</span>
                    </div>
                    <div class="item-price" id="shippingPrice">FREE</div>
                </div>
            </div>
            
            <!-- Total -->
            <div class="summary-total">
                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-price" id="orderTotal">€{{ $totalPrice ?? 445 }}</span>
                </div>
                <p style="font-size: 0.85rem; color: var(--neutral-medium); text-align: center; margin-top: 0.5rem;">
                    VAT included • Free shipping
                </p>
            </div>
            
            <!-- Ethical Commitment -->
            <div class="ethical-commitment">
                <div class="commitment-title">
                    <span>🤝</span>
                    <span>Your Ethical Commitment</span>
                </div>
                <ul class="commitment-list">
                    <li class="commitment-item">
                        <span>✓</span>
                        <span>Supports fair artisan wages</span>
                    </li>
                    <li class="commitment-item">
                        <span>✓</span>
                        <span>Uses 100% sustainable materials</span>
                    </li>
                    <li class="commitment-item">
                        <span>✓</span>
                        <span>Includes lifetime repair guarantee</span>
                    </li>
                    <li class="commitment-item">
                        <span>✓</span>
                        <span>Carbon-neutral production & shipping</span>
                    </li>
                </ul>
            </div>
            
            <!-- Security Badge -->
            <div class="security-badge">
                <div class="security-icon">🔒</div>
                <div class="security-text">
                    <strong>Secure Checkout</strong><br>
                    Your payment information is encrypted and secure
                </div>
            </div>
        </div>
    </main>
    
    <!-- Confirmation Modal -->
    <div class="confirmation-modal" id="confirmationModal">
        <div class="modal-content">
            <div class="modal-icon">✨</div>
            <h2 class="modal-title">Reservation Confirmed!</h2>
            <p class="modal-message">
                Thank you for joining our ethical journey. Your Artisan Satchel is now in production.
                Our craftsmen will begin working on your piece within 48 hours.
            </p>
            
            <div class="modal-order-number" id="orderNumber">VRD-2847-{{ now()->year }}</div>
            
            <p class="modal-message">
                We've sent a confirmation email with all details and production timeline.
                You'll receive regular updates as your satchel progresses through each stage of craftsmanship.
            </p>
            
            <a href="{{ route('home') }}" class="modal-button">
                Return to Home
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Current order details
    let orderDetails = {
        leather: '{{ $leather ?? "Heritage Brown" }}',
        hardware: '{{ $hardware ?? "Antique Brass" }}',
        monogram: '{{ $monogram ?? "F•L" }}',
        basePrice: 420,
        monogramPrice: 25,
        shippingPrice: 0,
        shippingMethod: 'standard',
        total: {{ $totalPrice ?? 445 }}
    };
    
    // Initialize form validation
    function initializeFormValidation() {
        const formInputs = document.querySelectorAll('.form-input[required]');
        
        formInputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearError(this);
            });
        });
        
        // Special validation for card number
        const cardNumber = document.querySelector('input[name="card_number"]');
        if (cardNumber) {
            cardNumber.addEventListener('input', function(e) {
                formatCardNumber(e.target);
            });
        }
        
        // Special validation for expiry date
        const expiryDate = document.querySelector('input[name="expiry_date"]');
        if (expiryDate) {
            expiryDate.addEventListener('input', function(e) {
                formatExpiryDate(e.target);
            });
        }
    }
    
    // Field validation
    function validateField(field) {
        const errorElement = field.nextElementSibling;
        
        if (!field.value.trim()) {
            field.classList.add('error');
            errorElement.style.display = 'block';
            return false;
        }
        
        // Email validation
        if (field.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                field.classList.add('error');
                errorElement.style.display = 'block';
                errorElement.textContent = 'Please enter a valid email address';
                return false;
            }
        }
        
        // Card number validation
        if (field.name === 'card_number') {
            const cardNumber = field.value.replace(/\s/g, '');
            if (cardNumber.length < 13 || cardNumber.length > 19 || !/^\d+$/.test(cardNumber)) {
                field.classList.add('error');
                errorElement.style.display = 'block';
                errorElement.textContent = 'Please enter a valid card number';
                return false;
            }
        }
        
        field.classList.remove('error');
        errorElement.style.display = 'none';
        return true;
    }
    
    // Clear error
    function clearError(field) {
        field.classList.remove('error');
        const errorElement = field.nextElementSibling;
        errorElement.style.display = 'none';
    }
    
    // Format card number
    function formatCardNumber(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})/g, '$1 ').trim();
        input.value = value.substring(0, 19);
    }
    
    // Format expiry date
    function formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        input.value = value.substring(0, 5);
    }
    
    // Shipping method selection
    function selectShipping(method) {
        const options = document.querySelectorAll('.radio-option');
        options.forEach(option => {
            option.classList.remove('selected');
            option.querySelector('.radio-input').checked = false;
        });
        
        const selectedOption = document.querySelector(`[value="${method}"]`).closest('.radio-option');
        selectedOption.classList.add('selected');
        selectedOption.querySelector('.radio-input').checked = true;
        
        orderDetails.shippingMethod = method;
        orderDetails.shippingPrice = method === 'express' ? 15 : 0;
        
        updateOrderSummary();
    }
    
    // Payment method selection
    function selectPaymentMethod(method) {
        const methods = document.querySelectorAll('.payment-method');
        methods.forEach(m => m.classList.remove('selected'));
        
        const selectedMethod = event.currentTarget || document.querySelector(`[onclick*="${method}"]`);
        selectedMethod.classList.add('selected');
        
        // Show/hide payment form based on method
        const paymentForm = document.getElementById('paymentForm');
        if (method === 'card') {
            paymentForm.style.display = 'block';
        } else {
            paymentForm.style.display = 'none';
        }
    }
    
    // Update order summary
    function updateOrderSummary() {
        // Update shipping
        document.getElementById('shippingLabel').textContent = 
            orderDetails.shippingMethod === 'express' ? 'Express Shipping' : 'Standard Shipping';
        document.getElementById('shippingPrice').textContent = 
            orderDetails.shippingPrice === 0 ? 'FREE' : `€${orderDetails.shippingPrice}`;
        
        // Update total
        orderDetails.total = orderDetails.basePrice + orderDetails.monogramPrice + orderDetails.shippingPrice;
        document.getElementById('orderTotal').textContent = `€${orderDetails.total}`;
        document.getElementById('totalAmount').textContent = `€${orderDetails.total}`;
    }
    
    // Go back to previous page
    function goBack() {
        window.history.back();
    }
    
    // Form submission
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        // Validate all required fields
        const requiredInputs = document.querySelectorAll('.form-input[required]');
        let isValid = true;
        
        requiredInputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        // Check terms agreement
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            alert('Please agree to the Terms of Service to continue.');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = document.querySelector('.form-input.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Initialize page
    document.addEventListener('DOMContentLoaded', () => {
        initializeFormValidation();
        
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
        
        document.querySelectorAll('.animate-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
        
        // Focus on first input
        const firstInput = document.querySelector('.form-input');
        if (firstInput) {
            firstInput.focus();
        }
        
        // If there are validation errors from Laravel
        @if($errors->any())
            // Scroll to first error
            const firstError = document.querySelector('.form-input');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        @endif
    });
</script>
@endpush