import axios from "axios";

export default async function apiURL() {
    const apiURL = await axios.create({
        baseURL: 'http://localhost:8000/',
        headers: {
            'Content-Type': 'application/json',
        },
        // headers: {
        //     "X_Requested-With" : "  XMLHttpRequest"
        // },
        withCredentials: true
    });

    return apiURL;
}
