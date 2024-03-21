"use client"
import axios from "axios";
import { useState } from "react";

export default function UserRegistration() {

    const [formData, setFormData] = useState({
        firstName: '',
        lastName: '',
        mobile: '',
        email: '',
        password: '',
    });

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
          const response = await axios.post('http://localhost:8000/user-registration', formData);
          console.log(response.data);
          // Handle successful registration
          alert(response.data['message']);
          setTimeout(() => {
            window.location.href = '/login';
          }, 2000);
        } catch (error) {
          console.error('Registration failed:', error);
          // Handle registration error
          alert('Registration failed. Please try again.');
        }
    };

    return (
        <div className="max-w-md mx-auto mt-8">
            <h1 className="text-2xl font-bold mb-4">User Registration</h1>
            <form onSubmit={handleSubmit}>
                <div className="mb-4">
                    <label htmlFor="firstName" className="block mb-2">First Name</label>
                    <input type="text" id="firstName" name="firstName" value={formData.firstName} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
                </div>
                <div className="mb-4">
                    <label htmlFor="lastName" className="block mb-2">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value={formData.lastName} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
                </div>
                <div className="mb-4">
                    <label htmlFor="mobile" className="block mb-2">Mobile</label>
                    <input type="text" id="mobile" name="mobile" value={formData.mobile} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
                </div>
                <div className="mb-4">
                    <label htmlFor="email" className="block mb-2">Email</label>
                    <input type="email" id="email" name="email" value={formData.email} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
                </div>
                <div className="mb-4">
                    <label htmlFor="password" className="block mb-2">Password</label>
                    <input type="password" id="password" name="password" value={formData.password} onChange={handleChange} className="w-full text-black px-3 py-2 border rounded-md" required />
                </div>
                <button type="submit" className="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Register</button>
            </form>
        </div>
    );
}
