@extends('layouts.app')

@section('title', 'Obeid Hospital')

@section('content')

<style>
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
    background: linear-gradient(135deg, #007a3d 0%, #009f4d 100%);
    color: white;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    overflow-x: hidden;
}

        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 40px;
            height: 40px;
        }
        
        .logo svg {
            width: 100%;
            height: 100%;
            color: #ff8c00;
        }
        
        .greeting {
            margin-left: 15px;
        }
        
        .greeting h1 {
            font-size: 22px;
            font-weight: normal;
        }
        
        .greeting p {
            font-size: 18px;
        }
        
        
        .dot {
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
        }
        
        .main-card {
            background-color: white;
            border-radius: 15px;
            margin: 0 20px;
            padding: 20px;
            display: flex;
            justify-content: space-around;
        }
        
        .card-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: #007a3d;
            padding: 20px;
        }
        
        .card-icon {
            width: 70px;
            height: 70px;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-title {
            font-size: 16px;
            text-align: center;
        }
        
        .section-title {
            color: white;
            text-align: center;
            margin: 20px 0 20px;
            font-size: 22px;
        }
        
        .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 0 20px;
        }

        @media (max-width: 768px) {
        .services-grid {
        grid-template-columns: repeat(2, 1fr);
        }
        }

        .department-section {
        margin-top: 20px;
        }

        
        .service-item {
            background-color: #f4f7f6;
            border-radius: 10px;
            padding: 30px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .service-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
            color: #007a3d;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .service-name {
            color: #007a3d;
            font-size: 16px;
            text-align: center;
        }
        
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            background-color: white;
            padding: 15px 0;
            border-top: 1px solid #e0e0e0;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #707070;
            font-size: 14px;
        }
        
        .nav-item.active {
            color: #007a3d;
        }
        
        .nav-icon {
            margin-bottom: 5px;
        }
</style>

<div class="header">
    <div class="logo-container">
        <div class="logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="2" x2="12" y2="6" />
                <line x1="12" y1="18" x2="12" y2="22" />
                <line x1="4.93" y1="4.93" x2="7.76" y2="7.76" />
                <line x1="16.24" y1="16.24" x2="19.07" y2="19.07" />
                <line x1="2" y1="12" x2="6" y2="12" />
                <line x1="18" y1="12" x2="22" y2="12" />
                <line x1="4.93" y1="19.07" x2="7.76" y2="16.24" />
                <line x1="16.24" y1="7.76" x2="19.07" y2="4.93" />
            </svg>
        </div>
        <div class="greeting">
            <h1>Hello, @auth {{ Auth::user()->name }} @else Guest @endauth</h1>
            <p>Welcome back!</p>
        </div>
    </div>
 
</div>

<div class="main-card">
    <div class="card-item">
        <a href="@auth {{ url('set-appointment/' . Auth::id()) }} @else {{ route('login') }} @endauth" style="text-decoration: none; color: inherit;">
            <div class="card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="#007a3d" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <circle cx="9" cy="16" r="2"></circle>
                </svg>
            </div>
            <div class="card-title">Book Appointment</div>
        </a>
    </div>

    <div class="card-item">
        <a href="@auth {{ url('medical/' . Auth::id()) }} @else {{ route('login') }} @endauth" style="text-decoration: none; color: inherit;">
            <div class="card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="#007a3d" stroke-width="2">
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                    <circle cx="12" cy="14" r="4"></circle>
                    <path d="M16 14h.01"></path>
                </svg>
            </div>
            <div class="card-title">My Medical File</div>
        </a>
    </div>
</div>

<h2 class="section-title">Quick Services</h2>
    
    
    <div class="services-grid">
        <div class="service-item">
            <div class="service-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    <circle cx="18" cy="4" r="4" fill="#007a3d"></circle>
                </svg>
            </div>
            <div class="service-name">Notifications</div>
        </div>
        <div class="service-item">
            <div class="service-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
            </div>
            <div class="service-name">SMC Services</div>
        </div>
        <div class="service-item">
            <div class="service-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="service-name">Contact Us</div>
        </div>
        
        <div class="service-item">
            <div class="service-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <path d="M9 22V12h6v10"></path>
                    <path d="M12 7v0"></path>
                </svg>
            </div>
            <div class="service-name">Home Health Care</div>
        </div>
        <div class="service-item">
            <div class="service-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
            </div>
            <div class="service-name">Virtual Consultation</div>
        </div>
        <div class="service-item">
            <div class="service-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="service-name">Nearest Appointment</div>
        </div>
    </div>


<div class="services-grid department-section">
    @foreach($department as $dept)
        <div class="service-item">
            <a href="{{ url('department/' . $dept->id) }}" style="text-decoration: none; color: inherit;">
                <div class="service-icon">
                    <i class="{{ $dept->icon }}" style="font-size: 32px; color: #007a3d;"></i>
                </div>
                <div class="service-name">{{ $dept->name }}</div>
            </a>
        </div>
    @endforeach
</div>




@endsection
