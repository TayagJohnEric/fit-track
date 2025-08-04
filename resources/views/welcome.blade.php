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
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@800&display=swap"
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

  h1 {
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
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

  /* Feature Card Hover Effects */
  .feature-card {
    background: white;
    transition: all 0.3s ease;
    border: 1px solid transparent;
  }

  .feature-card:hover {
    transform: translateY(-8px);
    box-shadow:
      0 20px 40px rgba(0, 0, 0, 0.15),
      0 20px 25px -5px rgb(0 0 0 / 0.1),
      0 8px 10px -6px rgb(0 0 0 / 0.1);
    border-color: rgb(234 88 12 / 0.2);
  }

  /* Icon Container Hover Effects */
  .icon-container {
    background: linear-gradient(135deg, rgb(234 88 12) 0%, rgb(194 65 12) 100%);
    transition: all 0.3s ease;
  }

  .feature-card:hover .icon-container {
    transform: scale(1.05);
    box-shadow: 0 8px 16px -4px rgb(234 88 12 / 0.4);
  }

  /* Feature Badge Hover Effects */
  .feature-badge {
    transition: all 0.3s ease;
  }

  .feature-card:hover .feature-badge {
    background: rgb(255 247 237);
    border-color: rgb(234 88 12 / 0.3);
    color: rgb(194 65 12);
  }

  /* Reduced Motion Support */
  @media (prefers-reduced-motion: reduce) {
    .feature-card, .icon-container, .feature-badge {
      transition: none;
    }

    .feature-card:hover,
    .feature-card:hover .icon-container {
      transform: none;
      box-shadow: none;
    }
  }

  /* Optional: Background for interactive demos */
  .interactive-demo {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
  }
</style>

  </head>
  <body class="bg-gray-50">
  
   <!-- Full-width background wrapper -->
<div class="w-full">
  <!-- Background wrapper with image support -->
  <div class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('fit-track-hero3.png');">
    <!-- Dark overlay to match gym-themed palette -->
    <div class="absolute inset-0 bg-black/70"></div>

    <!-- Content on top of background -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 py-9">

     <!-- Header -->
<header class="flex items-center justify-between py-3 px-5 bg-black/30 backdrop-blur-md mb-16 rounded-2xl">
  <!-- Logo -->
  <div class="w-16 h-8 flex items-center justify-center font-bold text-sm tracking-wide text-white">
    FitTrack
  </div>

  <!-- Centered nav -->
  <nav class="flex-1 flex justify-center space-x-8 ml-12">
    <a href="#features" class="text-xs font-light text-gray-300 hover:text-white transition-colors">Features</a>
    <a href="#how-it-works" class="text-xs font-light text-gray-300 hover:text-white transition-colors">How It Works</a>
    <a href="#about" class="text-xs font-light text-gray-300 hover:text-white transition-colors">About</a>
    <a href="#faq" class="text-xs font-light text-gray-300 hover:text-white transition-colors">FAQs</a>
  </nav>

 <!-- Auth buttons -->
<div class="flex items-center space-x-2">
  <button class="text-white text-xs font-semibold px-6 py-2 transition-all duration-300 rounded-lg border border-white hover:bg-white hover:text-black hover:shadow-xl">
        Login
  </button>
  <button class="text-white text-xs font-semibold px-6 py-2 transition-all duration-300 rounded-lg bg-orange-600 hover:bg-orange-700 hover:text-white hover:shadow-xl">
    Signup
  </button>
</div>
</header>

      <!-- Hero Section -->
      <section class="py-24 overflow-hidden">
        <div class="text-center mb-20 slide-in-up">
       
            <!-- Feature label -->
            <div class="flex justify-center items-center mb-8">
              <span class="flex items-center gap-2 px-4 py-2 text-[10px] font-semibold text-white bg-black/30 backdrop-blur-md border border-white/20 rounded-2xl shadow-sm">
                <i class="fas fa-bolt text-orange-500"></i>
                Customized Plans, Simplified Life
              </span>
            </div>

          <!-- Main Header -->
          <h1 class="font-extrabold text-4xl sm:text-5xl md:text-6xl max-w-4xl mx-auto leading-tight text-white mb-6">
            FITNESS THAT FINALLY
            <br>
            FITS YOUR LIFE
          </h1>

          <!-- Sub Header -->
          <p class="text-sm sm:text-base text-gray-100 font-medium max-w-2xl mx-auto mb-10 leading-relaxed">
            Get your custom plan with personalized workouts, easy nutrition tracking, and budget-friendly meals. All designed for your goals and your life.
          </p>

          <!-- CTA Buttons -->
          <div class="flex justify-center space-x-4">
            <button class="bg-orange-600  text-white text-sm font-semibold px-8 py-3 flex items-center space-x-2 hover:bg-orange-700  transition-all shadow-lg rounded-xl">
              <i class="fas fa-arrow-right"></i>
              <span>Get Your Personal Plan</span>
            </button>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>


 <!-- How It Works -->
    <section id="how-it-works" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-semibold mb-6 text-gray-900  tracking-tight">
                    How Fit-Track Works
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto  tracking-tight">
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
            <div class="interactive-demo rounded-3xl border-2 border-gray-200 p-8 max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold mb-6 text-center tracking-tight">Try Our Interactive Demo</h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h4 class="text-lg font-semibold mb-4">Daily Nutrition Tracker</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span>Calories</span>
                                <span class="font-semibold">1,847 / 2,200</span>
                            </div>
                            <div class="bg-gray-200 rounded-full h-3">
                                <div class="bg-gray-800 h-3 rounded-full" style="width: 84%"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div class="text-center">
                                    <div class="font-semibold">Protein</div>
                                    <div class="text-gray-600">120g / 150g</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold">Carbs</div>
                                    <div class="text-gray-600">180g / 220g</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold">Fat</div>
                                    <div class="text-gray-600">65g / 80g</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h4 class="text-lg font-semibold mb-4">Budget-Smart Meal Suggestion</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span>Daily Budget</span>
                                <span class="font-semibold text-green-600">₱15.00</span>
                            </div>
                            <div class="bg-gray-100 rounded-lg p-3">
                                <div class="font-medium text-sm mb-1">Suggested Lunch</div>
                                <div class="text-sm text-gray-600">
                                    Grilled chicken breast with quinoa and vegetables
                                </div>
                                <div class="flex justify-between mt-2 text-sm">
                                    <span>Cost: ₱4.50</span>
                                    <span class="text-green-600">490 calories</span>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                Remaining budget: ₱10.50
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-8">
                    <button class="bg-gray-900 text-sm text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-800 transition-colors">
                        Try Full Demo
                    </button>
                </div>
            </div>
        </div>
    </section>
    

     <!-- Problem & Solution Section -->
<section class="py-24 mt-24 rounded-xl">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Heading -->
    <div class="text-center mb-16">
      <h2 class="text-3xl font-semibold text-gray-900 mb-4  tracking-tight">
        Why Most Fitness Apps Fail You
      </h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto  tracking-tight">
        Generic plans, expensive meal suggestions, and lack of personal guidance leave you frustrated and unmotivated.
      </p>
    </div>

    <!-- Problem & Solution Cards -->
    <div class="flex flex-col md:flex-row gap-10 justify-center items-start">
      
     <!-- Problem -->
<div class="feature-card bg-white border border-gray-200 rounded-xl shadow-lg p-8 w-full max-w-md flex flex-col items-center">
  <div class="bg-red-200 w-12 h-12 rounded-full flex items-center justify-center mb-4">
    <i class="fas fa-times text-red-600 text-xl"></i>
  </div>
  <h3 class="text-lg font-semibold text-center mb-6">The Problem</h3>
  <ul class="space-y-6 text-sm text-gray-600 w-full leading-relaxed">
    <li class="flex items-start gap-3">
      <div class="bg-red-200 w-6 h-6 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
        <i class="fas fa-times text-red-600 text-xs"></i>
      </div>
      <div class="flex flex-col">
        <h4 class="font-semibold text-md mb-1">One-Size-Fits-All Approach</h4>
        <p>Generic workout plans that don't consider your experience level or goals.</p>
      </div>
    </li>
    <li class="flex items-start gap-3">
      <div class="bg-red-200 w-6 h-6 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
        <i class="fas fa-times text-red-600 text-xs"></i>
      </div>
      <div class="flex flex-col">
        <h4 class="font-semibold text-md mb-1">Expensive Meal Plans</h4>
        <p>Nutrition advice that ignores your budget constraints.</p>
      </div>
    </li>
    <li class="flex items-start gap-3">
      <div class="bg-red-200 w-6 h-6 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
        <i class="fas fa-times text-red-600 text-xs"></i>
      </div>
      <div class="flex flex-col">
        <h4 class="font-semibold text-md mb-1">Poor Form Guidance</h4>
        <p>No video demonstrations leading to injuries and ineffective workouts.</p>
      </div>
    </li>
  </ul>
</div>

   <!-- Solution -->
<div class="feature-card border border-gray-200 rounded-xl shadow-lg p-8 w-full max-w-md flex flex-col items-center">
  <div class="bg-green-200 w-12 h-12 rounded-full flex items-center justify-center mb-4">
    <i class="fas fa-check text-green-600 text-xl"></i>
  </div>
  <h3 class="text-lg font-semibold text-center mb-6">Our Solution</h3>
  <ul class="space-y-6 text-sm text-gray-600 w-full leading-relaxed">
    <li class="flex items-start gap-3">
      <div class="bg-green-200 w-6 h-6 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
        <i class="fas fa-check text-green-600 text-xs"></i>
      </div>
      <div class="flex flex-col">
        <h4 class="font-semibold text-md mb-1">Personalized Everything</h4>
        <p>Tailored workouts and nutrition based on your goals, experience, and preferences.</p>
      </div>
    </li>
    <li class="flex items-start gap-3">
      <div class="bg-green-200 w-6 h-6 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
        <i class="fas fa-check text-green-600 text-xs"></i>
      </div>
      <div class="flex flex-col">
        <h4 class="font-semibold text-md mb-1">Budget-Smart Nutrition</h4>
        <p>Meal suggestions that fit your budget while meeting your nutritional needs.</p>
      </div>
    </li>
    <li class="flex items-start gap-3">
      <div class="bg-green-200 w-6 h-6 rounded-full flex items-center justify-center mt-1 flex-shrink-0">
        <i class="fas fa-check text-green-600 text-xs"></i>
      </div>
      <div class="flex flex-col">
        <h4 class="font-semibold text-md mb-1">Video-Guided Workouts</h4>
        <p>Professional demonstrations for every exercise to ensure proper form and safety.</p>
      </div>
    </li>
  </ul>
</div>
      </div>
    </div>
  </div>
</section>


 <!-- Key Features -->
   <section id="features" class="py-20">
  <div class="max-w-6xl mx-auto px-6 sm:px-8">
    <div class="text-center mb-16">
      <h3 class="text-3xl sm:text-3xl font-semibold mb-6 text-gray-900  tracking-tight">
        Everything You Need to Succeed
      </h3>
      <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed  tracking-tight">
        Powerful features designed to keep you motivated, informed, and on track toward your fitness goals.
      </p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      

        <!--Card 1-->
      <div class=" p-6 flex flex-col gap-4">
        <div class="flex justify-between items-center">
          <div class="w-10 h-10 rounded-lg bg-black flex items-center justify-center shadow-md">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-5 h-5 lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <button class="text-xs font-medium text-black bg-white border border-gray-300 rounded-full px-3 py-1 flex items-center gap-1 hover:bg-gray-50">
            Personalized Onboarding 
          </button>
        </div>
        <h3 class="text-sm font-semibold text-black leading-tight">Complete profile setup with physical stats, fitness goals, and experience level for tailored nutrition targets.</h3>
        <p class="text-xs text-gray-600 leading-snug">
         • Weight Loss or Muscle Gain goals</br>
         • Experience-based customization</br>
         • Automatic macro calculations </br>
        </p>
      </div>

     <!--Card 2-->
       <div class=" p-6 flex flex-col gap-4">
        <div class="flex justify-between items-center">
          <div class="w-10 h-10 rounded-lg bg-black flex items-center justify-center shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-5 h-5 lucide lucide-video-icon lucide-video"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>          </div>
          <button class="text-xs font-medium text-black bg-white border border-gray-300 rounded-full px-3 py-1 flex items-center gap-1 hover:bg-gray-50">
            Video-Guided Workouts
          </button>
        </div>
        <h3 class="text-sm font-semibold text-black leading-tight">Professional demonstrations for every exercise with detailed sets, reps, and rest times.</h3>
        <p class="text-xs text-gray-600 leading-snug">
         • Weekly workout schedules</br>
         • Proper form demonstrations</br>
         • Safety-focused guidance </br>
        </p>
      </div>

      <!--Card 3-->
     <div class=" p-6 flex flex-col gap-4">
        <div class="flex justify-between items-center">
          <div class="w-10 h-10 rounded-lg bg-black flex items-center justify-center shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white h-4 w-4 lucide lucide-philippine-peso-icon lucide-philippine-peso"><path d="M20 11H4"/><path d="M20 7H4"/><path d="M7 21V4a1 1 0 0 1 1-1h4a1 1 0 0 1 0 12H7"/></svg>          </div>
          <button class="text-xs font-medium text-black bg-white border border-gray-300 rounded-full px-3 py-1 flex items-center gap-1 hover:bg-gray-50">
          Budget-Smart Meals
          </button>
        </div>
        <h3 class=" text-sm font-semibold text-black leading-tight">Unique meal suggestions that fit your budget while meeting your nutritional targets.</h3>
        <p class="text-xs text-gray-600 leading-snug">
         • Daily or per-meal budgets</br>
         • Affordable meal combinations</br>
         • Nutritionally balanced options</br>
        </p>
      </div>


      <!--Card 4-->
     <div class=" p-6 flex flex-col gap-4">
        <div class="flex justify-between items-center">
          <div class="w-10 h-10 rounded-lg bg-black flex items-center justify-center shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white h-5 w-5 lucide lucide-chart-line-icon lucide-chart-line"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="m19 9-5 5-4-4-3 3"/></svg>          </div>
          <button class="text-xs font-medium text-black bg-white border border-gray-300 rounded-full px-3 py-1 flex items-center gap-1 hover:bg-gray-50">
           Progress Tracking
          </button>
        </div>
        <h3 class="text-sm font-semibold text-black leading-tight">Visual charts and BMI calculations to monitor your health journey over time.</h3>
        <p class="text-xs text-gray-600 leading-snug">
         •  Weight tracking charts</br>
         • Automatic BMI calculations</br>
         • Visual progress reports</br>
        </p>
      </div>


      <!--Card 5-->
     <div class=" p-6 flex flex-col gap-4">
        <div class="flex justify-between items-center">
          <div class="w-10 h-10 rounded-lg bg-black flex items-center justify-center shadow-md">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-5 h-5 lucide lucide-biceps-flexed-icon lucide-biceps-flexed"><path d="M12.409 13.017A5 5 0 0 1 22 15c0 3.866-4 7-9 7-4.077 0-8.153-.82-10.371-2.462-.426-.316-.631-.832-.62-1.362C2.118 12.723 2.627 2 10 2a3 3 0 0 1 3 3 2 2 0 0 1-2 2c-1.105 0-1.64-.444-2-1"/><path d="M15 14a5 5 0 0 0-7.584 2"/><path d="M9.964 6.825C8.019 7.977 9.5 13 8 15"/></svg>          </div>
          <button class="text-xs font-medium text-black bg-white border border-gray-300 rounded-full px-3 py-1 flex items-center gap-1 hover:bg-gray-50">
          Motivational Tools
          </button>
        </div>
        <h3 class="text-sm font-semibold text-black leading-tight">Daily streaks, motivations, and fitness facts to keep you engaged and inspired.</h3>
        <p class="text-xs text-gray-600 leading-snug">
         • Consecutive day tracking</br>
         • Daily motivational messages</br>
         • Educational fitness tips</br>
        </p>
      </div>

      <!--Card 6-->
      <div class=" p-6 flex flex-col gap-4">
        <div class="flex justify-between items-center">
          <div class="w-10 h-10 rounded-lg bg-black flex items-center justify-center shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white h-5 w-5 lucide lucide-file-icon lucide-file"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>          </div>
          <button class="text-xs font-medium text-black bg-white border border-gray-300 rounded-full px-3 py-1 flex items-center gap-1 hover:bg-gray-50">
           Weekly Reports
          </button>
        </div>
        <h3 class="text-sm font-semibold text-black leading-tight">Visual charts and BMI calculations to monitor your health journey over time.</h3>
        <p class="text-xs text-gray-600 leading-snug">
         • Nutrition performance analysis</br>
         • Workout consistency tracking</br>
         • Goal achievement metrics</br>
        </p>  
      </div>

    </div>
  </div>
</section>
    
 <!-- About / Credibility -->
    <section id="about" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-semibold mb-6 text-gray-900  tracking-tight">
                    Built by Fitness Enthusiasts, For Fitness Enthusiasts
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto  tracking-tight">
                    We understand the struggle of finding affordable, personalized fitness guidance. That's why we created Fit-Track.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-16 items-center mb-16">
                <div>
                    <h3 class="text-3xl font-bold mb-6">Our Mission</h3>
                    <p class="text-lg text-gray-600 mb-6">
                        We believe everyone deserves access to personalized fitness guidance, regardless of their budget or experience level. Fit-Track democratizes health and wellness by combining cutting-edge technology with practical, affordable solutions.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 rounded-full p-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700">Science-backed nutrition and fitness guidance</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 rounded-full p-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700">Affordable and accessible to everyone</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 rounded-full p-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700">Personalized for your unique journey</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">1000+</div>
                        <div class="text-gray-600">Active Users</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">95%</div>
                        <div class="text-gray-600">Success Rate</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">500k+</div>
                        <div class="text-gray-600">Workouts Completed</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">4.9/5</div>
                        <div class="text-gray-600">User Rating</div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonials -->
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl">★★★★★</div>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "Finally, a fitness app that considers my budget! The meal suggestions are practical and actually affordable. I've lost 15 pounds in 3 months."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="bg-gray-300 rounded-full w-10 h-10"></div>
                        <div>
                            <div class="font-semibold">Sarah M.</div>
                            <div class="text-sm text-gray-500">College Student</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl">★★★★★</div>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "The video demonstrations are a game-changer. As a beginner, I felt confident knowing I was doing exercises correctly. Great results!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="bg-gray-300 rounded-full w-10 h-10"></div>
                        <div>
                            <div class="font-semibold">Mike R.</div>
                            <div class="text-sm text-gray-500">Fitness Beginner</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl">★★★★★</div>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "The weekly reports keep me motivated and accountable. I love seeing my progress visualized. This app has transformed my relationship with fitness."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="bg-gray-300 rounded-full w-10 h-10"></div>
                        <div>
                            <div class="font-semibold">Emily K.</div>
                            <div class="text-sm text-gray-500">Working Professional</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- FAQ Section -->
   <section id="faq" class="py-20">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl font-semibold mb-6 text-gray-900 tracking-tight">
        Frequently Asked Questions
      </h2>
      <p class="text-xl text-gray-600 tracking-tight ">
        Got questions? We've got answers.
      </p>
    </div>

    <div class="space-y-4" id="faq-list">
      <!-- FAQ Item Template -->
      <div class="border-b py-4">
        <button class="faq-toggle w-full flex justify-between items-center text-left">
          <span class="text-lg font-medium text-gray-900">
            How does Fit-Track personalize my experience?
          </span>
          <span class="faq-icon text-xl">+</span>
        </button>
        <div class="faq-content mt-2 text-gray-600 hidden">
          During onboarding, you'll provide your physical stats (weight, height, age), fitness goals (weight loss or muscle gain), experience level, and workout preferences. Our algorithm uses this data to calculate personalized daily nutrition targets and create custom workout schedules that match your abilities and goals.
        </div>
      </div>

      <div class="border-b py-4">
        <button class="faq-toggle w-full flex justify-between items-center text-left">
          <span class="text-lg font-medium text-gray-900">
            What makes the budget-based meal suggestions unique?
          </span>
          <span class="faq-icon text-xl">+</span>
        </button>
        <div class="faq-content mt-2 text-gray-600 hidden">
          Unlike other apps that suggest expensive superfoods, Fit-Track considers your actual budget. You input your daily or per-meal spending limit, and we recommend affordable meal combinations that still meet your nutritional needs.
        </div>
      </div>

      <div class="border-b py-4">
        <button class="faq-toggle w-full flex justify-between items-center text-left">
          <span class="text-lg font-medium text-gray-900">
            Do I need gym equipment to use the workout features?
          </span>
          <span class="faq-icon text-xl">+</span>
        </button>
        <div class="faq-content mt-2 text-gray-600 hidden">
          No! Our workout plans are designed to be flexible. During setup, you can specify your available equipment or choose bodyweight-only options. All workouts include video demonstrations to ensure proper form, whether you're at home, in a gym, or outdoors.
        </div>
      </div>

      <div class="border-b py-4">
        <button class="faq-toggle w-full flex justify-between items-center text-left">
          <span class="text-lg font-medium text-gray-900">
            How accurate is the nutrition tracking?
          </span>
          <span class="faq-icon text-xl">+</span>
        </button>
        <div class="faq-content mt-2 text-gray-600 hidden">
          Our comprehensive food database includes thousands of items with accurate nutritional information. You can also add custom foods if something isn't in our database. The system tracks calories, protein, carbs, and fats in real-time against your personalized targets.
        </div>
      </div>

      <div class="border-b py-4">
        <button class="faq-toggle w-full flex justify-between items-center text-left">
          <span class="text-lg font-medium text-gray-900">
            What kind of progress tracking is available?
          </span>
          <span class="faq-icon text-xl">+</span>
        </button>
        <div class="faq-content mt-2 text-gray-600 hidden">
          You can log your weight over time and view progress through intuitive charts. We automatically calculate your BMI and provide weekly performance reports that summarize your nutrition averages, workout consistency, and overall progress toward your goals.
        </div>
      </div>

      <div class="border-b py-4">
        <button class="faq-toggle w-full flex justify-between items-center text-left">
          <span class="text-lg font-medium text-gray-900">
            Is Fit-Track suitable for beginners?
          </span>
          <span class="faq-icon text-xl">+</span>
        </button>
        <div class="faq-content mt-2 text-gray-600 hidden">
          Absolutely! Our experience-based customization ensures beginners get appropriate workout intensity and detailed guidance. The video demonstrations are especially helpful for learning proper form, and the motivational tools help build healthy habits gradually.
        </div>
      </div>

      <div class="border-b py-4">
        <button class="faq-toggle w-full flex justify-between items-center text-left">
          <span class="text-lg font-medium text-gray-900">
            How much does Fit-Track cost?
          </span>
          <span class="faq-icon text-xl">+</span>
        </button>
        <div class="faq-content mt-2 text-gray-600 hidden">
          We offer a free tier with basic features, plus premium plans starting at $9.99/month. Our premium features include advanced analytics, unlimited meal suggestions, and priority support. We believe everyone should have access to personalized fitness guidance.
        </div>
      </div>
    </div>
  </div>
   </section>
</div>

     <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-1">
                    <div class="text-2xl font-bold mb-6">Fit-Track</div>
                    <p class="text-gray-400 mb-6">
                        Personalized fitness and nutrition tracking that fits your budget and lifestyle.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-800 p-3 rounded-full hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-800 p-3 rounded-full hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-800 p-3 rounded-full hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.219-.359-1.219c0-1.141.662-1.992 1.488-1.992.219 0 .219.219.219.438 0 .359-.219.578-.219.937 0 .797.578 1.275 1.275 1.275.797 0 1.406-.797 1.406-1.992 0-1.033-.797-1.831-1.831-1.831-1.275 0-2.027 1.033-2.027 2.207 0 .438.141.797.359 1.033-.041.219-.219.578-.359.578-.219 0-.359-.219-.359-.578 0-.797.578-1.406 1.555-1.406.937 0 1.831.797 1.831 1.992 0 1.195-.719 2.027-1.692 2.027-.578 0-1.275-.359-1.275-1.033 0-.578.359-1.195.359-1.773 0-.797-.578-1.275-1.275-1.275-.797 0-1.406.578-1.406 1.406 0 .219.041.438.041.656-.219.937-1.406 5.957-1.406 5.957-.219.937-.105 2.027-.041 3.016C3.158 21.404.029 17.066.029 11.987.029 5.367 5.396.029 12.017.029z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Product</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Demo</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Press</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Fit-Track. All rights reserved. Built with ❤️ for your fitness journey.</p>
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
          icon.textContent = "×";
        } else {
          content.classList.add("hidden");
          icon.textContent = "+";
        }
      });
    });
  });
</script>

  </body>
</html>
