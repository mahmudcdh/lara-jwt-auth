"use client";

import axios from "axios";
import { useState } from "react";

export default function ForgotPassword() {

    const [formData, setFormData] = useState({ email: '' });

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        const res = await axios.post('http://localhost:8000/send-otp', formData);

        if(res.status == 200 && res.data['status'] == 'success'){
            alert(res.data['message']);

            setTimeout(() => {
                window.location.href = '/verify-otp';
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
                <button type="submit" className="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Send OTP</button>
            </form>
        </div>
    );
}
