<div class="mt-[10%] mx-[30%] w-[40%] border-2 border-gray-500 p-3 rounded-lg bg-slate-100">
    <div class="mb-4 text-sm text-gray-600">
        <div class="text-center flex justify-center gap-2 mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="UserKey" class="w-[17%] h-[20%] p-1.5">
            <h2 class="text-2xl font-semibold">Enter your Email Address</h2>
        </div>
        <hr class="border-gray-300 mb-4">

        <div class="mb-4 grid grid-cols-4 gap-2">
            <div class="col-span-3">
                <input type="email" name="email" id="email" placeholder="Enter Your Email for Reset Password" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="{{ old('email') }}">
            </div>
            <div class="col-span-1">
                <button onclick="onSendOtp()" class="w-full bg-blue-600 text-white font-semibold p-2 rounded-lg">Send OTP</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function onSendOtp() {
        const email = $('#email').val();

        if (!email) {
            errorToast('Please Enter Your Email Address');
        }else{
            showLoader();
            let res = await axios.post('/send-otp', {email:email});
            hideLoader();

            if(res.status == 200 && res.data['status'] == 'success'){
                successToast(res.data['message']);
                sessionStorage.setItem('email', email);
                setTimeout(() => {
                    window.location.href = '/verify-otp';
                }, 2000);
            }else{
                errorToast(res.data['message']);
            }
        }
    }
</script>
