"use client"
import axios from "axios";
import Cookies from "js-cookie";
// import { useRouter } from "next/router";
import { useState } from "react";

export default function ResetPassword() {

    const [formData, setFormData] = useState({ password: '', cpassword: '' });
    // const router = useRouter();

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        const { password, cpassword } = formData;

        if (password === cpassword) {
            alert('Passwords do not match');
        } else {
            const token = Cookies.get('token');
            const config = {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            };

            try {
                const res = await axios.post('http://localhost:8000/reset-password', formData, config);

                if (res.status === 200 && res.data.status === 'success') {
                    alert(res.data.message);
                    window.location.href = '/login';
                } else {
                    alert(res.data.message);
                }
            } catch (error) {
                console.error('Error resetting password:', error);
                alert('An error occurred while resetting the password. Please try again later.');
            }
        }
    }


    return (
        <div className="max-w-md mx-auto mt-8">
            <h1 className="text-2xl font-bold mb-4">Please Enter New Password</h1>
            <form onSubmit={handleSubmit}>
            <div className="mb-4">
                <label htmlFor="password" className="block mb-2">Password</label>
                <input type="password" id="password" name="password" value={formData.password} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
            </div>
            <div className="mb-4">
                <label htmlFor="cpassword" className="block mb-2">Confirm Password</label>
                <input type="password" id="cpassword" name="cpassword" className="w-full text-black px-3 py-2 border rounded-md" required />
            </div>
            <button type="submit" className="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Reset Password</button>
            </form>
        </div>
    );
}
