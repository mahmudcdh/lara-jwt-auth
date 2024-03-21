<div class="mt-[10%] mx-[30%] w-[30%] border-2 border-gray-500 p-3 rounded-lg bg-slate-100">
    <div class="mb-4 text-sm text-gray-600">
        <div class="text-center flex justify-center gap-2 mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="UserKey" class="w-[17%] h-[20%] p-1.5">
            <h2 class="text-2xl font-semibold">Verify OTP</h2>
        </div>
        <hr class="border-gray-300 mb-4">

        <!-- <div class="mb-4 grid grid-cols-4 gap-2"> -->
            <div class="mb-4 col-span-3 flex space-x-4">
                <input type="text" name="verify_otp" id="verify_otp" maxlength="1" class="bg-gray-50 border border-gray-300 text-center font-semibold text-gray-900 w-full p-2 rounded-lg" value="">
                <input type="text" name="verify_otp" id="verify_otp" maxlength="1" class="bg-gray-50 border border-gray-300 text-center font-semibold text-gray-900 w-full p-2 rounded-lg" value="">
                <input type="text" name="verify_otp" id="verify_otp" maxlength="1" class="bg-gray-50 border border-gray-300 text-center font-semibold text-gray-900 w-full p-2 rounded-lg" value="">
                <input type="text" name="verify_otp" id="verify_otp" maxlength="1" class="bg-gray-50 border border-gray-300 text-center font-semibold text-gray-900 w-full p-2 rounded-lg" value="">
                <input type="text" name="verify_otp" id="verify_otp" maxlength="1" class="bg-gray-50 border border-gray-300 text-center font-semibold text-gray-900 w-full p-2 rounded-lg" value="">
                <input type="text" name="verify_otp" id="verify_otp" maxlength="1" class="bg-gray-50 border border-gray-300 text-center font-semibold text-gray-900 w-full p-2 rounded-lg" value="">
            </div>
            <div class="col-span-1">
                <button onclick="getOTP()" class="btn-submit w-full bg-blue-600 text-white font-semibold p-2 rounded-lg">Verify OTP</button>
            </div>
        <!-- </div> -->
    </div>
</div>

<script>

    const otpInputs = document.querySelectorAll('input[type="text"]');

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1) {
                // otpInputs[index + 1].focus();
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                } else {
                    // Last digit entered, you can trigger verification process here
                    console.log("OTP Entered:", getOTP());
                }
            } else if (e.target.value.length === 0) {
                if (index > 0) {
                    otpInputs[index - 1].focus();
                }
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value.length === 0) {
                if (index > 0) {
                    otpInputs[index - 1].focus();
                }
            }
        });
    });

    async function getOTP() {
        let otp = "";
        otpInputs.forEach((input) => {
            otp += input.value;
        });

        // return otp;

        // Send OTP to server
        if(otp.length !== 6){
            errorToast('Please enter valid OTP');
        }else{
            showLoader();
            let res = await axios.post('/verify-otp', {
                otp: otp,
                email: sessionStorage.getItem('email'),
            });
            hideLoader();

            if(res.status === 200 && res.data['status'] === 'success'){
                successToast(res.data['message']);
                sessionStorage.clear();
                setTimeout(() => {
                    window.location.href = '/reset-password';
                }, 2000);
            }else{
                errorToast(res.data['message']);
            }
        }
    }

</script>
