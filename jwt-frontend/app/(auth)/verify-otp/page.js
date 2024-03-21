"use client"
import axios from "axios";
import Cookies from "js-cookie";
import { useState } from "react";

export default function VerifyOTP() {

    const [formData, setFormData] = useState({ email: '', otp: '' });

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        const res = await axios.post('http://localhost:8000/verify-otp', formData);

        if(res.status == 200 && res.data['status'] == 'success'){
            alert(res.data['message']);

            Cookies.set('token', res.data['token'], { expires: 5 });

            setTimeout(() => {
                window.location.href = '/reset-password';
            }, 2000);

        }else{
            alert(res.data['message']);
        }
    }

    return (
        <div className="max-w-md mx-auto mt-8">
            <h1 className="text-2xl font-bold mb-4">Forgot Password</h1>
            <form onSubmit={handleSubmit}>
                <div className="mb-4">
                    <label htmlFor="email" className="block mb-2">Email</label>
                    <input type="email" id="email" name="email" value={formData.email} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
                </div>
                <div className="mb-4">
                    <label htmlFor="otp" className="block mb-2">OTP</label>
                    <input type="text" id="otp" name="otp" value={formData.otp} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
                </div>
                <button type="submit" className="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Verify OTP</button>
            </form>
        </div>
    );
}
