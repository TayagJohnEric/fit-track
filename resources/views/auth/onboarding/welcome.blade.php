@extends('layout.onboarding')



@section('content')
<div class="space-y-8">
    <!-- Welcome Message -->
    <div class="bg-orange-50 rounded-xl p-6 ">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white lucide lucide-zap-icon lucide-zap"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    Hello, {{ auth()->user()->name }}! 👋
                </h3>
                <p class="text-gray-600 text-sm">
                    Ready to transform your fitness journey? Let's get started!
                </p>
            </div>
        </div>  
    </div>

    <!-- What You'll Get -->
    <div class="space-y-4">
        <h3 class="text-lg font-semibold text-gray-900">What you'll get:</h3>
        
        <div class="grid gap-4">
            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">Personalized Workout Plans</h4>
                    <p class="text-sm text-gray-600">Customized exercises based on your fitness level and goals</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">Custom Nutrition Goals</h4>
                    <p class="text-sm text-gray-600">Meal recommendations tailored to your dietary preferences and budget</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">Progress Tracking</h4>
                    <p class="text-sm text-gray-600">Monitor your achievements and stay motivated</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Setup Process -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Setup Process</h3>
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs font-medium">1</div>
                <span class="text-gray-700">Personal Info</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-300 mx-4"></div>
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-xs font-medium">2</div>
                <span class="text-gray-600">Fitness Goals</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-300 mx-4"></div>
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-xs font-medium">3</div>
                <span class="text-gray-600">Final Details</span>
            </div>
        </div>
    </div>

    <!-- CTA Button -->
    <div class="flex justify-end pt-4">
        <a href="{{ route('onboarding.step1') }}" 
           class="inline-flex items-center text-sm px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white font-bold rounded-lg transition duration-200 space-x-2">
            <span>Start Setup</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 lucide lucide-arrow-right-icon lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </div>
</div>
@endsection