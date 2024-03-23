<div class="mt-[10%] mx-[30%] w-[30%] border-2 border-gray-500 p-3 rounded-lg bg-slate-100">
    <div class="mb-4 text-sm text-gray-600">
        <div class="text-center flex justify-center gap-2 mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="UserKey" class="w-[17%] h-[20%] p-1.5">
            <h2 class="text-2xl font-semibold">Reset Password Form</h2>
        </div>
        <hr class="border-gray-300 mb-4">
        <div class="mb-3">
            <input type="password" name="password" id="password" placeholder="Enter New Password" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="">
        </div>
        <div class="mb-4">
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="">
        </div>
        <button onclick="resetPassword()" class="w-full mb-4 bg-blue-500 text-white font-semibold p-2 rounded-lg hover:bg-blue-600">Reset Password</button>
    </div>
</div>

<script>
    async function resetPassword() {
        let password = $('#password').val();
        let cpassword = $('#cpassword').val();

        if(password.length === 0 && cpassword.length === 0){
            errorToast("Please enter your password");
        }else if(password !== cpassword){
            errorToast("Password and Confirm Password doesn't match");
        }else{
            showLoader();
            let res = await axios.post('/reset-password', {'password': password});
            hideLoader();

            if(res.status === 200 && res.data['status'] === 'success'){
                successToast(res.data['message']);
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            }else{
                errorToast(res.data['message']);
            }
        }
    }
</script>
