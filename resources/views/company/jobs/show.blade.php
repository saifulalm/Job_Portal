<x-guest-layout>
    <div class="bg-gray-100">
        <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 sm:p-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <a href="{{ route('jobs.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">&larr; Back to all jobs</a>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">{{ $job->title }}</h1>
                        <p class="text-xl text-gray-600 mt-1">{{ $job->companyProfile->company_name }}</p>
                    </div>

                    <!-- Job Meta Info -->
                    <div class="flex flex-wrap gap-x-6 gap-y-2 text-gray-600 mb-6 border-t border-b border-gray-200 py-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $job->location }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>{{ $job->job_type }}</span>
                        </div>
                        @if($job->salary)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path></svg>
                                <span>{{ $job->salary }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Job Description -->
                    <div class="prose max-w-none text-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Job Description</h3>
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                <!-- Apply Button Footer -->
                <div class="bg-gray-50 px-6 py-4">
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
