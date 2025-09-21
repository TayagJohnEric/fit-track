<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fit-Track</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
    rel="stylesheet"
  />
   <style>

  /* Base Styles */
  body {
    font-family: 'Inter', sans-serif;
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
  }

  body.loaded {
    opacity: 1;
  }

  h1, h2, h3 {
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  /* Smooth scrolling */
  html {
    scroll-behavior: smooth;
  }

  /* Floating Animation */
  @keyframes float {
    0%, 100% {
      transform: translateY(0);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    50% {
      transform: translateY(-6px);
      box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
    }
  }

  .floating {
    animation: float 1.5s ease-in-out infinite;
  }

  /* Slide In Animation */
  @keyframes slideInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .slide-in-up {
    animation: slideInUp 0.6s ease-out forwards;
  }

  /* Enhanced gradient backgrounds */
  .gradient-orange {
    background: linear-gradient(135deg, #ff8a50 0%, #ff6b35 50%, #f97316 100%);
  }

  .gradient-orange-subtle {
    background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
  }

  /* Feature Card Enhanced Styles */
  .feature-card {
    background: white;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #f3f4f6;
    backdrop-filter: blur(10px);
  }

  .feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px -12px rgba(249, 115, 22, 0.15);
    border-color: rgba(249, 115, 22, 0.2);
  }

  /* Problem/Solution Cards */
  .comparison-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
  }

  .comparison-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
  }

  .problem-card:hover {
    border-color: #fecaca;
  }

  .solution-card:hover {
    border-color: #bbf7d0;
  }

  /* Button enhancements */
  .btn-primary {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 25px -8px rgba(249, 115, 22, 0.5);
  }

  /* FAQ Animations */
  .faq-content {
    transition: all 0.3s ease;
    max-height: 0;
    overflow: hidden;
  }

  .faq-content.show {
    max-height: 200px;
  }

  /* Reduced Motion Support */
  @media (prefers-reduced-motion: reduce) {
    *, ::before, ::after {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
    }
  }

  /* Interactive demo enhanced */
  .demo-card {
    background: linear-gradient(135deg, #ffffff 0%, #fef3f2 100%);
    border: 1px solid #fed7aa;
  }

  /* Typography improvements */
  .text-balance {
    text-wrap: balance;
  }

  /* Custom scrollbar */
  ::-webkit-scrollbar {
    width: 6px;
  }

  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  ::-webkit-scrollbar-thumb {
    background: #f97316;
    border-radius: 3px;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: #ea580c;
  }

</style>

  </head>
  <body class="bg-white">
  
   <!-- Full-width background wrapper -->
<div class="w-full">
  <!-- Background wrapper with image support -->
  <div class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/hero-bg.png') }}');">
    <!-- Dark overlay to match gym-themed palette -->
    <div class="absolute inset-0 bg-black/70"></div>

    <!-- Content on top of background -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 py-9">

     <!-- Header -->
<header class="flex items-center justify-between py-4 px-6 bg-black/30 backdrop-blur-md mb-16 rounded-2xl border border-white/10">
  <!-- Logo -->
  <div class="flex items-center space-x-2">
    
    <span class="font-bold text-lg tracking-wide text-white">FitTrack</span>
  </div>

  <!-- Centered nav -->
  <nav class="flex-1 flex justify-center space-x-8 ml-12">
    <a href="#features" class="text-sm font-medium text-gray-300 hover:text-white transition-colors duration-200">Features</a>
    <a href="#how-it-works" class="text-sm font-medium text-gray-300 hover:text-white transition-colors duration-200">How It Works</a>
    <a href="#about" class="text-sm font-medium text-gray-300 hover:text-white transition-colors duration-200">About</a>
    <a href="#faq" class="text-sm font-medium text-gray-300 hover:text-white transition-colors duration-200">FAQs</a>
  </nav>

 <!-- Auth links -->
<div class="flex items-center space-x-3">
  <a href="{{ route('login.form') }}" 
     class="text-white text-sm font-semibold px-6 py-2.5 transition-all duration-300 rounded-xl border border-white/30 hover:bg-white hover:text-black hover:shadow-xl backdrop-blur-sm">
        Login
  </a>
  <a href="{{ route('register.form') }}" 
     class="text-white text-sm font-semibold px-6 py-2.5 transition-all duration-300 rounded-xl gradient-orange hover:shadow-xl transform hover:-translate-y-0.5">
    Get Started
  </a>
</div>

</header>

      <!-- Hero Section -->
      <section class="py-24 overflow-hidden">
        <div class="text-center mb-20 slide-in-up">
       
            <!-- Feature label -->
            <div class="flex justify-center items-center mb-8">
              <span class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-black/30 backdrop-blur-md border border-white/20 rounded-2xl shadow-sm">
                <i class="fas fa-bolt text-orange-500"></i>
                Customized Plans, Simplified Life
              </span>
            </div>

          <!-- Main Header -->
          <h1 class="font-extrabold text-4xl sm:text-5xl md:text-6xl max-w-4xl mx-auto leading-tight text-white mb-6 text-balance">
            FITNESS THAT FINALLY
            <br>
            FITS YOUR LIFE
          </h1>

          <!-- Sub Header -->
          <p class="text-lg sm:text-xl text-gray-100 font-medium max-w-2xl mx-auto mb-10 leading-relaxed text-balance">
            Get your custom plan with personalized workouts, easy nutrition tracking, and budget-friendly meals. All designed for your goals and your life.
          </p>

          <!-- CTA Buttons -->
          <div class="flex justify-center space-x-4">
            <a href="{{ route('register.form') }}" 
   class="btn-primary text-white text-base font-semibold px-8 py-4 flex items-center space-x-2 rounded-xl shadow-lg">
    <i class="fas fa-arrow-right"></i>
    <span>Get Your Personal Plan</span>
</a>

          </div>
        </div>
      </section>
    </div>
  </div>
</div>


 <!-- How It Works Section -->
    <section id="how-it-works" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-semibold mb-6 text-gray-900 tracking-tight">
                    How Fit-Track Works
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto tracking-tight">
                    Get started in minutes with our simple, science-backed approach to fitness and nutrition tracking.
                </p>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 py-12 ">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
              <!-- Card 1 -->
              <div class="relative bg-white border border-gray-200 rounded-lg pt-12 pb-8 px-6 text-center">
              <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-white border border-gray-300 rounded-lg p-3">
                <p class="w-10 h-10 text-orange-600 text-3xl font-bold">1</p>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2 mt-6">
                Complete Your Profile
              </h3>
              <p class="text-gray-600 text-sm leading-relaxed">
          Tell us about your goals, experience level, and preferences. We'll calculate your personalized nutrition targets.     </p>
              </div>

              <!-- Card 2 -->
              <div class="relative bg-white border border-gray-200 rounded-lg pt-12 pb-8 px-6 text-center">
              <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-white border border-gray-300 rounded-lg p-3">
                <p class="w-10 h-10 text-orange-600 text-3xl font-bold">2</p>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2 mt-6">
                Follow Your Plan
              </h3>
              <p class="text-gray-600 text-sm leading-relaxed">
          Get weekly workout schedules with video guides and track your meals with our comprehensive food database.     </p>
              </div>
              
              <!-- Card 3 -->
              <div class="relative bg-white border border-gray-200 rounded-lg pt-12 pb-8 px-6 text-center">
              <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-white border border-gray-300 rounded-lg p-3">
                <p class="w-10 h-10 text-orange-600 text-3xl font-bold">3</p>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2 mt-6">
          Track Your Progress
              </h3>
              <p class="text-gray-600 text-sm leading-relaxed">
          Monitor your journey with visual charts, maintain streaks, and get weekly performance reports.
              </p>
              </div>
            </div>
            </div>
            
            <!-- Interactive Demo -->
            <div class="demo-card rounded-3xl p-8 max-w-5xl mx-auto mt-16">
                <h3 class="text-3xl font-bold mb-8 text-center text-gray-900">Try Our Interactive Demo</h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
                        <h4 class="text-xl font-semibold mb-6 text-gray-900">Daily Nutrition Tracker</h4>
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-medium">Calories</span>
                                <span class="font-bold text-gray-900">1,847 / 2,200</span>
                            </div>
                            <div class="bg-gray-100 rounded-full h-4 overflow-hidden">
                                <div class="gradient-orange h-4 rounded-full transition-all duration-500" style="width: 84%"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div class="text-center p-3 bg-orange-50 rounded-lg">
                                    <div class="font-semibold text-gray-900">Protein</div>
                                    <div class="text-orange-600 font-medium">120g / 150g</div>
                                </div>
                                <div class="text-center p-3 bg-orange-50 rounded-lg">
                                    <div class="font-semibold text-gray-900">Carbs</div>
                                    <div class="text-orange-600 font-medium">180g / 220g</div>
                                </div>
                                <div class="text-center p-3 bg-orange-50 rounded-lg">
                                    <div class="font-semibold text-gray-900">Fat</div>
                                    <div class="text-orange-600 font-medium">65g / 80g</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
                        <h4 class="text-xl font-semibold mb-6 text-gray-900">Budget-Smart Meal Suggestion</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                <span class="font-medium text-gray-700">Daily Budget</span>
                                <span class="font-bold text-green-600 text-lg">₱15.00</span>
                            </div>
                            <div class="gradient-orange-subtle rounded-xl p-4">
                                <div class="font-semibold text-gray-900 mb-2">Suggested Lunch</div>
                                <div class="text-gray-700 mb-3">
                                    Grilled chicken breast with quinoa and vegetables
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-orange-700 font-medium">Cost: ₱4.50</span>
                                    <span class="text-orange-700 font-medium">490 calories</span>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 text-center p-2 bg-gray-50 rounded-lg">
                                Remaining budget: ₱10.50
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-8">
                   <a href="{{ route('login.form') }}" 
   class="btn-primary text-white px-8 py-3 rounded-xl font-semibold shadow-lg">
    Try Full Demo
</a>
                </div>
            </div>
        </div>
    </section>
    

     <!-- Problem & Solution Section -->
<section class="py-24 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Heading -->
    <div class="text-center mb-20">
      <h2 class="text-4xl font-bold text-gray-900 mb-6 text-balance">
        Why Most Fitness Apps Fail You
      </h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto text-balance">
        Generic plans, expensive meal suggestions, and lack of personal guidance leave you frustrated and unmotivated.
      </p>
    </div>

    <!-- Problem & Solution Cards -->
    <div class="flex flex-col lg:flex-row gap-12 justify-center items-start max-w-6xl mx-auto">
      
     <!-- Problem -->
<div class="comparison-card problem-card bg-white rounded-2xl shadow-sm p-8 w-full max-w-lg">
  <div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-2xl mb-4">
      <i class="fas fa-times text-red-600 text-2xl"></i>
    </div>
    <h3 class="text-2xl font-bold text-gray-900">The Problem</h3>
  </div>
  <ul class="space-y-6">
    <li class="flex items-start gap-4">
      <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mt-1">
        <i class="fas fa-times text-red-600 text-sm"></i>
      </div>
      <div>
        <h4 class="font-semibold text-gray-900 mb-2">One-Size-Fits-All Approach</h4>
        <p class="text-gray-600 leading-relaxed">Generic workout plans that don't consider your experience level or goals.</p>
      </div>
    </li>
    <li class="flex items-start gap-4">
      <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mt-1">
        <i class="fas fa-times text-red-600 text-sm"></i>
      </div>
      <div>
        <h4 class="font-semibold text-gray-900 mb-2">Expensive Meal Plans</h4>
        <p class="text-gray-600 leading-relaxed">Nutrition advice that ignores your budget constraints.</p>
      </div>
    </li>
    <li class="flex items-start gap-4">
      <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mt-1">
        <i class="fas fa-times text-red-600 text-sm"></i>
      </div>
      <div>
        <h4 class="font-semibold text-gray-900 mb-2">Poor Form Guidance</h4>
        <p class="text-gray-600 leading-relaxed">No video demonstrations leading to injuries and ineffective workouts.</p>
      </div>
    </li>
  </ul>
</div>

   <!-- Solution -->
<div class="comparison-card solution-card bg-white rounded-2xl shadow-sm p-8 w-full max-w-lg">
  <div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-2xl mb-4">
      <i class="fas fa-check text-orange-600 text-2xl"></i>
    </div>
    <h3 class="text-2xl font-bold text-gray-900">Our Solution</h3>
  </div>
  <ul class="space-y-6">
    <li class="flex items-start gap-4">
      <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mt-1">
        <i class="fas fa-check text-orange-600 text-sm"></i>
      </div>
      <div>
        <h4 class="font-semibold text-gray-900 mb-2">Personalized Everything</h4>
        <p class="text-gray-600 leading-relaxed">Tailored workouts and nutrition based on your goals, experience, and preferences.</p>
      </div>
    </li>
    <li class="flex items-start gap-4">
      <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mt-1">
        <i class="fas fa-check text-orange-600 text-sm"></i>
      </div>
      <div>
        <h4 class="font-semibold text-gray-900 mb-2">Budget-Smart Nutrition</h4>
        <p class="text-gray-600 leading-relaxed">Meal suggestions that fit your budget while meeting your nutritional needs.</p>
      </div>
    </li>
    <li class="flex items-start gap-4">
      <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mt-1">
        <i class="fas fa-check text-orange-600 text-sm"></i>
      </div>
      <div>
        <h4 class="font-semibold text-gray-900 mb-2">Video-Guided Workouts</h4>
        <p class="text-gray-600 leading-relaxed">Professional demonstrations for every exercise to ensure proper form and safety.</p>
      </div>
    </li>
  </ul>
</div>
      </div>
    </div>
  </div>
</section>


 <!-- Key Features -->
<section id="features" class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20">
      <h2 class="text-4xl font-bold mb-6 text-gray-900 text-balance">
        Everything You Need to Succeed
      </h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed text-balance">
        Powerful features designed to keep you motivated, informed, and on track toward your fitness goals.
      </p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      
      <!--Card 1-->
      <div class="feature-card rounded-2xl p-8 group">
        <div class="flex items-center justify-between mb-6">
          <div class="w-14 h-14 rounded-2xl gradient-orange flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-6 h-6"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <span class="text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-200 rounded-full px-3 py-1">
            Personalized
          </span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4 leading-tight">Complete Profile Setup</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">
         Physical stats, fitness goals, and experience level for tailored nutrition targets and workout plans.
        </p>
        <ul class="space-y-2 text-sm text-gray-600">
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Weight Loss or Muscle Gain goals
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Experience-based customization
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Automatic macro calculations
         </li>
        </ul>
      </div>

     <!--Card 2-->
       <div class="feature-card rounded-2xl p-8 group">
        <div class="flex items-center justify-between mb-6">
          <div class="w-14 h-14 rounded-2xl gradient-orange flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-6 h-6"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>
          </div>
          <span class="text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-200 rounded-full px-3 py-1">
            Video-Guided
          </span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4 leading-tight">Professional Workout Videos</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">Professional demonstrations for every exercise with detailed sets, reps, and rest times.</p>
        <ul class="space-y-2 text-sm text-gray-600">
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Weekly workout schedules
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Proper form demonstrations
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Safety-focused guidance
         </li>
        </ul>
      </div>

      <!--Card 3-->
     <div class="feature-card rounded-2xl p-8 group">
        <div class="flex items-center justify-between mb-6">
          <div class="w-14 h-14 rounded-2xl gradient-orange flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-6 h-6"><path d="M20 11H4"/><path d="M20 7H4"/><path d="M7 21V4a1 1 0 0 1 1-1h4a1 1 0 0 1 0 12H7"/></svg>
          </div>
          <span class="text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-200 rounded-full px-3 py-1">
          Budget-Smart
          </span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4 leading-tight">Budget-Friendly Meal Plans</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">Unique meal suggestions that fit your budget while meeting your nutritional targets.</p>
        <ul class="space-y-2 text-sm text-gray-600">
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Daily or per-meal budgets
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Affordable meal combinations
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Nutritionally balanced options
         </li>
        </ul>
      </div>

      <!--Card 4-->
     <div class="feature-card rounded-2xl p-8 group">
        <div class="flex items-center justify-between mb-6">
          <div class="w-14 h-14 rounded-2xl gradient-orange flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-6 h-6"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="m19 9-5 5-4-4-3 3"/></svg>
          </div>
          <span class="text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-200 rounded-full px-3 py-1">
           Analytics
          </span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4 leading-tight">Progress Tracking</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">Visual charts and BMI calculations to monitor your health journey over time.</p>
        <ul class="space-y-2 text-sm text-gray-600">
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Weight tracking charts
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Automatic BMI calculations
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Visual progress reports
         </li>
        </ul>
      </div>

      <!--Card 5-->
     <div class="feature-card rounded-2xl p-8 group">
        <div class="flex items-center justify-between mb-6">
          <div class="w-14 h-14 rounded-2xl gradient-orange flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-6 h-6"><path d="M12.409 13.017A5 5 0 0 1 22 15c0 3.866-4 7-9 7-4.077 0-8.153-.82-10.371-2.462-.426-.316-.631-.832-.62-1.362C2.118 12.723 2.627 2 10 2a3 3 0 0 1 3 3 2 2 0 0 1-2 2c-1.105 0-1.64-.444-2-1"/><path d="M15 14a5 5 0 0 0-7.584 2"/><path d="M9.964 6.825C8.019 7.977 9.5 13 8 15"/></svg>
          </div>
          <span class="text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-200 rounded-full px-3 py-1">
          Motivation
          </span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4 leading-tight">Stay Motivated Daily</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">Daily streaks, motivations, and fitness facts to keep you engaged and inspired.</p>
        <ul class="space-y-2 text-sm text-gray-600">
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Consecutive day tracking
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Daily motivational messages
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Educational fitness tips
         </li>
        </ul>
      </div>

      <!--Card 6-->
      <div class="feature-card rounded-2xl p-8 group">
        <div class="flex items-center justify-between mb-6">
          <div class="w-14 h-14 rounded-2xl gradient-orange flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-6 h-6"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>
          </div>
          <span class="text-xs font-semibold text-orange-700 bg-orange-50 border border-orange-200 rounded-full px-3 py-1">
           Reports
          </span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4 leading-tight">Weekly Performance Reports</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">Comprehensive analysis of your nutrition and workout consistency to track goal achievement.</p>
        <ul class="space-y-2 text-sm text-gray-600">
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Nutrition performance analysis
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Workout consistency tracking
         </li>
         <li class="flex items-center gap-2">
           <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
           Goal achievement metrics
         </li>
        </ul>  
      </div>

    </div>
  </div>
</section>
    
 <!-- About / Credibility -->
<section id="about" class="py-24 gradient-orange-subtle">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20">
      <h2 class="text-4xl font-bold mb-6 text-gray-900 text-balance">
        Built by Fitness Enthusiasts, For Fitness Enthusiasts
      </h2>
      <p class="text-xl text-gray-700 max-w-3xl mx-auto text-balance">
        We understand the struggle of finding affordable, personalized fitness guidance. That's why we created Fit-Track.
      </p>
    </div>
    
    <div class="grid lg:grid-cols-2 gap-16 items-center mb-16">
      <div class="bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
        <h3 class="text-3xl font-bold mb-6 text-gray-900">Our Mission</h3>
        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
          We believe everyone deserves access to personalized fitness guidance, regardless of their budget or experience level. Fit-Track democratizes health and wellness by combining cutting-edge technology with practical, affordable solutions.
        </p>
        <div class="space-y-4">
          <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <span class="text-gray-700 font-medium">Science-backed nutrition and fitness guidance</span>
          </div>
          <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <span class="text-gray-700 font-medium">Affordable and accessible to everyone</span>
          </div>
          <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <span class="text-gray-700 font-medium">Personalized for your unique journey</span>
          </div>
        </div>
      </div>
      
      <div class="space-y-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
              <span class="text-2xl font-bold text-orange-600">10k+</span>
            </div>
            <div>
              <h4 class="text-lg font-semibold text-gray-900">Active Users</h4>
              <p class="text-gray-600">Transforming lives daily</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
              <span class="text-2xl font-bold text-orange-600">4.8★</span>
            </div>
            <div>
              <h4 class="text-lg font-semibold text-gray-900">User Rating</h4>
              <p class="text-gray-600">Based on 2,500+ reviews</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
              <span class="text-2xl font-bold text-orange-600">85%</span>
            </div>
            <div>
              <h4 class="text-lg font-semibold text-gray-900">Success Rate</h4>
              <p class="text-gray-600">Users reach their goals</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-24 bg-white">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20">
      <h2 class="text-4xl font-bold mb-6 text-gray-900 text-balance">
        Frequently Asked Questions
      </h2>
      <p class="text-xl text-gray-600 text-balance">
        Got questions? We've got answers.
      </p>
    </div>

    <div class="space-y-4" id="faq-list">
      <!-- FAQ Items -->
      <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
        <button class="faq-toggle w-full flex justify-between items-center text-left p-6 hover:bg-gray-100 transition-colors">
          <span class="text-lg font-semibold text-gray-900 pr-8">
            How does Fit-Track personalize my experience?
          </span>
          <span class="faq-icon text-2xl text-orange-600 font-light transition-transform duration-200">+</span>
        </button>
        <div class="faq-content px-6 pb-6 text-gray-700 leading-relaxed hidden">
          During onboarding, you'll provide your physical stats (weight, height, age), fitness goals (weight loss or muscle gain), experience level, and workout preferences. Our algorithm uses this data to calculate personalized daily nutrition targets and create custom workout schedules that match your abilities and goals.
        </div>
      </div>

      <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
        <button class="faq-toggle w-full flex justify-between items-center text-left p-6 hover:bg-gray-100 transition-colors">
          <span class="text-lg font-semibold text-gray-900 pr-8">
            What makes the budget-based meal suggestions unique?
          </span>
          <span class="faq-icon text-2xl text-orange-600 font-light transition-transform duration-200">+</span>
        </button>
        <div class="faq-content px-6 pb-6 text-gray-700 leading-relaxed hidden">
          Unlike other apps that suggest expensive superfoods, Fit-Track considers your actual budget. You input your daily or per-meal spending limit, and we recommend affordable meal combinations that still meet your nutritional needs using locally available ingredients.
        </div>
      </div>

      <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
        <button class="faq-toggle w-full flex justify-between items-center text-left p-6 hover:bg-gray-100 transition-colors">
          <span class="text-lg font-semibold text-gray-900 pr-8">
            Do I need gym equipment to use the workout features?
          </span>
          <span class="faq-icon text-2xl text-orange-600 font-light transition-transform duration-200">+</span>
        </button>
        <div class="faq-content px-6 pb-6 text-gray-700 leading-relaxed hidden">
          No! Our workout plans are designed to be flexible. During setup, you can specify your available equipment or choose bodyweight-only options. All workouts include video demonstrations to ensure proper form, whether you're at home, in a gym, or outdoors.
        </div>
      </div>

      <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
        <button class="faq-toggle w-full flex justify-between items-center text-left p-6 hover:bg-gray-100 transition-colors">
          <span class="text-lg font-semibold text-gray-900 pr-8">
            How accurate is the nutrition tracking?
          </span>
          <span class="faq-icon text-2xl text-orange-600 font-light transition-transform duration-200">+</span>
        </button>
        <div class="faq-content px-6 pb-6 text-gray-700 leading-relaxed hidden">
          Our comprehensive food database includes thousands of items with accurate nutritional information, including many Filipino foods and local ingredients. You can also add custom foods if something isn't in our database. The system tracks calories, protein, carbs, and fats in real-time against your personalized targets.
        </div>
      </div>

      <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
        <button class="faq-toggle w-full flex justify-between items-center text-left p-6 hover:bg-gray-100 transition-colors">
          <span class="text-lg font-semibold text-gray-900 pr-8">
            What kind of progress tracking is available?
          </span>
          <span class="faq-icon text-2xl text-orange-600 font-light transition-transform duration-200">+</span>
        </button>
        <div class="faq-content px-6 pb-6 text-gray-700 leading-relaxed hidden">
          You can log your weight over time and view progress through intuitive charts and graphs. We automatically calculate your BMI and provide weekly performance reports that summarize your nutrition averages, workout consistency, and overall progress toward your goals.
        </div>
      </div>

      <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
        <button class="faq-toggle w-full flex justify-between items-center text-left p-6 hover:bg-gray-100 transition-colors">
          <span class="text-lg font-semibold text-gray-900 pr-8">
            Is Fit-Track suitable for beginners?
          </span>
          <span class="faq-icon text-2xl text-orange-600 font-light transition-transform duration-200">+</span>
        </button>
        <div class="faq-content px-6 pb-6 text-gray-700 leading-relaxed hidden">
          Absolutely! Our experience-based customization ensures beginners get appropriate workout intensity and detailed guidance. The video demonstrations are especially helpful for learning proper form, and the motivational tools help build healthy habits gradually.
        </div>
      </div>

      <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
        <button class="faq-toggle w-full flex justify-between items-center text-left p-6 hover:bg-gray-100 transition-colors">
          <span class="text-lg font-semibold text-gray-900 pr-8">
            How much does Fit-Track cost?
          </span>
          <span class="faq-icon text-2xl text-orange-600 font-light transition-transform duration-200">+</span>
        </button>
        <div class="faq-content px-6 pb-6 text-gray-700 leading-relaxed hidden">
          We offer a free tier with basic features, plus premium plans starting at ₱299/month. Our premium features include advanced analytics, unlimited meal suggestions, and priority support. We believe everyone should have access to personalized fitness guidance.
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-24 gradient-orange">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <h2 class="text-4xl font-bold text-white mb-6 text-balance">
      Ready to Transform Your Fitness Journey?
    </h2>
    <p class="text-xl text-orange-100 mb-10 max-w-2xl mx-auto text-balance">
      Join thousands of users who've already discovered the power of personalized, budget-friendly fitness guidance.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
      <button class="bg-white text-orange-600 text-lg font-bold px-8 py-4 rounded-xl hover:bg-orange-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
        Start Your Free Trial
      </button>
      <button class="text-white border-2 border-white/30 text-lg font-semibold px-8 py-4 rounded-xl hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
        Watch Demo
      </button>
    </div>
    <p class="text-orange-100 text-sm mt-6">No credit card required • Cancel anytime • 30-day money-back guarantee</p>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-4 gap-12">
      <div class="col-span-1">
        <div class="flex items-center space-x-2 mb-6">
          
          <span class="text-2xl font-bold">Fit-Track</span>
        </div>
        <p class="text-gray-400 mb-8 leading-relaxed">
          Personalized fitness and nutrition tracking that fits your budget and lifestyle.
        </p>
        <div class="flex space-x-4">
          <a href="#" class="bg-gray-800 p-3 rounded-xl hover:bg-gray-700 transition-colors group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
            </svg>
          </a>
          <a href="#" class="bg-gray-800 p-3 rounded-xl hover:bg-gray-700 transition-colors group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
              <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
            </svg>
          </a>
          <a href="#" class="bg-gray-800 p-3 rounded-xl hover:bg-gray-700 transition-colors group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.219-.359-1.219c0-1.141.662-1.992 1.488-1.992.219 0 .219.219.219.438 0 .359-.219.578-.219.937 0 .797.578 1.275 1.275 1.275.797 0 1.406-.797 1.406-1.992 0-1.033-.797-1.831-1.831-1.831-1.275 0-2.027 1.033-2.027 2.207 0 .438.141.797.359 1.033-.041.219-.219.578-.359.578-.219 0-.359-.219-.359-.578 0-.797.578-1.406 1.555-1.406.937 0 1.831.797 1.831 1.992 0 1.195-.719 2.027-1.692 2.027-.578 0-1.275-.359-1.275-1.033 0-.578.359-1.195.359-1.773 0-.797-.578-1.275-1.275-1.275-.797 0-1.406.578-1.406 1.406 0 .219.041.438.041.656-.219.937-1.406 5.957-1.406 5.957-.219.937-.105 2.027-.041 3.016C3.158 21.404.029 17.066.029 11.987.029 5.367 5.396.029 12.017.029z"/>
            </svg>
          </a>
        </div>
      </div>
      
      <div>
        <h3 class="text-lg font-semibold mb-6">Product</h3>
        <ul class="space-y-3 text-gray-400">
          <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Demo</a></li>
          <li><a href="#" class="hover:text-white transition-colors">API</a></li>
        </ul>
      </div>
      
      <div>
        <h3 class="text-lg font-semibold mb-6">Company</h3>
        <ul class="space-y-3 text-gray-400">
          <li><a href="#about" class="hover:text-white transition-colors">About</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Press</a></li>
        </ul>
      </div>
      
      <div>
        <h3 class="text-lg font-semibold mb-6">Support</h3>
        <ul class="space-y-3 text-gray-400">
          <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
        </ul>
      </div>
    </div>
    
    <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
      <p>&copy; 2025 Fit-Track. All rights reserved. Built with care for your fitness journey.</p>
    </div>
  </div>
</footer>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".faq-toggle");
    document.body.classList.add('loaded');

    toggles.forEach(toggle => {
      toggle.addEventListener("click", function () {
        const content = this.nextElementSibling;
        const icon = this.querySelector(".faq-icon");

        if (content.classList.contains("hidden")) {
          content.classList.remove("hidden");
          content.classList.add("show");
          icon.style.transform = "rotate(45deg)";
        } else {
          content.classList.add("hidden");
          content.classList.remove("show");
          icon.style.transform = "rotate(0deg)";
        }
      });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Add intersection observer for animations
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

    // Observe elements for animation
    document.querySelectorAll('.feature-card, .comparison-card').forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'all 0.6s ease-out';
      observer.observe(el);
    });
  });
</script>