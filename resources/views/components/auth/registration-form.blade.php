<div class="mt-[10%] mx-[30%] w-[40%] border-2 border-gray-500 p-3 rounded-lg bg-slate-100">
    <div class="mb-4 text-sm text-gray-600">
        <div class="text-center flex justify-center gap-2 mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="UserKey" class="w-[17%] h-[20%] p-1.5">
            <h2 class="text-2xl font-semibold">User Registration Form</h2>
        </div>
        <hr class="border-gray-300 mb-4">
        <div class="mb-4 flex justify-between gap-2">
            <input type="firstName" name="firstName" id="firstName" placeholder="First Name" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="{{ old('firstName') }}">
            <input type="lastName" name="lastName" id="lastName" placeholder="Last Name" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="{{ old('lastName') }}">
        </div>
        <div class="mb-4 flex justify-between gap-2">
            <input type="mobile" name="mobile" id="mobile" placeholder="Mobile" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="{{ old('mobile') }}">
            <input type="email" name="email" id="email" placeholder="Email" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="{{ old('email') }}">
        </div>
        <div class="mb-4 flex justify-between gap-2">
            <input type="password" name="password" id="password" placeholder="Password" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="">
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="bg-gray-50 border border-gray-300 text-gray-900 w-full p-2 rounded-lg" value="">
        </div>
        <button onclick="onRegistration()" class="w-full mb-4 bg-blue-500 text-white font-semibold p-2 rounded-lg">Register</button>
        <div class="">
            <p class="w-full text-sm">Already registered..! <a href="{{ route('login') }}" class="w-full bg-gray-200 rounded-lg p-2 text-gray-700 hover:underline hover:font-semibold">Login Here</a></p>
        </div>
    </div>
</div>

<script>

    async function onRegistration(){

        const firstName = $('#firstName').val();
        const lastName = $('#lastName').val();
        const mobile = $('#mobile').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const cpassword = $('#cpassword').val();

        if(firstName.length == 0){
            errorToast('Please enter First Name');
        }else if(lastName.length == 0){
            errorToast('Please enter Last Name');
        }else if(mobile.length == 0){
            errorToast('Please enter Mobile Number');
        }else if(email.length == 0){
            errorToast('Please enter Email Address');
        }else if(password.length == 0){
            errorToast('Please enter Password');
        }else if(cpassword !== password){
            errorToast('Confirm Password is not matched with Password');
        }else{
            showLoader();
            const response = await axios.post('/user-registration', {
                firstName: firstName,
                lastName: lastName,
                mobile: mobile,
                email: email,
                password: password
            });
            hideLoader();

            if(response.status == 200 && response.data['status'] == 'success'){
                successToast(response.data['message']);
                setTimeout(function(){
                    window.location.href = '/login';
                }, 2000);
            }else{
                errorToast(response.data['message']);
            }
        }
    }

</script>
