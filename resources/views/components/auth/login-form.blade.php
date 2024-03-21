<div class="mt-[10%] mx-[30%] w-[33%] border-2 border-gray-500 p-3 rounded-lg bg-slate-100">
    <div class="mb-4 text-sm text-gray-600">
        <div class="text-center flex justify-center gap-2 mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="UserKey" class="w-[17%] h-[20%] p-1.5">
            <h2 class="text-2xl font-semibold">User Login</h2>
        </div>
        <hr class="border-gray-300 mb-4">
        <div class="mb-4">
            <label for="email" class="sr-only block my-1 mx-3 text-gray-500 font-semibold">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg">
        </div>
        <div class="">
            <label for="password" class="sr-only block my-1 mx-3 text-gray-500 font-semibold">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg">
        </div>
        <button onclick="onLogin()" class="w-full mt-4 mb-4 bg-blue-500 text-white font-semibold p-2 rounded-lg">Login</button>
        <div class="flex justify-between">
            <p class="w-full text-sm">Not registered yet? <br><a href="{{ route('register') }}" class="w-full text-gray-700 hover:underline hover:font-semibold">Register Here</a></p>
            <p>Forgot Password? <a href="{{ route('send-otp') }}" class="w-full text-gray-700 hover:underline hover:font-semibold">Reset Here</a></p>
        </div>
    </div>
</div>

<script>

    async function onLogin(){

        const email = $('#email').val();
        const password = $('#password').val();

        if(email.length == 0){
            errorToast('Please enter Email Address');
        }else if(password.length == 0){
            errorToast('Please enter Password');
        }else{
            showLoader();
            const res = await axios.post('/user-login', {
                email: email,
                password: password
            });
            hideLoader();

            if(res.status == 200 && res.data['status'] == 'success'){
                successToast(res.data['message']);
                setTimeout(() => {
                    window.location.href = "/dashboard";
                }, 1000);
            }else{
                errorToast(res.data['message']);
            }
        }
    }

</script>
