<x-guest-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

            <!-- Header and Filters -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Alumni Job Board</h1>
                <p class="text-gray-600 mb-6">Find your next career opportunity.</p>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('jobs.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Keyword -->
                        <div class="md:col-span-2">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" name="search" id="search" placeholder="Search by keyword (e.g., 'Developer')"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ request('search') }}">
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="sr-only">Location</label>
                            <input type="text" name="location" id="location" placeholder="Location"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ request('location') }}">
                        </div>

                        <!-- Job Type -->
                        <div>
                            <label for="job_type" class="sr-only">Job Type</label>
                            <select name="job_type" id="job_type"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Types</option>
                                <option value="Full-time" {{ request('job_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="Part-time" {{ request('job_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="Contract" {{ request('job_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                <option value="Internship" {{ request('job_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('jobs.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Clear Filters</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Job Listings -->
            <div class="space-y-4">
                @forelse ($jobs as $job)
                    <a href="{{ route('jobs.show', $job) }}" class="block">
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">{{ $job->title }}</h2>
                                    <p class="text-gray-600">{{ $job->companyProfile->company_name }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block bg-gray-200 text-gray-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $job->job_type }}</span>
                                    <p class="text-sm text-gray-500 mt-2">{{ $job->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-gray-500 mt-2">{{ $job->location }}</p>
                        </div>
                    </a>
                @empty
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <p class="text-gray-600">No jobs found matching your criteria. Try adjusting your filters.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>
