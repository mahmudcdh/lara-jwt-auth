"use client"
import axios from "axios";
import Cookies from "js-cookie";
import Link from "next/link";
import { useState } from "react";

export default function Login() {

    const [formData, setFormData] = useState({
        email: '',
        password: '',
    });

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
          const response = await axios.post('http://localhost:8000/user-login', formData);

          if(response.status == 200 && response.data['status'] == 'success'){
            console.log(response);
            // Handle successful login
            alert(response.data['message']);
            // Cookies.set('token', response.data['token']);
            Cookies.set('token', response.data['token'], { expires: 7 });
            setTimeout(() => {
              window.location.href = '/dashboard';
            }, 2000);
          }else{
            console.log(response.data['message']);
            // Handle login error
            alert(response.data['message']);
            // setTimeout(() => {
            //   window.location.href = '/login';
            // }, 2000);
          }
    };


    return (
        <div className="max-w-md mx-auto mt-8">
            <h1 className="text-2xl font-bold mb-4">User Login</h1>
            <form onSubmit={handleSubmit}>
            <div className="mb-4">
                <label htmlFor="email" className="block mb-2">Email</label>
                <input type="email" id="email" name="email" value={formData.email} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
            </div>
            <div className="mb-4">
                <label htmlFor="password" className="block mb-2">Password</label>
                <input type="password" id="password" name="password" value={formData.password} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
            </div>
            <button type="submit" className="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Login</button>
            </form>
            <div className="mt-4 grid grid-cols-2 gap-4">
                <div>
                    <p className="text-sm font-semibold">Don't have an account? <Link href="/user-registration" className="text-blue-500">Register</Link></p>
                </div>
                <div>
                    <p className="text-sm font-semibold">Forgot your password? <Link href="/forgot-password" className="text-blue-500">Reset Password</Link></p>
                </div>
            </div>
        </div>
    );
}
