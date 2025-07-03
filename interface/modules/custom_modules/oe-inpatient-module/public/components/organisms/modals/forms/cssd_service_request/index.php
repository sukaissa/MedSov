<div id="cssdServiceRequestForm" class="hidden pb-4">
    <form action="" method="POST">
        <input type="hidden" name="new" value="1">
        <div class="mt-6 flex justify-between items-center">
            <p class="text-[#282224] text-2xl font-semibold">New CSSD Service Request</p>
        </div>
        <div class="flex flex-col gap-4 my-6  max-h-[400px] overflow-auto">
            <div>
                <label class="font-medium" for="">Service Name<span class="text-[#ED2024]">*</span></label>
                <input type="text" name="name"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="name">
            </div>

            <div>
                <label class="font-medium" for="">Item<span class="text-[#ED2024]">*</span></label>
                <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="item" name="item">
                    <option value="">Select Item</option>
                </select>
            </div>

            <div>
                <label class="font-medium" for="">Quantity<span class="text-[#ED2024]">*</span></label>
                <input type="number" name="quantity"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="quantity">
            </div>

            <div>
                <label class="font-medium" for="">Request Date<span class="text-[#ED2024]">*</span></label>
                <input type="date" name="request_date"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="request_date">
            </div>


            <div>
                <label class="font-medium" for="">Requested By<span class="text-[#ED2024]">*</span></label>
                <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="item" name="item">
                    <option value="">Select User</option>
                </select>
            </div>


            <div>
                <label class="font-medium" for="">Request Status<span class="text-[#ED2024]">*</span></label>
                <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="item" name="item">
                    <option value="">Select Status</option>
                </select>
            </div>

            <div>
                <label class="font-medium" for="">Request Process Date<span class="text-[#ED2024]">*</span></label>
                <input type="date" name="request_process_date"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="request_process_date">
            </div>


            <div>
                <label class="font-medium" for="">Request Processed By<span class="text-[#ED2024]">*</span></label>
                <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="item" name="item">
                    <option value="">Select</option>
                </select>
            </div>


            <div>
                <label class="font-medium" for="">Recieved By<span class="text-[#ED2024]">*</span></label>
                <select class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="item" name="item">
                    <option value="">Select</option>
                </select>
            </div>
        </div>
        <button type="submit" class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold">Save</button>
    </form>
</div>