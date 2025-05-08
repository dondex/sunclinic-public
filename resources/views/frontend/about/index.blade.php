@extends('layouts.app')

@section('title', 'Obeid Hospital')

@section('content')

<div class="container-fluid bg-green p-1">
    <div class="row mx-2">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ url('/') }}" class="btn btn-success btn-sm shadow-sm my-3">
                    <i class="fas fa-chevron-left text-white p-2"></i>
                </a>
            </div>
            <div class="text-center">
                <h5 class="text-white">About Sun Clinic</h5>
            </div>
        </div>
    </div>
    <div class="row mx-2 pt-3">
        <img class="img-fluid rounded pb-3" src="{{ asset('uploads/about-sunclinic.png') }}" alt="about sun clinic">
        <div class="py-2 text-white">
            <h3>Welcome to Suncity Polyclinic!</h3>
            <p>Located in Batha, Riyadh, Suncity Polyclinic is a modern healthcare facility dedicated to providing top-notch medical services since its establishment in July 2007. This clinic offers convenient features for all visitors, including extensive parking facilities and complimentary Wi-Fi.</p>
        </div>

        <div class="py-2 text-white">
            <h3>To Accomodate All Patients</h3>
            <p>Emergency Care: Immediate support for critical health needs.

                Ambulance Services: Ensuring timely transportation for patients in need.

                Diverse Medical Team: Suncity Polyclinic boasts a highly skilled team of physicians and nurses from various nationalities, including Bangladeshi, Indian, Egyptian, Pakistani, and Nepali professionals, all committed to patient-centered care.

                Outpatient Department: Capable of serving over 300 patients daily, across various specialized departments.

                Insurance Services at Suncity Polyclinic Suncity Polyclinic partners with 20+ leading insurance providers to help you find the right health insurance plan in minutes, offering comprehensive coverage for various treatments.</p>
        </div>

        <div class="py-2 text-white">
            <h3>Our Vision & Mission</h3>
            <p><b>Vision:</b> To be the premier healthcare provider for every patient.</p>
            <p><b>Mission:</b> To deliver compassionate, high-quality healthcare and foster an environment for research and learning.</p>
        </div>


        <div class="py-2 text-white">
            <h3>Our Values</h3>
            <p><b>Patient-Centric Care:</b> Prioritizing the needs of patients and families, ensuring their active participation in decisions, and fostering open communication.</p>

            <p><b>Safety:</b> Implementing best practices to deliver safe, reliable care.</p>

                <p><b>Excellence:</b> Offering exceptional clinical care and patient experience, alongside educational opportunities for healthcare providers.</p>

                <p><b>Accountability:</b> Ensuring responsibility across all organizational levels to maintain the highest standards of healthcare delivery.</p>
        </div>

        <div class="py-2 text-white">
            <h3>24/7 Fast Support:</h3>
            <span>Around-the-Clock Availability: We’re here for you 24 hours a day, ensuring accessible support through:</span>
            <ul>
                <li>Customer Service: Prompt assistance for all inquiries.</li>
                <li>Information Screening: Guidance on services and procedures.</li>
                <li>Live Chat: Instant online support.</li>
                <li>Scheduling & Appointments: Easy booking options to fit your schedule.</li>
            </ul>
        </div>

        <div class="py-2 text-white">
            <h3>Strategic Focus & Social Commitment</h3>
           <ul>
            <li>Inclusive Access: Our services are available to everyone in need.</li>
            <li>Core Specialties: We emphasize our strengths in specific medical fields.</li>
            <li>World-Class Experience: Committed to excellence in patient care, safety, and overall experience.</li>
            <li>Community Impact: We prioritize positive contributions to the communities and environment we serve.</li>
            <li>Ethical Standards: We operate with the highest ethical and legal standards to support and enhance our healthcare services.</li>
           </ul>
            
        </div>
    </div>
        
    </div>
@endsection