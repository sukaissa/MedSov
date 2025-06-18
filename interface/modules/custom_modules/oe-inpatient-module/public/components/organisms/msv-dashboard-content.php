<main class="flex-1">
    <div class="bg-gradient-to-b from-[#FFA97F] to-[#ED2024] text-white p-6 pb-10">
        <div class="flex justify-between items-start mb-4">
            <span class="text-xs opacity-90">Patient ID: 1234567890</span>
        </div>
        <div class="flex items-center space-x-4">
            <img src="./assets/img/patient.png" alt="Patient" class="w-[50px] h-[50px] object-fit-contain" />

            <div>
                <h1 class="text-3xl font-medium leading-none">John Doe</h1>
                <p class="text-[16px] opacity-90 leading-none font-medium">male • 1990/01/23 • English</p>
            </div>
        </div>
        <p class="my-4 text-[16px] leading-none opacity-90 max-w-2xl">
            John was admitted to oncology ward for management of AML complications including febrile neutropenia and
            severe anemia. He is receiving induction chemotherapy, transfusions and monitoring for side effects.
        </p>
    </div>
    <div class="w-full flex items-center justify-center">
        <div class="w-[1100px] -mt-10">
            <!-- Content Grid -->
            <div class=" gap-5 flex">
                <!-- Admission Details -->
                <div class="bg-white w-[400px] h-fit border border-gray-200 p-6">
                    <h2 class="text-sm text-[#8D8D8D] mb-2">Admission Details</h2>
                    <div class="space-y-4">
                        <div class="border-b border-b-4 border-b-[#282224]">
                            <div>
                                <h3 class=" text-2xl font-bold text-gray-900 mb-1">Emergency</h3>
                                <p class="text-sm font-semibold text-[#282224]">Admission Type</p>
                            </div>

                            <div class="space-y-2 text-sm mt-4 pb-5">
                                <div class="flex gap-4">
                                    <span class="w-[70px] text-gray-600">Date/Time</span>
                                    <p class="flex-1 font-medium">May 1, 2025 • 15:21</p>
                                </div>
                                <div class="flex gap-4">
                                    <span class="w-[70px]  text-gray-600">Dept</span>
                                    <p class="flex-1 font-medium">Emergency Department</p>
                                </div>
                                <div class="flex gap-4">
                                    <span class="w-[70px] text-gray-600">Doctor</span>
                                    <p class="flex-1 font-medium">Dr. Bell Mitchells</p>
                                </div>
                            </div>

                        </div>


                        <div class="space-y-2 text-sm mt-4 pb-5 border-b border-b-4 border-b-[#282224]">
                            <div class="flex gap-4">
                                <span class="w-[70px] text-gray-600">Bed</span>
                                <p class="flex-1 font-medium">3</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="w-[70px]  text-gray-600">Room</span>
                                <p class="flex-1 font-medium">121-D</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="w-[70px] text-gray-600">Ward</span>
                                <p class="flex-1 font-medium">Oncology</p>
                            </div>
                        </div>



                        <button
                            class="w-full h-[87px] bg-white border-2 border-[#D9D9D9] py-3 px-4 rounded-lg hover:bg-coral hover:text-white transition-colors flex items-center justify-center space-x-2">
                            <img src="./assets/img/care-icon.svg" alt="care-icon" class="w-5 h-5">
                            <div class="text-left">
                                <p class="text-sm leading-none">Activate</p>
                                <p class="font-semibold leading-none">PersonalCare™</p>
                            </div>

                        </button>
                    </div>
                </div>



                <div class="flex-1">
                    <!-- Care Schedule -->
                    <div class=" bg-white flex-1 border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-sm text-gray-500">Care Schedule</h2>

                        </div>

                        <div
                            class="flex justify-between items-center p-4 bg-gray-50 rounded-md h-[90px] border border-[#D9D9D9]">

                            <div class="flex items-center space-x-4">
                                <div
                                    class="border border-[#D9D9D9] bg-white rounded-md py-2 px-5 text-2xl font-bold text-gray-900">
                                    16:00</div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Blood Draw (CBC, CMP)</h3>
                                    <p class="text-sm text-gray-600">Laboratory • Phlebotomy Room 2</p>
                                </div>
                            </div>


                            <button
                                class="bg-coral text-white h-[40px] px-4 py-2 rounded-md text-sm font-medium hover:bg-coral-light transition-colors">
                                View Schedule
                            </button>
                        </div>

                        <div class="mt-4 text-center">
                            <button class="text-coral text-sm font-medium hover:underline">
                                See Full Schedule
                            </button>
                        </div>
                    </div>


                    <!-- Clinical Information -->
                    <div class="mt-8 bg-white mt-4 border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-sm text-gray-500">Clinical Information</h3>
                            <span class="text-xs text-gray-400">Last Update: May 1, 2025 • 15:48</span>
                        </div>

                        <div class="grid lg:grid-cols-6 gap-4 mb-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">36.8</div>
                                <div class="text-xs text-gray-600">Temperature</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">78</div>
                                <div class="text-xs text-gray-600">Heart Rate</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">16</div>
                                <div class="text-xs text-gray-600">Respiratory Rate</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">120/76</div>
                                <div class="text-xs text-gray-600">Blood Pressure</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">98%</div>
                                <div class="text-xs text-gray-600">SpO₂</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">2</div>
                                <div class="text-xs text-gray-600">Pain Score</div>
                            </div>
                        </div>

                        <!-- Allergies -->
                        <div
                            class="bg-red-50 justify-between flex items-center border border-red-200 rounded-lg p-4 flex mb-4">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium text-red-800">Allergies:</span>
                                <span class="text-red-700">Penicillin • Sulfa • Latex • Peanuts • Shellfish</span>

                            </div>
                            <button
                                class="w-fit h-[30px] bg-white border-2 border-coral text-center px-4  rounded-md text-xs font-medium hover:bg-coral hover:text-white transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>

                    <!-- Medication & Orders -->
                    <div class="mt-8 bg-white mt-4 border border-gray-200 p-6">
                        <h3 class="text-sm text-gray-500 mb-4">Medication & Orders</h3>
                        <div class="text-center py-8 text-gray-400">
                            <p class="text-sm">No current medications or orders</p>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>



</main>