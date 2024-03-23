<div class="m-6 bg-white rounded-md px-5 py-4">
    <h2>Edit Profile</h2>
    <div class="grid grid-cols-3 gap-2 mt-4">
        <div class="relative flex">
            <label for="firstName" class="text-gray-700 text-xs font-medium py-1 mr-2">First Name :</label>
            <input type="text" name="firstName" id="firstName" class="border border-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs" value="firstName">
        </div>
        <div class="relative flex">
            <label for="lastName" class="text-gray-700 text-xs font-medium py-1 mr-2">Last Name :</label>
            <input type="text" name="lastName" id="lastName" class="border border-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs" value="lastName">
        </div>
        <div class="relative flex">
            <label for="mobile" class="text-gray-700 text-xs font-medium py-1 mr-2">Mobile :</label>
            <input type="text" name="mobile" id="mobile" class="border border-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs" value="Mobile">
        </div>
    </div>
    <button onclick="updateProfile()" class="bg-[#1da1f2] text-white font-semibold rounded-md px-3 py-2 text-xs mt-4 translate-x-6 hover:bg-slate-500">Update Profile</button>
</div>
<div class="m-6">
    <div class="grid grid-cols-2 gap-5">
        <div class="relative bg-white rounded-md px-5 py-4">
            <div class="flex items-center mb-5">
                <label for="email" class="text-gray-700 text-xs font-medium py-1 mr-2">Email Address :</label>
                <input type="text" name="email" id="email" class="ml-[1.4rem] border border-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs" readonly>
            </div>
            <h2 class="text-gray-600 font-semibold text-md mb-3 underline">Change Password</h2>
            <div class="flex items-center mb-2">
                <label for="password" class="text-gray-700 text-xs font-medium py-1 mr-2">New Password :</label>
                <input type="password" name="password" id="password" class="ml-[1.4rem] border border-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs" value="">
            </div>
            <div class="flex items-center">
                <label for="cpassword" class="text-gray-700 text-xs font-medium py-1 mr-2">Confirm Password :</label>
                <input type="password" name="cpassword" id="cpassword" class="border border-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs" value="">
            </div>
            <button onclick="updatePassword()" class="bg-[#1da1f2] text-white font-semibold rounded-md px-3 py-2 text-xs mt-4 translate-x-6 hover:bg-slate-500">Update Password</button>

        </div>
        <div class="relative bg-white rounded-md px-5 py-4">
            <h2 class="text-gray-600 font-semibold text-lg mb-3 underline">User Status</h2>
            <div class="flex items-center mb-3">
                <label for="role" class="text-gray-700 text-xs font-medium py-1 mr-2">User Role :</label>
                <p class="bg-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs font-semibold"><span id="role"></span></p>
            </div>
            <div class="flex items-center">
                <label for="status" class="text-gray-700 text-xs font-medium py-1 mr-2">User Status :</label>
                <p class="bg-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs font-semibold"><span id="status"></span></p>
            </div>
        </div>
    </div>
</div>

<script>

    userProfileData();
    async function userProfileData(){
        showLoader();
        let res = await axios.get('/userProfile');
        hideLoader();

        if(res.status === 200 && res.data['status'] === 'success'){
            let data = res.data['data'];
            $('#firstName').val(data['firstName']);
            $('#lastName').val(data['lastName']);
            $('#mobile').val(data['mobile']);
            $('#email').val(data['email']);
            $('#role').text(data['role']).css('text-transform', 'capitalize');
            $('#status').text(data['status']).css('text-transform', 'capitalize');
        }else{
            errorToast(res.data['message']);
        }
    }

    async function updateProfile(){
        showLoader();
        let res = await axios.post('/updateUserProfile',
            {
                'firstName' : $('#firstName').val(),
                'lastName' : $('#lastName').val(),
                'mobile' : $('#mobile').val(),
            });
        hideLoader();

        if(res.status === 200 && res.data['status'] === 'success'){
            successToast(res.data['message']);
            await userProfileData();
            // setTimeout(() => {
            //     window.location.reload();
            // }, 2000);
        }else{
            errorToast(res.data['message']);
        }
    }

    async function updatePassword(){
        if($('#password').val() === '' || $('#cpassword').val() === ''){
            errorToast('Please enter password');
        }else if($('#password').val() !== $('#cpassword').val()){
            errorToast('Password does not match');
        }else{
            showLoader();
            let res = await axios.post('/updateUserPassword',
                {
                    'password' : $('#password').val(),
                });
            hideLoader();

            if(res.status === 200 && res.data['status'] === 'success'){
                successToast(res.data['message']);
                // await userProfileData();
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }else{
                errorToast(res.data['message']);
            }
        }
    }

</script>
